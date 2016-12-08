<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 8.12.2016 г.
 * Time: 10:47
 */

namespace FPopov\Repositories\TypeOfItems;


use FPopov\Adapter\DatabaseInterface;
use FPopov\Repositories\AbstractRepository;
use FPopov\Repositories\TypeOfHeroes\TypeOfHeroesRepositoryInterface;

class TypeOfItemsRepository extends AbstractRepository implements TypeOfItemsRepositoryInterface
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
            'tableName' => 'type_of_items',
            'primaryKeyName' => 'id'
        ];
    }
}