<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 9.12.2016 г.
 * Time: 9:26
 */

namespace FPopov\Models\DB\TypeMonsters;


class TypeMonster
{
    private $id;

    private $name;

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
}