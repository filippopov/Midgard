<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 6.12.2016 г.
 * Time: 20:00
 */

namespace FPopov\Services\Hero;



use FPopov\Core\ViewInterface;
use FPopov\Repositories\Hero\HeroRepositoryInterface;
use FPopov\Services\AbstractService;

class HeroService extends AbstractService implements HeroServiceInterface
{
    private $view;
    private $heroRepository;

    public function __construct(ViewInterface $view, HeroRepositoryInterface $heroRepository)
    {
        $this->view = $view;
        $this->heroRepository = $heroRepository;
    }

    public function findAllHeroesForCurrentUser($params = [])
    {
        $allowParams = ['userId'];
        $bindFilter = $this->getParamFilters($params, $allowParams);

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

        $repoData = $this->heroRepository->findAllHeroesForCurrentUser($bindFilter);
        $bindFilter['total'] = $this->heroRepository->findAllHeroesForCurrentUserCount($bindFilter);
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

    public function createHero()
    {
        $structure = $this->getModuleFields();

        return [
            'formFieldData' => self::generateFormData($structure)
        ];
    }

//    public function addGridCategory()
//    {
//        $structure = $this->getModuleFieldsAdd();
//
//        return [
//            'formFieldData' => self::generateFormData($structure)
//        ];
//    }

    public function addGridHero($heroName, $heroType)
    {

    }

    protected function getModuleFields()
    {
        $structure = [
            'heroName' => [
                'title' => 'Hero Name',
                'type' => self::TYPE_INPUT,
                'inputValidate' => self::TYPE_INPUT
            ],
            'heroType' => [
                'title' => 'Hero Type',
                'type' => self::TYPE_INPUT,
                'inputValidate' => self::TYPE_INPUT
            ]
        ];

        return $structure;
    }
}