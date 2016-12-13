<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 7.12.2016 г.
 * Time: 14:41
 */

namespace FPopov\Repositories\TypeOfResources;


use FPopov\Adapter\DatabaseInterface;
use FPopov\Repositories\AbstractRepository;

class TypeOfResourcesRepository extends AbstractRepository implements TypeOfResourcesRepositoryInterface
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
            'tableName' => 'type_of_resources',
            'primaryKeyName' => 'id'
        ];
    }

    public function getTypeOfItemsWithoutGold($params = [])
    {
        $query = "
            SELECT 
                tor.id AS type_of_resources_id 
            FROM 
                type_of_resources AS tor
            WHERE 
                tor.name != ?
                AND tor.name != ?
        ";

        $stmt = $this->db->prepare($query);
        $stmt->execute($params);

        return $stmt->fetchAll();
    }

}