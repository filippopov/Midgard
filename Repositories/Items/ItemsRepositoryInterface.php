<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 8.12.2016 г.
 * Time: 10:53
 */

namespace FPopov\Repositories\Items;


interface ItemsRepositoryInterface
{
    public function getAllItemsForOneHero($params = []);

    public function getAllItemsForOneHeroCount($params = []);

    public function getItemTypes($params = []);

    public function getWeaponsId($params = []);

    public function unEqupedWeapons($params = []);
}