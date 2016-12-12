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
                  CASE 
                      WHEN 
                          ei.health IS NULL OR ei.health = '' 
                      THEN 
                          h.real_health 
                      ELSE 
                        h.real_health + ei.health
                  END  AS real_health,
                  CASE 
                      WHEN 
                          ei.health IS NULL OR ei.health = '' 
                      THEN 
                          0 
                      ELSE 
                        ei.health
                  END  AS health_from_items, 
                  CASE 
                      WHEN 
                          ei.mana IS NULL OR ei.mana = '' 
                      THEN 
                          h.real_mana 
                      ELSE 
                        h.real_mana + ei.mana
                  END  AS real_mana,
                  h.experience,
                  CASE 
                      WHEN 
                          ei.damage_low_value IS NULL OR ei.damage_low_value = '' 
                      THEN 
                          h.damage_low_value 
                      ELSE 
                        h.damage_low_value + ei.damage_low_value
                  END  AS damage_low_value,
                  CASE 
                      WHEN 
                          ei.damage_high_value IS NULL OR ei.damage_high_value = '' 
                      THEN 
                          h.damage_high_value 
                      ELSE 
                        h.damage_high_value + ei.damage_high_value
                  END  AS damage_high_value,
                  CASE 
                      WHEN 
                          ei.armor IS NULL OR ei.armor = '' 
                      THEN 
                          h.armor 
                      ELSE 
                        h.armor + ei.armor
                  END  AS armor,
                  CASE 
                      WHEN 
                          ei.strength IS NULL OR ei.strength = '' 
                      THEN 
                          h.strength 
                      ELSE 
                        h.strength + ei.strength
                  END  AS strength,
                  CASE 
                      WHEN 
                          ei.magic IS NULL OR ei.magic = '' 
                      THEN 
                          h.magic 
                      ELSE 
                        h.magic + ei.magic
                  END  AS magic,
                  CASE 
                      WHEN 
                          ei.vitality IS NULL OR ei.vitality = '' 
                      THEN 
                          h.vitality 
                      ELSE 
                        h.vitality + ei.vitality
                  END  AS vitality,
                  CASE 
                      WHEN 
                          ei.dexterity IS NULL OR ei.dexterity = '' 
                      THEN 
                          h.dexterity 
                      ELSE 
                        h.dexterity + ei.dexterity
                  END  AS dexterity,
                  CASE 
                      WHEN 
                          ei.health IS NULL OR ei.health = '' 
                      THEN 
                          h.health 
                      ELSE 
                        h.health + ei.health
                  END  AS max_health,
                   CASE 
                      WHEN 
                          ei.mana IS NULL OR ei.mana = '' 
                      THEN 
                          h.mana 
                      ELSE 
                        h.mana + ei.mana
                  END  AS max_mana,
                  CASE 
                      WHEN 
                          ei.critical IS NULL OR ei.critical = '' 
                      THEN 
                          h.critical 
                      ELSE 
                          h.critical + ei.critical
                  END  AS critical_chance,
                  c.name AS city_name,
                  l.level_number,
                  l.to_experience AS experience_to_next_level,
                  toh.name AS hero_type,
                  group_concat(concat(tor.name,' - '), r.amount separator ', ') AS resources,
                  h.hero_status,
                  h.level_points
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
              INNER JOIN 
                  type_of_heroes AS toh ON (h.type_of_heroes_id = toh.id)  
              LEFT JOIN (
                  SELECT
                      SUM(ceil(i.damage_low_value + (i.strength/2))) AS damage_low_value,
                      SUM(ceil(i.damage_high_value + (i.strength/2))) AS damage_high_value,
                      SUM(i.armor + (i.dexterity * 2)) AS armor,
                      SUM(i.strength) AS strength,
                      SUM(i.vitality) AS vitality,
                      SUM(i.magic) AS magic,
                      SUM(i.dexterity) AS dexterity,
                      SUM(i.health + (i.vitality * 10)) AS health,
                      SUM(i.mana + (i.magic * 10)) AS mana,
                      i.hero_id,
                      SUM(i.critical + (i.dexterity * 0.01)) AS critical
                  FROM 
                      items AS i
                  WHERE 
                      i.is_equiped = ? 
                      AND i.hero_id = ? 
                  HAVING 
                      i.hero_id) AS ei ON (ei.hero_id = h.id)
              WHERE 
                  h.id = ?;
        ";

        $stmt = $this->db->prepare($query);

        $stmt->execute($params);

        return $stmt->fetchObject(HeroStatistic::class);
    }

    public function getTypeOfHeroById($params = [])
    {
        $query = "
            SELECT 
                toh.name AS type_of_hero
            FROM 
                heroes AS h 
            INNER JOIN 
                type_of_heroes AS toh ON (h.type_of_heroes_id = toh.id)
            WHERE 
                h.id = ?
            LIMIT 1;   
        ";

        $stmt = $this->db->prepare($query);

        $stmt->execute($params);

        return $stmt->fetch();
    }
}