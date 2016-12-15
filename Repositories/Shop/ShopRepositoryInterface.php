<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 15.12.2016 г.
 * Time: 9:24
 */

namespace FPopov\Repositories\Shop;


interface ShopRepositoryInterface
{
    public function getAllItemsFromShopByStatus($params = []);

    public function getAllItemsFromShopByStatusCount($params = []);
}