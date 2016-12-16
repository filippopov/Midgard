<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 15.12.2016 г.
 * Time: 10:37
 */

namespace FPopov\Services\Shop;


use FPopov\Core\MVC\Message;
use FPopov\Core\MVC\SessionInterface;
use FPopov\Core\ViewInterface;
use FPopov\Exceptions\GameException;
use FPopov\Models\DB\Shop\Shop;
use FPopov\Models\DB\TypeOfItems\TypeOfItem;
use FPopov\Repositories\Items\ItemsRepository;
use FPopov\Repositories\Items\ItemsRepositoryInterface;
use FPopov\Repositories\Recipes\RecipesRepository;
use FPopov\Repositories\Recipes\RecipesRepositoryInterface;
use FPopov\Repositories\Resources\ResourcesRepository;
use FPopov\Repositories\Resources\ResourcesRepositoryInterface;
use FPopov\Repositories\Shop\ShopRepository;
use FPopov\Repositories\Shop\ShopRepositoryInterface;
use FPopov\Repositories\TypeOfItems\TypeOfItemsRepository;
use FPopov\Repositories\TypeOfItems\TypeOfItemsRepositoryInterface;
use FPopov\Services\AbstractService;
use FPopov\Services\Application\AuthenticationServiceInterface;
use FPopov\Services\Application\ResponseServiceInterface;
use FPopov\Services\CreateItem\CreateItemService;
use FPopov\Services\Hero\HeroService;

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

    /** @var  RecipesRepository */
    private $recipesRepository;

    /** @var  ResourcesRepository */
    private $resourcesRepository;

    /** @var  ItemsRepository */
    private $itemsRepository;

    public function __construct(
        ViewInterface $view,
        AuthenticationServiceInterface $authenticationService,
        SessionInterface $session,
        ResponseServiceInterface $responseService,
        ShopRepositoryInterface $shopRepository,
        TypeOfItemsRepositoryInterface $typeOfItemsRepository,
        RecipesRepositoryInterface $recipesRepository,
        ResourcesRepositoryInterface $resourcesRepository,
        ItemsRepositoryInterface $itemsRepository
    )
    {
        $this->view = $view;
        $this->authenticationService = $authenticationService;
        $this->session = $session;
        $this->responseService = $responseService;
        $this->shopRepository = $shopRepository;
        $this->typeOfItemsRepository = $typeOfItemsRepository;
        $this->recipesRepository = $recipesRepository;
        $this->resourcesRepository = $resourcesRepository;
        $this->itemsRepository = $itemsRepository;
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
                'title' => 'Buy item',
                'type' => self::TYPE_DATA,
                'value' => function ($value) {
                    return 'Buy item';
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

        /** @var Shop $shopItem */
        $shopItem = $this->shopRepository->findOneRowById($shopItemId, Shop::class);

        $shopStatusMapper = [
            0 => self::GOLD_SHOP,
            1 => self::HONOR_SHOP,
            2 => self::AUCTION_SHOP
        ];

        $shopType = $shopStatusMapper[$shopItem->getShopStatus()];
        $heroId = $this->authenticationService->getHeroId();

        if (! $heroId) {
            throw new GameException('Not set hero id');
        }

        $itemParams = [
            'damage_low_value' => $shopItem->getDamageLowValue(),
            'damage_high_value' => $shopItem->getDamageHighValue(),
            'armor' => $shopItem->getArmor(),
            'strength' => $shopItem->getStrength(),
            'vitality' => $shopItem->getVitality(),
            'magic' => $shopItem->getMagic(),
            'dexterity' => $shopItem->getDexterity(),
            'health' => $shopItem->getHealth(),
            'mana' => $shopItem->getMana(),
            'type_of_item_id' => $shopItem->getTypeOfItemId(),
            'hero_id' => $heroId,
            'item_level' => $shopItem->getItemLevel(),
            'is_equiped' => 0,
            'critical' => $shopItem->getCritical(),
            'name' => $shopItem->getName()
        ];

        switch ($shopType) {
            case self::GOLD_SHOP :
                $goldParams = [
                    $shopItem->getPrice(),
                    $shopItem->getPrice(),
                    $heroId,
                    HeroService::RESOURCES_COLD
                ];

                $checkIsEnoughGold = $this->recipesRepository->checkEnoughResources($goldParams);

                if ($checkIsEnoughGold['is_enogh'] == CreateItemService::ENOUGH_RESOURCE) {
                    $myResourcesParams = [
                        $heroId,
                        HeroService::RESOURCES_COLD
                    ];
                    $myNeedResources = $this->recipesRepository->getResourcesAmountByHeroIdAndName($myResourcesParams);

                    $reduceAmountResourcesGold = $myNeedResources['amount'] - $shopItem->getPrice();

                    $updateResources = $this->resourcesRepository->update($myNeedResources['id'], ['amount' => $reduceAmountResourcesGold]);

                    if (! $updateResources) {
                        throw new GameException('Can not update resources');
                    }

                    $addItemToInventory = $this->itemsRepository->create($itemParams);

                    if (! $addItemToInventory) {
                        throw new GameException('Can not add item to inventory');
                    }

                    Message::postMessage('You successfully buy item', Message::POSITIVE_MESSAGE);
                    return $shopType;
                } else {
                    Message::postMessage("You need {$checkIsEnoughGold['is_enogh']} Gold, to buy this item", Message::NEGATIVE_MESSAGE);
                    return $shopType;
                }

                break;
            case self::HONOR_SHOP :

                $honorParams = [
                    $shopItem->getPrice(),
                    $shopItem->getPrice(),
                    $heroId,
                    HeroService::RESOURCES_HONOR
                ];

                $checkIsEnoughHonor = $this->recipesRepository->checkEnoughResources($honorParams);

                if ($checkIsEnoughHonor['is_enogh'] == CreateItemService::ENOUGH_RESOURCE) {

                    $myResourcesParams = [
                        $heroId,
                        HeroService::RESOURCES_HONOR
                    ];
                    $myNeedResources = $this->recipesRepository->getResourcesAmountByHeroIdAndName($myResourcesParams);

                    $reduceAmountResourcesHonor = $myNeedResources['amount'] - $shopItem->getPrice();

                    $updateResources = $this->resourcesRepository->update($myNeedResources['id'], ['amount' => $reduceAmountResourcesHonor]);

                    if (! $updateResources) {
                        throw new GameException('Can not update resources');
                    }

                    $addItemToInventory = $this->itemsRepository->create($itemParams);

                    if (! $addItemToInventory) {
                        throw new GameException('Can not add item to inventory');
                    }

                    Message::postMessage('You successfully buy item', Message::POSITIVE_MESSAGE);
                    return $shopType;

                } else {
                    Message::postMessage("You need {$checkIsEnoughHonor['is_enogh']} Honor, to buy this item", Message::NEGATIVE_MESSAGE);
                    return $shopType;
                }

                break;
            case self::AUCTION_SHOP :
                $sellerId = $shopItem->getHeroId();

                if ($heroId == $sellerId) {
                    Message::postMessage("This item is yours", Message::NEGATIVE_MESSAGE);
                    return $shopType;
                }

                $goldParams = [
                    $shopItem->getPrice(),
                    $shopItem->getPrice(),
                    $heroId,
                    HeroService::RESOURCES_COLD
                ];

                $checkIsEnoughGold = $this->recipesRepository->checkEnoughResources($goldParams);

                if ($checkIsEnoughGold['is_enogh'] == CreateItemService::ENOUGH_RESOURCE) {
                    $myResourcesParams = [
                        $heroId,
                        HeroService::RESOURCES_COLD
                    ];
                    $myNeedResources = $this->recipesRepository->getResourcesAmountByHeroIdAndName($myResourcesParams);

                    $reduceAmountResourcesGold = $myNeedResources['amount'] - $shopItem->getPrice();

                    $updateResources = $this->resourcesRepository->update($myNeedResources['id'], ['amount' => $reduceAmountResourcesGold]);

                    if (! $updateResources) {
                        throw new GameException('Can not update resources');
                    }

                    $addItemToInventory = $this->itemsRepository->create($itemParams);

                    if (! $addItemToInventory) {
                        throw new GameException('Can not add item to inventory');
                    }

                    if (! $sellerId) {
                        throw new GameException('Can not find seller');
                    }

                    $sellerResourcesParams = [
                        $sellerId,
                        HeroService::RESOURCES_COLD
                    ];

                    $sellerGold = $this->recipesRepository->getResourcesAmountByHeroIdAndName($sellerResourcesParams);

                    $addAmountGold = $sellerGold['amount'] + $shopItem->getPrice();

                    $updateResources = $this->resourcesRepository->update($sellerGold['id'], ['amount' => $addAmountGold]);

                    if (! $updateResources) {
                        throw new GameException('Can not update resources');
                    }

                    $deleteShopItem = $this->shopRepository->delete($shopItem->getId());

                    if (! $deleteShopItem) {
                        throw new GameException('Can not delete item from shop');
                    }

                    Message::postMessage('You successfully buy item', Message::POSITIVE_MESSAGE);
                    return $shopType;
                } else {
                    Message::postMessage("You need {$checkIsEnoughGold['is_enogh']} Gold, to buy this item", Message::NEGATIVE_MESSAGE);
                    return $shopType;
                }

                break;
        }

        return $shopType;
    }

    public function cancelItemFromAction($shopItemId)
    {
        if (! $shopItemId) {
            throw new GameException('Not set shop id');
        }

        $heroId = $this->authenticationService->getHeroId();

        if (! $heroId) {
            throw new GameException('Not set hero id');
        }

        /** @var Shop $shopItem */
        $shopItem = $this->shopRepository->findOneRowById($shopItemId, Shop::class);

        $shopStatusMapper = [
            0 => self::GOLD_SHOP,
            1 => self::HONOR_SHOP,
            2 => self::AUCTION_SHOP
        ];

        $shopType = $shopStatusMapper[$shopItem->getShopStatus()];

        $itemParams = [
            'damage_low_value' => $shopItem->getDamageLowValue(),
            'damage_high_value' => $shopItem->getDamageHighValue(),
            'armor' => $shopItem->getArmor(),
            'strength' => $shopItem->getStrength(),
            'vitality' => $shopItem->getVitality(),
            'magic' => $shopItem->getMagic(),
            'dexterity' => $shopItem->getDexterity(),
            'health' => $shopItem->getHealth(),
            'mana' => $shopItem->getMana(),
            'type_of_item_id' => $shopItem->getTypeOfItemId(),
            'hero_id' => $heroId,
            'item_level' => $shopItem->getItemLevel(),
            'is_equiped' => 0,
            'critical' => $shopItem->getCritical(),
            'name' => $shopItem->getName()
        ];

        $createItem = $this->itemsRepository->create($itemParams);

        if (! $createItem) {
            throw new GameException('Can not create item row');
        }

        $deleteItemFromShop = $this->shopRepository->delete($shopItemId);

        if (! $deleteItemFromShop) {
            throw new GameException('Can not delete shop row');
        }

        Message::postMessage('Stop selling this item', Message::POSITIVE_MESSAGE);
        return $shopType;
    }
}