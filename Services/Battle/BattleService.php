<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 8.12.2016 г.
 * Time: 20:15
 */

namespace FPopov\Services\Battle;


use FPopov\Core\MVC\Message;
use FPopov\Core\MVC\SessionInterface;
use FPopov\Core\ViewInterface;
use FPopov\Exceptions\GameException;
use FPopov\Models\DB\Battle\Battle;
use FPopov\Models\DB\Hero\Hero;
use FPopov\Models\DB\Hero\HeroStatistic;
use FPopov\Models\DB\Items\Item;
use FPopov\Models\DB\Level\Level;
use FPopov\Models\DB\Monsters\Monsters;
use FPopov\Models\DB\Resources\Resources;
use FPopov\Models\DB\TypeMonsters\TypeMonster;
use FPopov\Models\DB\TypeOfItems\TypeOfItem;
use FPopov\Models\DB\TypeOfResources\TypeOfResources;
use FPopov\Repositories\Battle\BattleRepository;
use FPopov\Repositories\Battle\BattleRepositoryInterface;
use FPopov\Repositories\Hero\HeroRepository;
use FPopov\Repositories\Hero\HeroRepositoryInterface;
use FPopov\Repositories\Items\ItemsRepository;
use FPopov\Repositories\Items\ItemsRepositoryInterface;
use FPopov\Repositories\Level\LevelRepository;
use FPopov\Repositories\Level\LevelRepositoryInterface;
use FPopov\Repositories\Monsters\MonstersRepository;
use FPopov\Repositories\Monsters\MonstersRepositoryInterface;
use FPopov\Repositories\Resources\ResourcesRepository;
use FPopov\Repositories\Resources\ResourcesRepositoryInterface;
use FPopov\Repositories\TypeMonsters\TypeMonstersRepository;
use FPopov\Repositories\TypeMonsters\TypeMonstersRepositoryInterface;
use FPopov\Repositories\TypeOfItems\TypeOfItemsRepository;
use FPopov\Repositories\TypeOfItems\TypeOfItemsRepositoryInterface;
use FPopov\Repositories\TypeOfResources\TypeOfResourcesRepository;
use FPopov\Repositories\TypeOfResources\TypeOfResourcesRepositoryInterface;
use FPopov\Services\AbstractService;
use FPopov\Services\Application\AuthenticationServiceInterface;
use FPopov\Services\Application\ResponseServiceInterface;
use FPopov\Services\Hero\HeroService;

class BattleService extends AbstractService implements BattleServiceInterface
{
    const HERO_STATUS_IN_BATTLE = 2;
    const HERO_STATUS_OUT_OF_BATTLE = 1;
    const DEAD_BATTLE_STATUS = 0;

    const TYPE_OF_BATTLE_PVP = 'player';
    const TYPE_OF_BATTLE_PVE = 'monster';

    const LEVEL_UP = 5;

    const WEAPON = 1;
    const ARMOR = 0;

    private $view;
    private $authenticationService;
    private $session;
    private $responseService;

    /** @var MonstersRepository */
    private $monstersRepository;

    /** @var TypeMonstersRepository */
    private $typeMonstersRepository;

    /** @var  HeroRepository */
    private $heroRepository;

    /** @var  BattleRepository */
    private $battleRepository;

    /** @var  TypeOfItemsRepository */
    private $typeOfItemsRepository;

    /** @var ItemsRepository */
    private $itemsRepository;

    /** @var  LevelRepository */
    private $levelRepository;

    /** @var  ResourcesRepository */
    private $resourcesRepository;

    /** @var TypeOfResourcesRepository  */
    private $typeOfResourcesRepository;

    public function __construct(
        ViewInterface $view,
        AuthenticationServiceInterface $authenticationService,
        MonstersRepositoryInterface $monstersRepository,
        TypeMonstersRepositoryInterface $typeMonstersRepository,
        HeroRepositoryInterface $heroRepository,
        SessionInterface $session,
        BattleRepositoryInterface $battleRepository,
        TypeOfItemsRepositoryInterface $typeOfItemsRepository,
        ItemsRepositoryInterface $itemsRepository,
        LevelRepositoryInterface $levelRepository,
        ResourcesRepositoryInterface $resourcesRepository,
        TypeOfResourcesRepositoryInterface $typeOfResourcesRepository,
        ResponseServiceInterface $responseService
    )
    {
        $this->view = $view;
        $this->authenticationService = $authenticationService;
        $this->monstersRepository = $monstersRepository;
        $this->typeMonstersRepository = $typeMonstersRepository;
        $this->heroRepository = $heroRepository;
        $this->session = $session;
        $this->battleRepository = $battleRepository;
        $this->typeOfItemsRepository = $typeOfItemsRepository;
        $this->itemsRepository = $itemsRepository;
        $this->levelRepository = $levelRepository;
        $this->resourcesRepository = $resourcesRepository;
        $this->typeOfResourcesRepository = $typeOfResourcesRepository;
        $this->responseService = $responseService;
    }


