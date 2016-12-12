<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 11.12.2016 г.
 * Time: 19:41
 */

namespace FPopov\Services\Inventory;


use FPopov\Core\MVC\Message;
use FPopov\Core\MVC\SessionInterface;
use FPopov\Core\ViewInterface;
use FPopov\Exceptions\GameException;
use FPopov\Models\DB\TypeOfItems\TypeOfItem;
use FPopov\Repositories\Hero\HeroRepository;
use FPopov\Repositories\Hero\HeroRepositoryInterface;
use FPopov\Repositories\Items\ItemsRepository;
use FPopov\Repositories\Items\ItemsRepositoryInterface;
use FPopov\Repositories\TypeOfItems\TypeOfItemsRepository;
use FPopov\Repositories\TypeOfItems\TypeOfItemsRepositoryInterface;
use FPopov\Services\AbstractService;
use FPopov\Services\Application\AuthenticationServiceInterface;
use FPopov\Services\Application\ResponseServiceInterface;
use FPopov\Services\Battle\BattleService;
use FPopov\Services\Hero\HeroService;

class InventoryService extends AbstractService implements InventoryServiceInterface
{
    const ITEM_NOT_IN_USE = 0;

    const TYPE_OF_ITEM_ARMOR = 'Armor';
    const TYPE_OF_ITEM_WEAPON = 'Weapon';

    private $view;
    private $authenticationService;
    private $session;
    private $responseService;

    /** @var  ItemsRepository */
    private $itemsRepository;

    /** @var  TypeOfItemsRepository */
    private $typeOfItemsRepository;

    /** @var  HeroRepository */
    private $heroRepository;

    public function __construct(
        ViewInterface $view,
        AuthenticationServiceInterface $authenticationService,
        SessionInterface $session,
        ResponseServiceInterface $responseService,
        ItemsRepositoryInterface $itemsRepository,
        TypeOfItemsRepositoryInterface $typeOfItemsRepository,
        HeroRepositoryInterface $heroRepository
    )
    {
        $this->view = $view;
        $this->authenticationService = $authenticationService;
        $this->session = $session;
        $this->responseService = $responseService;
        $this->itemsRepository = $itemsRepository;
        $this->typeOfItemsRepository = $typeOfItemsRepository;
        $this->heroRepository = $heroRepository;

    }

    public function inventory($params = [])
    {
        $heroId = $this->authenticationService->getHeroId();

        $params['heroId'] = $heroId;
        $allowParams = ['heroId'];
        $bindFilter = $this->getParamFilters($params, $allowParams);

        $canUseThisItem = [
            'All heroes' => 0,

        ];

        $heroTypeArr = $this->heroRepository->getTypeOfHeroById([$heroId]);
        $heroTye = $heroTypeArr['type_of_hero'];

        $mapperWhoCanUseItem = [
            'Warrior' => 1,
            'Marksman' => 2,
            'Wizard' => 3
        ];

        $canYouUse = isset($mapperWhoCanUseItem[$heroTye]) ? $mapperWhoCanUseItem[$heroTye] : 0;

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
            'for_type_of_heroes' => [
                'title' => 'for_type_of_heroes',
                'type' => self::TYPE_HIDDEN
            ],
            'actions' => array(
                'title' => 'Delete',
                'type' => self::TYPE_ACTIONS,
                'values' => array(
                    'delete' => function  ($row) {
                        return $this->view->uri('inventory', 'removeItem', [], ['itemId' => $row['id']]);
                    }
                )
            ),
            'is_equiped' => [
                'title' => 'Equipped',
                'type' => self::TYPE_DATA,
                'value' => function ($value) {
                    return $value = $value == 1 ? 'Already in use' : 'Equipped item';
                },
                'onClick' => function ($row) use ($canYouUse){
                    if ($row['for_type_of_heroes'] == $canYouUse || $row['for_type_of_heroes'] ==0) {
                        return $row['is_equiped'] == 0 ? $this->view->uri('inventory', 'equippedItem', ['itemId' => $row['id']])
                            : $this->view->uri('inventory', 'alreadyInUse', ['itemId' => $row['id']]);
                    } else {
                        return $this->view->uri('inventory', 'youCanUseThisItem');
                    }
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

    public function equippedItem($itemId)
    {
        if (! $itemId) {
            throw new GameException('Not set ItemId');
        }

        $heroId = $this->authenticationService->getHeroId();

        $itemTypes = $this->itemsRepository->getItemTypes([$itemId]);

        $weaponOrArmor = $itemTypes['weapon_or_armor'];
        $typeOfItemId = $itemTypes['type_of_item_id'];

        $mapWeaponOrArmor = [
            0 => 'Armor',
            1 => 'Weapon'
        ];

        $weaponOrArmorStr = isset($mapWeaponOrArmor[$weaponOrArmor]) ? $mapWeaponOrArmor[$weaponOrArmor] : '';

        if ($weaponOrArmorStr == self::TYPE_OF_ITEM_ARMOR) {
            $makeNotEquipedOtherItemsFroThisType = $this->itemsRepository->updateItemToNotEquiped([$typeOfItemId, $heroId]);
        }

        if ($weaponOrArmorStr == self::TYPE_OF_ITEM_WEAPON) {
            $getWeapons = $this->itemsRepository->getWeaponsId([$heroId, BattleService::WEAPON]);

            if (! empty($getWeapons)) {
                $allWeaponsId = $getWeapons['items_id'];
                $removeAllWeapons = $this->itemsRepository->unEqupedWeapons([$allWeaponsId]);
            }
        }

        $updateItem = $this->itemsRepository->update($itemId, ['is_equiped' => HeroService::ITEM_IS_EQUIPED]);

        if (! $updateItem) {
            Message::postMessage('Can not equipped this item', Message::NEGATIVE_MESSAGE);
            return false;
        }

        Message::postMessage('Successfully equipped item', Message::POSITIVE_MESSAGE);

        return true;
    }

    public function removeItem($itemId)
    {
        $result = $this->itemsRepository->delete($itemId);

        if (! $result) {
            Message::postMessage('Can not delete this item', Message::NEGATIVE_MESSAGE);
            return false;
        }

        Message::postMessage('Successfully delete this item', Message::POSITIVE_MESSAGE);
        return true;
    }

    public function alreadyInUse($itemId)
    {
        if (! $itemId) {
            throw new GameException('Not set item id');
        }

        $removeItemFromHero = $this->itemsRepository->update($itemId, ['is_equiped' => self::ITEM_NOT_IN_USE]);

        if (! $removeItemFromHero) {
            Message::postMessage('Can not remove item from hero', Message::NEGATIVE_MESSAGE);
            return false;
        }

        Message::postMessage('Successfully remove item from hero', Message::POSITIVE_MESSAGE);
        return true;
    }
}
