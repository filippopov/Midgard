<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 13.12.2016 г.
 * Time: 19:31
 */

namespace FPopov\Services\CreateItem;


interface CreateItemServiceInterface
{
    public function showRecipes($params = []);

    public function createItem($recipeId);

    public function startItem($typeOfRecipesId);

    public function takeItem($typeOfRecipesId);
}