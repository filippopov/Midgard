<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 8.12.2016 г.
 * Time: 23:42
 */

namespace FPopov\Repositories\Monsters;


interface MonstersRepositoryInterface
{
    public function findAllMonstersForCurentCity($params = []);

    public function findAllMonstersForCurentCityCount($params = []);

    public function monsterInformation($params = []);
}