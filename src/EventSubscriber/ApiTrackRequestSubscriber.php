<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use App\Event\ApiRequestEvent;
use App\Message\ApiRequestMessage;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * Class ApiTrackRequestSubscriber.
 */
class ApiTrackRequestSubscriber implements EventSubscriberInterface
{
    /**
     * @var MessageBusInterface
     */
    private $messageBus;

    /**
     * ApiTrackRequestSubscriber constructor.
     *
     * @param MessageBusInterface $messageBus
     */
    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    /**
     * @param $event
     */
    public function onApiRequestEvent(ApiRequestEvent $event)
    {
        $this->messageBus->dispatch(
            new ApiRequestMessage(
                $event->getTrack()->getUserId(),
                $event->getTrack()->getSourceLabel(),
                $event->getTrack()->getDateTime()->format('Y-m-d H:i:s')
            )
        );
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'api_request_event' => 'onApiRequestEvent',
        ];
    }
}
