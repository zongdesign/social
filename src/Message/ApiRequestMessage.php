<?php

declare(strict_types=1);

namespace App\Message;

/**
 * Class ApiRequestMessage
 */
class ApiRequestMessage
{

    /**
     * @var string
     */
    private $userUUID;
    /**
     * @var string
     */
    private $sourceLabel;
    /**
     * @var string
     */
    private $dataTime;

    /**
     * ApiRequestMessage constructor.
     * @param string $userUUID
     * @param string $sourceLabel
     * @param string $dataTime
     */
    public function __construct(string $userUUID, string $sourceLabel, string $dataTime)
    {
        $this->userUUID = $userUUID;
        $this->sourceLabel = $sourceLabel;
        $this->dataTime = $dataTime;
    }

    /**
     * @return string
     */
    public function getUserUUID(): string
    {
        return $this->userUUID;
    }

    /**
     * @return string
     */
    public function getSourceLabel(): string
    {
        return $this->sourceLabel;
    }

    /**
     * @return string
     */
    public function getDataTime(): string
    {
        return $this->dataTime;
    }
}