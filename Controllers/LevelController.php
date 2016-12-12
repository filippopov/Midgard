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
use FPopov\Services\Application\AuthenticationServiceInterface;
use FPopov\Services\Application\ResponseServiceInterface;

class LevelController
{
    private $authenticationService;
    private $responseService;
    private $MVCContext;
    private $view;

    public function __construct(
        AuthenticationServiceInterface $authenticationService,
        ResponseServiceInterface $responseService,
        MVCContext $MVCContext,
        ViewInterface $view)
    {
        $this->authenticationService = $authenticationService;
        $this->responseService = $responseService;
        $this->MVCContext = $MVCContext;
        $this->view = $view;
    }

    public function levelUp()
    {

    }
}