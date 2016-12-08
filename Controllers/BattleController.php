<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 8.12.2016 г.
 * Time: 19:52
 */

namespace FPopov\Controllers;

use FPopov\Core\MVC\MVCContext;
use FPopov\Core\ViewInterface;
use FPopov\Services\Application\AuthenticationServiceInterface;
use FPopov\Services\Application\ResponseServiceInterface;
use FPopov\Services\Battle\BattleServiceInterface;

class BattleController
{
    private $authenticationService;
    private $responseService;
    private $MVCContext;
    private $view;
    private $battleService;

    public function __construct(
        AuthenticationServiceInterface $authenticationService,
        ResponseServiceInterface $responseService,
        MVCContext $MVCContext,
        ViewInterface $view,
        BattleServiceInterface $battleService)
    {
        $this->authenticationService = $authenticationService;
        $this->responseService = $responseService;
        $this->MVCContext = $MVCContext;
        $this->view = $view;
        $this->battleService = $battleService;
    }

    public function pveBattle()
    {
        if (! $this->authenticationService->isAuthenticated()) {
            $this->responseService->redirect('users', 'login');
        }

        if (! $this->authenticationService->isAuthenticatedHero()) {
            $this->responseService->redirect('heroes', 'createHero');
        }

        $getParams = $this->MVCContext->getGetParams();
        $allMonsters = $this->battleService->pveBattle($getParams = []);

        $params = ['model' => $allMonsters];
        $this->view->render($params);
    }


}