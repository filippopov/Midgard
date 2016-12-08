<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 8.12.2016 г.
 * Time: 10:53
 */

namespace FPopov\Repositories\Items;


use FPopov\Adapter\DatabaseInterface;
use FPopov\Repositories\AbstractRepository;

class ItemsRepository extends AbstractRepository implements ItemsRepositoryInterface
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
            'tableName' => 'items',
            'primaryKeyName' => 'id'
        ];
    }
}