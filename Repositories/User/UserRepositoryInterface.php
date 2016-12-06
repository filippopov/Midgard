<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 29.11.2016 г.
 * Time: 14:22
 */

namespace FPopov\Repositories\User;


interface UserRepositoryInterface
{
    public function findAllHeroesForCurrentUser($params = []);

    public function findAllHeroesForCurrentUserCount($params = []);
}