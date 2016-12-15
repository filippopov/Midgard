<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 15.12.2016 г.
 * Time: 9:29
 */

namespace FPopov\Models\DB\Shop;


class Shop
{
    private $id;

    private $name;

    private $damage_low_value;

    private $damage_high_value;

    private $armor;

    private $strength;

    private $vitality;

    private $magic;

    private $dexterity;

    private $health;

    private $mana;

    private $type_of_item_id;

    private $item_level;

    private $critical;

    private $shop_status;

    private $price;

    private $hero_id;

    /**
     * @return mixed
     */
    public function getHeroId()
    {
        return $this->hero_id;
    }

    /**
     * @param mixed $hero_id
     */
    public function setHeroId($hero_id)
    {
        $this->hero_id = $hero_id;
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
    public function getShopStatus()
    {
        return $this->shop_status;
    }

    /**
     * @param mixed $shop_status
     */
    public function setShopStatus($shop_status)
    {
        $this->shop_status = $shop_status;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }
}