<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 6.12.2016 г.
 * Time: 14:42
 */

namespace FPopov\Controllers;


use FPopov\Core\ViewInterface;

class DefaultController
{
    private $view;

    public function __construct(ViewInterface $view)
    {
        $this->view = $view;
    }

    public function defaultAction()
    {
        $this->view->render();
    }
}