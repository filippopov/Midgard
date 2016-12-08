<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 8.12.2016 г.
 * Time: 23:42
 */

namespace FPopov\Repositories\Monsters;


use FPopov\Adapter\DatabaseInterface;
use FPopov\Repositories\AbstractRepository;

class MonstersRepository extends AbstractRepository implements MonstersRepositoryInterface
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
            'tableName' => 'monsters',
            'primaryKeyName' => 'id'
        ];
    }

    public function findAllMonstersForCurentCity($bindFilter = [])
    {
        $listOfFields = [
            'm.id',
            'tm.name AS type_of_monster',
            'c.name AS city_name',
            'concat(m.damage_low_value, \' - \', m.damage_high_value) AS damage',
            'm.damage_low_value',
            'm.damage_high_value',
            'm.armor',
            'm.health'
        ];

        $searchFields = [
            'type_of_monster' => 'tm.name'
        ];

        $orderFields = [
            'id' => 'm.id',
            'type_of_monster' => 'tm.name',
            'city_name' => 'c.name',
            'damage' => 'concat(m.damage_low_value, \' - \', m.damage_high_value)',
            'damage_low_value' => 'm.damage_low_value',
            'damage_high_value' => 'm.damage_high_value',
            'armor' => 'm.armor',
            'health' => 'm.health'
        ];

        $onlyCount = isset($params['onlyCount']) ? true : false;

        list($select, $where, $order, $limit) = $this->buildQuery($params, $listOfFields, $searchFields, $orderFields);
        $query = "
            SELECT
                " . implode(', ', $select) . "
            FROM 
                monsters AS m
            INNER JOIN 
                type_monsters AS tm ON (m.type_monsters_id = tm.id)
            INNER JOIN 
                city AS c ON (m.city_id = c.id)
            WHERE 
                m.city_id = ?   
        ";

        $query .= $where . $order . $limit;

        $stmt = $this->db->prepare($query);

        $stmt->execute($params);

        return $stmt->fetchAll();
    }

    public function findAllMonstersForCurentCityCount($params = [])
    {
        $params['onlyCount'] = '*';

        $result = $this->findAllMonstersForCurentCity($params);

        return isset($result[0]) ? $result[0]['count'] : 0;
    }
}