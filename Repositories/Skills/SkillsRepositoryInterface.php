<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 20.1.2017 г.
 * Time: 10:43
 */

namespace FPopov\Repositories\Skills;


interface SkillsRepositoryInterface
{
    public function getAllSkillsForCurrentHero($params = []);
}