<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 13.12.2016 г.
 * Time: 17:41
 */

namespace FPopov\Controllers;


use FPopov\Core\MVC\MVCContext;
use FPopov\Core\ViewInterface;
use FPopov\Models\View\CreateItem\CreateItemViewModel;
use FPopov\Services\Application\AuthenticationServiceInterface;
use FPopov\Services\Application\ResponseServiceInterface;
use FPopov\Services\CreateItem\CreateItemServiceInterface;

class CreateItemController
{

    private $authenticationService;
    private $responseService;
    private $MVCContext;
    private $view;
    private $createItemService;

    public function __construct(
        AuthenticationServiceInterface $authenticationService,
        ResponseServiceInterface $responseService,
        MVCContext $MVCContext,
        ViewInterface $view,
        CreateItemServiceInterface $createItemService)
    {
        $this->authenticationService = $authenticationService;
        $this->responseService = $responseService;
        $this->MVCContext = $MVCContext;
        $this->view = $view;
        $this->createItemService = $createItemService;
    }

    public function showRecipes()
    {
        if (! $this->authenticationService->isAuthenticated()) {
            $this->responseService->redirect('users', 'login');
        }

        if (! $this->authenticationService->isAuthenticatedHero()) {
            $this->responseService->redirect('heroes', 'createHero');
        }

        $getParams = $this->MVCContext->getGetParams();
        $allRecipes = $this->createItemService->showRecipes($getParams);

        $params = ['model' => $allRecipes];
        $this->view->render($params);
    }

    public function createItem($recipeId)
    {
        if (! $this->authenticationService->isAuthenticated()) {
            $this->responseService->redirect('users', 'login');
        }

        if (! $this->authenticationService->isAuthenticatedHero()) {
            $this->responseService->redirect('heroes', 'createHero');
        }

        $createItemStatus = $this->createItemService->createItem($recipeId);

        $typeOfRecipesId = isset($createItemStatus['typeOfRecipesId']) ? $createItemStatus['typeOfRecipesId'] : '';
        $status = isset($createItemStatus['status']) ? $createItemStatus['status'] : '';
        $name = isset($createItemStatus['name']) ? $createItemStatus['name'] : '';
        $duration = isset($createItemStatus['duration']) ? $createItemStatus['duration'] : '';
        $timeToCreateItem = isset($createItemStatus['timeToCreateItem']) ? $createItemStatus['timeToCreateItem'] : 0;


        $model = new CreateItemViewModel($typeOfRecipesId, $status, $name, $duration, $timeToCreateItem);

        $this->view->render(['model' => $model]);
    }

    public function startItem($typeOfRecipesId)
    {
        if (! $this->authenticationService->isAuthenticated()) {
            $this->responseService->redirect('users', 'login');
        }

        if (! $this->authenticationService->isAuthenticatedHero()) {
            $this->responseService->redirect('heroes', 'createHero');
        }

        $startItem = $this->createItemService->startItem($typeOfRecipesId);

        $this->responseService->redirect('createItem', 'createItem', ['recipeId' => $typeOfRecipesId]);
    }

    public function takeItem($typeOfRecipesId)
    {
        if (! $this->authenticationService->isAuthenticated()) {
            $this->responseService->redirect('users', 'login');
        }

        if (! $this->authenticationService->isAuthenticatedHero()) {
            $this->responseService->redirect('heroes', 'createHero');
        }

        $takeItem = $this->createItemService->takeItem($typeOfRecipesId);

        $this->responseService->redirect('createItem', 'createItem', ['recipeId' => $typeOfRecipesId]);
    }
}