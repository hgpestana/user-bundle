<?php

/*
 * This file is part of hgpestana's user bundle.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace HGPestana\UserBundle\Entity;


use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class used to assign time properties to the classes extending it.
 *
 * @author Hélder Pestana <hgpestana@gmail.com>
 *
 * @ORM\HasLifecycleCallbacks
 */
abstract class TimeProperties
{
    /**
     * The date and time of the object creation
     *
     * @var DateTime
     * @ORM\Column(name="create_date", type="datetime")
     */
    private $createDate;

    /**
     * Registers the time and date of the object update
     *
     * @var DateTime
     * @ORM\Column(name="update_date", type="datetime")
     */
    private $updateDate;

    /**
     * @return DateTime
     */
    public function getCreateDate(): DateTime
    {
        return $this->createDate;
    }

    /**
     * @param DateTime $createDate
     *
     * @return TimeProperties
     */
    public function setCreateDate(DateTime $createDate): TimeProperties
    {
        $this->createDate = $createDate;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getUpdateDate(): DateTime
    {
        return $this->updateDate;
    }

    /**
     * @param DateTime $updateDate
     *
     * @return TimeProperties
     */
    public function setUpdateDate(DateTime $updateDate): TimeProperties
    {
        $this->updateDate = $updateDate;
        return $this;
    }

    /**
     * Automatically updates the time properties.
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updateTimeProperties(): void
    {
        $now = new DateTime('now');
        $this->setUpdateDate($now);
        if ($this->getCreateDate() == null) {
            $this->setCreateDate($now);
        }
    }
}