<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 7.12.2016 г.
 * Time: 11:49
 */

namespace FPopov\Models\DB\City;


class City
{
    private $id;

    private $name;

    private $coordinates_x;

    private $coordinates_y;

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
    public function getCoordinatesX()
    {
        return $this->coordinates_x;
    }

    /**
     * @param mixed $coordinates_x
     */
    public function setCoordinatesX($coordinates_x)
    {
        $this->coordinates_x = $coordinates_x;
    }

    /**
     * @return mixed
     */
    public function getCoordinatesY()
    {
        return $this->coordinates_y;
    }

    /**
     * @param mixed $coordinates_y
     */
    public function setCoordinatesY($coordinates_y)
    {
        $this->coordinates_y = $coordinates_y;
    }
}