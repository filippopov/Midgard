<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 8.12.2016 г.
 * Time: 20:15
 */

namespace FPopov\Services\Battle;


use FPopov\Core\MVC\SessionInterface;
use FPopov\Core\ViewInterface;
use FPopov\Exceptions\GameException;
use FPopov\Models\DB\Hero\Hero;
use FPopov\Models\DB\Hero\HeroStatistic;
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

        $monsterInformation = $this->monstersRepository->monsterInformation([$monsterId]);

        return [
            'heroInformation' => $heroInformation,
            'monsterInformation' => $monsterInformation
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


    }
}