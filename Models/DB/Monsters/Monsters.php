<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 9.12.2016 г.
 * Time: 9:27
 */

namespace FPopov\Models\DB\Monsters;


class Monsters
{
    private $id;

    private $type_monsters_id;

    private $city_id;

    private $damage_low_value;

    private $armor;

    private $health;

    private $damage_high_value;

    private $monster_type;

    private $win_experience;

    private $min_gold;

    private $max_gold;

    /**
     * @return mixed
     */
    public function getMinGold()
    {
        return $this->min_gold;
    }

    /**
     * @param mixed $min_gold
     */
    public function setMinGold($min_gold)
    {
        $this->min_gold = $min_gold;
    }

    /**
     * @return mixed
     */
    public function getMaxGold()
    {
        return $this->max_gold;
    }

    /**
     * @param mixed $max_gold
     */
    public function setMaxGold($max_gold)
    {
        $this->max_gold = $max_gold;
    }

    /**
     * @return mixed
     */
    public function getWinExperience()
    {
        return $this->win_experience;
    }

    /**
     * @param mixed $win_experience
     */
    public function setWinExperience($win_experience)
    {
        $this->win_experience = $win_experience;
    }

    /**
     * @return mixed
     */
    public function getMonsterType()
    {
        return $this->monster_type;
    }

    /**
     * @param mixed $monster_type
     */
    public function setMonsterType($monster_type)
    {
        $this->monster_type = $monster_type;
    }

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
    public function getTypeMonstersId()
    {
        return $this->type_monsters_id;
    }

    /**
     * @param mixed $type_monsters_id
     */
    public function setTypeMonstersId($type_monsters_id)
    {
        $this->type_monsters_id = $type_monsters_id;
    }

    /**
     * @return mixed
     */
    public function getCityId()
    {
        return $this->city_id;
    }

    /**
     * @param mixed $city_id
     */
    public function setCityId($city_id)
    {
        $this->city_id = $city_id;
    }

    /**
     * @return mixed
     */
    public function getDamageLowValue()
    {
        return $this->damage_low_value;
    }

    /**
     * @param mixed $damage_low_value
     */
    public function setDamageLowValue($damage_low_value)
    {
        $this->damage_low_value = $damage_low_value;
    }

    /**
     * @return mixed
     */
    public function getArmor()
    {
        return $this->armor;
    }

    /**
     * @param mixed $armor
     */
    public function setArmor($armor)
    {
        $this->armor = $armor;
    }

    /**
     * @return mixed
     */
    public function getHealth()
    {
        return $this->health;
    }

    /**
     * @param mixed $health
     */
    public function setHealth($health)
    {
        $this->health = $health;
    }

    /**
     * @return mixed
     */
    public function getDamageHighValue()
    {
        return $this->damage_high_value;
    }

    /**
     * @param mixed $damage_high_value
     */
    public function setDamageHighValue($damage_high_value)
    {
        $this->damage_high_value = $damage_high_value;
    }
}