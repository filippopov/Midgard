<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 7.12.2016 г.
 * Time: 14:32
 */

namespace FPopov\Models\DB\Hero;


class Hero
{
    private $id;

    private $user_id;

    private $type_of_heroes_id;

    private $level_id;

    private $city_id;

    private $real_health;

    private $experience;

    private $real_mana;

    private $name;

    private $hero_status;

    private $health;

    private $mana;

    private $level_points;

    private $strength;

    private $dexterity;

    private $vitality;

    private $magic;

    /**
     * @return mixed
     */
    public function getStrength()
    {
        return $this->strength;
    }

    /**
     * @param mixed $strength
     */
    public function setStrength($strength)
    {
        $this->strength = $strength;
    }

    /**
     * @return mixed
     */
    public function getDexterity()
    {
        return $this->dexterity;
    }

    /**
     * @param mixed $dexterity
     */
    public function setDexterity($dexterity)
    {
        $this->dexterity = $dexterity;
    }

    /**
     * @return mixed
     */
    public function getVitality()
    {
        return $this->vitality;
    }

    /**
     * @param mixed $vitality
     */
    public function setVitality($vitality)
    {
        $this->vitality = $vitality;
    }

    /**
     * @return mixed
     */
    public function getMagic()
    {
        return $this->magic;
    }

    /**
     * @param mixed $magic
     */
    public function setMagic($magic)
    {
        $this->magic = $magic;
    }

    /**
     * @return mixed
     */
    public function getLevelPoints()
    {
        return $this->level_points;
    }

    /**
     * @param mixed $level_points
     */
    public function setLevelPoints($level_points)
    {
        $this->level_points = $level_points;
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
    public function getMana()
    {
        return $this->mana;
    }

    /**
     * @param mixed $mana
     */
    public function setMana($mana)
    {
        $this->mana = $mana;
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
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * @return mixed
     */
    public function getTypeOfHeroesId()
    {
        return $this->type_of_heroes_id;
    }

    /**
     * @param mixed $type_of_heroes_id
     */
    public function setTypeOfHeroesId($type_of_heroes_id)
    {
        $this->type_of_heroes_id = $type_of_heroes_id;
    }

    /**
     * @return mixed
     */
    public function getLevelId()
    {
        return $this->level_id;
    }

    /**
     * @param mixed $level_id
     */
    public function setLevelId($level_id)
    {
        $this->level_id = $level_id;
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
    public function getRealHealth()
    {
        return $this->real_health;
    }

    /**
     * @param mixed $real_health
     */
    public function setRealHealth($real_health)
    {
        $this->real_health = $real_health;
    }

    /**
     * @return mixed
     */
    public function getExperience()
    {
        return $this->experience;
    }

    /**
     * @param mixed $experience
     */
    public function setExperience($experience)
    {
        $this->experience = $experience;
    }

    /**
     * @return mixed
     */
    public function getRealMana()
    {
        return $this->real_mana;
    }

    /**
     * @param mixed $real_mana
     */
    public function setRealMana($real_mana)
    {
        $this->real_mana = $real_mana;
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
    public function getHeroStatus()
    {
        return $this->hero_status;
    }

    /**
     * @param mixed $hero_status
     */
    public function setHeroStatus($hero_status)
    {
        $this->hero_status = $hero_status;
    }
}