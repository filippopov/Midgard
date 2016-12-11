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
use FPopov\Models\DB\TypeOfItems\TypeOfItem;
use FPopov\Repositories\Items\ItemsRepository;
use FPopov\Repositories\Items\ItemsRepositoryInterface;
use FPopov\Repositories\TypeOfItems\TypeOfItemsRepository;
use FPopov\Repositories\TypeOfItems\TypeOfItemsRepositoryInterface;
use FPopov\Services\AbstractService;
use FPopov\Services\Application\AuthenticationServiceInterface;
use FPopov\Services\Application\ResponseServiceInterface;

class InventoryService extends AbstractService implements InventoryServiceInterface
{
    private $view;
    private $authenticationService;
    private $session;
    private $responseService;

    /** @var  ItemsRepository */
    private $itemsRepository;

    /** @var  TypeOfItemsRepository */
    private $typeOfItemsRepository;

    public function __construct(
        ViewInterface $view,
        AuthenticationServiceInterface $authenticationService,
        SessionInterface $session,
        ResponseServiceInterface $responseService,
        ItemsRepositoryInterface $itemsRepository,
        TypeOfItemsRepositoryInterface $typeOfItemsRepository
    )
    {
        $this->view = $view;
        $this->authenticationService = $authenticationService;
        $this->session = $session;
        $this->responseService = $responseService;
        $this->itemsRepository = $itemsRepository;
        $this->typeOfItemsRepository = $typeOfItemsRepository;
    }

    public function inventory($params = [])
    {
        $heroId = $this->authenticationService->getHeroId();

        $params['heroId'] = $heroId;
        $allowParams = ['heroId'];
        $bindFilter = $this->getParamFilters($params, $allowParams);

        $structure = [
            'name' => [
                'title' => 'Name Of Item',
                'type' => self::TYPE_DATA
            ],
            'type_of_item' => [
                'title' => 'Type Of Item',
                'type' => self::TYPE_DATA
            ],
            'weapon_or_armor' => [
                'title' => 'Defense Or Attack',
                'type' => self::TYPE_DATA
            ],
            'for_type_hero' => [
                'title' => 'This Item Can be use from',
                'type' => self::TYPE_DATA
            ],
            'item_level' => [
                'title' => 'Item Level',
                'type' => self::TYPE_DATA
            ],
            'damage' => [
                'title' => 'Damage',
                'type' => self::TYPE_DATA
            ],
            'armor' => [
                'title' => 'Armor',
                'type' => self::TYPE_DATA
            ],
            'strength' => [
                'title' => 'Strength',
                'type' => self::TYPE_DATA
            ],
            'dexterity' => [
                'title' => 'Dexterity',
                'type' => self::TYPE_DATA
            ],
            'vitality' => [
                'title' => 'Vitality',
                'type' => self::TYPE_DATA
            ],
            'magic' => [
                'title' => 'Magic',
                'type' => self::TYPE_DATA
            ],
            'critical' => [
                'title' => 'Critical',
                'type' => self::TYPE_DATA
            ],
            'health' => [
                'title' => 'Health',
                'type' => self::TYPE_DATA
            ],
            'mana' => [
                'title' => 'Mana',
                'type' => self::TYPE_DATA
            ],
            'actions' => array(
                'title' => 'Delete',
                'type' => self::TYPE_ACTIONS,
                'values' => array(
                    'delete' => function  ($row) {
                        return $this->view->uri('heroes', 'removeHero', [], ['heroId' => $row['id']]);
                    }
                )
            ),
            'is_equiped' => [
                'title' => 'Equipped',
                'type' => self::TYPE_DATA,
                'value' => function ($value) {
                    return $value = $value == 1 ? 'Already in use' : 'Equipped item';
                },
                'onClick' => function ($row) {
                    return $this->view->uri('battle', 'attackHero', ['defenderHeroId' => $row['id']]);
                }
            ]
        ];

        $repoData = $this->itemsRepository->getAllItemsForOneHero($bindFilter);
        $bindFilter['total'] = $this->itemsRepository->getAllItemsForOneHeroCount($bindFilter);
        $data = $this->generateGridData($structure, $repoData);

        /** @var TypeOfItem[] $typeOfItems */
        $typeOfItems = $this->typeOfItemsRepository->findAll(TypeOfItem::class);

        $dropDownForTypeOfItems[''] = '';

        foreach ($typeOfItems as $typeOfItem) {
            $dropDownForTypeOfItems[$typeOfItem->getName()] = $typeOfItem->getName();
        }

        $dropDownForTypeOfItems['title'] = 'Item Type';

        $searchFields = [
            'type_of_item' => $dropDownForTypeOfItems
        ];

        $table = [
            'tableSearchFields' => $searchFields,
            'tableData' => $data,
            'filter' => $this->pageFilters($bindFilter),
        ];

        return $table;
    }
}
