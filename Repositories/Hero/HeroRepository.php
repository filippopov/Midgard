<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 6.12.2016 г.
 * Time: 20:05
 */

namespace FPopov\Repositories\Hero;


use FPopov\Adapter\DatabaseInterface;
use FPopov\Models\DB\Hero\HeroStatistic;
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

    public function heroInformation($params = [])
    {
        $query = "
              SELECT
                  h.name AS hero_name,
                  h.real_health + ei.health AS real_health,
                  h.real_mana + ei.mana AS real_mana,
                  h.experience,
                  h.damage_low_value + ei.damage_low_value AS damage_low_value,
                  h.damage_high_value + ei.damage_high_value AS damage_high_value,
                  h.armor + ei.armor AS armor,
                  h.strength,
                  h.magic,
                  h.vitality,
                  h.dexterity,
                  h.health + ei.health AS max_health,
                  h.mana + ei.mana AS max_mana,
                  h.critical + ei.critical AS critical_chance,
                  c.name AS city_name,
                  l.level_number,
                  l.to_experience AS experience_to_next_level,
                  group_concat(concat(tor.name,' - '), r.amount separator ', ') AS resources
              FROM 
                  resources AS r
              INNER JOIN 
                  type_of_resources AS tor ON (r.type_of_resources_id = tor.id)
              INNER JOIN 
                  heroes AS h ON (r.heroes_id = h.id)
              INNER JOIN 
                  level AS l ON (h.level_id = l.id)
              INNER JOIN 
                  city AS c ON (h.city_id = c.id)
              INNER JOIN (
                  SELECT
                      SUM(ceil(i.damage_low_value + (i.strength/2))) AS damage_low_value,
                      SUM(ceil(i.damage_high_value + (i.strength/2))) AS damage_high_value,
                      SUM(i.armor + (i.dexterity * 2)) AS armor,
                      SUM(i.strength),
                      SUM(i.vitality),
                      SUM(i.magic),
                      SUM(i.dexterity),
                      SUM(i.health + (i.vitality * 10)) AS health,
                      SUM(i.mana + (i.magic * 10)) AS mana,
                      i.hero_id,
                      SUM(i.critical + (i.dexterity * 0.01)) AS critical
                  FROM 
                      items AS i
                  WHERE 
                      i.is_equiped = ?
                  HAVING 
                      i.hero_id) AS ei ON (ei.hero_id = h.id)
              WHERE 
                  h.id = ?;
        ";

        $stmt = $this->db->prepare($query);

        $stmt->execute($params);

        return $stmt->fetchObject(HeroStatistic::class);
    }
}