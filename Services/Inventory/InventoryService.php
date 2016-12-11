<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 11.12.2016 г.
 * Time: 19:41
 */

namespace FPopov\Services\Inventory;


use FPopov\Core\MVC\SessionInterface;
use FPopov\Core\ViewInterface;
use FPopov\Services\AbstractService;
use FPopov\Services\Application\AuthenticationServiceInterface;
use FPopov\Services\Application\ResponseServiceInterface;

class InventoryService extends AbstractService implements InventoryServiceInterface
{
    private $view;
    private $authenticationService;
    private $session;
    private $responseService;

    public function __construct(
        ViewInterface $view,
        AuthenticationServiceInterface $authenticationService,
        SessionInterface $session,
        ResponseServiceInterface $responseService
    )
    {
        $this->view = $view;
        $this->authenticationService = $authenticationService;
        $this->session = $session;
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

    public function inventory($params = [])
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
    }
}