<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 6.12.2016 г.
 * Time: 20:05
 */

namespace FPopov\Repositories\Hero;


interface HeroRepositoryInterface
{
    public function findAllHeroesForCurrentUser($params = []);

    public function findAllHeroesForCurrentUserCount($params = []);

    public function changeStatus($heroId);

    public function changeStatusOfHeroes($params = []);

    public function heroInformation($params = []);

    public function getTypeOfHeroById($params = []);
}