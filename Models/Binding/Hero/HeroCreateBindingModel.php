<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 6.12.2016 г.
 * Time: 20:34
 */

namespace FPopov\Models\Binding\Hero;


class HeroCreateBindingModel
{
    private $heroName;
    private $heroType;

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