<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 13.12.2016 г.
 * Time: 17:37
 */

namespace FPopov\Repositories\Recipes;


use FPopov\Adapter\DatabaseInterface;
use FPopov\Repositories\AbstractRepository;

class RecipesRepository extends AbstractRepository implements RecipesRepositoryInterface
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
            'tableName' => 'recipes',
            'primaryKeyName' => 'id'
        ];
    }

    public function checkEnoughResources($params = [])
    {
        $query = "
            SELECT
                CASE
                    WHEN
                        r.amount >= ?
                    THEN
                        'Yes'
                    ELSE
                        ? - r.amount
                END AS is_enogh
            FROM 
                resources AS r
            INNER JOIN 
                type_of_resources AS tor ON (r.type_of_resources_id = tor.id)
            WHERE 
                r.heroes_id = ?
                AND tor.name = ?
            LIMIT 1 
        ";

        $stmt = $this->db->prepare($query);
        $stmt->execute($params);

        return $stmt->fetch();
    }

    public function getAllTypeOfResourceForOneUserWithoutHonor($params =[])
    {
        $query = "
            SELECT
                tor.name, 
                r.amount,
                r.id
            FROM 
                resources AS r
            INNER JOIN 
                type_of_resources AS tor ON (r.type_of_resources_id = tor.id)
            WHERE 
                r.heroes_id = ?
                AND tor.name != 'honor'
        ";

        $stmt = $this->db->prepare($query);
        $stmt->execute($params);

        return $stmt->fetchAll();
    }
}