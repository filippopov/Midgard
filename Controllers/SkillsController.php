<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 19.1.2017 г.
 * Time: 23:55
 */

namespace FPopov\Controllers;


use FPopov\Core\MVC\MVCContext;
use FPopov\Core\ViewInterface;
use FPopov\Services\Application\AuthenticationServiceInterface;
use FPopov\Services\Application\ResponseServiceInterface;
use FPopov\Services\Skills\SkillsServiceInterface;

class SkillsController
{
    private $authenticationService;
    private $responseService;
    private $MVCContext;
    private $view;

    private $skillsService;

    public function __construct(
        AuthenticationServiceInterface $authenticationService,
        ResponseServiceInterface $responseService,
        MVCContext $MVCContext,
        ViewInterface $view,
        SkillsServiceInterface $skillsService
    )
    {
        $this->authenticationService = $authenticationService;
        $this->responseService = $responseService;
        $this->MVCContext = $MVCContext;
        $this->view = $view;
        $this->skillsService = $skillsService;
    }

    public function showSkills()
    {
        if (! $this->authenticationService->isAuthenticated()) {
            $this->responseService->redirect('users', 'login');
        }

        if (! $this->authenticationService->isAuthenticatedHero()) {
            $this->responseService->redirect('heroes', 'createHero');
        }

        $getParams = $this->MVCContext->getGetParams();

        $allSkills = $this->skillsService->showSkills();

        $params = ['model' => $allSkills];

        $this->view->render($params);
    }
}