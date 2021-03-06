<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 6.12.2016 г.
 * Time: 17:33
 */

namespace FPopov\Controllers;

use FPopov\Core\MVC\Message;
use FPopov\Core\MVC\MVCContext;
use FPopov\Core\ViewInterface;
use FPopov\Models\Binding\Hero\HeroCreateBindingModel;
use FPopov\Services\Application\AuthenticationServiceInterface;
use FPopov\Services\Application\ResponseServiceInterface;
use FPopov\Services\Hero\HeroServiceInterface;

class HeroesController
{
    private $authenticationService;
    private $responseService;
    private $MVCContext;
    private $view;
    private $service;

    public function __construct(
        AuthenticationServiceInterface $authenticationService,
        ResponseServiceInterface $responseService,
        MVCContext $MVCContext,
        ViewInterface $view,
        HeroServiceInterface $service)
    {
        $this->authenticationService = $authenticationService;
        $this->responseService = $responseService;
        $this->MVCContext = $MVCContext;
        $this->view = $view;
        $this->service = $service;
    }

    public function choseHeroToPlay()
    {
        if (! $this->authenticationService->isAuthenticated()) {
            $this->responseService->redirect('users', 'login');
        }

        $getParams = $this->MVCContext->getGetParams();
        $userId = $this->authenticationService->getUserId();

        $getParams['userId'] = $userId;
        $heroes = $this->service->findAllHeroesForCurrentUser($getParams);

        $params = ['model' => $heroes];
        $this->view->render($params);
    }

    public function createHero(HeroCreateBindingModel $bindingModel)
    {
        $heroName = $bindingModel->getHeroName();
        $heroType = $bindingModel->getHeroType();

        if (! empty($_POST)) {
            $heroCreate = $this->service->addGridHero($heroName, $heroType);

            $result['success'] = $heroCreate ? true : false;

            if (! $heroCreate) {
                $result['message'] = Message::returnMessages();
            }

            echo json_encode($result);
            die();
        }

        $addGridHero = $this->service->createHero();

        $params = [
            'model' => $addGridHero,
            'withHeader' => false,
            'withFooter' => false,
            'isMessage' => false
        ];

        $this->view->render($params);
    }

    public function removeHero()
    {
        $heroId = $this->MVCContext->getOneGetParam('heroId');
        $result = $this->service->removeHero($heroId);

        return $result;
    }

    public function heroInformation()
    {
        if (! $this->authenticationService->isAuthenticated()) {
            $this->responseService->redirect('users', 'login');
        }

        if (! $this->authenticationService->isAuthenticatedHero()) {
            $this->responseService->redirect('heroes', 'createHero');
        }

        $heroInformation = $this->service->heroInformation();

        $params = [
            'model' => $heroInformation
        ];

        $this->view->render($params);
    }
}