    public function pvpBattle($params = [])
    {
        $heroId = $this->authenticationService->getHeroId();
        $userId = $this->authenticationService->getUserId();

        /** @var Hero $hero */
        $hero = $this->heroRepository->findOneRowById($heroId, Hero::class);

        $params['userId'] = $userId;
        $params['cityId'] = $hero->getCityId();
        $params['honor'] = HeroService::RESOURCES_HONOR;
        $allowParams = ['cityId', 'userId', 'honor'];
        $bindFilter = $this->getParamFilters($params, $allowParams);

        $structure = [
            'name' => [
                'title' => 'Hero Name',
                'type' => self::TYPE_DATA
            ],
            'type_of_hero' => [
                'title' => 'Hero Type',
                'type' => self::TYPE_DATA
            ],
            'level_number' => [
                'title' => 'Level',
                'type' => self::TYPE_DATA
            ],
            'honor' => [
                'title' => 'Win Honor',
                'type' => self::TYPE_DATA
            ],
            'id' => [
                'title' => 'Attack',
                'type' => self::TYPE_DATA,
                'value' => function ($value) {
                    return 'Attack';
                },
                'onClick' => function ($row) {
                    return $this->view->uri('battle', 'attackHero', ['defenderHeroId' => $row['id']]);
                }
            ]
        ];


        $repoData = $this->battleRepository->findAllHeroesForCurrentCity($bindFilter);
        $bindFilter['total'] = $this->battleRepository->findAllHeroesForCurrentCityCount($bindFilter);
        $data = $this->generateGridData($structure, $repoData);

        $searchFields = [
            'name' => 'Hero Name'
        ];

        $table = [
            'tableSearchFields' => $searchFields,
            'tableData' => $data,
            'filter' => $this->pageFilters($bindFilter),
        ];

        return $table;
    }

    public function pveBattle($params = [])
    {
        $heroId = $this->authenticationService->getHeroId();

        /** @var Hero $hero */
        $hero = $this->heroRepository->findOneRowById($heroId, Hero::class);

        $params['cityId'] = $hero->getCityId();
        $allowParams = ['cityId'];
        $bindFilter = $this->getParamFilters($params, $allowParams);

        $structure = [
            'type_of_monster' => [
                'title' => 'Monster Type',
                'type' => self::TYPE_DATA
            ],
            'city_name' => [
                'title' => 'City',
                'type' => self::TYPE_DATA
            ],
            'damage' => [
                'title' => 'Damage',
                'type' => self::TYPE_DATA
            ],
            'armor' => [
                'title' => 'Armor ',
                'type' => self::TYPE_DATA
            ],
            'health' => [
                'title' => 'Health ',
                'type' => self::TYPE_DATA
            ],
            'id' => [
                'title' => 'Attack',
                'type' => self::TYPE_DATA,
                'value' => function ($value) {
                    return 'Attack';
                },
                'onClick' => function ($row) {
                    return $this->view->uri('battle', 'attackMonster', ['monsterId' => $row['id']]);
                }
            ]
        ];

        $repoData = $this->monstersRepository->findAllMonstersForCurentCity($bindFilter);
        $bindFilter['total'] = $this->monstersRepository->findAllMonstersForCurentCityCount($bindFilter);
        $data = $this->generateGridData($structure, $repoData);

        /** @var TypeMonster[] $typeOfMonsters */
        $typeOfMonsters = $this->typeMonstersRepository->findAll(TypeMonster::class);

        $dropDownForTypeOfMonster[''] = '';

        foreach ($typeOfMonsters as $typeMonster) {
            $dropDownForTypeOfMonster[$typeMonster->getName()] = $typeMonster->getName();
        }

        $dropDownForTypeOfMonster['title'] = 'Monster Type';

        $searchFields = [
            'type_of_monster' => $dropDownForTypeOfMonster
        ];

        $table = [
            'tableSearchFields' => $searchFields,
            'tableData' => $data,
            'filter' => $this->pageFilters($bindFilter),
        ];

        return $table;
    }

