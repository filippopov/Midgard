<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 13.12.2016 г.
 * Time: 19:31
 */

namespace FPopov\Services\CreateItem;


use FPopov\Core\MVC\SessionInterface;
use FPopov\Core\ViewInterface;
use FPopov\Services\AbstractService;
use FPopov\Services\Application\AuthenticationServiceInterface;
use FPopov\Services\Application\ResponseServiceInterface;

class CreateItemService extends AbstractService implements CreateItemServiceInterface
{
    private $view;
    private $authenticationService;
    private $session;
    private $responseService;

    public function __construct(
        ViewInterface $view,
        AuthenticationServiceInterface $authenticationService,
        SessionInterface $session,
        ResponseServiceInterface $responseService
    )
    {
        $this->view = $view;
        $this->authenticationService = $authenticationService;
        $this->session = $session;
        $this->responseService = $responseService;
    }

    public function showRecipes($params = [])
    {
        dd('v igrata');
    }
}