<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 11.12.2016 г.
 * Time: 17:48
 */

namespace FPopov\Models\View\Battle;


class BattleDefenderHeroWinHeroViewModel
{
    private $heroHalfFromMaxHP;

    private $winnerHonor;

    private $loseHonor;

    /**
     * BattleDefenderHeroWinHeroViewModel constructor.
     * @param $heroHalfFromMaxHP
     * @param $winnerHonor
     * @param $loseHonor
     */
    public function __construct($heroHalfFromMaxHP, $winnerHonor, $loseHonor)
    {
        $this->heroHalfFromMaxHP = $heroHalfFromMaxHP;
        $this->winnerHonor = $winnerHonor;
        $this->loseHonor = $loseHonor;
    }

    /**
     * @return mixed
     */
    public function getHeroHalfFromMaxHP()
    {
        return $this->heroHalfFromMaxHP;
    }

    /**
     * @param mixed $heroHalfFromMaxHP
     */
    public function setHeroHalfFromMaxHP($heroHalfFromMaxHP)
    {
        $this->heroHalfFromMaxHP = $heroHalfFromMaxHP;
    }

    /**
     * @return mixed
     */
    public function getWinnerHonor()
    {
        return $this->winnerHonor;
    }

    /**
     * @param mixed $winnerHonor
     */
    public function setWinnerHonor($winnerHonor)
    {
        $this->winnerHonor = $winnerHonor;
    }

    /**
     * @return mixed
     */
    public function getLoseHonor()
    {
        return $this->loseHonor;
    }

    /**
     * @param mixed $loseHonor
     */
    public function setLoseHonor($loseHonor)
    {
        $this->loseHonor = $loseHonor;
    }
}