    public function attackMonster($monsterId)
    {
        if (empty($monsterId)) {
            throw new GameException('Not set monster Id');
        }

        $this->session->set('monsterId', $monsterId);

        $heroId = $this->authenticationService->getHeroId();

        $heroParams = [
            HeroService::ITEM_IS_EQUIPED, $heroId, $heroId
        ];

        /** @var HeroStatistic $heroInformation */
        $heroInformation = $this->heroRepository->heroInformation($heroParams);

        $monsterAndHeroInBattle = false;
        $monsterRealHealth = 0;
        if ($heroInformation->getHeroStatus() == self::HERO_STATUS_IN_BATTLE) {
            /** @var Battle[] $isInBattle */
            $isInBattle = $this->battleRepository->findByCondition(['attacker_id' => $heroId, 'defender_monster_id' => $monsterId], Battle::class);

            if (! empty($isInBattle)) {
                $counter = count($isInBattle) - 1;

                if ($isInBattle[$counter]->getDeadStatus() == self::DEAD_BATTLE_STATUS) {
                    $monsterAndHeroInBattle = true;
                    $monsterRealHealth = $isInBattle[$counter]->getDefenderHealthAfterAttack();
                }
            }
        }

        $monsterInformation = $this->monstersRepository->monsterInformation([$monsterId]);

        return [
            'heroInformation' => $heroInformation,
            'monsterInformation' => $monsterInformation,
            'monsterAndHeroInBattle' => $monsterAndHeroInBattle,
            'monsterRealHealth' => $monsterRealHealth
        ];
    }

    public function attackHero($defenderHeroId)
    {
        if (empty($defenderHeroId)) {
            throw new GameException('Not set monster Id');
        }

        $this->session->set('defenderHeroId', $defenderHeroId);

        $heroId = $this->authenticationService->getHeroId();

        $heroParams = [
            HeroService::ITEM_IS_EQUIPED, $heroId, $heroId
        ];

        /** @var HeroStatistic $heroInformation */
        $heroInformation = $this->heroRepository->heroInformation($heroParams);

        $heroAndDefendHeroInBattle = false;
        $defendHeroRealHealth = 0;
        if ($heroInformation->getHeroStatus() == self::HERO_STATUS_IN_BATTLE) {
            /** @var Battle[] $isInBattle */
            $isInBattle = $this->battleRepository->findByCondition(['attacker_id' => $heroId, 'defender_hero_id' => $defenderHeroId], Battle::class);

            if (! empty($isInBattle)) {
                $counter = count($isInBattle) - 1;

                if ($isInBattle[$counter]->getDeadStatus() == self::DEAD_BATTLE_STATUS) {
                    $heroAndDefendHeroInBattle = true;
                    $defendHeroRealHealth = $isInBattle[$counter]->getDefenderHealthAfterAttack();
                }
            }
        }

        $defenderHeroParams = [
            HeroService::ITEM_IS_EQUIPED, $defenderHeroId, $defenderHeroId
        ];

        $defenderHeroInformation = $this->heroRepository->heroInformation($defenderHeroParams);

        return [
            'heroInformation' => $heroInformation,
            'defenderHeroInformation' => $defenderHeroInformation,
            'heroAndDefendHeroInBattle' => $heroAndDefendHeroInBattle,
            'defendHeroRealHealth' => $defendHeroRealHealth
        ];
    }

    public function runFromBattle($runParams = [])
    {
        $typeOfBattle = isset($runParams['typeOfBattle']) ? $runParams['typeOfBattle'] : '';
        $attackerId = isset($runParams['attackerId']) ? $runParams['attackerId'] : 0;
        $defenderId = isset($runParams['defenderId']) ? $runParams['defenderId'] : 0;

        $defenderPVEOrPVP = $typeOfBattle == self::TYPE_OF_BATTLE_PVE ? 'defender_monster_id' : 'defender_hero_id';

        /** @var Battle[] $allBattles */
        $allBattles = $this->battleRepository->findByCondition(['attacker_id' => $attackerId, $defenderPVEOrPVP => $defenderId], Battle::class);

        if (! empty($allBattles)) {
            foreach ($allBattles as $battle) {
                $deleteBattle = $this->battleRepository->delete($battle->getId());

                if (! $deleteBattle) {
                    throw new GameException('Can not delete battle row');
                }
            }
        }

        $updateHeroStatus = $this->heroRepository->update($attackerId, ['hero_status' => self::HERO_STATUS_OUT_OF_BATTLE]);

        if (! $updateHeroStatus) {
            throw new GameException('Can not update hero status');
        }

        return true;
    }

