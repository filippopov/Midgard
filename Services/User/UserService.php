<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 25.11.2016 г.
 * Time: 21:26
 */

namespace FPopov\Services\User;


use FPopov\Adapter\DatabaseInterface;
use FPopov\Core\MVC\Message;
use FPopov\Core\ViewInterface;
use FPopov\Models\Binding\User\UserProfileEditBindingModel;
use FPopov\Models\DB\Role\Role;
use FPopov\Models\DB\User\User;
use FPopov\Repositories\Role\RoleRepository;
use FPopov\Repositories\Role\RoleRepositoryInterface;
use FPopov\Repositories\User\UserRepository;
use FPopov\Repositories\User\UserRepositoryInterface;
use FPopov\Repositories\UserRole\UserRoleRepository;
use FPopov\Repositories\UserRole\UserRoleRepositoryInterface;
use FPopov\Services\AbstractService;
use FPopov\Services\Application\EncryptionServiceInterface;

class UserService extends AbstractService  implements UserServiceInterface
{
    const IS_ACTIVE = 1;
    const USER_ROLE = 'user';

    private $db;
    private $encryptionService;
    private $view;

    /** @var  UserRepository */
    private $userRepository;

    /** @var RoleRepository */
    private $roleRepository;
    /** @var  UserRoleRepository */
    private $userRoleRepository;

    public function __construct(
        DatabaseInterface $db,
        EncryptionServiceInterface $encryptionService,
        UserRepositoryInterface $userRepository,
        RoleRepositoryInterface $roleRepository,
        UserRoleRepositoryInterface $userRoleRepository,
        ViewInterface $view)
    {
        $this->db = $db;
        $this->encryptionService = $encryptionService;
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
        $this->userRoleRepository = $userRoleRepository;
        $this->view = $view;
    }

    public function register($username, $password) : bool
    {
        if (strlen($username) < 5) {
            Message::postMessage('Username must be, at least five or more symbols', Message::NEGATIVE_MESSAGE);
            return false;
        }

        if (strlen($password) < 5) {
            Message::postMessage('Password must be, at least five or more symbols', Message::NEGATIVE_MESSAGE);
            return false;
        }

        $isExistUsername = $this->userRepository->findByCondition(['username' => $username]);

        if (! empty($isExistUsername)) {
            Message::postMessage('Username exist', Message::NEGATIVE_MESSAGE);
            return false;
        }

        $userRegister = $this->userRepository->create([
            'username' => $username,
            'password' => $this->encryptionService->hash($password),
            'is_active' => self::IS_ACTIVE
        ]);

        /** @var User $user */
        $user = $this->userRepository->findByCondition(['username' => $username], User::class);

        /** @var Role $role */
        $role = $this->roleRepository->findByCondition(['name' => self::USER_ROLE], Role::class);

        $userRole = $this->userRoleRepository->create([
            'user_id' => $user->getId(),
            'role_id' => $role->getId()
        ]);

        if ($userRegister && $userRole) {
            Message::postMessage('Successfully register user', Message::POSITIVE_MESSAGE);
        } else {
            Message::postMessage('Please try again', Message::NEGATIVE_MESSAGE);
            return false;
        }

        return true;
    }

    public function findOne($id) : User
    {
        /** @var User $user */
        $user = $this->userRepository->findOneRowById($id, User::class);

        return $user;
    }

    public function edit(UserProfileEditBindingModel $bindingModel)
    {
        if ($bindingModel->getPassword() != $bindingModel->getConfirmPassword()) {
            return false;
        }

        $params = [
            'username' => $bindingModel->getUsername(),
            'password' => $this->encryptionService->hash($bindingModel->getPassword()),
            'email' => $bindingModel->getEmail(),
            'birthday' => $bindingModel->getBirthday(),
        ];

        return $this->userRepository->update($bindingModel->getId(), $params);
    }

//    public function findAll($params)
//    {
//        $bindFilter = $this->getParamFilters($params);
//
//        $structure = [
//            'id' => [
//                'title' => 'Id',
//                'type' => self::TYPE_DATA
//            ],
//            'name' => [
//                'title' => 'Name',
//                'type' => self::TYPE_DATA
//            ],
//            'actions' => array(
//                'title' => 'Actions',
//                'type' => self::TYPE_ACTIONS,
//                'values' => array(
//                    'edit' => function ($row) {
//                        return $this->view->uri('categories', 'edit', [], ['id' => $row['id']]);
//                    },
//                    'delete' => function  ($row) {
//                        return $this->view->uri('categories', 'deleteCategory', [], ['id' => $row['id']]);
//                    }
//                )
//            )
//        ];
//
//        $repoData = $this->categoryRepository->testGrid($bindFilter);
//        $bindFilter['total'] = $this->categoryRepository->testGridCount($bindFilter);
//        $data = $this->generateGridData($structure, $repoData);
//
//        $searchFields = [
//            'id' => 'Id',
//            'name' => 'Name Category'
//        ];
//
//        $table = [
//            'tableSearchFields' => $searchFields,
//            'tableData' => $data,
//            'filter' => $this->pageFilters($bindFilter),
//        ];
//
//        return $table;
//    }

    public function findAllHeroesForCurrentUser($params = [])
    {
        $allowParams = ['userId'];
        $bindFilter = $this->getParamFilters($params, $allowParams);

        $listOfFields = [
            'h.id',
            'h.name AS hero_name',
            'toh.name AS hero_type',
            'l.level_number AS level',
            'l.to_experience',
            'c.name AS city_name',
            'c.coordinates_x',
            'c.coordinates_y',
            'h.experience'
        ];

        $structure = [
            'hero_name' => [
                'title' => 'Hero Name',
                'type' => self::TYPE_DATA
            ],
            'hero_type' => [
                'title' => 'Hero Type',
                'type' => self::TYPE_DATA
            ],
            'level' => [
                'title' => 'Level',
                'type' => self::TYPE_DATA
            ],
            'experience' => [
                'title' => 'Experience',
                'type' => self::TYPE_DATA
            ],
            'to_experience' => [
                'title' => 'Experience to level',
                'type' => self::TYPE_DATA
            ],
            'city_name' => [
                'title' => 'City',
                'type' => self::TYPE_DATA
            ],
            'coordinates_x' => [
                'title' => 'Coordinates X',
                'type' => self::TYPE_DATA
            ],
            'coordinates_y' => [
                'title' => 'Coordinates Y',
                'type' => self::TYPE_DATA
            ],
            'actions' => array(
                'title' => 'Actions',
                'type' => self::TYPE_ACTIONS,
                'values' => array(
                    'delete' => function  ($row) {
                        return $this->view->uri('users', 'deleteHero', [], ['id' => $row['id']]);
                    }
                )
            ),
            'id' => [
                'title' => 'Play',
                'type' => self::TYPE_DATA,
                'value' => function ($value) {
                    return 'Play';
                },
                'onClick' => function ($value) {
                    return $this->view->uri('users', 'playHero', ['heroId' => $value]);
                }
            ]
        ];

        $repoData = $this->userRepository->findAllHeroesForCurrentUser($bindFilter);
        $bindFilter['total'] = $this->userRepository->findAllHeroesForCurrentUserCount($bindFilter);
        $data = $this->generateGridData($structure, $repoData);

        $searchFields = [
            'name' => 'Hero Name'
        ];

        $table = [
            'tableSearchFields' => $searchFields,
            'tableData' => $data,
            'filter' => $this->pageFilters($bindFilter),
        ];

        return $table;
    }
}