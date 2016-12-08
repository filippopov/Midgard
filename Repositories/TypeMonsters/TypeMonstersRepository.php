<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 8.12.2016 г.
 * Time: 23:38
 */

namespace FPopov\Repositories\TypeMonsters;


use FPopov\Adapter\DatabaseInterface;
use FPopov\Repositories\AbstractRepository;

class TypeMonstersRepository extends AbstractRepository implements TypeMonstersRepositoryInterface
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
            'tableName' => 'type_monsters',
            'primaryKeyName' => 'id'
        ];
    }
}