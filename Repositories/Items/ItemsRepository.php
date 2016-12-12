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

    public function getAllItemsForOneHero($params = [])
    {
        $listOfFields = [
            'i.id',
            'concat(i.damage_low_value, \' - \', i.damage_high_value) AS damage',
            'i.armor',
            'i.strength',
            'i.vitality',
            'i.magic',
            'i.dexterity',
            'i.health',
            'i.mana',
            'i.item_level',
            'i.critical',
            'i.name',
            'toi.name AS type_of_item',
            'i.is_equiped',
            'CASE
                  WHEN
                      toi.weapon_or_armor = 1
                  THEN
                      \'Weapon\'
                  ELSE
                    \'Armor\'
            END  AS weapon_or_armor',
            'CASE
                  WHEN
                      toi.for_type_of_heroes = 1
                  THEN
                      \'Only Warrior\'
                  WHEN
                      toi.for_type_of_heroes = 2
                  THEN
                      \'Only Marksmen\'
                  WHEN
                      toi.for_type_of_heroes = 3
                  THEN
                      \'Only Wizard\'
                  ELSE
                    \'For all type of heroes\'
            END  AS for_type_hero',
            'toi.for_type_of_heroes'
        ];

        $searchFields = [
            'type_of_item' => 'toi.name'
        ];

        $orderFields = [
            'id' => 'i.id',
            'damage' => 'concat(i.damage_low_value, \' - \', i.damage_high_value)',
            'armor' => 'i.armor',
            'strength' => 'i.strength',
            'vitality' => 'i.vitality',
            'magic' => 'i.magic',
            'dexterity' => 'i.dexterity',
            'mana' => 'i.mana',
            'health' => 'i.health',
            'item_level' => 'i.item_level',
            'critical' => 'i.critical',
            'name' => 'i.name',
            'type_of_item' => 'toi.name',
            'is_equiped' => 'i.is_equiped',
            'weapon_or_armor' => 'CASE
                  WHEN
                      toi.weapon_or_armor = 1
                  THEN
                      \'Weapon\'
                  ELSE
                    \'Armor\'
            END',
            'for_type_hero' => 'CASE
                  WHEN
                      toi.for_type_of_heroes = 1
                  THEN
                      \'Only Warrior\'
                  WHEN
                      toi.for_type_of_heroes = 2
                  THEN
                      \'Only Marksmen\'
                  WHEN
                      toi.for_type_of_heroes = 2
                  THEN
                      \'Only Wizard\'
                  ELSE
                    \'For all type of heroes\'
            END'

        ];

        $onlyCount = isset($params['onlyCount']) ? true : false;

        list($select, $where, $order, $limit) = $this->buildQuery($params, $listOfFields, $searchFields, $orderFields);

        $query = "
            SELECT
                " . implode(', ', $select) . "
              FROM 
                  items AS i
              INNER JOIN 
                  type_of_items AS toi ON (i.type_of_item_id = toi.id)
              WHERE 
                  hero_id = :heroId
        ";

        $query .= $where . $order . $limit;

        $stmt = $this->db->prepare($query);

        $stmt->execute($params);

        return $stmt->fetchAll();
    }

    public function getAllItemsForOneHeroCount($params = [])
    {
        $params['onlyCount'] = '*';

        $result = $this->getAllItemsForOneHero($params);

        return isset($result[0]) ? $result[0]['count'] : 0;
    }

    public function getItemTypes($params = [])
    {
        $query = "
            SELECT
                toi.weapon_or_armor,
                toi.id AS type_of_item_id
            FROM 
                items AS i
            INNER JOIN 
                type_of_items AS toi ON (i.type_of_item_id = toi.id)
            WHERE
                i.id = ?
            LIMIT 1  
        ";

        $stmt = $this->db->prepare($query);

        $stmt->execute($params);

        return $stmt->fetch();
    }

    public function updateItemToNotEquiped($params = [])
    {
        $query = "
            UPDATE
                items AS i
            SET
                i.is_equiped = 0
            WHERE
                type_of_item_id = ?
                AND i.hero_id = ?
        ";

        $stmt = $this->db->prepare($query);

        return $stmt->execute($params);
    }

    public function getWeaponsId($params = [])
    {
        $query = "
            SELECT
                group_concat(i.id) AS items_id
            FROM 
                items AS i
            INNER JOIN 
                type_of_items AS toi ON (i.type_of_item_id = toi.id)
            WHERE 
                i.hero_id = ?
                AND toi.weapon_or_armor = ?
        ";

        $stmt = $this->db->prepare($query);
        $stmt->execute($params);

        return $stmt->fetch();
    }

    public function unEqupedWeapons($params = [])
    {
        $query = "
            UPDATE
                items AS i
            SET
                i.is_equiped = 0
            WHERE
                i.id IN (" . $params[0] . ")
        ";


        $stmt = $this->db->prepare($query);

        return $stmt->execute();
    }
}