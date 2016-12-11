<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 11.12.2016 г.
 * Time: 9:13
 */

namespace FPopov\Models\View\Battle;


class BattleHeroDefenderHeroViewModel
{
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

    private $defenderHeroName;

    private $defenderHeroHealth;

    private $defenderHeroMana;

    private $defenderHeroDamageLowValue;

    private $defenderHeroDamageHighValue;

    private $defenderHeroArmor;

    private $defenderHeroCriticalChance;

    private $defenderHeroLevelNumber;

    private $defenderHeroType;

    private $heroAndDefendHeroInBattle;

    private $defendHeroRealHealth;

    /**
     * BattleHeroDefenderHeroViewModel constructor.
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
     * @param $defenderHeroName
     * @param $defenderHeroHealth
     * @param $defenderHeroMana
     * @param $defenderHeroDamageLowValue
     * @param $defenderHeroDamageHighValue
     * @param $defenderHeroArmor
     * @param $defenderHeroCriticalChance
     * @param $defenderHeroLevelNumber
     * @param $defenderHeroType
     * @param $heroAndDefendHeroInBattle
     * @param $defendHeroRealHealth
     */
    public function __construct($heroName, $heroRealHealth, $heroRealMana, $heroDamageLowValue, $heroDamageHighValue, $heroArmor, $heroMaxHealth, $heroMaxMana, $heroCriticalChance, $heroLevelNumber, $heroType, $defenderHeroName, $defenderHeroHealth, $defenderHeroMana, $defenderHeroDamageLowValue, $defenderHeroDamageHighValue, $defenderHeroArmor, $defenderHeroCriticalChance, $defenderHeroLevelNumber, $defenderHeroType, $heroAndDefendHeroInBattle, $defendHeroRealHealth)
    {
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
        $this->defenderHeroName = $defenderHeroName;
        $this->defenderHeroHealth = $defenderHeroHealth;
        $this->defenderHeroMana = $defenderHeroMana;
        $this->defenderHeroDamageLowValue = $defenderHeroDamageLowValue;
        $this->defenderHeroDamageHighValue = $defenderHeroDamageHighValue;
        $this->defenderHeroArmor = $defenderHeroArmor;
        $this->defenderHeroCriticalChance = $defenderHeroCriticalChance;
        $this->defenderHeroLevelNumber = $defenderHeroLevelNumber;
        $this->defenderHeroType = $defenderHeroType;
        $this->heroAndDefendHeroInBattle = $heroAndDefendHeroInBattle;
        $this->defendHeroRealHealth = $defendHeroRealHealth;
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

    /**
     * @return mixed
     */
    public function getDefenderHeroName()
    {
        return $this->defenderHeroName;
    }

    /**
     * @param mixed $defenderHeroName
     */
    public function setDefenderHeroName($defenderHeroName)
    {
        $this->defenderHeroName = $defenderHeroName;
    }

    /**
     * @return mixed
     */
    public function getDefenderHeroHealth()
    {
        return $this->defenderHeroHealth;
    }

    /**
     * @param mixed $defenderHeroHealth
     */
    public function setDefenderHeroHealth($defenderHeroHealth)
    {
        $this->defenderHeroHealth = $defenderHeroHealth;
    }

    /**
     * @return mixed
     */
    public function getDefenderHeroMana()
    {
        return $this->defenderHeroMana;
    }

    /**
     * @param mixed $defenderHeroMana
     */
    public function setDefenderHeroMana($defenderHeroMana)
    {
        $this->defenderHeroMana = $defenderHeroMana;
    }

    /**
     * @return mixed
     */
    public function getDefenderHeroDamageLowValue()
    {
        return $this->defenderHeroDamageLowValue;
    }

    /**
     * @param mixed $defenderHeroDamageLowValue
     */
    public function setDefenderHeroDamageLowValue($defenderHeroDamageLowValue)
    {
        $this->defenderHeroDamageLowValue = $defenderHeroDamageLowValue;
    }

    /**
     * @return mixed
     */
    public function getDefenderHeroDamageHighValue()
    {
        return $this->defenderHeroDamageHighValue;
    }

    /**
     * @param mixed $defenderHeroDamageHighValue
     */
    public function setDefenderHeroDamageHighValue($defenderHeroDamageHighValue)
    {
        $this->defenderHeroDamageHighValue = $defenderHeroDamageHighValue;
    }

    /**
     * @return mixed
     */
    public function getDefenderHeroArmor()
    {
        return $this->defenderHeroArmor;
    }

    /**
     * @param mixed $defenderHeroArmor
     */
    public function setDefenderHeroArmor($defenderHeroArmor)
    {
        $this->defenderHeroArmor = $defenderHeroArmor;
    }

    /**
     * @return mixed
     */
    public function getDefenderHeroCriticalChance()
    {
        return $this->defenderHeroCriticalChance;
    }

    /**
     * @param mixed $defenderHeroCriticalChance
     */
    public function setDefenderHeroCriticalChance($defenderHeroCriticalChance)
    {
        $this->defenderHeroCriticalChance = $defenderHeroCriticalChance;
    }

    /**
     * @return mixed
     */
    public function getDefenderHeroLevelNumber()
    {
        return $this->defenderHeroLevelNumber;
    }

    /**
     * @param mixed $defenderHeroLevelNumber
     */
    public function setDefenderHeroLevelNumber($defenderHeroLevelNumber)
    {
        $this->defenderHeroLevelNumber = $defenderHeroLevelNumber;
    }

    /**
     * @return mixed
     */
    public function getDefenderHeroType()
    {
        return $this->defenderHeroType;
    }

    /**
     * @param mixed $defenderHeroType
     */
    public function setDefenderHeroType($defenderHeroType)
    {
        $this->defenderHeroType = $defenderHeroType;
    }

    /**
     * @return mixed
     */
    public function getHeroAndDefendHeroInBattle()
    {
        return $this->heroAndDefendHeroInBattle;
    }

    /**
     * @param mixed $heroAndDefendHeroInBattle
     */
    public function setHeroAndDefendHeroInBattle($heroAndDefendHeroInBattle)
    {
        $this->heroAndDefendHeroInBattle = $heroAndDefendHeroInBattle;
    }

    /**
     * @return mixed
     */
    public function getDefendHeroRealHealth()
    {
        return $this->defendHeroRealHealth;
    }

    /**
     * @param mixed $defendHeroRealHealth
     */
    public function setDefendHeroRealHealth($defendHeroRealHealth)
    {
        $this->defendHeroRealHealth = $defendHeroRealHealth;
    }
}