<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 7.12.2016 г.
 * Time: 11:37
 */

namespace FPopov\Repositories\Level;


use FPopov\Adapter\DatabaseInterface;
use FPopov\Repositories\AbstractRepository;

class LevelRepository extends AbstractRepository implements LevelRepositoryInterface
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
            'tableName' => 'level',
            'primaryKeyName' => 'id'
        ];
    }

    public function getLevelByExperience($params = [])
    {
        $query = "
            SELECT 
                l.id 
            FROM 
                level AS l
            WHERE 
                l.from_experience <= ?
                AND l.to_experience >= ?
        ";

        $stmt = $this->db->prepare($query);

        $stmt->execute($params);

        return $stmt->fetch();
    }
}