<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 14.12.2016 г.
 * Time: 9:53
 */

namespace FPopov\Models\DB\TypeOfRecipes;


class TypeOfRecipes
{
    private $id;

    private $name;

    private $damage_low_value;

    private $damage_high_value;

    private $critical;

    private $armor;

    private $strength;

    private $dexterity;

    private $vitality;

    private $magic;

    private $health;

    private $mana;

    private $type_of_item_id;

    private $item_level;

    private $gold;

    private $iron;

    private $leather;

    private $silk;

    private $tree;

    private $duration;

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
    public function getCritical()
    {
        return $this->critical;
    }

    /**
     * @param mixed $critical
     */
    public function setCritical($critical)
    {
        $this->critical = $critical;
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
    public function getTypeOfItemId()
    {
        return $this->type_of_item_id;
    }

    /**
     * @param mixed $type_of_item_id
     */
    public function setTypeOfItemId($type_of_item_id)
    {
        $this->type_of_item_id = $type_of_item_id;
    }

    /**
     * @return mixed
     */
    public function getItemLevel()
    {
        return $this->item_level;
    }

    /**
     * @param mixed $item_level
     */
    public function setItemLevel($item_level)
    {
        $this->item_level = $item_level;
    }

    /**
     * @return mixed
     */
    public function getGold()
    {
        return $this->gold;
    }

    /**
     * @param mixed $gold
     */
    public function setGold($gold)
    {
        $this->gold = $gold;
    }

    /**
     * @return mixed
     */
    public function getIron()
    {
        return $this->iron;
    }

    /**
     * @param mixed $iron
     */
    public function setIron($iron)
    {
        $this->iron = $iron;
    }

    /**
     * @return mixed
     */
    public function getLeather()
    {
        return $this->leather;
    }

    /**
     * @param mixed $leather
     */
    public function setLeather($leather)
    {
        $this->leather = $leather;
    }

    /**
     * @return mixed
     */
    public function getSilk()
    {
        return $this->silk;
    }

    /**
     * @param mixed $silk
     */
    public function setSilk($silk)
    {
        $this->silk = $silk;
    }

    /**
     * @return mixed
     */
    public function getTree()
    {
        return $this->tree;
    }

    /**
     * @param mixed $tree
     */
    public function setTree($tree)
    {
        $this->tree = $tree;
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