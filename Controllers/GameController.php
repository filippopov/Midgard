<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 7.12.2016 г.
 * Time: 16:30
 */

namespace FPopov\Controllers;


use FPopov\Core\MVC\MVCContext;
use FPopov\Core\ViewInterface;
use FPopov\Services\Application\AuthenticationServiceInterface;
use FPopov\Services\Application\ResponseServiceInterface;
use FPopov\Services\Game\GameServicesInterface;

class GameController
{
    private $authenticationService;
    private $responseService;
    private $MVCContext;
    private $view;
    private $gameServices;

    public function __construct(
        AuthenticationServiceInterface $authenticationService,
        ResponseServiceInterface $responseService,
        MVCContext $MVCContext,
        ViewInterface $view,
        GameServicesInterface $gameServices)
    {
        $this->authenticationService = $authenticationService;
        $this->responseService = $responseService;
        $this->MVCContext = $MVCContext;
        $this->view = $view;
        $this->gameServices = $gameServices;
    }

    public function playHero($heroId)
    {
        if (! $this->authenticationService->isAuthenticated()) {
            $this->responseService->redirect('users', 'login');
        }

        $params['heroId'] = $heroId;
        $menu = $this->gameServices->playHero($params);

        $paramsView = ['model' => $menu];
        $this->view->render($paramsView);
    }
}