    public function attack($attackParams = [])
    {
        $typeOfBattle = isset($attackParams['typeOfBattle']) ? $attackParams['typeOfBattle'] : '';
        $attackerId = isset($attackParams['attackerId']) ? $attackParams['attackerId'] : 0;
        $defenderId = isset($attackParams['defenderId']) ? $attackParams['defenderId'] : 0;

        $heroUpdateStatus = $this->heroRepository->update($attackerId, ['hero_status' => self::HERO_STATUS_IN_BATTLE]);

        if (! $heroUpdateStatus) {
            throw new GameException('Can not update hero status');
        }

        if (empty($typeOfBattle)) {
            throw new GameException('Not set type of the battle');
        }

        if (! $attackerId) {
            throw new GameException('Not ser attackerId');
        }

        if (! $defenderId) {
            throw new GameException('Not set defenderId');
        }

        $heroParams = [
            HeroService::ITEM_IS_EQUIPED, $attackerId, $attackerId
        ];


        /** @var HeroStatistic $attacker */
        $attacker = $this->heroRepository->heroInformation($heroParams);

        if ($typeOfBattle == self::TYPE_OF_BATTLE_PVE) {
            $monsterAndHeroInBattle = false;
            $monsterRealHealth = 0;
            if ($attacker->getHeroStatus() == self::HERO_STATUS_IN_BATTLE) {
                /** @var Battle[] $isInBattle */
                $isInBattle = $this->battleRepository->findByCondition(['attacker_id' => $attackerId, 'defender_monster_id' => $defenderId], Battle::class);

                if (! empty($isInBattle)) {
                    $counter = count($isInBattle) - 1;

                    if ($isInBattle[$counter]->getDeadStatus() == self::DEAD_BATTLE_STATUS) {
                        $monsterAndHeroInBattle = true;
                        $monsterRealHealth = $isInBattle[$counter]->getDefenderHealthAfterAttack();
                    }
                }
            }

            /** @var Monsters $monster */
            $monster = $this->monstersRepository->monsterInformation([$defenderId]);

            $makeAttack = [
                'attacker' => [
                    'damageLowValue' => $attacker->getDamageLowValue(),
                    'damageHighValue' => $attacker->getDamageHighValue(),
                    'health' => $attacker->getRealHealth(),
                    'armor' => $attacker->getArmor()
                ],
                'defender' => [
                    'damageLowValue' => $monster->getDamageLowValue(),
                    'damageHighValue' => $monster->getDamageHighValue(),
                    'health' => $monsterAndHeroInBattle ? $monsterRealHealth : $monster->getHealth(),
                    'armor' => $monster->getArmor()
                ]
            ];

        } else {
            $heroAndDefendHeroInBattle = false;
            $heroRealHealth = 0;
            if ($attacker->getHeroStatus() == self::HERO_STATUS_IN_BATTLE) {
                /** @var Battle[] $isInBattle */
                $isInBattle = $this->battleRepository->findByCondition(['attacker_id' => $attackerId, 'defender_hero_id' => $defenderId], Battle::class);

                if (! empty($isInBattle)) {
                    $counter = count($isInBattle) - 1;

                    if ($isInBattle[$counter]->getDeadStatus() == self::DEAD_BATTLE_STATUS) {
                        $heroAndDefendHeroInBattle = true;
                        $heroRealHealth = $isInBattle[$counter]->getDefenderHealthAfterAttack();
                    }
                }
            }

            $defendHeroParams = [
                HeroService::ITEM_IS_EQUIPED, $defenderId, $defenderId
            ];

            /** @var HeroStatistic $defenderHero */
            $defenderHero = $this->heroRepository->heroInformation($defendHeroParams);

            $makeAttack = [
                'attacker' => [
                    'damageLowValue' => $attacker->getDamageLowValue(),
                    'damageHighValue' => $attacker->getDamageHighValue(),
                    'health' => $attacker->getRealHealth(),
                    'armor' => $attacker->getArmor()
                ],
                'defender' => [
                    'damageLowValue' => $defenderHero->getDamageLowValue(),
                    'damageHighValue' => $defenderHero->getDamageHighValue(),
                    'health' => $heroAndDefendHeroInBattle ? $heroRealHealth : $defenderHero->getMaxHealth(),
                    'armor' => $defenderHero->getArmor()
                ]
            ];
        }

        $resultAttack = $this->makeAttack($makeAttack);
        $attackerHit = isset($resultAttack['attackerHit']) ? $resultAttack['attackerHit'] : 0;
        $defenderHealthAfterAttack = isset($resultAttack['defenderHealthAfterAttack']) ? $resultAttack['defenderHealthAfterAttack'] : 0;
        $defenderHit = isset($resultAttack['defenderHit']) ? $resultAttack['defenderHit'] : 0;
        $attackerHealthAfterAttack = isset($resultAttack['attackerHealthAfterAttack']) ? $resultAttack['attackerHealthAfterAttack'] : 0;
        $deadStatus = isset($resultAttack['deadStatus']) ? $resultAttack['deadStatus'] : 0;

        $attackerHealthAfterAttack = $attackerHealthAfterAttack - $attacker->getHealthFromItems();

        $createBattleParams = [
            'attacker_id' => $attackerId,
            'defender_monster_id' => $typeOfBattle == self::TYPE_OF_BATTLE_PVE ? $defenderId : 0,
            'attacker_hit' => $attackerHit,
            'defender_hit' => $defenderHit,
            'defender_hero_id' => $typeOfBattle == self::TYPE_OF_BATTLE_PVP ? $defenderId : 0,
            'defender_health_after_attack' => $defenderHealthAfterAttack,
            'attacker_health_after_attack' => $attackerHealthAfterAttack,
            'dead_status' => $deadStatus
        ];

        if ($typeOfBattle == self::TYPE_OF_BATTLE_PVE) {
            /** @var Battle[] $deleteBattleRows */
            $deleteBattleRows = $this->battleRepository->findByCondition(['attacker_id' => $attackerId, 'defender_monster_id' => $defenderId], Battle::class);
        } else {
            /** @var Battle[] $deleteBattleRows */
            $deleteBattleRows = $this->battleRepository->findByCondition(['attacker_id' => $attackerId, 'defender_hero_id' => $defenderId], Battle::class);
        }

        foreach ($deleteBattleRows as $deleteBattleRow) {
            $deleteBattle = $this->battleRepository->delete($deleteBattleRow->getId());

            if (! $deleteBattle) {
                throw new GameException('Can not delete row for battle');
            }
        }

        $createBattleRow = $this->battleRepository->create($createBattleParams);

        if (! $createBattleRow) {
            throw new GameException('Can not create battle row');
        }

        $updateHeroHealth = $this->heroRepository->update($attackerId, ['real_health' => $attackerHealthAfterAttack]);

        if (! $updateHeroHealth) {
            throw new GameException('Can not update hero real health');
        }

        Message::postMessage("Attacker hit with $attackerHit damage, defender hit with $defenderHit damage", Message::POSITIVE_MESSAGE);

        return $deadStatus;
    }

