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

    public function findAllHeroesForCurrentCity($params = [])
    {
        $listOfFields = [
            'h.id',
            'h.name',
            'l.level_number',
            'r.amount AS honor',
            'toh.name AS type_of_hero'
        ];

        $searchFields = [
            'name' => 'h.name'
        ];

        $orderFields = [
            'id' => 'h.id',
            'name' => 'h.name',
            'level_number' => 'l.level_number',
            'honor' => 'r.amount',
            'type_of_hero' => 'toh.name'
        ];

        $onlyCount = isset($params['onlyCount']) ? true : false;

        list($select, $where, $order, $limit) = $this->buildQuery($params, $listOfFields, $searchFields, $orderFields);

        $query = "
            SELECT
              " . implode(', ', $select) . "
            FROM 
                heroes AS h
            INNER JOIN 
                level AS l ON (h.level_id = l.id)
            INNER JOIN 
                type_of_heroes AS toh ON (h.type_of_heroes_id = toh.id)
            INNER JOIN 
                resources AS r ON (r.heroes_id = h.id)
            INNER JOIN 
                type_of_resources AS tor ON (r.type_of_resources_id = tor.id)
            WHERE
                tor.name = :honor
                AND h.user_id != :userId
                AND h.city_id = :cityId
        ";

        $query .= $where . $order . $limit;

        $stmt = $this->db->prepare($query);

        $stmt->execute($params);

        return $stmt->fetchAll();
    }

    public function findAllHeroesForCurrentCityCount($params = [])
    {
        $params['onlyCount'] = '*';

        $result = $this->findAllHeroesForCurrentCity($params);

        return isset($result[0]) ? $result[0]['count'] : 0;
    }

    public function getWinHonorData($params = [])
    {
        $query = "
            SELECT
                r.amount + 10 AS amaunt, 
                r.id
            FROM 
                resources AS r
            INNER JOIN 
                type_of_resources AS tor ON (r.type_of_resources_id = tor.id)
            WHERE
                tor.name = ?
                AND r.heroes_id = ?
            LIMIT 1
        ";

        $stmt = $this->db->prepare($query);

        $stmt->execute($params);

        return $stmt->fetch();
    }

    public function getLoseHonorData($params = [])
    {
        $query = "
            SELECT
                r.amount - 10 AS amaunt, 
                r.id
            FROM 
                resources AS r
            INNER JOIN 
                type_of_resources AS tor ON (r.type_of_resources_id = tor.id)
            WHERE
                tor.name = ?
                AND r.heroes_id = ?
            LIMIT 1
        ";

        $stmt = $this->db->prepare($query);

        $stmt->execute($params);

        return $stmt->fetch();
    }
}