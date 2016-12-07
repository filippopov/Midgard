<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 6.12.2016 г.
 * Time: 20:05
 */

namespace FPopov\Repositories\Hero;


use FPopov\Adapter\DatabaseInterface;
use FPopov\Repositories\AbstractRepository;
use FPopov\Services\Hero\HeroService;

class HeroRepository extends AbstractRepository implements HeroRepositoryInterface
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
            'tableName' => 'heroes',
            'primaryKeyName' => 'id'
        ];
    }

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
                AND h.hero_status != :deleteHeroStatus 
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

    public function changeStatus($heroId)
    {
        $deleteStatus = HeroService::DELETE_HERO_STATUS;
        $params = [$deleteStatus, $heroId];
        $query = "
            UPDATE
                heroes AS h
            SET
                h.hero_status = ?
            WHERE
                h.id = ?
        ";

        $stmt = $this->db->prepare($query);

        return $stmt->execute($params);
    }

    public function changeStatusOfHeroes($params = [])
    {
        $query = "
            UPDATE
                heroes AS h
            SET
                h.hero_status = 0
            WHERE
                h.id != ?
                AND h.user_id = ?
                AND h.hero_status != ?
        ";

        $stmt = $this->db->prepare($query);

        return $stmt->execute($params);
    }
}