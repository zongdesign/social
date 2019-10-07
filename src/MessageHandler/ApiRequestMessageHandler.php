<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Message\ApiRequestMessage;
use SocialTech\SlowStorage;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

/**
 * Class ApiRequestMessageHandler.
 */
class ApiRequestMessageHandler implements MessageHandlerInterface
{
    /**
     * @var SlowStorage
     */
    private $storage;
    /**
     * @var string
     */
    private $trackerFilePath;

    /**
     * ApiRequestMessageHandler constructor.
     * @param SlowStorage $storage
     * @param string $trackerFilePath
     */
    public function __construct(SlowStorage $storage, string $trackerFilePath)
    {
        $this->storage = $storage;
        $this->trackerFilePath = $trackerFilePath;
    }

    /**
     * @param ApiRequestMessage $message
     */
    public function __invoke(ApiRequestMessage $message)
    {
        if (!$this->storage->exists($this->trackerFilePath)) {
            new \Exception('Can\'t find the file');
        }

        $this->storage->append(
            $this->trackerFilePath,
            $this->prepareData($message)
        );
    }

    /**
     * @param ApiRequestMessage $message
     * @return string
     */
    public function prepareData(ApiRequestMessage $message): string
    {
        $id = array_key_last(
            explode(
                PHP_EOL,
                $this->storage->load($this->trackerFilePath)
            )
        );

        $string = json_encode(
            [
                'id' => $id,
                'user_id' => $message->getUserUUID(),
                'source_label' => $message->getSourceLabel(),
                'date_created' => $message->getDataTime(),
            ]
        );

        return $string. PHP_EOL;
    }
}