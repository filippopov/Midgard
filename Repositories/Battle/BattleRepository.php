<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 9.12.2016 г.
 * Time: 14:14
 */

namespace FPopov\Repositories\Battle;


use FPopov\Adapter\DatabaseInterface;
use FPopov\Repositories\AbstractRepository;

class BattleRepository extends AbstractRepository implements BattleRepositoryInterface
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
            'tableName' => 'battle',
            'primaryKeyName' => 'id'
        ];
    }
}