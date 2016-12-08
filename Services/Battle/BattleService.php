<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 8.12.2016 г.
 * Time: 20:15
 */

namespace FPopov\Services\Battle;


use FPopov\Core\ViewInterface;
use FPopov\Models\DB\Hero\Hero;
use FPopov\Repositories\Hero\HeroRepository;
use FPopov\Repositories\Hero\HeroRepositoryInterface;
use FPopov\Repositories\Monsters\MonstersRepository;
use FPopov\Repositories\Monsters\MonstersRepositoryInterface;
use FPopov\Repositories\TypeMonsters\TypeMonstersRepository;
use FPopov\Repositories\TypeMonsters\TypeMonstersRepositoryInterface;
use FPopov\Services\AbstractService;
use FPopov\Services\Application\AuthenticationServiceInterface;

class BattleService extends AbstractService implements BattleServiceInterface
{

    private $view;
    private $authenticationService;

    /** @var MonstersRepository */
    private $monstersRepository;

    /** @var TypeMonstersRepository */
    private $typeMonstersRepository;

    /** @var  HeroRepository */
    private $heroRepository;

    public function __construct(
        ViewInterface $view,
        AuthenticationServiceInterface $authenticationService,
        MonstersRepositoryInterface $monstersRepository,
        TypeMonstersRepositoryInterface $typeMonstersRepository,
        HeroRepositoryInterface $heroRepository
    )
    {
        $this->view = $view;
        $this->authenticationService = $authenticationService;
        $this->monstersRepository = $monstersRepository;
        $this->typeMonstersRepository = $typeMonstersRepository;
        $this->heroRepository = $heroRepository;
    }

//    public function findAllHeroesForCurrentUser($params = [])
//    {
//        $params['deleteHeroStatus'] = self::DELETE_HERO_STATUS;
//        $allowParams = [
//            'userId',
//            'deleteHeroStatus'
//        ];
//        $bindFilter = $this->getParamFilters($params, $allowParams);
//
//        $structure = [
//            'hero_name' => [
//                'title' => 'Hero Name',
//                'type' => self::TYPE_DATA
//            ],
//            'hero_type' => [
//                'title' => 'Hero Type',
//                'type' => self::TYPE_DATA
//            ],
//            'level' => [
//                'title' => 'Level',
//                'type' => self::TYPE_DATA
//            ],
//            'experience' => [
//                'title' => 'Experience',
//                'type' => self::TYPE_DATA
//            ],
//            'to_experience' => [
//                'title' => 'Experience to level',
//                'type' => self::TYPE_DATA
//            ],
//            'city_name' => [
//                'title' => 'City',
//                'type' => self::TYPE_DATA
//            ],
//            'coordinates_x' => [
//                'title' => 'Coordinates X',
//                'type' => self::TYPE_DATA
//            ],
//            'coordinates_y' => [
//                'title' => 'Coordinates Y',
//                'type' => self::TYPE_DATA
//            ],
//            'actions' => array(
//                'title' => 'Actions',
//                'type' => self::TYPE_ACTIONS,
//                'values' => array(
//                    'delete' => function  ($row) {
//                        return $this->view->uri('heroes', 'removeHero', [], ['heroId' => $row['id']]);
//                    }
//                )
//            ),
//            'id' => [
//                'title' => 'Play',
//                'type' => self::TYPE_DATA,
//                'value' => function ($value) {
//                    return 'Play';
//                },
//                'onClick' => function ($row) {
//                    return $this->view->uri('game', 'playHero', ['heroId' => $row['id']]);
//                }
//            ]
//        ];
//
//        $repoData = $this->heroRepository->findAllHeroesForCurrentUser($bindFilter);
//        $bindFilter['total'] = $this->heroRepository->findAllHeroesForCurrentUserCount($bindFilter);
//        $data = $this->generateGridData($structure, $repoData);
//
//        $searchFields = [
//            'name' => 'Hero Name'
//        ];
//
//        $table = [
//            'tableSearchFields' => $searchFields,
//            'tableData' => $data,
//            'filter' => $this->pageFilters($bindFilter),
//        ];
//
//        return $table;
//    }

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
                'title' => 'Play',
                'type' => self::TYPE_DATA,
                'value' => function ($value) {
                    return 'Play';
                },
                'onClick' => function ($row) {
                    return $this->view->uri('game', 'playHero', ['monsterId' => $row['id']]);
                }
            ]
        ];



        $repoData = $this->monstersRepository->findAllMonstersForCurentCity($bindFilter);

        $bindFilter['total'] = $this->monstersRepository->findAllMonstersForCurentCityCount($bindFilter);
        $data = $this->generateGridData($structure, $repoData);

        $searchFields = [
            'type_of_monster' => 'Monster Type'
        ];

        $table = [
            'tableSearchFields' => $searchFields,
            'tableData' => $data,
            'filter' => $this->pageFilters($bindFilter),
        ];

        return $table;
    }
}