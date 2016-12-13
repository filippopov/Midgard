<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 13.12.2016 г.
 * Time: 17:37
 */

namespace FPopov\Repositories\Recipes;


use FPopov\Adapter\DatabaseInterface;
use FPopov\Repositories\AbstractRepository;

class RecipesRepository extends AbstractRepository implements RecipesRepositoryInterface
{
    protected $db;

    public function __construct(DatabaseInterface $db)
    {
        parent::__construct($db);
        $this->db = $db;
    }

    public function setOptions()
    {
        return [
            'tableName' => 'recipes',
            'primaryKeyName' => 'id'
        ];
    }
}