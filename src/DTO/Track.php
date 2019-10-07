<?php
/**
 * Created by PhpStorm.
 * User: kirpich
 * Date: 03.10.19
 * Time: 15:15
 */

namespace App\DTO;


class Track
{
    /**
     * @var string
     */
    private $userId;
    /**
     * @var string
     */
    private $sourceLabel;
    /**
     * @var \DateTime
     */
    private $dateTime;

    public function __construct(string $userId, string $sourceLabel, \DateTime $dateTime)
    {
        $this->userId = $userId;
        $this->sourceLabel = $sourceLabel;
        $this->dateTime = $dateTime;
    }

    /**
     * @return string
     */
    public function getUserId(): string
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getSourceLabel(): string
    {
        return $this->sourceLabel;
    }

    /**
     * @return \DateTime
     */
    public function getDateTime(): \DateTime
    {
        return $this->dateTime;
    }
}