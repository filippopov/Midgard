<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 7.12.2016 г.
 * Time: 15:09
 */

namespace FPopov\Models\DB\Resources;


class Resources
{
    private $id;

    private $type_of_resources_id;

    private $heroes_id;

    private $amount;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getTypeOfResourcesId()
    {
        return $this->type_of_resources_id;
    }

    /**
     * @param mixed $type_of_resources_id
     */
    public function setTypeOfResourcesId($type_of_resources_id)
    {
        $this->type_of_resources_id = $type_of_resources_id;
    }

    /**
     * @return mixed
     */
    public function getHeroesId()
    {
        return $this->heroes_id;
    }

    /**
     * @param mixed $heroes_id
     */
    public function setHeroesId($heroes_id)
    {
        $this->heroes_id = $heroes_id;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }
}