<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 8.12.2016 г.
 * Time: 20:16
 */

namespace FPopov\Services\Battle;


interface BattleServiceInterface
{
    public function pveBattle($params = []);

    public function pvpBattle($params = []);

    public function attackMonster($monsterId);

    public function attackHero($defenderHeroId);

    public function attack($attackParams = []);

    public function attackerWinMonster($defenderId);

    public function defenderWinHero($defenderId);

    public function runFromBattle($runParams = []);

    public function defenderHeroWinHero($defenderId);

    public function attackerHeroWinHero($defenderId);
}