<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 14.12.2016 г.
 * Time: 11:04
 */

namespace FPopov\Models\DB\Recipes;


class Recipes
{
    private $id;

    private $type_of_recipes_id;

    private $hero_id;

    private $start_dt;

    private $status;

    private $end_dt;

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
    public function getTypeOfRecipesId()
    {
        return $this->type_of_recipes_id;
    }

    /**
     * @param mixed $type_of_recipes_id
     */
    public function setTypeOfRecipesId($type_of_recipes_id)
    {
        $this->type_of_recipes_id = $type_of_recipes_id;
    }

    /**
     * @return mixed
     */
    public function getHeroId()
    {
        return $this->hero_id;
    }

    /**
     * @param mixed $hero_id
     */
    public function setHeroId($hero_id)
    {
        $this->hero_id = $hero_id;
    }

    /**
     * @return mixed
     */
    public function getStartDt()
    {
        return $this->start_dt;
    }

    /**
     * @param mixed $start_dt
     */
    public function setStartDt($start_dt)
    {
        $this->start_dt = $start_dt;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getEndDt()
    {
        return $this->end_dt;
    }

    /**
     * @param mixed $end_dt
     */
    public function setEndDt($end_dt)
    {
        $this->end_dt = $end_dt;
    }
}


