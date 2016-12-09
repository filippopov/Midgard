<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 28.11.2016 г.
 * Time: 19:02
 */

namespace FPopov\Services\Application;

use FPopov\Adapter\DatabaseInterface;
use FPopov\Core\MVC\Message;
use FPopov\Core\MVC\SessionInterface;
use FPopov\Models\DB\User\User;
use FPopov\Repositories\User\UserRepository;
use FPopov\Repositories\User\UserRepositoryInterface;
use FPopov\Services\AbstractService;
use FPopov\Services\User\UserService;

class AuthenticationService extends AbstractService implements AuthenticationServiceInterface
{
    const AUTHENTICATION_ID = 'id';
    const AUTHENTICATION_HERO_ID = 'heroId';
    const AUTHENTICATION_MONSTER_ID = 'monsterId';

    private $db;
    private $session;
    private $encryptionService;

    /** @var  UserRepository */
    private $userRepository;

    public function __construct(DatabaseInterface $db, SessionInterface $session, EncryptionServiceInterface $encryptionService, UserRepositoryInterface $userRepository)
    {
        $this->db = $db;
        $this->session = $session;
        $this->encryptionService = $encryptionService;
        $this->userRepository = $userRepository;
    }

    public function isAuthenticated() : bool
    {
        return $this->session->exists(self::AUTHENTICATION_ID);
    }

    public function isAuthenticatedHero() : bool
    {
        return $this->session->exists(self::AUTHENTICATION_HERO_ID);
    }

    public function isAuthenticatedMonster() : bool
    {
        return $this->session->exists(self::AUTHENTICATION_MONSTER_ID);
    }

    public function logout()
    {
        $this->session->destroy();
    }

    public function login($username, $password) : bool
    {
        $userParams = [
            'username' => $username
        ];

        /** @var User[] $user */
        $user = $this->userRepository->findByCondition($userParams, User::class, null, 'asc', 1, 0);

        if (empty($user)) {
            Message::postMessage('Not found user, with this username', Message::NEGATIVE_MESSAGE);
            return false;
        }

        $hash = $user[0]->getPassword();

        if ($this->encryptionService->verify($password, $hash) && $user[0]->getIsActive() == UserService::IS_ACTIVE) {
            $this->session->set('id', $user[0]->getId());
            return true;
        }
        Message::postMessage('Please enter valid password', Message::NEGATIVE_MESSAGE);
        return false;
    }

    public function getUserId()
    {
        return $this->session->get(self::AUTHENTICATION_ID);
    }

    public function getHeroId()
    {
        return $this->session->get(self::AUTHENTICATION_HERO_ID);
    }

    public function getMonsterId()
    {
        return $this->session->get(self::AUTHENTICATION_MONSTER_ID);
    }
}