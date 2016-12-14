<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 14.12.2016 г.
 * Time: 11:44
 */

namespace FPopov\Models\View\CreateItem;


class CreateItemViewModel
{
    private $typeOfRecipesId;

    private $status;

    private $name;

    private $duration;

    private $timeToCreateItem;

    /**
     * CreateItemViewModel constructor.
     * @param $typeOfRecipesId
     * @param $status
     * @param $name
     * @param $duration
     * @param $timeToCreateItem
     */
    public function __construct($typeOfRecipesId, $status, $name, $duration, $timeToCreateItem)
    {
        $this->typeOfRecipesId = $typeOfRecipesId;
        $this->status = $status;
        $this->name = $name;
        $this->duration = $duration;
        $this->timeToCreateItem = $timeToCreateItem;
    }


    /**
     * @return mixed
     */
    public function getTimeToCreateItem()
    {
        return $this->timeToCreateItem;
    }

    /**
     * @param mixed $timeToCreateItem
     */
    public function setTimeToCreateItem($timeToCreateItem)
    {
        $this->timeToCreateItem = $timeToCreateItem;
    }

    /**
     * @return mixed
     */
    public function getTypeOfRecipesId()
    {
        return $this->typeOfRecipesId;
    }

    /**
     * @param mixed $typeOfRecipesId
     */
    public function setTypeOfRecipesId($typeOfRecipesId)
    {
        $this->typeOfRecipesId = $typeOfRecipesId;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * @param mixed $duration
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;
    }
}