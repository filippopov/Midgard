<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 13.12.2016 г.
 * Time: 17:37
 */

namespace FPopov\Repositories\Recipes;


interface RecipesRepositoryInterface
{
    public function checkEnoughResources($params = []);

    public function getAllTypeOfResourceForOneUserWithoutHonor($params =[]);

    public function getResourcesAmountByHeroIdAndName($params = []);
}