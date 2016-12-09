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
use FPopov\Models\DB\Monsters\Monsters;
use FPopov\Models\DB\TypeMonsters\TypeMonster;
use FPopov\Repositories\Battle\BattleRepository;
use FPopov\Repositories\Battle\BattleRepositoryInterface;
use FPopov\Repositories\Hero\HeroRepository;
use FPopov\Repositories\Hero\HeroRepositoryInterface;
use FPopov\Repositories\Monsters\MonstersRepository;
use FPopov\Repositories\Monsters\MonstersRepositoryInterface;
use FPopov\Repositories\TypeMonsters\TypeMonstersRepository;
use FPopov\Repositories\TypeMonsters\TypeMonstersRepositoryInterface;
use FPopov\Services\AbstractService;
use FPopov\Services\Application\AuthenticationServiceInterface;
use FPopov\Services\Hero\HeroService;

class BattleService extends AbstractService implements BattleServiceInterface
{


    const HERO_STATUS_IN_BATTLE = 2;
    const DEAD_BATTLE_STATUS = 0;

    private $view;
    private $authenticationService;
    private $session;

    /** @var MonstersRepository */
    private $monstersRepository;

    /** @var TypeMonstersRepository */
    private $typeMonstersRepository;

    /** @var  HeroRepository */
    private $heroRepository;

    /** @var  BattleRepository */
    private $battleRepository;

    public function __construct(
        ViewInterface $view,
        AuthenticationServiceInterface $authenticationService,
        MonstersRepositoryInterface $monstersRepository,
        TypeMonstersRepositoryInterface $typeMonstersRepository,
        HeroRepositoryInterface $heroRepository,
        SessionInterface $session,
        BattleRepositoryInterface $battleRepository
    )
    {
        $this->view = $view;
        $this->authenticationService = $authenticationService;
        $this->monstersRepository = $monstersRepository;
        $this->typeMonstersRepository = $typeMonstersRepository;
        $this->heroRepository = $heroRepository;
        $this->session = $session;
        $this->battleRepository = $battleRepository;
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

        $heroUpdateStatus = $this->heroRepository->update($heroId, ['hero_status' => self::HERO_STATUS_IN_BATTLE]);

        if (! $heroUpdateStatus) {
            throw new GameException('Can not update hero status');
        }

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

    public function attack($attackParams = [])
    {
        $typeOfBattle = isset($attackParams['typeOfBattle']) ? $attackParams['typeOfBattle'] : '';
        $attackerId = isset($attackParams['attackerId']) ? $attackParams['attackerId'] : 0;
        $defenderId = isset($attackParams['defenderId']) ? $attackParams['defenderId'] : 0;

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

        $resultAttack = $this->makeAttack($makeAttack);
        $attackerHit = isset($resultAttack['attackerHit']) ? $resultAttack['attackerHit'] : 0;
        $defenderHealthAfterAttack = isset($resultAttack['defenderHealthAfterAttack']) ? $resultAttack['defenderHealthAfterAttack'] : 0;
        $defenderHit = isset($resultAttack['defenderHit']) ? $resultAttack['defenderHit'] : 0;
        $attackerHealthAfterAttack = isset($resultAttack['attackerHealthAfterAttack']) ? $resultAttack['attackerHealthAfterAttack'] : 0;
        $deadStatus = isset($resultAttack['deadStatus']) ? $resultAttack['deadStatus'] : 0;

        $attackerHealthAfterAttack = $attackerHealthAfterAttack - $attacker->getHealthFromItems();

        $createBattleParams = [
            'attacker_id' => $attackerId,
            'defender_monster_id' => $defenderId,
            'attacker_hit' => $attackerHit,
            'defender_hit' => $defenderHit,
            'defender_hero_id' => 0,
            'defender_health_after_attack' => $defenderHealthAfterAttack,
            'attacker_health_after_attack' => $attackerHealthAfterAttack,
            'dead_status' => $deadStatus
        ];

        /** @var Battle[] $deleteBattleRows */
        $deleteBattleRows = $this->battleRepository->findByCondition(['attacker_id' => $attackerId, 'defender_monster_id' => $defenderId], Battle::class);

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
}