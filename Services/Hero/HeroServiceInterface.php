<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 6.12.2016 г.
 * Time: 20:00
 */

namespace FPopov\Services\Hero;


interface HeroServiceInterface
{
    public function findAllHeroesForCurrentUser($params = []);

    public function createHero();

    public function addGridHero($heroName, $heroType);
}