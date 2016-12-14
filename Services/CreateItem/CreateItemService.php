<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 13.12.2016 г.
 * Time: 19:31
 */

namespace FPopov\Services\CreateItem;


use FPopov\Core\MVC\Message;
use FPopov\Core\MVC\SessionInterface;
use FPopov\Core\ViewInterface;
use FPopov\Exceptions\GameException;
use FPopov\Models\DB\Recipes\Recipes;
use FPopov\Models\DB\TypeOfItems\TypeOfItem;
use FPopov\Models\DB\TypeOfRecipes\TypeOfRecipes;
use FPopov\Models\DB\TypeOfResources\TypeOfResources;
use FPopov\Repositories\Items\ItemsRepository;
use FPopov\Repositories\Items\ItemsRepositoryInterface;
use FPopov\Repositories\Recipes\RecipesRepository;
use FPopov\Repositories\Recipes\RecipesRepositoryInterface;
use FPopov\Repositories\Resources\ResourcesRepository;
use FPopov\Repositories\Resources\ResourcesRepositoryInterface;
use FPopov\Repositories\TypeOfItems\TypeOfItemsRepository;
use FPopov\Repositories\TypeOfItems\TypeOfItemsRepositoryInterface;
use FPopov\Repositories\TypeOfRecipes\TypeOfRecipesRepository;
use FPopov\Repositories\TypeOfRecipes\TypeOfRecipesRepositoryInterface;
use FPopov\Repositories\TypeOfResources\TypeOfResourcesRepository;
use FPopov\Repositories\TypeOfResources\TypeOfResourcesRepositoryInterface;
use FPopov\Services\AbstractService;
use FPopov\Services\Application\AuthenticationServiceInterface;
use FPopov\Services\Application\ResponseServiceInterface;
use FPopov\Services\Hero\HeroService;

class CreateItemService extends AbstractService implements CreateItemServiceInterface
{
    const RECIPES_STATUS_IN_PROGRESS = 1;
    const RECIPES_STATUS_FINISH = 0;

    const ITEM_IS_NOT_EQUIPPED = 0;
    const ENOUGH_RESOURCE = 'Yes';

    private $view;
    private $authenticationService;
    private $session;
    private $responseService;

    /** @var  TypeOfRecipesRepository */
    private $typeOfRecipesRepository;

    /** @var  TypeOfItemsRepository */
    private $typeOfItemsRepository;

    /** @var RecipesRepository */
    private $recipesRepository;

    /** @var  ItemsRepository */
    private $itemsRepository;

    /** @var  TypeOfResourcesRepository */
    private $typeOfResourcesRepository;

    /** @var  ResourcesRepository */
    private $resourcesRepository;

    public function __construct(
        ViewInterface $view,
        AuthenticationServiceInterface $authenticationService,
        SessionInterface $session,
        ResponseServiceInterface $responseService,
        TypeOfRecipesRepositoryInterface $typeOfRecipesRepository,
        TypeOfItemsRepositoryInterface $typeOfItemsRepository,
        RecipesRepositoryInterface $recipesRepository,
        ItemsRepositoryInterface $itemsRepository,
        TypeOfResourcesRepositoryInterface $typeOfResourcesRepository,
        ResourcesRepositoryInterface $resourcesRepository
    )
    {
        $this->view = $view;
        $this->authenticationService = $authenticationService;
        $this->session = $session;
        $this->responseService = $responseService;
        $this->typeOfRecipesRepository = $typeOfRecipesRepository;
        $this->typeOfItemsRepository = $typeOfItemsRepository;
        $this->recipesRepository = $recipesRepository;
        $this->itemsRepository = $itemsRepository;
        $this->typeOfResourcesRepository = $typeOfResourcesRepository;
        $this->resourcesRepository = $resourcesRepository;
    }

