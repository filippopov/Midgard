<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 6.12.2016 г.
 * Time: 20:00
 */

namespace FPopov\Services\Hero;



use FPopov\Core\MVC\Message;
use FPopov\Core\ViewInterface;
use FPopov\Models\DB\City\City;
use FPopov\Models\DB\Hero\Hero;
use FPopov\Models\DB\Level\Level;
use FPopov\Models\DB\TypeOfHero\TypeOfHero;
use FPopov\Models\DB\TypeOfResources\TypeOfResources;
use FPopov\Repositories\City\CityRepository;
use FPopov\Repositories\City\CityRepositoryInterface;
use FPopov\Repositories\Hero\HeroRepository;
use FPopov\Repositories\Hero\HeroRepositoryInterface;
use FPopov\Repositories\Level\LevelRepository;
use FPopov\Repositories\Level\LevelRepositoryInterface;
use FPopov\Repositories\Resources\ResourcesRepository;
use FPopov\Repositories\Resources\ResourcesRepositoryInterface;
use FPopov\Repositories\TypeOfHeroes\TypeOfHeroesRepository;
use FPopov\Repositories\TypeOfHeroes\TypeOfHeroesRepositoryInterface;
use FPopov\Repositories\TypeOfResources\TypeOfResourcesRepository;
use FPopov\Repositories\TypeOfResources\TypeOfResourcesRepositoryInterface;
use FPopov\Services\AbstractService;
use FPopov\Services\Application\AuthenticationServiceInterface;

class HeroService extends AbstractService implements HeroServiceInterface
{
    const RESOURCES_COLD = 'gold';
    const RESOURCES_HONOR = 'honor';
    const RESOURCES_IRON = 'iron';
    const RESOURCES_LEATHER = 'leather';
    const RESOURCES_SILK = 'silk';
    const RESOURCES_TREE = 'tree';

    const DELETE_HERO_STATUS = 10;

    private $view;
    private $authenticationService;

    /** @var HeroRepository */
    private $heroRepository;

    /** @var TypeOfHeroesRepository */
    private $typeOfHeroesRepository;

    /** @var  LevelRepository */
    private $levelRepository;

    /** @var  CityRepository */
    private $cityRepository;

    /** @var  TypeOfResourcesRepository */
    private $typeOfResourcesRepository;

    /** @var  ResourcesRepository */
    private $resourcesRepository;

    public function __construct(
        ViewInterface $view,
        HeroRepositoryInterface $heroRepository,
        TypeOfHeroesRepositoryInterface $typeOfHeroesRepository,
        AuthenticationServiceInterface $authenticationService,
        LevelRepositoryInterface $levelRepository,
        CityRepositoryInterface $cityRepository,
        ResourcesRepositoryInterface $resourcesRepository,
        TypeOfResourcesRepositoryInterface $typeOfResourcesRepository
        )
    {
        $this->view = $view;
        $this->heroRepository = $heroRepository;
        $this->typeOfHeroesRepository = $typeOfHeroesRepository;
        $this->authenticationService = $authenticationService;
        $this->levelRepository = $levelRepository;
        $this->cityRepository = $cityRepository;
        $this->typeOfResourcesRepository = $typeOfResourcesRepository;
        $this->resourcesRepository = $resourcesRepository;
    }

