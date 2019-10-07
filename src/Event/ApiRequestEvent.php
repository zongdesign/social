<?php

declare(strict_types=1);

namespace App\Event;

use App\DTO\Track;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class ApiRequestEvent.
 */
class ApiRequestEvent extends Event
{
    /**
     * @var Track
     */
    private $track;

    /**
     * ApiRequestEvent constructor.
     * @param Track $track
     */
    public function __construct(Track $track)
    {
        $this->track = $track;
    }

    /**
     * @return Track
     */
    public function getTrack(): Track
    {
        return $this->track;
    }

}