<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 13.12.2016 г.
 * Time: 17:34
 */

namespace FPopov\Repositories\TypeOfRecipes;


interface TypeOfRecipesRepositoryInterface
{
    public function getAllRecipes($params = []);

    public function getAllRecipesCount($params = []);
}