    public function findAllHeroesForCurrentUser($params = [])
    {
        $params['deleteHeroStatus'] = self::DELETE_HERO_STATUS;
        $allowParams = [
            'userId',
            'deleteHeroStatus'
        ];
        $bindFilter = $this->getParamFilters($params, $allowParams);

        $structure = [
            'hero_name' => [
                'title' => 'Hero Name',
                'type' => self::TYPE_DATA
            ],
            'hero_type' => [
                'title' => 'Hero Type',
                'type' => self::TYPE_DATA
            ],
            'level' => [
                'title' => 'Level',
                'type' => self::TYPE_DATA
            ],
            'experience' => [
                'title' => 'Experience',
                'type' => self::TYPE_DATA
            ],
            'to_experience' => [
                'title' => 'Experience to level',
                'type' => self::TYPE_DATA
            ],
            'city_name' => [
                'title' => 'City',
                'type' => self::TYPE_DATA
            ],
            'coordinates_x' => [
                'title' => 'Coordinates X',
                'type' => self::TYPE_DATA
            ],
            'coordinates_y' => [
                'title' => 'Coordinates Y',
                'type' => self::TYPE_DATA
            ],
            'actions' => array(
                'title' => 'Actions',
                'type' => self::TYPE_ACTIONS,
                'values' => array(
                    'delete' => function  ($row) {
                        return $this->view->uri('heroes', 'removeHero', [], ['heroId' => $row['id']]);
                    }
                )
            ),
            'id' => [
                'title' => 'Play',
                'type' => self::TYPE_DATA,
                'value' => function ($value) {
                    return 'Play';
                },
                'onClick' => function ($row) {
                    return $this->view->uri('game', 'playHero', ['heroId' => $row['id']]);
                }
            ]
        ];

        $repoData = $this->heroRepository->findAllHeroesForCurrentUser($bindFilter);
        $bindFilter['total'] = $this->heroRepository->findAllHeroesForCurrentUserCount($bindFilter);
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

    public function createHero()
    {
        $structure = $this->getModuleFields();

        return [
            'formFieldData' => self::generateFormData($structure)
        ];
    }

    public function addGridHero($heroName, $heroType)
    {
        if (empty($heroName)) {
            Message::setError('Please enter name');
            return false;
        }

        if (empty($heroName)) {
            Message::setError('Please enter hero type');
            return false;
        }

        $isExistingHeroName = $this->heroRepository->findByCondition(['name' => $heroName]);

        if (! empty($isExistingHeroName)) {
            Message::setError('Hero name exist, please try with other name');
            return false;
        }

        $userId = $this->authenticationService->getUserId();

        /** @var Level[] $level */
        $level = $this->levelRepository->findByCondition(['level_number' => 1], Level::class);

        if (empty($level)) {
            Message::setError('Error please try again');
            return false;
        }

        /** @var City[] $city */
        $city = $this->cityRepository->findByCondition(
            ['coordinates_x' => 1, 'coordinates_y' => 10
        ], City::class);

        if (empty($city)) {
            Message::setError('Error, please try again');
            return false;
        }

        /** @var TypeOfHero $getHeroTypeData */
        $getHeroTypeData = $this->typeOfHeroesRepository->findOneRowById($heroType, TypeOfHero::class);

        if (empty($getHeroTypeData)) {
            Message::setError('Error, please try again');
            return false;
        }

        $heroParams = [
            'user_id' => $userId,
            'type_of_heroes_id' => $heroType,
            'level_id' => $level[0]->getId(),
            'city_id' => $city[0]->getId(),
            'real_health' => $getHeroTypeData->getHealth(),
            'real_mana' => $getHeroTypeData->getMana(),
            'experience' => 0,
            'name' => $heroName,
            'hero_status' => 0
        ];

        $newHero = $this->heroRepository->create($heroParams);

        if (! $newHero) {
            Message::setError('Error, please try again');
            return false;
        }

        /** @var Hero[] $newHeroCreate */
        $newHeroCreate = $this->heroRepository->findByCondition(['name' => $heroName], Hero::class);

        $newHeroId = $newHeroCreate[0]->getId();

        /** @var TypeOfResources[] $typeOfResources */
        $typeOfResources = $this->typeOfResourcesRepository->findAll(TypeOfResources::class);

        foreach ($typeOfResources as $typeOfResource) {
            $paramsResources = [
                'type_of_resources_id' => $typeOfResource->getId(),
                'heroes_id' => $newHeroId,
                'amount' => 0
            ];
            if ($typeOfResource->getName() == self::RESOURCES_COLD) {
                $paramsResources['amount'] = 1000;
            }

            $createResourceForCurrentHero = $this->resourcesRepository->create($paramsResources);

            if (! $createResourceForCurrentHero) {
                Message::setError('Create resources fail!!');
                return false;
            }
        }

        Message::postMessage('Successfully create hero', Message::POSITIVE_MESSAGE);
        return true;
    }

    public function removeHero($heroId)
    {
        $result = $this->heroRepository->changeStatus($heroId);

        if (! $result) {
            Message::postMessage('Can not delete this hero', Message::NEGATIVE_MESSAGE);
            return false;
        }

        Message::postMessage('Successfully delete this hero', Message::POSITIVE_MESSAGE);
        return true;
    }

    private function getModuleFields()
    {
        $structure = [
            'heroName' => [
                'title' => 'Hero Name',
                'type' => self::TYPE_INPUT,
            ],
            'heroType' => [
                'title' => 'Hero Type',
                'type' => self::TYPE_SELECT,
                'compleatValues' => $this->dropDownForHeroType(),
            ]
        ];

        return $structure;
    }

    private function dropDownForHeroType()
    {
        /** @var TypeOfHero[] $typeOFHeroes */
        $typeOFHeroes = $this->typeOfHeroesRepository->findAll(TypeOfHero::class);

        $dropDown = [];
        foreach ($typeOFHeroes as $typeOFHero) {
            $dropDown[$typeOFHero->getId()] = $typeOFHero->getName();
        }

        return $dropDown;
    }

    public function heroInformation()
    {
        $heroId = $this->authenticationService->getHeroId();

        $params = [$heroId];
        $information = $this->heroRepository->heroInformation($params);

        return $information;
    }
}