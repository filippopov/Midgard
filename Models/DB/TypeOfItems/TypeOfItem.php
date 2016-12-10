<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 8.12.2016 г.
 * Time: 11:16
 */

namespace FPopov\Models\DB\TypeOfItems;


class TypeOfItem
{
    private $id;

    private $name;

    private $for_type_of_heroes;

    private $weapon_or_armor;

    /**
     * @return mixed
     */
    public function getWeaponOrArmor()
    {
        return $this->weapon_or_armor;
    }

    /**
     * @param mixed $weapon_or_armor
     */
    public function setWeaponOrArmor($weapon_or_armor)
    {
        $this->weapon_or_armor = $weapon_or_armor;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getForTypeOfHeroes()
    {
        return $this->for_type_of_heroes;
    }

    /**
     * @param mixed $for_type_of_heroes
     */
    public function setForTypeOfHeroes($for_type_of_heroes)
    {
        $this->for_type_of_heroes = $for_type_of_heroes;
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