<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 20.1.2017 г.
 * Time: 10:43
 */

namespace FPopov\Repositories\Skills;


use FPopov\Adapter\DatabaseInterface;
use FPopov\Repositories\AbstractRepository;
use FPopov\Services\AbstractService;

class SkillsRepository extends AbstractRepository  implements SkillsRepositoryInterface
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
            'tableName' => 'skills',
            'primaryKeyName' => 'id'
        ];
    }

    public function getAllSkillsForCurrentHero($params = [])
    {
        $listOfFields = [
                's.id',
                's.name AS skill_name',
                'CASE
                    WHEN
                      s.is_active = 0
                    THEN
                      \'Passive Skill\'
                    ELSE
                      \'Active Skill\'
                    END AS type_of_skill',
                's.description',
                'CASE
                    WHEN
                      hs.level IS NULL OR hs.level = \'\'
                    THEN
                      0
                    ELSE
                      hs.level
                    END AS skill_level'
        ];

        $searchFields = [
            'skill_name' => 's.name'
        ];

        $orderFields = [
            'id' => 's.id',
            'skill_name' => 's.name',
            'type_of_skill' => 'CASE
                    WHEN
                      s.is_active = 0
                    THEN
                      \'Passive Skill\'
                    ELSE
                      \'Active Skill\'
                    END',
            'description' => 's.description',
            'skill_level' => 'CASE
                    WHEN
                      hs.level IS NULL OR hs.level = \'\'
                    THEN
                      0
                    ELSE
                      hs.level
                    END'
        ];

        $onlyCount = isset($params['onlyCount']) ? true : false;

        list($select, $where, $order, $limit) = $this->buildQuery($params, $listOfFields, $searchFields, $orderFields);
        $query = "
            SELECT
                " . implode(', ', $select) . "
            FROM 
                skills AS s
                LEFT JOIN 
                    hero_skill AS hs ON (hs.skill_id = s.id AND hs.hero_id = :heroId)
                INNER JOIN
                    (SELECT
                        toh.id
                    FROM
                        heroes AS h
                        INNER JOIN
                            type_of_heroes AS toh ON (h.type_of_heroes_id = toh.id)
                    WHERE
                        h.id = :heroId
                    LIMIT 1) AS type_of_hero_data
                    ON (s.type_of_heroes_id = type_of_hero_data.id)
        ";

        $query .= $where . $order . $limit;

        $stmt = $this->db->prepare($query);

        $stmt->execute($params);

        return $stmt->fetchAll();
    }

    public function getAllSkillsForCurrentHeroCount($params = [])
    {
        $params['onlyCount'] = '*';

        $result = $this->getAllSkillsForCurrentHero($params);

        return isset($result[0]) ? $result[0]['count'] : 0;
    }
}