    private function makeAttack($params = [])
    {
        $attacker = isset($params['attacker']) ? $params['attacker'] : [];
        $defender = isset($params['defender']) ? $params['defender'] : [];

        $attackerDamageLow = isset($attacker['damageLowValue']) ? $attacker['damageLowValue'] : 0;
        $attackerDamageHigh = isset($attacker['damageHighValue']) ? $attacker['damageHighValue'] : 0;
        $attackerHealth = isset($attacker['health']) ? $attacker['health'] : 0;
        $attackerArmor = isset($attacker['armor']) ? $attacker['armor'] : 0;

        $defenderDamageLow = isset($defender['damageLowValue']) ? $defender['damageLowValue'] : 0;
        $defenderDamageHigh = isset($defender['damageHighValue']) ? $defender['damageHighValue'] : 0;
        $defenderHealth = isset($defender['health']) ? $defender['health'] : 0;
        $defenderArmor = isset($defender['armor']) ? $defender['armor'] : 0;

        $attackResult = $this->hit($attackerDamageLow, $attackerDamageHigh, $defenderArmor, $defenderHealth);

        $attackerHit = (int) isset($attackResult['hitDamage']) ? $attackResult['hitDamage'] : 0;
        $defenderHealthAfterAttack = (int) isset($attackResult['defenderHealth']) ? $attackResult['defenderHealth'] : 0;

        if ($defenderHealthAfterAttack > 0) {
            $attackResultDefender = $this->hit($defenderDamageLow, $defenderDamageHigh, $attackerArmor, $attackerHealth);
        } else {
            return [
                'attackerHit' => $attackerHit,
                'defenderHealthAfterAttack' => $defenderHealthAfterAttack,
                'defenderHit' => 0,
                'attackerHealthAfterAttack' => $attackerHealth,
                'deadStatus' => 2
            ];
        }

        $defenderHit = (int) isset($attackResultDefender['hitDamage']) ? $attackResultDefender['hitDamage'] : 0;
        $attackerHealthAfterAttack = (int) isset($attackResultDefender['defenderHealth']) ? $attackResultDefender['defenderHealth'] : 0;

        if ($attackerHealthAfterAttack > 0) {
            return [
                'attackerHit' => $attackerHit,
                'defenderHealthAfterAttack' => $defenderHealthAfterAttack,
                'defenderHit' => $defenderHit,
                'attackerHealthAfterAttack' => $attackerHealthAfterAttack,
                'deadStatus' => 0
            ];
        } else {
            return [
                'attackerHit' => $attackerHit,
                'defenderHealthAfterAttack' => $defenderHealthAfterAttack,
                'defenderHit' => $defenderHit,
                'attackerHealthAfterAttack' => $attackerHealthAfterAttack,
                'deadStatus' => 1
            ];
        }
    }

