<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 9.12.2016 г.
 * Time: 11:31
 */

namespace FPopov\Models\View\Battle;


class BattleHeroMonsterViewModel
{
    private $monsterType;

    private $monsterDamageLowValue;

    private $monsterDamageHighValue;

    private $monsterArmor;

    private $monsterHealth;

    private $heroName;

    private $heroRealHealth;

    private $heroRealMana;

    private $heroDamageLowValue;

    private $heroDamageHighValue;

    private $heroArmor;

    private $heroMaxHealth;

    private $heroMaxMana;

    private $heroCriticalChance;

    private $heroLevelNumber;

    private $heroType;

    /**
     * BattleHeroMonsterViewModel constructor.
     * @param $monsterType
     * @param $monsterDamageLowValue
     * @param $monsterDamageHighValue
     * @param $monsterArmor
     * @param $monsterHealth
     * @param $heroName
     * @param $heroRealHealth
     * @param $heroRealMana
     * @param $heroDamageLowValue
     * @param $heroDamageHighValue
     * @param $heroArmor
     * @param $heroMaxHealth
     * @param $heroMaxMana
     * @param $heroCriticalChance
     * @param $heroLevelNumber
     * @param $heroType
     */
    public function __construct($monsterType, $monsterDamageLowValue, $monsterDamageHighValue, $monsterArmor, $monsterHealth, $heroName, $heroRealHealth, $heroRealMana, $heroDamageLowValue, $heroDamageHighValue, $heroArmor, $heroMaxHealth, $heroMaxMana, $heroCriticalChance, $heroLevelNumber, $heroType)
    {
        $this->monsterType = $monsterType;
        $this->monsterDamageLowValue = $monsterDamageLowValue;
        $this->monsterDamageHighValue = $monsterDamageHighValue;
        $this->monsterArmor = $monsterArmor;
        $this->monsterHealth = $monsterHealth;
        $this->heroName = $heroName;
        $this->heroRealHealth = $heroRealHealth;
        $this->heroRealMana = $heroRealMana;
        $this->heroDamageLowValue = $heroDamageLowValue;
        $this->heroDamageHighValue = $heroDamageHighValue;
        $this->heroArmor = $heroArmor;
        $this->heroMaxHealth = $heroMaxHealth;
        $this->heroMaxMana = $heroMaxMana;
        $this->heroCriticalChance = $heroCriticalChance;
        $this->heroLevelNumber = $heroLevelNumber;
        $this->heroType = $heroType;
    }

    /**
     * @return mixed
     */
    public function getMonsterType()
    {
        return $this->monsterType;
    }

    /**
     * @param mixed $monsterType
     */
    public function setMonsterType($monsterType)
    {
        $this->monsterType = $monsterType;
    }

    /**
     * @return mixed
     */
    public function getMonsterDamageLowValue()
    {
        return $this->monsterDamageLowValue;
    }

    /**
     * @param mixed $monsterDamageLowValue
     */
    public function setMonsterDamageLowValue($monsterDamageLowValue)
    {
        $this->monsterDamageLowValue = $monsterDamageLowValue;
    }

    /**
     * @return mixed
     */
    public function getMonsterDamageHighValue()
    {
        return $this->monsterDamageHighValue;
    }

    /**
     * @param mixed $monsterDamageHighValue
     */
    public function setMonsterDamageHighValue($monsterDamageHighValue)
    {
        $this->monsterDamageHighValue = $monsterDamageHighValue;
    }

    /**
     * @return mixed
     */
    public function getMonsterArmor()
    {
        return $this->monsterArmor;
    }

    /**
     * @param mixed $monsterArmor
     */
    public function setMonsterArmor($monsterArmor)
    {
        $this->monsterArmor = $monsterArmor;
    }

    /**
     * @return mixed
     */
    public function getMonsterHealth()
    {
        return $this->monsterHealth;
    }

    /**
     * @param mixed $monsterHealth
     */
    public function setMonsterHealth($monsterHealth)
    {
        $this->monsterHealth = $monsterHealth;
    }

    /**
     * @return mixed
     */
    public function getHeroName()
    {
        return $this->heroName;
    }

    /**
     * @param mixed $heroName
     */
    public function setHeroName($heroName)
    {
        $this->heroName = $heroName;
    }

    /**
     * @return mixed
     */
    public function getHeroRealHealth()
    {
        return $this->heroRealHealth;
    }

    /**
     * @param mixed $heroRealHealth
     */
    public function setHeroRealHealth($heroRealHealth)
    {
        $this->heroRealHealth = $heroRealHealth;
    }

    /**
     * @return mixed
     */
    public function getHeroRealMana()
    {
        return $this->heroRealMana;
    }

    /**
     * @param mixed $heroRealMana
     */
    public function setHeroRealMana($heroRealMana)
    {
        $this->heroRealMana = $heroRealMana;
    }

    /**
     * @return mixed
     */
    public function getHeroDamageLowValue()
    {
        return $this->heroDamageLowValue;
    }

    /**
     * @param mixed $heroDamageLowValue
     */
    public function setHeroDamageLowValue($heroDamageLowValue)
    {
        $this->heroDamageLowValue = $heroDamageLowValue;
    }

    /**
     * @return mixed
     */
    public function getHeroDamageHighValue()
    {
        return $this->heroDamageHighValue;
    }

    /**
     * @param mixed $heroDamageHighValue
     */
    public function setHeroDamageHighValue($heroDamageHighValue)
    {
        $this->heroDamageHighValue = $heroDamageHighValue;
    }

    /**
     * @return mixed
     */
    public function getHeroArmor()
    {
        return $this->heroArmor;
    }

    /**
     * @param mixed $heroArmor
     */
    public function setHeroArmor($heroArmor)
    {
        $this->heroArmor = $heroArmor;
    }

    /**
     * @return mixed
     */
    public function getHeroMaxHealth()
    {
        return $this->heroMaxHealth;
    }

    /**
     * @param mixed $heroMaxHealth
     */
    public function setHeroMaxHealth($heroMaxHealth)
    {
        $this->heroMaxHealth = $heroMaxHealth;
    }

    /**
     * @return mixed
     */
    public function getHeroMaxMana()
    {
        return $this->heroMaxMana;
    }

    /**
     * @param mixed $heroMaxMana
     */
    public function setHeroMaxMana($heroMaxMana)
    {
        $this->heroMaxMana = $heroMaxMana;
    }

    /**
     * @return mixed
     */
    public function getHeroCriticalChance()
    {
        return $this->heroCriticalChance;
    }

    /**
     * @param mixed $heroCriticalChance
     */
    public function setHeroCriticalChance($heroCriticalChance)
    {
        $this->heroCriticalChance = $heroCriticalChance;
    }

    /**
     * @return mixed
     */
    public function getHeroLevelNumber()
    {
        return $this->heroLevelNumber;
    }

    /**
     * @param mixed $heroLevelNumber
     */
    public function setHeroLevelNumber($heroLevelNumber)
    {
        $this->heroLevelNumber = $heroLevelNumber;
    }

    /**
     * @return mixed
     */
    public function getHeroType()
    {
        return $this->heroType;
    }

    /**
     * @param mixed $heroType
     */
    public function setHeroType($heroType)
    {
        $this->heroType = $heroType;
    }
}