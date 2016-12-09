<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 8.12.2016 г.
 * Time: 19:52
 */

namespace FPopov\Controllers;

use FPopov\Core\MVC\MVCContext;
use FPopov\Core\ViewInterface;
use FPopov\Models\DB\Hero\HeroStatistic;
use FPopov\Models\DB\Monsters\Monsters;
use FPopov\Models\View\Battle\BattleHeroMonsterViewModel;
use FPopov\Services\Application\AuthenticationServiceInterface;
use FPopov\Services\Application\ResponseServiceInterface;
use FPopov\Services\Battle\BattleServiceInterface;

class BattleController
{
    private $authenticationService;
    private $responseService;
    private $MVCContext;
    private $view;
    private $battleService;

    public function __construct(
        AuthenticationServiceInterface $authenticationService,
        ResponseServiceInterface $responseService,
        MVCContext $MVCContext,
        ViewInterface $view,
        BattleServiceInterface $battleService)
    {
        $this->authenticationService = $authenticationService;
        $this->responseService = $responseService;
        $this->MVCContext = $MVCContext;
        $this->view = $view;
        $this->battleService = $battleService;
    }

    public function pveBattle()
    {
        if (! $this->authenticationService->isAuthenticated()) {
            $this->responseService->redirect('users', 'login');
        }

        if (! $this->authenticationService->isAuthenticatedHero()) {
            $this->responseService->redirect('heroes', 'createHero');
        }

        $getParams = $this->MVCContext->getGetParams();
        $allMonsters = $this->battleService->pveBattle($getParams);

        $params = ['model' => $allMonsters];
        $this->view->render($params);
    }

    public function attackMonster($monsterId)
    {
        if (! $this->authenticationService->isAuthenticated()) {
            $this->responseService->redirect('users', 'login');
        }

        if (! $this->authenticationService->isAuthenticatedHero()) {
            $this->responseService->redirect('heroes', 'createHero');
        }

        $battleData = $this->battleService->attackMonster($monsterId);

        /** @var Monsters $monsterInfo */
        $monsterInfo = isset($battleData['monsterInformation']) ? $battleData['monsterInformation'] : [];

        /** @var HeroStatistic $heroInfo */
        $heroInfo = isset($battleData['heroInformation']) ? $battleData['heroInformation'] : [];

        $monsterAndHeroInBattle = isset($battleData['monsterAndHeroInBattle']) ? $battleData['monsterAndHeroInBattle'] : false;
        $monsterRealHealth = isset($battleData['monsterRealHealth']) ? $battleData['monsterRealHealth'] : 0;


        $monsterType = $monsterInfo->getMonsterType();
        $monsterDamageLowValue = $monsterInfo->getDamageLowValue();
        $monsterDamageHighValue = $monsterInfo->getDamageHighValue();
        $monsterArmor = $monsterInfo->getArmor();
        $monsterHealth = $monsterInfo->getHealth();
        $heroName = $heroInfo->getHeroName();
        $heroRealHealth = $heroInfo->getRealHealth();
        $heroRealMana = $heroInfo->getRealMana();
        $heroDamageLowValue = $heroInfo->getDamageLowValue();
        $heroDamageHighValue = $heroInfo->getDamageHighValue();
        $heroArmor = $heroInfo->getArmor();
        $heroMaxHealth = $heroInfo->getMaxHealth();
        $heroMaxMana = $heroInfo->getMaxMana();
        $heroCriticalChance = $heroInfo->getCriticalChance();
        $heroLevelNumber = $heroInfo->getLevelNumber();
        $heroType = $heroInfo->getHeroType();

        $battleHeroMonsterViewModel = new BattleHeroMonsterViewModel(
            $monsterType,
            $monsterDamageLowValue,
            $monsterDamageHighValue,
            $monsterArmor,
            $monsterHealth,
            $heroName,
            $heroRealHealth,
            $heroRealMana,
            $heroDamageLowValue,
            $heroDamageHighValue,
            $heroArmor,
            $heroMaxHealth,
            $heroMaxMana,
            $heroCriticalChance,
            $heroLevelNumber,
            $heroType,
            $monsterAndHeroInBattle,
            $monsterRealHealth
        );

        $params = ['model' => $battleHeroMonsterViewModel];

        $this->view->render($params);
    }

    public function attack()
    {
        $mvcContext = $this->MVCContext->getArguments();
        $attackerId = isset($mvcContext[1]) ? $mvcContext[1] : 0;
        $defenderId = isset($mvcContext[2]) ? $mvcContext[2] : 0;
        $typeOfBattle = isset($mvcContext[0]) ? $mvcContext[0] : '';

        if (! $this->authenticationService->isAuthenticated()) {
            $this->responseService->redirect('users', 'login');
        }

        if (! $this->authenticationService->isAuthenticatedHero()) {
            $this->responseService->redirect('heroes', 'createHero');
            if ($this->authenticationService->getHeroId() != $attackerId) {
                $this->responseService->redirect('heroes', 'createHero');
            }
        }

        if (! $this->authenticationService->isAuthenticatedMonster()) {
            $this->responseService->redirect('heroes', 'createHero');
            if ($this->authenticationService->getMonsterId() != $defenderId) {
                $this->responseService->redirect('heroes', 'createHero');
            }
        }

        $attackParams = [
            'typeOfBattle' => $typeOfBattle,
            'attackerId' => $attackerId,
            'defenderId' => $defenderId
        ];

        $attackData = $this->battleService->attack($attackParams);


        $this->responseService->redirect('battle', 'attackMonster', [$defenderId, $attackData]);
    }


}
