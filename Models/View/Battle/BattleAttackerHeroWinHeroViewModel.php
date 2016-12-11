<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 11.12.2016 г.
 * Time: 18:24
 */

namespace FPopov\Models\View\Battle;


class BattleAttackerHeroWinHeroViewModel
{
    private $winnerHonor;

    /**
     * AttackerHeroWinHeroViewModel constructor.
     * @param $winnerHonor
     */
    public function __construct($winnerHonor)
    {
        $this->winnerHonor = $winnerHonor;
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
}