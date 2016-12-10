<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 10.12.2016 г.
 * Time: 13:02
 */

namespace FPopov\Models\View\Battle;


class BattleHeroWinMonsterViewModel
{
    private $monsterType;

    private $gold;

    private $experience;

    private $itemName;

    /**
     * BattleHeroWinMonsterViewModel constructor.
     * @param $monsterType
     * @param $gold
     * @param $experience
     * @param $itemName
     */
    public function __construct($monsterType, $gold, $experience, $itemName)
    {
        $this->monsterType = $monsterType;
        $this->gold = $gold;
        $this->experience = $experience;
        $this->itemName = $itemName;
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
    public function getItemName()
    {
        return $this->itemName;
    }

    /**
     * @param mixed $itemName
     */
    public function setItemName($itemName)
    {
        $this->itemName = $itemName;
    }


}

