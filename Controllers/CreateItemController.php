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
}