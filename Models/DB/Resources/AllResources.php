<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 17.12.2016 г.
 * Time: 8:45
 */

namespace FPopov\Models\DB\Resources;


class AllResources
{
    private $resources;

    /**
     * @return mixed
     */
    public function getResources()
    {
        return $this->resources;
    }

    /**
     * @param mixed $resources
     */
    public function setResources($resources)
    {
        $this->resources = $resources;
    }

}