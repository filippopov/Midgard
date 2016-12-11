<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 11.12.2016 г.
 * Time: 19:40
 */

namespace FPopov\Services\Inventory;


interface InventoryServiceInterface
{
    public function inventory($params = []);
}