<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 15.12.2016 г.
 * Time: 19:48
 */

namespace FPopov\Models\Binding\Inventory;


class SellItemBindingModel
{
    private $price;

    private $itemId;

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function getItemId()
    {
        return $this->itemId;
    }

    /**
     * @param mixed $itemId
     */
    public function setItemId($itemId)
    {
        $this->itemId = $itemId;
    }


}