<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 7.12.2016 г.
 * Time: 9:15
 */

namespace FPopov\Repositories\TypeOfHeroes;


use FPopov\Adapter\DatabaseInterface;
use FPopov\Repositories\AbstractRepository;

class TypeOfHeroesRepository extends AbstractRepository implements TypeOfHeroesRepositoryInterface
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
            'tableName' => 'type_of_heroes',
            'primaryKeyName' => 'id'
        ];
    }
}