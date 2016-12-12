<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 12.12.2016 г.
 * Time: 19:10
 */

namespace FPopov\Models\View\Level;


class LevelDataViewModel
{
    private $strength;

    private $dexterity;

    private $vitality;

    private $magic;

    private $levelPoints;

    /**
     * LevelDataViewModel constructor.
     * @param $strength
     * @param $dexterity
     * @param $vitality
     * @param $magic
     * @param $levelPoints
     */
    public function __construct($strength, $dexterity, $vitality, $magic, $levelPoints)
    {
        $this->strength = $strength;
        $this->dexterity = $dexterity;
        $this->vitality = $vitality;
        $this->magic = $magic;
        $this->levelPoints = $levelPoints;
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
    public function getLevelPoints()
    {
        return $this->levelPoints;
    }

    /**
     * @param mixed $levelPoints
     */
    public function setLevelPoints($levelPoints)
    {
        $this->levelPoints = $levelPoints;
    }
}