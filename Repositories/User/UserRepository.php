<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 29.11.2016 г.
 * Time: 14:21
 */

namespace FPopov\Repositories\User;


use FPopov\Adapter\DatabaseInterface;
use FPopov\Repositories\AbstractRepository;

class UserRepository extends AbstractRepository implements UserRepositoryInterface
{
    protected $db;
    /**
     * UserRepository constructor.
     */
    public function __construct(DatabaseInterface $db)
    {
        parent::__construct($db);
        $this->db = $db;
    }

    public function setOptions()
    {
        return [
            'tableName' => 'users',
            'primaryKeyName' => 'id'
        ];
    }

//    public function testGrid($params = array())
//    {
//        $listOfFields = [
//            'c.id',
//            'c.name'
//        ];
//
//        $searchFields = [
//            'id' => 'c.id',
//            'name' => 'c.name'
//        ];
//
//        $orderFields = [
//            'id' => 'c.id',
//            'name' => 'c.name'
//        ];
//
//        $onlyCount = isset($params['onlyCount']) ? true : false;
//
//        list($select, $where, $order, $limit) = $this->buildQuery($params, $listOfFields, $searchFields, $orderFields);
//
//        $query = "
//            SELECT
//                " . implode(', ', $select) . "
//            FROM
//                categories AS c
//            WHERE
//                TRUE
//        ";
//
//        $query .= $where . $order . $limit;
//
//        $stmt = $this->db->prepare($query);
//
//        $stmt->execute($params);
//
//        return $stmt->fetchAll();
//    }
//
//    public function testGridCount($params = [])
//    {
//        $params['onlyCount'] = '*';
//
//        $result = $this->testGrid($params);
//
//        return isset($result[0]) ? $result[0]['count'] : 0;
//    }

    public function findAllHeroesForCurrentUser($params = [])
    {
        $listOfFields = [
            'h.id',
            'h.name AS hero_name',
            'toh.name AS hero_type',
            'l.level_number AS level',
            'l.to_experience',
            'c.name AS city_name',
            'c.coordinates_x',
            'c.coordinates_y',
            'h.experience'
        ];

        $searchFields = [
            'name' => 'h.name'
        ];

        $orderFields = [
            'id' => 'h.id',
            'hero_name' => 'h.name',
            'hero_type' => 'toh.name',
            'level' => 'l.level_number',
            'to_experience' => 'l.to_experience',
            'city_name' => 'c.name',
            'coordinates_x' => 'c.coordinates_x',
            'coordinates_y' => 'c.coordinates_y',
            'experience' => 'h.experience'
        ];

        $onlyCount = isset($params['onlyCount']) ? true : false;

        list($select, $where, $order, $limit) = $this->buildQuery($params, $listOfFields, $searchFields, $orderFields);

        $query = "
            SELECT 
                " . implode(', ', $select) . "
            FROM heroes AS h
                INNER JOIN 
                    type_of_heroes AS toh ON (h.type_of_heroes_id = toh.id)
                INNER JOIN 
                    level as l ON (h.level_id = l.id)
                INNER JOIN city AS c ON (h.city_id = c.id)
            WHERE 
                h.user_id = :userId 
        ";

        $query .= $where . $order . $limit;

        $stmt = $this->db->prepare($query);

        $stmt->execute($params);

        return $stmt->fetchAll();
    }

    public function findAllHeroesForCurrentUserCount($params = [])
    {
        $params['onlyCount'] = '*';

        $result = $this->findAllHeroesForCurrentUser($params);

        return isset($result[0]) ? $result[0]['count'] : 0;
    }
}