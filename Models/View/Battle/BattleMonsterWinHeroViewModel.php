<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 10.12.2016 г.
 * Time: 16:34
 */

namespace FPopov\Models\View\Battle;


class BattleMonsterWinHeroViewModel
{
    private $monsterType;

    private $lostExperience;

    private $heroHealth;

    /**
     * BattleMonsterWinHeroViewModel constructor.
     * @param $monsterType
     * @param $lostExperience
     * @param $heroHealth
     */
    public function __construct($monsterType, $lostExperience, $heroHealth)
    {
        $this->monsterType = $monsterType;
        $this->lostExperience = $lostExperience;
        $this->heroHealth = $heroHealth;
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
    public function getLostExperience()
    {
        return $this->lostExperience;
    }

    /**
     * @param mixed $lostExperience
     */
    public function setLostExperience($lostExperience)
    {
        $this->lostExperience = $lostExperience;
    }

    /**
     * @return mixed
     */
    public function getHeroHealth()
    {
        return $this->heroHealth;
    }

    /**
     * @param mixed $heroHealth
     */
    public function setHeroHealth($heroHealth)
    {
        $this->heroHealth = $heroHealth;
    }
}


