<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 12.12.2016 г.
 * Time: 18:48
 */

namespace FPopov\Services\Level;


interface LevelServiceInterface
{
    public function levelUp();

    public function levelUpPost($params = []);
}