    private function hit($attackerDamageLow, $attackerDamageHigh, $defenderArmor, $defenderHealth)
    {
        $attackerDamage = rand($attackerDamageLow, $attackerDamageHigh);

        $block = (int) ceil($defenderArmor * 0.2);

        $hitDamage = (int) $attackerDamage - $block;

        $hitDamage = $hitDamage > 0 ? $hitDamage : 0;

        $defenderHealth = (int) $defenderHealth - (int) $hitDamage;

        return [
            'hitDamage' => (int) $hitDamage,
            'defenderHealth' => (int) $defenderHealth
        ];
    }

    public function attackerWinMonster($defenderId)
    {
        if (! $defenderId) {
            throw new GameException('Not set defender id');
        }

        $heroId = $this->authenticationService->getHeroId();

        if (! $heroId) {
            throw new GameException('Not set hero');
        }

        /** @var Hero $hero */
        $hero = $this->heroRepository->findOneRowById($heroId, Hero::class);

        $status = $hero->getHeroStatus();

        if ($status != 2) {
            $this->responseService->redirect('game', 'playHero', [$heroId]);
        }

        $changeHeroStatus = $this->heroRepository->update($heroId, ['hero_status' => 1]);

        if (! $changeHeroStatus) {
            throw new GameException('Can not change status');
        }

        /** @var Battle[] $battleDeadStatus2 */
        $battleDeadStatus2 = $this->battleRepository->findByCondition(['attacker_id' => $heroId, 'defender_monster_id' => $defenderId, 'dead_status' => 2], Battle::class);

        if (! empty($battleDeadStatus2)) {
            $deleteBattle = $this->battleRepository->delete($battleDeadStatus2[0]->getId());

            if (! $deleteBattle) {
                throw new GameException('Can not delete battle with status 2');
            }
        }

        /** @var Monsters $monsterInformation */
        $monsterInformation = $this->monstersRepository->monsterInformation([$defenderId]);

        $item = $this->generateItem();

        $newResources = $this->generateNewResources();

        $amountNewResources = isset($newResources['amount']) ? $newResources['amount'] : 0;
        $typeNewResources = isset($newResources['resources']) ? $newResources['resources'] : '';

        $experienceAfterBattle = $hero->getExperience() + $monsterInformation->getWinExperience();

        $level = $this->levelRepository->getLevelByExperience([$experienceAfterBattle, $experienceAfterBattle]);

        if (empty($level)) {
            throw new GameException('Not such level');
        }

        $currentLevel = $level['id'];

        $updateHeroParams = [
            'level_id' => $currentLevel,
            'experience' => $experienceAfterBattle
        ];

        if ($currentLevel > $hero->getLevelId()) {
            $newLevelPoints = $hero->getLevelPoints() + self::LEVEL_UP;
            $updateHeroParams['level_points'] = $newLevelPoints;
        }

        $heroUpdate = $this->heroRepository->update($heroId, $updateHeroParams);

        if (! $heroUpdate) {
            throw new GameException('$hero can not be update');
        }

        /** @var TypeOfResources[] $typeOfResources */
        $typeOfResources = $this->typeOfResourcesRepository->findByCondition(['name' => HeroService::RESOURCES_COLD], TypeOfResources::class);

        if (empty($typeOfResources)) {
            throw new GameException('Can not found this resources');
        }

        /** @var Resources[] $resources */
        $resources = $this->resourcesRepository->findByCondition(['heroes_id' => $heroId, 'type_of_resources_id' => $typeOfResources[0]->getId()], Resources::class);

        if (empty($resources)) {
            throw new GameException('Can not found this resources');
        }

        $goldFromMonster = rand($monsterInformation->getMinGold(), $monsterInformation->getMaxGold());

        $gold = $resources[0]->getAmount() + $goldFromMonster;

        $updateResources = $this->resourcesRepository->update($resources[0]->getId(), ['amount' => $gold]);

        if (! $updateResources) {
            throw new GameException('Can not update this row');
        }

        $informationForReturn = [
            'monsterType' => $monsterInformation->getMonsterType(),
            'gold' => $goldFromMonster,
            'experience' => $monsterInformation->getWinExperience(),
            'itemName' => $item,
            'amountResources' => $amountNewResources,
            'typeResources' => $typeNewResources
        ];

        return $informationForReturn;
    }

