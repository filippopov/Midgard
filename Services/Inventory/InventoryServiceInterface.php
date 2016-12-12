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

    public function equippedItem($itemId);

    public function removeItem($itemId);

    public function alreadyInUse($itemId);
}