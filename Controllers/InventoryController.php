<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 11.12.2016 г.
 * Time: 19:34
 */

namespace FPopov\Controllers;


use FPopov\Core\MVC\Message;
use FPopov\Core\MVC\MVCContext;
use FPopov\Core\ViewInterface;
use FPopov\Services\Application\AuthenticationServiceInterface;
use FPopov\Services\Application\ResponseServiceInterface;
use FPopov\Services\Inventory\InventoryService;
use FPopov\Services\Inventory\InventoryServiceInterface;

class InventoryController
{
    private $authenticationService;
    private $responseService;
    private $MVCContext;
    private $view;

    /** @var InventoryService */
    private $inventoryService;

    public function __construct(
        AuthenticationServiceInterface $authenticationService,
        ResponseServiceInterface $responseService,
        MVCContext $MVCContext,
        ViewInterface $view,
        InventoryServiceInterface $inventoryService)
    {
        $this->authenticationService = $authenticationService;
        $this->responseService = $responseService;
        $this->MVCContext = $MVCContext;
        $this->view = $view;
        $this->inventoryService = $inventoryService;
    }

    public function inventory()
    {
        if (! $this->authenticationService->isAuthenticated()) {
            $this->responseService->redirect('users', 'login');
        }

        if (! $this->authenticationService->isAuthenticatedHero()) {
            $this->responseService->redirect('heroes', 'createHero');
        }

        $getParams = $this->MVCContext->getGetParams();
        $allItemsForOneHero = $this->inventoryService->inventory($getParams);

        $params = ['model' => $allItemsForOneHero];
        $this->view->render($params);
    }

    public function removeItem()
    {
        $itemId = $this->MVCContext->getOneGetParam('itemId');
        $result = $this->inventoryService->removeItem($itemId);

        return $result;
    }

    public function equippedItem($itemId)
    {
        if (! $this->authenticationService->isAuthenticated()) {
            $this->responseService->redirect('users', 'login');
        }

        if (! $this->authenticationService->isAuthenticatedHero()) {
            $this->responseService->redirect('heroes', 'createHero');
        }


        $result = $this->inventoryService->equippedItem($itemId);

        $this->responseService->redirect('inventory', 'inventory');
    }

    public function alreadyInUse($itemId)
    {
        if (! $this->authenticationService->isAuthenticated()) {
            $this->responseService->redirect('users', 'login');
        }

        if (! $this->authenticationService->isAuthenticatedHero()) {
            $this->responseService->redirect('heroes', 'createHero');
        }

        $result = $this->inventoryService->alreadyInUse($itemId);

        $this->responseService->redirect('inventory', 'inventory');
    }

    public function youCanUseThisItem()
    {
        if (! $this->authenticationService->isAuthenticated()) {
            $this->responseService->redirect('users', 'login');
        }

        if (! $this->authenticationService->isAuthenticatedHero()) {
            $this->responseService->redirect('heroes', 'createHero');
        }

        Message::postMessage('You can not use this item', Message::NEGATIVE_MESSAGE);

        $this->responseService->redirect('inventory', 'inventory');
    }
}