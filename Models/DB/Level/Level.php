<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 7.12.2016 г.
 * Time: 11:41
 */

namespace FPopov\Models\DB\Level;


class Level
{
    private $id;

    private $level_number;

    private $from_experience;

    private $to_experience;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getLevelNumber()
    {
        return $this->level_number;
    }

    /**
     * @param mixed $level_number
     */
    public function setLevelNumber($level_number)
    {
        $this->level_number = $level_number;
    }

    /**
     * @return mixed
     */
    public function getFromExperience()
    {
        return $this->from_experience;
    }

    /**
     * @param mixed $from_experience
     */
    public function setFromExperience($from_experience)
    {
        $this->from_experience = $from_experience;
    }

    /**
     * @return mixed
     */
    public function getToExperience()
    {
        return $this->to_experience;
    }

    /**
     * @param mixed $to_experience
     */
    public function setToExperience($to_experience)
    {
        $this->to_experience = $to_experience;
    }
}