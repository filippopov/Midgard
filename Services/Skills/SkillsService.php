<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 20.1.2017 г.
 * Time: 0:02
 */

namespace FPopov\Services\Skills;


use FPopov\Core\MVC\SessionInterface;
use FPopov\Core\ViewInterface;
use FPopov\Repositories\Skills\SkillsRepository;
use FPopov\Repositories\Skills\SkillsRepositoryInterface;
use FPopov\Services\AbstractService;
use FPopov\Services\Application\AuthenticationServiceInterface;
use FPopov\Services\Application\ResponseServiceInterface;

class SkillsService extends AbstractService implements SkillsServiceInterface
{
    private $view;
    private $authenticationService;
    private $session;
    private $responseService;

    /** @var  SkillsRepository */
    private $skillsRepository;

    public function __construct(
        ViewInterface $view,
        AuthenticationServiceInterface $authenticationService,
        SessionInterface $session,
        ResponseServiceInterface $responseService,
        SkillsRepositoryInterface $skillsRepository
    )
    {
        $this->view = $view;
        $this->authenticationService = $authenticationService;
        $this->session = $session;
        $this->responseService = $responseService;
        $this->skillsRepository = $skillsRepository;
    }

    public function showSkills($params = [])
    {
        $heroId = $this->authenticationService->getHeroId();
        $params['heroId'] = $heroId;

        $allowParams = [
            'heroId'
        ];

        $bindFilter = $this->getParamFilters($params, $allowParams);

        $structure = [
            'skill_name' => [
                'title' => 'Skill Name',
                'type' => self::TYPE_DATA
            ],
            'description' => [
                'title' => 'Skill Description',
                'type' => self::TYPE_DATA
            ],
            'type_of_skill' => [
                'title' => 'Type Of Skill',
                'type' => self::TYPE_DATA
            ],
            'skill_level' => [
                'title' => 'Skill Level',
                'type' => self::TYPE_DATA
            ],
        ];

        $repoData = $this->skillsRepository->getAllSkillsForCurrentHero($bindFilter);
        $bindFilter['total'] = $this->skillsRepository->getAllSkillsForCurrentHeroCount($bindFilter);
        $data = $this->generateGridData($structure, $repoData);

        $searchFields = [
            'skill_name' => 'Skill Name'
        ];

        $table = [
            'tableSearchFields' => $searchFields,
            'tableData' => $data,
            'filter' => $this->pageFilters($bindFilter),
        ];

        return $table;
    }
}