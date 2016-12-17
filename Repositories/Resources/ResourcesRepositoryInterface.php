<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 7.12.2016 г.
 * Time: 15:00
 */

namespace FPopov\Repositories\Resources;


interface ResourcesRepositoryInterface
{
    public function getResourcesForOneHero($params = []);
}