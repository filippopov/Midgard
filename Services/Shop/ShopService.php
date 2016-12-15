<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 15.12.2016 г.
 * Time: 10:37
 */

namespace FPopov\Services\Shop;


use FPopov\Core\MVC\SessionInterface;
use FPopov\Core\ViewInterface;
use FPopov\Exceptions\GameException;
use FPopov\Models\DB\TypeOfItems\TypeOfItem;
use FPopov\Repositories\Shop\ShopRepository;
use FPopov\Repositories\Shop\ShopRepositoryInterface;
use FPopov\Repositories\TypeOfItems\TypeOfItemsRepository;
use FPopov\Repositories\TypeOfItems\TypeOfItemsRepositoryInterface;
use FPopov\Services\AbstractService;
use FPopov\Services\Application\AuthenticationServiceInterface;
use FPopov\Services\Application\ResponseServiceInterface;

class ShopService extends AbstractService implements ShopServiceInterface
{
    const GOLD_SHOP = 'gold';
    const HONOR_SHOP = 'honor';
    const AUCTION_SHOP = 'auction';

    private $view;
    private $authenticationService;
    private $session;
    private $responseService;

    /** @var  ShopRepository */
    private $shopRepository;

    /** @var  TypeOfItemsRepository */
    private $typeOfItemsRepository;

    public function __construct(
        ViewInterface $view,
        AuthenticationServiceInterface $authenticationService,
        SessionInterface $session,
        ResponseServiceInterface $responseService,
        ShopRepositoryInterface $shopRepository,
        TypeOfItemsRepositoryInterface $typeOfItemsRepository
    )
    {
        $this->view = $view;
        $this->authenticationService = $authenticationService;
        $this->session = $session;
        $this->responseService = $responseService;
        $this->shopRepository = $shopRepository;
        $this->typeOfItemsRepository = $typeOfItemsRepository;
    }

    public function shopItems($params = [])
    {
        $typeOfShop = isset($params['typeOfShop']) ? $params['typeOfShop'] : '';

        if (empty($typeOfShop)) {
            throw new GameException('Not set type of shop');
        }

        $typeOfShopMapper = [
            self::GOLD_SHOP => 0,
            self::HONOR_SHOP => 1,
            self::AUCTION_SHOP => 2
        ];

        $typeOfShopValue = $typeOfShopMapper[$typeOfShop];

        unset($params['typeOfShop']);
        $params['typeOfShopValue'] = $typeOfShopValue;

        $allowParams = [
            'typeOfShopValue'
        ];

        $bindFilter = $this->getParamFilters($params, $allowParams);

        $heroId = $this->authenticationService->getHeroId();

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
            'price' => [
                'title' => 'Price',
                'type' => self::TYPE_DATA,
                'value' => function ($value) use ($typeOfShopValue){
                    if ($typeOfShopValue == 1) {
                        return $value . ' Honor';
                    } else {
                        return $value . ' Gold';
                    }
             },
            ],
            'id' => [
                'title' => 'Bye item',
                'type' => self::TYPE_DATA,
                'value' => function ($value) {
                    return 'Bye item';
                },
                'onClick' => function ($row){
                    return $this->view->uri('shop', 'byeItem', ['shopItemId' => $row['id']]);
                }
            ]
        ];

        if ($typeOfShop == self::AUCTION_SHOP) {
            $structure['hero_name'] = [
                'title' => 'Seller Name',
                'type' => self::TYPE_DATA,
            ];
            $structure['hero_id'] = [
                'title' => 'Remove item from auction',
                'type' => self::TYPE_DATA,
                'value' => function ($value) use ($heroId) {
                    if ($value == $heroId) {
                        return 'Cancel item';
                    } else {
                        return '';
                    }
                },
                'onClick' => function ($row){
                    return $this->view->uri('shop', 'cancelItemFromAction', ['shopItemId' => $row['id']]);
                }
            ];
        }

        $repoData = $this->shopRepository->getAllItemsFromShopByStatus($bindFilter);
        $bindFilter['total'] = $this->shopRepository->getAllItemsFromShopByStatusCount($bindFilter);
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

    public function byeItem($shopItemId)
    {
        if (! $shopItemId) {
            throw new GameException('Not set shop id');
        }

        $shopItem = $this->shopRepository->findOneRowById($shopItemId);
        dd($shopItem);
    }
}