<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 7.12.2016 г.
 * Time: 11:46
 */

namespace FPopov\Repositories\City;


use FPopov\Adapter\DatabaseInterface;
use FPopov\Repositories\AbstractRepository;

class CityRepository extends AbstractRepository implements CityRepositoryInterface
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
            'tableName' => 'city',
            'primaryKeyName' => 'id'
        ];
    }
}