    public function showRecipes($params = [])
    {
        $bindFilter = $this->getParamFilters($params);

        $structure = [
            'name' => [
                'title' => 'Name Of Item',
                'type' => self::TYPE_DATA,
                'onClick' => function ($row){
                    return $this->view->uri('createItem', 'createItem', ['recipeId' => $row['id']]);
                }
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

    public function createItem($recipeId)
    {
        if (! $recipeId) {
            throw new GameException('Not set recipe id');
        }

        $heroId = $this->authenticationService->getHeroId();

        if (! $heroId) {
            throw new GameException('Not set hero');
        }

        /** @var TypeOfRecipes $typeOfRecipes */
        $typeOfRecipes = $this->typeOfRecipesRepository->findOneRowById($recipeId, TypeOfRecipes::class);

        /** @var Recipes[] $recipes */
        $recipes = $this->recipesRepository->findByCondition(['type_of_recipes_id' => $typeOfRecipes->getId(), 'hero_id' => $heroId], Recipes::class);

        $returnParams = [];

        $returnParams['typeOfRecipesId'] = $typeOfRecipes->getId();
        $returnParams['name'] = $typeOfRecipes->getName();
        $returnParams['duration'] = $typeOfRecipes->getDuration();

        $status = '';
        if (empty($recipes)) {
            $status = 'stop';
        } else {
            if ($recipes[0]->getStatus() == self::RECIPES_STATUS_IN_PROGRESS) {
                $status = 'inProgress';
                $endTime = $recipes[0]->getEndDt();
                $dtNow = date('Y-m-d H:i:s');
                $needTime = strtotime($endTime) - strtotime($dtNow);
                $seconds = strtotime('s', $needTime);

                if ($seconds < 0) {
                    $this->recipesRepository->update($recipes[0]->getId(), ['status' => 0]);
                    Message::postMessage('Your item is ready', Message::POSITIVE_MESSAGE);
                    $this->responseService->redirect('createItem', 'createItem', ['recipeId' => $recipeId]);
                }

                $timeToCreateItem = gmdate("H:i:s", $seconds);
                $returnParams['timeToCreateItem'] = $timeToCreateItem;



            } elseif ($recipes[0]->getStatus() == self::RECIPES_STATUS_FINISH) {
                $status = 'finish';
            }
        }

        $returnParams['status'] = $status;

        return $returnParams;
    }

    public function startItem($typeOfRecipesId)
    {
        if (! $typeOfRecipesId) {
            throw new GameException('Please set id for recipe');
        }

        $heroId = $this->authenticationService->getHeroId();

        if (! $heroId) {
            throw new GameException('Not found heroId');
        }

        /** @var TypeOfRecipes $typeOfRecipes */
        $typeOfRecipes = $this->typeOfRecipesRepository->findOneRowById($typeOfRecipesId, TypeOfRecipes::class);
        $needGold = $typeOfRecipes->getGold();
        $needIron = $typeOfRecipes->getIron();
        $needTree = $typeOfRecipes->getTree();
        $needLeather = $typeOfRecipes->getLeather();
        $needSilk = $typeOfRecipes->getSilk();

        $goldParams = [
            $needGold, $needGold, $heroId, HeroService::RESOURCES_COLD
        ];

        $checkGold = $this->recipesRepository->checkEnoughResources($goldParams);

        $isEnoughGold = $checkGold['is_enogh'];

        $ironParams = [
            $needIron, $needIron, $heroId, HeroService::RESOURCES_IRON
        ];

        $checkIron = $this->recipesRepository->checkEnoughResources($ironParams);

        $isEnoughIron = $checkIron['is_enogh'];

        $treeParams = [
            $needTree, $needTree, $heroId, HeroService::RESOURCES_TREE
        ];

        $checkTree = $this->recipesRepository->checkEnoughResources($treeParams);

        $isEnoughTree = $checkTree['is_enogh'];

        $leatherParams = [
            $needLeather, $needLeather, $heroId, HeroService::RESOURCES_LEATHER
        ];

        $checkLeather = $this->recipesRepository->checkEnoughResources($leatherParams);

        $isEnoughLeather = $checkLeather['is_enogh'];

        $silkParams = [
            $needSilk, $needSilk, $heroId, HeroService::RESOURCES_SILK
        ];

        $checkSilk = $this->recipesRepository->checkEnoughResources($silkParams);

        $isEnoughSilk = $checkSilk['is_enogh'];

        if ($isEnoughGold == self::ENOUGH_RESOURCE && $isEnoughIron == self::ENOUGH_RESOURCE && $isEnoughTree == self::ENOUGH_RESOURCE
                && $isEnoughLeather == self::ENOUGH_RESOURCE && $isEnoughSilk == self::ENOUGH_RESOURCE) {

            $allResources = $this->recipesRepository->getAllTypeOfResourceForOneUserWithoutHonor([$heroId]);
            foreach ($allResources as $resource) {
                $newResAmount = 0;
                if ($resource['name'] == HeroService::RESOURCES_COLD) {
                    $newResAmount = $resource['amount'] - $needGold;
                } elseif ($resource['name'] == HeroService::RESOURCES_IRON) {
                    $newResAmount = $resource['amount'] - $needIron;
                } elseif ($resource['name'] == HeroService::RESOURCES_TREE) {
                    $newResAmount = $resource['amount'] - $needTree;
                } elseif ($resource['name'] == HeroService::RESOURCES_LEATHER) {
                    $newResAmount = $resource['amount'] - $needLeather;
                } elseif ($resource['name'] == HeroService::RESOURCES_SILK) {
                    $newResAmount = $resource['amount'] - $needSilk;
                }

                $resourceUpdateNewValue = $this->resourcesRepository->update($resource['id'], ['amount' => $newResAmount]);

                if (! $resourceUpdateNewValue) {
                    throw new GameException('Can not update resources');
                }
            }

        } else {
            Message::postMessage('You do not have enough resources', Message::NEGATIVE_MESSAGE);
            return false;
        }


        $duration = $typeOfRecipes->getDuration();

        $seconds = $this->timeToSeconds($duration);

        $startDt = date('Y-m-d H:i:s');

        $endDt =  date('Y-m-d H:i:s', (strtotime(date($startDt)) + $seconds));

        $recipesRow = [
            'type_of_recipes_id' => $typeOfRecipesId,
            'hero_id' => $heroId,
            'status' => 1,
            'start_dt' => $startDt,
            'end_dt' => $endDt
        ];

        $createRecipeRow = $this->recipesRepository->create($recipesRow);

        if (! $createRecipeRow) {
            Message::postMessage('Can not create this item', Message::NEGATIVE_MESSAGE);
            return false;
        }

        Message::postMessage('Item Creating, please wait', Message::POSITIVE_MESSAGE);
        return true;
    }

    public function takeItem($typeOfRecipesId)
    {
        if (! $typeOfRecipesId) {
            throw new GameException('Not set type of recipe id');
        }

        $heroId = $this->authenticationService->getHeroId();

        if (! $heroId) {
            throw new GameException('Not set hero id');
        }

        /** @var Recipes[] $recipes */
        $recipes = $this->recipesRepository->findByCondition(['type_of_recipes_id' => $typeOfRecipesId, 'hero_id' => $heroId], Recipes::class);

        if (empty($recipes)) {
            throw new GameException('Not Found recipes');
        }

        $deleteRecipe = $this->recipesRepository->delete($recipes[0]->getId());

        if (! $deleteRecipe) {
            throw new GameException('Can not delete recipes');
        }

        /** @var TypeOfRecipes $typeOfRecipes */
        $typeOfRecipes = $this->typeOfRecipesRepository->findOneRowById($typeOfRecipesId, TypeOfRecipes::class);

        if (! $typeOfRecipes) {
            throw new GameException('Not found this recipes');
        }

        $createItemParams = [
            'damage_low_value' => $typeOfRecipes->getDamageLowValue(),
            'damage_high_value' => $typeOfRecipes->getDamageHighValue(),
            'armor' => $typeOfRecipes->getArmor(),
            'strength' => $typeOfRecipes->getStrength(),
            'vitality' => $typeOfRecipes->getVitality(),
            'magic' => $typeOfRecipes->getMagic(),
            'dexterity' => $typeOfRecipes->getDexterity(),
            'health' => $typeOfRecipes->getHealth(),
            'mana' => $typeOfRecipes->getMana(),
            'type_of_item_id' => $typeOfRecipes->getTypeOfItemId(),
            'hero_id' => $heroId,
            'item_level' => $typeOfRecipes->getItemLevel(),
            'is_equiped' => self::ITEM_IS_NOT_EQUIPPED,
            'critical' => $typeOfRecipes->getCritical(),
            'name' => $typeOfRecipes->getName()
        ];

        $item = $this->itemsRepository->create($createItemParams);

        if (! $item) {
            Message::postMessage('Problem with item', Message::NEGATIVE_MESSAGE);
            return false;
        }

        Message::postMessage('Check item in inventory', Message::POSITIVE_MESSAGE);
        return true;
    }

    private function timeToSeconds($time='00:00:00')
    {
        list($hours, $mins, $secs) = explode(':', $time);
        return ($hours * 3600 ) + ($mins * 60 ) + $secs;
    }
}


