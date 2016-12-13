<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 13.12.2016 г.
 * Time: 17:34
 */

namespace FPopov\Repositories\TypeOfRecipes;


use FPopov\Adapter\DatabaseInterface;
use FPopov\Repositories\AbstractRepository;

class TypeOfRecipesRepository extends AbstractRepository implements TypeOfRecipesRepositoryInterface
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
            'tableName' => 'type_of_recipes',
            'primaryKeyName' => 'id'
        ];
    }

    public function getAllRecipes($params = [])
    {
        $listOfFields = [
            'tor.id',
            'tor.name',
            'concat(tor.damage_low_value, \' - \', tor.damage_high_value) AS damage',
            'tor.armor',
            'tor.strength',
            'tor.vitality',
            'tor.magic',
            'tor.dexterity',
            'tor.health',
            'tor.mana',
            'tor.item_level',
            'tor.critical',
            'tor.gold',
            'tor.iron',
            'tor.leather',
            'tor.silk',
            'tor.tree',
            'tor.duration',
            'toi.name AS type_of_item',
            'CASE
                    WHEN
                        toi.for_type_of_heroes = 1
                    THEN
                        \'only for warrior\'
                    WHEN
                        toi.for_type_of_heroes = 2
                    THEN
                        \'only for marksmen\'
                    WHEN 
                        toi.for_type_of_heroes = 3
                    THEN
                        \'only for wizard\'
                    ELSE
                        \'for all heroes\'
                END  AS for_type_of_heroes'
        ];

        $searchFields = [
            'type_of_item' => 'toi.name'
        ];

        $orderFields = [
            'id' => 'tor.id',
            'name' => 'tor.name',
            'damage' => 'concat(tor.damage_low_value, \' - \', tor.damage_high_value)',
            'armor' => 'tor.armor',
            'strength' => 'tor.strength',
            'vitality' => 'tor.vitality',
            'magic' => 'tor.magic',
            'dexterity' => 'tor.dexterity',
            'mana' => 'tor.mana',
            'health' => 'tor.health',
            'item_level' => 'tor.item_level',
            'critical' => 'tor.critical',
            'gold' => 'tor.gold',
            'iron' => 'tor.iron',
            'leather' => 'tor.leather',
            'silk' => 'tor.silk',
            'tree' => 'tor.tree',
            'duration' => 'tor.duration',
            'type_of_item' => 'toi.name',
            'for_type_of_heroes' => 'CASE
                    WHEN
                        toi.for_type_of_heroes = 1
                    THEN
                        \'only for warrior\'
                    WHEN
                        toi.for_type_of_heroes = 2
                    THEN
                        \'only for marksmen\'
                    WHEN 
                        toi.for_type_of_heroes = 3
                    THEN
                        \'only for wizard\'
                    ELSE
                        \'for all heroes\'
                END'

        ];

        $onlyCount = isset($params['onlyCount']) ? true : false;

        list($select, $where, $order, $limit) = $this->buildQuery($params, $listOfFields, $searchFields, $orderFields);

        $query = "
            SELECT
                " . implode(', ', $select) . "
            FROM 
                type_of_recipes AS tor
            INNER JOIN 
                type_of_items AS toi ON (tor.type_of_item_id = toi.id)
        ";

        $query .= $where . $order . $limit;

        $stmt = $this->db->prepare($query);

        $stmt->execute($params);

        return $stmt->fetchAll();
    }

    public function getAllRecipesCount($params = [])
    {
        $params['onlyCount'] = '*';

        $result = $this->getAllRecipes($params);

        return isset($result[0]) ? $result[0]['count'] : 0;
    }

}