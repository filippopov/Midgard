<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 15.12.2016 г.
 * Time: 9:24
 */

namespace FPopov\Repositories\Shop;


use FPopov\Adapter\DatabaseInterface;
use FPopov\Repositories\AbstractRepository;

class ShopRepository extends AbstractRepository implements ShopRepositoryInterface
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
            'tableName' => 'shop',
            'primaryKeyName' => 'id'
        ];
    }

    public function getAllItemsFromShopByStatus($params = [])
    {
        $listOfFields = [
            's.id',
            'concat(s.damage_low_value, \' - \', s.damage_high_value) AS damage',
            's.armor',
            's.strength',
            's.vitality',
            's.magic',
            's.dexterity',
            's.health',
            's.mana',
            's.item_level',
            's.critical',
            's.name',
            'toi.name AS type_of_item',
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
            's.price',
            's.hero_id',
            'h.name AS hero_name'
        ];

        $searchFields = [
            'type_of_item' => 'toi.name'
        ];

        $orderFields = [
            'id' => 's.id',
            'damage' => 'concat(s.damage_low_value, \' - \', s.damage_high_value)',
            'armor' => 's.armor',
            'strength' => 's.strength',
            'vitality' => 's.vitality',
            'magic' => 's.magic',
            'dexterity' => 's.dexterity',
            'mana' => 's.mana',
            'health' => 's.health',
            'item_level' => 's.item_level',
            'critical' => 's.critical',
            'name' => 's.name',
            'type_of_item' => 'toi.name',
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
            END',
            'price' => 's.price',
            'hero_id' => 's.hero_id',
            'hero_name' => 'h.name'

        ];

        $onlyCount = isset($params['onlyCount']) ? true : false;

        list($select, $where, $order, $limit) = $this->buildQuery($params, $listOfFields, $searchFields, $orderFields);
        $query = "
            SELECT
                " . implode(', ', $select) . "
            FROM 
                shop AS s
            INNER JOIN 
                type_of_items AS toi ON (s.type_of_item_id = toi.id)
            LEFT JOIN 
                heroes AS h ON (s.hero_id = h.id)
            WHERE 
                s.shop_status = :typeOfShopValue
        ";



        $query .= $where . $order . $limit;

        $stmt = $this->db->prepare($query);

        $stmt->execute($params);

        return $stmt->fetchAll();
    }

    public function getAllItemsFromShopByStatusCount($params = [])
    {
        $params['onlyCount'] = '*';

        $result = $this->getAllItemsFromShopByStatus($params);

        return isset($result[0]) ? $result[0]['count'] : 0;
    }
}

