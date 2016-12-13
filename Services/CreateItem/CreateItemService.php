<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 13.12.2016 г.
 * Time: 19:31
 */

namespace FPopov\Services\CreateItem;


use FPopov\Core\MVC\SessionInterface;
use FPopov\Core\ViewInterface;
use FPopov\Models\DB\TypeOfItems\TypeOfItem;
use FPopov\Repositories\TypeOfItems\TypeOfItemsRepository;
use FPopov\Repositories\TypeOfItems\TypeOfItemsRepositoryInterface;
use FPopov\Repositories\TypeOfRecipes\TypeOfRecipesRepository;
use FPopov\Repositories\TypeOfRecipes\TypeOfRecipesRepositoryInterface;
use FPopov\Services\AbstractService;
use FPopov\Services\Application\AuthenticationServiceInterface;
use FPopov\Services\Application\ResponseServiceInterface;

class CreateItemService extends AbstractService implements CreateItemServiceInterface
{
    private $view;
    private $authenticationService;
    private $session;
    private $responseService;

    /** @var  TypeOfRecipesRepository */
    private $typeOfRecipesRepository;


    /** @var  TypeOfItemsRepository */
    private $typeOfItemsRepository;

    public function __construct(
        ViewInterface $view,
        AuthenticationServiceInterface $authenticationService,
        SessionInterface $session,
        ResponseServiceInterface $responseService,
        TypeOfRecipesRepositoryInterface $typeOfRecipesRepository,
        TypeOfItemsRepositoryInterface $typeOfItemsRepository
    )
    {
        $this->view = $view;
        $this->authenticationService = $authenticationService;
        $this->session = $session;
        $this->responseService = $responseService;
        $this->typeOfRecipesRepository = $typeOfRecipesRepository;
        $this->typeOfItemsRepository = $typeOfItemsRepository;
    }

    public function showRecipes($params = [])
    {
        $bindFilter = $this->getParamFilters($params);

        $structure = [
            'name' => [
                'title' => 'Name Of Item',
                'type' => self::TYPE_DATA
            ],
            'for_type_of_heroes' => [
                'title' => 'Can be use from',
                'type' => self::TYPE_DATA
            ],
            'type_of_item' => [
                'title' => 'Type Of Item',
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
            'gold' => [
                'title' => 'Need Gold',
                'type' => self::TYPE_DATA
            ],
            'iron' => [
                'title' => 'Need Iron',
                'type' => self::TYPE_DATA
            ],
            'leather' => [
                'title' => 'Need Leather',
                'type' => self::TYPE_DATA
            ],
            'silk' => [
                'title' => 'Silk',
                'type' => self::TYPE_DATA
            ],
            'tree' => [
                'title' => 'Tree',
                'type' => self::TYPE_DATA
            ],
            'duration' => [
                'title' => 'Duration',
                'type' => self::TYPE_DATA
            ],
        ];

        $repoData = $this->typeOfRecipesRepository->getAllRecipes($bindFilter);
        $bindFilter['total'] = $this->typeOfRecipesRepository->getAllRecipesCount($bindFilter);
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