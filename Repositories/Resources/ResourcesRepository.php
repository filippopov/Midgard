<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 7.12.2016 г.
 * Time: 15:01
 */

namespace FPopov\Repositories\Resources;


use FPopov\Adapter\DatabaseInterface;
use FPopov\Models\DB\Resources\AllResources;
use FPopov\Repositories\AbstractRepository;

class ResourcesRepository extends AbstractRepository implements ResourcesRepositoryInterface
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
            'tableName' => 'resources',
            'primaryKeyName' => 'id'
        ];
    }

    public function getResourcesForOneHero($params = [])
    {
        $query = " 
            SELECT
                group_concat(concat(tor.name,' : '), r.amount separator ', ') AS resources
            FROM 
                resources AS r
            INNER JOIN 
                type_of_resources AS tor ON (r.type_of_resources_id = tor.id)
            WHERE 
                r.heroes_id = ?
            LIMIT 1   
        ";

        $stmt = $this->db->prepare($query);
        $stmt->execute($params);

        return $stmt->fetchObject(AllResources::class);
    }
}