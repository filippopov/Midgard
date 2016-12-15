<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 15.12.2016 г.
 * Time: 19:43
 */

namespace FPopov\Models\View\Inventory;


class SellItemViewModel
{
    private $itemId;

    /**
     * SellItemViewModel constructor.
     * @param $itemId
     */
    public function __construct($itemId)
    {
        $this->itemId = $itemId;
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