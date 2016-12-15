<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 15.12.2016 г.
 * Time: 10:37
 */

namespace FPopov\Services\Shop;


interface ShopServiceInterface
{
    public function shopItems($params = []);

    public function byeItem($shopItemId);
}