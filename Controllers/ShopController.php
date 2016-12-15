<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 15.12.2016 г.
 * Time: 9:18
 */

namespace FPopov\Controllers;


use FPopov\Core\MVC\MVCContext;
use FPopov\Core\ViewInterface;
use FPopov\Services\Application\AuthenticationServiceInterface;
use FPopov\Services\Application\ResponseServiceInterface;
use FPopov\Services\Shop\ShopService;
use FPopov\Services\Shop\ShopServiceInterface;

class ShopController
{
    private $authenticationService;
    private $responseService;
    private $MVCContext;
    private $view;

    /** @var  ShopService */
    private $shopService;

    public function __construct(
        AuthenticationServiceInterface $authenticationService,
        ResponseServiceInterface $responseService,
        MVCContext $MVCContext,
        ViewInterface $view,
        ShopServiceInterface $shopService)
    {
        $this->authenticationService = $authenticationService;
        $this->responseService = $responseService;
        $this->MVCContext = $MVCContext;
        $this->view = $view;
        $this->shopService = $shopService;
    }

    public function shopItems($typeOfShop)
    {
        if (! $this->authenticationService->isAuthenticated()) {
            $this->responseService->redirect('users', 'login');
        }

        if (! $this->authenticationService->isAuthenticatedHero()) {
            $this->responseService->redirect('heroes', 'createHero');
        }
        $getParams = $this->MVCContext->getGetParams();
        $getParams['typeOfShop'] = $typeOfShop;

        $allItemsInShop = $this->shopService->shopItems($getParams);
        $params = ['model' => $allItemsInShop];
        $this->view->render($params);
    }

    public function byeItem($shopItemId)
    {
        if (! $this->authenticationService->isAuthenticated()) {
            $this->responseService->redirect('users', 'login');
        }

        if (! $this->authenticationService->isAuthenticatedHero()) {
            $this->responseService->redirect('heroes', 'createHero');
        }

        $byeItem = $this->shopService->byeItem($shopItemId);

        $this->responseService->redirect('shop', 'shopItems', ['typeOfShop' => $byeItem]);
    }

    public function cancelItemFromAction($shopItemId)
    {
        dd($shopItemId);
    }
}