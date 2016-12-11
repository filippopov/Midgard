<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 9.12.2016 г.
 * Time: 14:14
 */

namespace FPopov\Repositories\Battle;


interface BattleRepositoryInterface
{
    public function findAllHeroesForCurrentCity($params = []);

    public function findAllHeroesForCurrentCityCount($params = []);

    public function getWinHonorData($params = []);

    public function getLoseHonorData($params = []);
}