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
use FPopov\Models\View\Battle\BattleHeroWinMonsterViewModel;
use FPopov\Models\View\Battle\BattleMonsterWinHeroViewModel;
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

    const DEAD_STATUS_NEUTRAL = 0;
    const DEAD_STATUS_ATTACKER = 1;
    const DEAD_STATUS_DEFENDER = 2;

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

    public function pvpBattle()
    {
        if (! $this->authenticationService->isAuthenticated()) {
            $this->responseService->redirect('users', 'login');
        }

        if (! $this->authenticationService->isAuthenticatedHero()) {
            $this->responseService->redirect('heroes', 'createHero');
        }

        $getParams = $this->MVCContext->getGetParams();
        $allHeroes = $this->battleService->pvpBattle($getParams);

        $params = ['model' => $allHeroes];
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

        switch ($attackData) {
            case self::DEAD_STATUS_NEUTRAL :
                $this->responseService->redirect('battle', 'attackMonster', [$defenderId, $attackData]);
                break;
            case self::DEAD_STATUS_ATTACKER :
                $this->responseService->redirect('battle', 'defenderWinHero', [$defenderId]);
                break;
            case self::DEAD_STATUS_DEFENDER :
                $this->responseService->redirect('battle', 'attackerWinMonster', [$defenderId]);
                break;
        }
    }

    public function runFromBattle()
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

        $runParams = [
            'typeOfBattle' => $typeOfBattle,
            'attackerId' => $attackerId,
            'defenderId' => $defenderId
        ];

        $run = $this->battleService->runFromBattle($runParams);

        $this->responseService->redirect('game', 'playHero', [$attackerId]);
    }

    public function attackerWinMonster()
    {
        if (! $this->authenticationService->isAuthenticated()) {
            $this->responseService->redirect('users', 'login');
        }

        if (! $this->authenticationService->isAuthenticatedHero()) {
            $this->responseService->redirect('heroes', 'createHero');
        }

        $defender = $this->MVCContext->getArguments();
        $defenderId = isset($defender[0]) ? $defender[0] : 0;

        $informationAfterBattle = $this->battleService->attackerWinMonster($defenderId);

        $monsterType = isset($informationAfterBattle['monsterType']) ? $informationAfterBattle['monsterType'] : '';
        $gold = isset($informationAfterBattle['gold']) ? $informationAfterBattle['gold'] : '';
        $experience = isset($informationAfterBattle['experience']) ? $informationAfterBattle['experience'] : '';
        $itemName = isset($informationAfterBattle['itemName']) ? $informationAfterBattle['itemName'] : '';

        $returnModel = new BattleHeroWinMonsterViewModel($monsterType, $gold, $experience, $itemName);

        $this->view->render(['model' => $returnModel]);
    }

    public function defenderWinHero()
    {
        if (! $this->authenticationService->isAuthenticated()) {
            $this->responseService->redirect('users', 'login');
        }

        if (! $this->authenticationService->isAuthenticatedHero()) {
            $this->responseService->redirect('heroes', 'createHero');
        }

        $defender = $this->MVCContext->getArguments();
        $defenderId = isset($defender[0]) ? $defender[0] : 0;

        $informationAfterBattle = $this->battleService->defenderWinHero($defenderId);

        $monsterType = isset($informationAfterBattle['monsterType']) ? $informationAfterBattle['monsterType'] : '';
        $lostExperience = isset($informationAfterBattle['lostExperience']) ? $informationAfterBattle['lostExperience'] : '';
        $heroHealth = isset($informationAfterBattle['heroHealth']) ? $informationAfterBattle['heroHealth'] : '';

        $renderViewModel = new BattleMonsterWinHeroViewModel($monsterType, $lostExperience, $heroHealth);

        $this->view->render(['model' => $renderViewModel]);
    }

}
