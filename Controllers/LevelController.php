<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 12.12.2016 г.
 * Time: 15:35
 */

namespace FPopov\Controllers;


use FPopov\Core\MVC\MVCContext;
use FPopov\Core\ViewInterface;
use FPopov\Models\View\Level\LevelDataViewModel;
use FPopov\Services\Application\AuthenticationServiceInterface;
use FPopov\Services\Application\ResponseServiceInterface;
use FPopov\Services\Level\LevelServiceInterface;

class LevelController
{
    private $authenticationService;
    private $responseService;
    private $MVCContext;
    private $view;

    private $levelService;

    public function __construct(
        AuthenticationServiceInterface $authenticationService,
        ResponseServiceInterface $responseService,
        MVCContext $MVCContext,
        ViewInterface $view,
        LevelServiceInterface $levelService)
    {
        $this->authenticationService = $authenticationService;
        $this->responseService = $responseService;
        $this->MVCContext = $MVCContext;
        $this->view = $view;
        $this->levelService = $levelService;
    }

    public function levelUp()
    {
        if (! $this->authenticationService->isAuthenticated()) {
            $this->responseService->redirect('users', 'login');
        }

        if (! $this->authenticationService->isAuthenticatedHero()) {
            $this->responseService->redirect('heroes', 'createHero');
        }

        $statusData = $this->levelService->levelUp();

        $strength = isset($statusData['strength']) ? $statusData['strength'] : '';
        $dexterity = isset($statusData['dexterity']) ? $statusData['dexterity'] : '';
        $vitality = isset($statusData['vitality']) ? $statusData['vitality'] : '';
        $magic = isset($statusData['magic']) ? $statusData['magic'] : '';
        $levelPoints = isset($statusData['levelPoints']) ? $statusData['levelPoints'] : '';

        $viewModel = new LevelDataViewModel($strength, $dexterity, $vitality, $magic, $levelPoints);

        $this->view->render(['model' => $viewModel]);
    }

    public function levelUpPost()
    {
        $getParams = $this->MVCContext->getArguments();

        $result = $this->levelService->levelUpPost($getParams);

        $this->responseService->redirect('level', 'levelUp');
    }
}
