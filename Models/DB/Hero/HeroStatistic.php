<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 8.12.2016 г.
 * Time: 15:19
 */

namespace FPopov\Models\DB\Hero;


class HeroStatistic
{
    private $hero_name;

    private $real_health;

    private $real_mana;

    private $experience;

    private $damage_low_value;

    private $damage_high_value;

    private $armor;

    private $strength;

    private $magic;

    private $vitality;

    private $dexterity;

    private $max_health;

    private $max_mana;

    private $critical_chance;

    private $city_name;

    private $level_number;

    private $experience_to_next_level;

    private $resources;

    private $hero_type;

    private $health_from_items;

    private $hero_status;

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

    /**
     * @return mixed
     */
    public function getHealthFromItems()
    {
        return $this->health_from_items;
    }

    /**
     * @param mixed $health_from_items
     */
    public function setHealthFromItems($health_from_items)
    {
        $this->health_from_items = $health_from_items;
    }

    /**
     * @return mixed
     */
    public function getHeroType()
    {
        return $this->hero_type;
    }

    /**
     * @param mixed $hero_type
     */
    public function setHeroType($hero_type)
    {
        $this->hero_type = $hero_type;
    }

    /**
     * @return mixed
     */
    public function getHeroName()
    {
        return $this->hero_name;
    }

    /**
     * @param mixed $hero_name
     */
    public function setHeroName($hero_name)
    {
        $this->hero_name = $hero_name;
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
    public function getMaxHealth()
    {
        return $this->max_health;
    }

    /**
     * @param mixed $max_health
     */
    public function setMaxHealth($max_health)
    {
        $this->max_health = $max_health;
    }

    /**
     * @return mixed
     */
    public function getMaxMana()
    {
        return $this->max_mana;
    }

    /**
     * @param mixed $max_mana
     */
    public function setMaxMana($max_mana)
    {
        $this->max_mana = $max_mana;
    }

    /**
     * @return mixed
     */
    public function getCriticalChance()
    {
        return $this->critical_chance;
    }

    /**
     * @param mixed $critical_chance
     */
    public function setCriticalChance($critical_chance)
    {
        $this->critical_chance = $critical_chance;
    }

    /**
     * @return mixed
     */
    public function getCityName()
    {
        return $this->city_name;
    }

    /**
     * @param mixed $city_name
     */
    public function setCityName($city_name)
    {
        $this->city_name = $city_name;
    }

    /**
     * @return mixed
     */
    public function getLevelNumber()
    {
        return $this->level_number;
    }

    /**
     * @param mixed $level_number
     */
    public function setLevelNumber($level_number)
    {
        $this->level_number = $level_number;
    }

    /**
     * @return mixed
     */
    public function getExperienceToNextLevel()
    {
        return $this->experience_to_next_level;
    }

    /**
     * @param mixed $experience_to_next_level
     */
    public function setExperienceToNextLevel($experience_to_next_level)
    {
        $this->experience_to_next_level = $experience_to_next_level;
    }

    /**
     * @return mixed
     */
    public function getResources()
    {
        return $this->resources;
    }

    /**
     * @param mixed $resources
     */
    public function setResources($resources)
    {
        $this->resources = $resources;
    }
}