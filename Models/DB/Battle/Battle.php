<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 9.12.2016 г.
 * Time: 20:32
 */

namespace FPopov\Models\DB\Battle;


class Battle
{
    private $id;

    private $attacker_id;

    private $defender_monster_id;

    private $attacker_hit;

    private $defender_hit;

    private $defender_hero_id;

    private $defender_health_after_attack;

    private $attacker_health_after_attack;

    private $dead_status;

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
    public function getAttackerId()
    {
        return $this->attacker_id;
    }

    /**
     * @param mixed $attacker_id
     */
    public function setAttackerId($attacker_id)
    {
        $this->attacker_id = $attacker_id;
    }

    /**
     * @return mixed
     */
    public function getDefenderMonsterId()
    {
        return $this->defender_monster_id;
    }

    /**
     * @param mixed $defender_monster_id
     */
    public function setDefenderMonsterId($defender_monster_id)
    {
        $this->defender_monster_id = $defender_monster_id;
    }

    /**
     * @return mixed
     */
    public function getAttackerHit()
    {
        return $this->attacker_hit;
    }

    /**
     * @param mixed $attacker_hit
     */
    public function setAttackerHit($attacker_hit)
    {
        $this->attacker_hit = $attacker_hit;
    }

    /**
     * @return mixed
     */
    public function getDefenderHit()
    {
        return $this->defender_hit;
    }

    /**
     * @param mixed $defender_hit
     */
    public function setDefenderHit($defender_hit)
    {
        $this->defender_hit = $defender_hit;
    }

    /**
     * @return mixed
     */
    public function getDefenderHeroId()
    {
        return $this->defender_hero_id;
    }

    /**
     * @param mixed $defender_hero_id
     */
    public function setDefenderHeroId($defender_hero_id)
    {
        $this->defender_hero_id = $defender_hero_id;
    }

    /**
     * @return mixed
     */
    public function getDefenderHealthAfterAttack()
    {
        return $this->defender_health_after_attack;
    }

    /**
     * @param mixed $defender_health_after_attack
     */
    public function setDefenderHealthAfterAttack($defender_health_after_attack)
    {
        $this->defender_health_after_attack = $defender_health_after_attack;
    }

    /**
     * @return mixed
     */
    public function getAttackerHealthAfterAttack()
    {
        return $this->attacker_health_after_attack;
    }

    /**
     * @param mixed $attacker_health_after_attack
     */
    public function setAttackerHealthAfterAttack($attacker_health_after_attack)
    {
        $this->attacker_health_after_attack = $attacker_health_after_attack;
    }

    /**
     * @return mixed
     */
    public function getDeadStatus()
    {
        return $this->dead_status;
    }

    /**
     * @param mixed $dead_status
     */
    public function setDeadStatus($dead_status)
    {
        $this->dead_status = $dead_status;
    }
}