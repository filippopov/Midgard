<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 7.12.2016 г.
 * Time: 16:32
 */

namespace FPopov\Services\Game;


use FPopov\Core\MVC\SessionInterface;
use FPopov\Core\ViewInterface;
use FPopov\Exceptions\GameException;
use FPopov\Repositories\Hero\HeroRepository;
use FPopov\Repositories\Hero\HeroRepositoryInterface;
use FPopov\Repositories\TypeOfHeroes\TypeOfHeroesRepositoryInterface;
use FPopov\Services\AbstractService;
use FPopov\Services\Application\AuthenticationServiceInterface;
use FPopov\Services\Application\ResponseServiceInterface;
use FPopov\Services\Hero\HeroService;

class GameServices extends AbstractService implements GameServicesInterface
{
    private $view;
    private $authenticationService;
    private $session;
    private $responseService;

    /** @var HeroRepository */
    private $heroRepository;


    public function __construct(
        ViewInterface $view,
        AuthenticationServiceInterface $authenticationService,
        SessionInterface $session,
        ResponseServiceInterface $responseService,
        HeroRepositoryInterface $heroRepository)
    {
        $this->view = $view;
        $this->authenticationService = $authenticationService;
        $this->session = $session;
        $this->responseService = $responseService;
        $this->heroRepository = $heroRepository;
    }

    public function playHero($params = [])
    {
        $heroId = (int) isset($params['heroId']) ? $params['heroId'] : 0;

        if (! $heroId) {
            $this->responseService->redirect('heroes', 'choseHeroToPlay');
        }

        $this->session->set('heroId', $heroId);

        $updateStatusToPlay = $this->heroRepository->update($heroId, ['hero_status' => 1]);

        if (! $updateStatusToPlay) {
            throw new GameException('Can not update hero status');
        }

        $needParams = [
            $heroId,
            $this->authenticationService->getUserId(),
            HeroService::DELETE_HERO_STATUS
        ];

        $updateStatusToOtherHeroes = $this->heroRepository->changeStatusOfHeroes($needParams);

        if (! $updateStatusToOtherHeroes) {
            throw new GameException('Can not update status to other heroes');
        }

        $menu = [
            0 => [
                'menuItem' => 'Hero Information',
                'controller' => 'heroes',
                'action' => 'heroInformation'
            ],
            1 => [
                'menuItem' => 'PVE Battle',
                'controller' => 'battle',
                'action' => 'pveBattle'
            ],
            2 => [
                'menuItem' => 'PVP Battle',
                'controller' => 'battle',
                'action' => 'pvpBattle'
            ],
            3 => [
                'menuItem' => 'Inventory',
                'controller' => 'inventory',
                'action' => 'inventory'
            ],
            4 => [
                'menuItem' => 'Level Up Status',
                'controller' => 'level',
                'action' => 'levelUp'
            ],
            5 => [
                'menuItem' => 'Create Item',
                'controller' => 'createItem',
                'action' => 'showRecipes'
            ],
            6 => [
                'menuItem' => 'Shop',
                'controller' => 'shop',
                'action' => 'shopItems',
                'params' => 'gold'
            ],
            7 => [
                'menuItem' => 'Shop Honor',
                'controller' => 'shop',
                'action' => 'shopItems',
                'params' => 'honor'
            ],
            8 => [
                'menuItem' => 'Auction House',
                'controller' => 'shop',
                'action' => 'shopItems',
                'params' => 'auction'
            ]
        ];

        $structure = [
            'menuItem' => [
                'title' => 'Menu',
                'type' => self::TYPE_DATA,
                'onClick' => function ($row) {
                    return $this->view->uri($row['controller'], $row['action'], ['data' => isset($row['params']) ? $row['params'] : '']);
                }
            ]
        ];

        $repoData = $menu;
        $bindFilter['total'] = count($menu);
        $data = $this->generateGridData($structure, $repoData);

        $table = [
            'tableData' => $data
        ];

        return $table;
    }
}