    public function defenderHeroWinHero($defenderId)
    {
        if (! $defenderId) {
            throw new GameException('Not set defender id');
        }

        $heroId = $this->authenticationService->getHeroId();

        if (! $heroId) {
            throw new GameException('Not set hero');
        }

        /** @var Hero $hero */
        $hero = $this->heroRepository->findOneRowById($heroId, Hero::class);

        $status = $hero->getHeroStatus();

        if ($status != 2) {
            $this->responseService->redirect('game', 'playHero', [$heroId]);
        }

        /** @var Battle[] $battleDeadStatus1 */
        $battleDeadStatus1 = $this->battleRepository->findByCondition(['attacker_id' => $heroId, 'defender_hero_id' => $defenderId, 'dead_status' => 1], Battle::class);

        if (! empty($battleDeadStatus1)) {
            $deleteBattle = $this->battleRepository->delete($battleDeadStatus1[0]->getId());

            if (! $deleteBattle) {
                throw new GameException('Can not delete battle with status 2');
            }
        }

        $heroHalfFromMaxHP = $hero->getHealth() / 2;

        $winHonor = $this->battleRepository->getWinHonorData([HeroService::RESOURCES_HONOR, $defenderId]);

        $loseHonor = $this->battleRepository->getLoseHonorData([HeroService::RESOURCES_HONOR, $heroId]);

        $updateWiner = $this->resourcesRepository->update($winHonor['id'], ['amount' => $winHonor['amaunt']]);

        if (! $updateWiner) {
            throw new GameException('Can not update honor');
        }

        $updateLoser = $this->resourcesRepository->update($loseHonor['id'], ['amount' => $loseHonor['amaunt']]);

        if (! $updateLoser) {
            throw new GameException('Can not update honor');
        }

        $newHeroData = [
            'hero_status' => 1,
            'real_health' => $heroHalfFromMaxHP,
        ];

        $changeHero = $this->heroRepository->update($heroId, $newHeroData);

        if (! $changeHero) {
            throw new GameException('Can not change hero data');
        }

        return [
            'heroHalfFromMaxHP' => $heroHalfFromMaxHP,
            'winnerHonor' => $winHonor['amaunt'],
            'loseHonor' => $loseHonor['amaunt']
        ];
    }

    public function attackerHeroWinHero($defenderId)
    {
        if (! $defenderId) {
            throw new GameException('Not set defender id');
        }

        $heroId = $this->authenticationService->getHeroId();

        if (! $heroId) {
            throw new GameException('Not set hero');
        }

        /** @var Hero $hero */
        $hero = $this->heroRepository->findOneRowById($heroId, Hero::class);

        $status = $hero->getHeroStatus();

        if ($status != 2) {
            $this->responseService->redirect('game', 'playHero', [$heroId]);
        }

        /** @var Battle[] $battleDeadStatus1 */
        $battleDeadStatus1 = $this->battleRepository->findByCondition(['attacker_id' => $heroId, 'defender_hero_id' => $defenderId, 'dead_status' => 1], Battle::class);

        if (! empty($battleDeadStatus1)) {
            $deleteBattle = $this->battleRepository->delete($battleDeadStatus1[0]->getId());

            if (! $deleteBattle) {
                throw new GameException('Can not delete battle with status 2');
            }
        }

        $winHonor = $this->battleRepository->getWinHonorData([HeroService::RESOURCES_HONOR, $heroId]);

        $loseHonor = $this->battleRepository->getLoseHonorData([HeroService::RESOURCES_HONOR, $defenderId]);

        $updateWiner = $this->resourcesRepository->update($winHonor['id'], ['amount' => $winHonor['amaunt']]);

        if (! $updateWiner) {
            throw new GameException('Can not update honor');
        }

        $updateLoser = $this->resourcesRepository->update($loseHonor['id'], ['amount' => $loseHonor['amaunt']]);

        if (! $updateLoser) {
            throw new GameException('Can not update honor');
        }

        $newHeroData = [
            'hero_status' => 1
        ];

        $changeHero = $this->heroRepository->update($heroId, $newHeroData);

        if (! $changeHero) {
            throw new GameException('Can not change hero data');
        }

        return [
            'winnerHonor' => $winHonor['amaunt'],
        ];
    }

