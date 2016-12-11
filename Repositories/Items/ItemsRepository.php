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
        $query = "
            SELECT
                i.id,
                concat(i.damage_low_value, ' - ', i.damage_high_value) AS damage,
                i.armor,
                i.strength,
                i.health,
                i.vitality,
                i.magic,
                i.dexterity,
                i.mana,
                i.item_level,
                i.critical,
                i.name,
                toi.name AS type_of_item,
              CASE
                  WHEN
                      toi.weapon_or_armor = 1
                  THEN
                      'Weapon'
                  ELSE
                    'Armor'
              END  AS weapon_or_armor,
              CASE
                  WHEN
                      toi.for_type_of_heroes = 1
                  THEN
                      'Only Warrior'
                  WHEN
                      toi.for_type_of_heroes = 2
                  THEN
                      'Only Marksmen'
                  WHEN
                      toi.for_type_of_heroes = 2
                  THEN
                      'Only Wizard'
                  ELSE
                    'For all type of heroes'
              END  AS weapon_or_armor
              FROM 
                  items AS i
              INNER JOIN 
                  type_of_items AS toi ON (i.type_of_item_id = toi.id)
              WHERE 
                  hero_id = :heroId;
        ";
    }
}