    public function defenderWinHero($defenderId)
    {
        if (! $defenderId) {
            throw new GameException('Not set defender id');
        }

        $heroId = $this->authenticationService->getHeroId();

        if (! $heroId) {
            throw new GameException('Not set hero');
        }

        /** @var Hero $hero */
        $hero = $this->heroRepository->findOneRowById($heroId, Hero::class);

        $status = $hero->getHeroStatus();

        if ($status != 2) {
            $this->responseService->redirect('game', 'playHero', [$heroId]);
        }

        /** @var Battle[] $battleDeadStatus1 */
        $battleDeadStatus1 = $this->battleRepository->findByCondition(['attacker_id' => $heroId, 'defender_monster_id' => $defenderId, 'dead_status' => 1], Battle::class);

        if (! empty($battleDeadStatus1)) {
            $deleteBattle = $this->battleRepository->delete($battleDeadStatus1[0]->getId());

            if (! $deleteBattle) {
                throw new GameException('Can not delete battle with status 2');
            }
        }

        /** @var Monsters $monsterInformation */
        $monsterInformation = $this->monstersRepository->monsterInformation([$defenderId]);

        $heroHalfFromMaxHP = $hero->getHealth() / 2;

        $experienceTakeTen = ($hero->getExperience() / 100) * 10;

        $experienceAfterBattle = $hero->getExperience() - $experienceTakeTen;

        $level = $this->levelRepository->getLevelByExperience([$experienceAfterBattle, $experienceAfterBattle]);


        $currentLevel = $level['id'];

        if ($currentLevel < $hero->getLevelId()) {
            /** @var Level $levelDownExp */
            $levelDownExp = $this->levelRepository->findOneRowById($hero->getLevelId(), Level::class);
            $experienceAfterBattle = $levelDownExp->getFromExperience();
        }

        $newHeroData = [
            'hero_status' => 1,
            'experience' => $experienceAfterBattle,
            'real_health' => $heroHalfFromMaxHP,
        ];

        $changeHero = $this->heroRepository->update($heroId, $newHeroData);

        if (! $changeHero) {
            throw new GameException('Can not change hero data');
        }

        $returnData = [
            'monsterType' => $monsterInformation->getMonsterType(),
            'lostExperience' => $experienceTakeTen,
            'heroHealth' => $heroHalfFromMaxHP
        ];

        return $returnData;
    }

    // TODO When create to return id, not bool value
    public function generateItem()
    {
        $typeOfItems = $this->typeOfItemsRepository->findAll(TypeOfItem::class);
        $counterForItems = count($typeOfItems);

        $dropItemsTypeId = rand(1, $counterForItems);

        /** @var TypeOfItem $itemType */
        $itemType = $this->typeOfItemsRepository->findOneRowById($dropItemsTypeId, TypeOfItem::class);

        /** @var Item[] $itemRepo */
        $itemRepo = $this->itemsRepository->findAll(Item::class);

        $itemRepoCounter = count($itemRepo);

        $latsItemId = $itemRepo[$itemRepoCounter - 1]->getId();

        $itemName = 'Item' . ($latsItemId + 1);

        $item = [
            'strength' => rand(0, 3),
            'vitality' => rand(0, 3),
            'magic' => rand(0, 3),
            'dexterity' => rand(0, 3),
            'health' => rand(0, 10),
            'mana' => rand(0, 10),
            'type_of_item_id' => $dropItemsTypeId,
            'hero_id' => $this->authenticationService->getHeroId(),
            'is_equiped' => 0,
            'critical' => 0,
            'item_level' => 1,
            'name' => $itemName
        ];

        switch ($itemType->getWeaponOrArmor()) {
            case self::ARMOR :
                $item['armor'] = rand(14, 30);
                $item['damage_low_value'] = 0;
                $item['damage_high_value'] = 0;
                break;
            case self::WEAPON :
                $item['damage_low_value'] = rand(15, 20);
                $item['damage_high_value'] = rand(21, 30);
                $item['armor'] = 0;
                break;
            default :
                $item['armor'] = rand(14, 30);
                $item['damage_low_value'] = 0;
                $item['damage_high_value'] = 0;
                break;
        }

        try {
            $itemCreate = $this->itemsRepository->create($item);
        } catch (\Exception $e) {
            return 'No item';
        }

        return $itemName;
    }

    private function generateNewResources()
    {
        $typeOfResources = $this->typeOfResourcesRepository->getTypeOfItemsWithoutGold([HeroService::RESOURCES_COLD, HeroService::RESOURCES_HONOR]);

        $randomResources = $typeOfResources[array_rand($typeOfResources)];

        $idRandomResources = isset($randomResources['type_of_resources_id']) ? $randomResources['type_of_resources_id'] : 0;

        if (! $idRandomResources) {
            throw new GameException('Not set resources');
        }

        /** @var TypeOfResources $typeResources */
        $typeResources = $this->typeOfResourcesRepository->findOneRowById($idRandomResources, TypeOfResources::class);

        $heroId = $this->authenticationService->getHeroId();

        $randAmount = rand(1, 5);

        /** @var Resources[] $resources */
        $resources = $this->resourcesRepository->findByCondition(['type_of_resources_id' => $typeResources->getId(), 'heroes_id' => $heroId], Resources::class);

        $amount = $resources[0]->getAmount() + $randAmount;

        $newResources = $this->resourcesRepository->update($resources[0]->getId(), ['amount' => $amount]);

        if (! $newResources) {
            throw new GameException('Can not update row');
        }

        return [
            'amount' => $randAmount,
            'resources' => $typeResources->getName()
        ];
    }
}

