<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 12.12.2016 г.
 * Time: 18:49
 */

namespace FPopov\Services\Level;


use FPopov\Core\MVC\Message;
use FPopov\Core\MVC\SessionInterface;
use FPopov\Core\ViewInterface;
use FPopov\Exceptions\GameException;
use FPopov\Models\DB\Hero\Hero;
use FPopov\Models\DB\Hero\HeroStatistic;
use FPopov\Repositories\Hero\HeroRepository;
use FPopov\Repositories\Hero\HeroRepositoryInterface;
use FPopov\Services\AbstractService;
use FPopov\Services\Application\AuthenticationServiceInterface;
use FPopov\Services\Application\ResponseServiceInterface;
use FPopov\Services\Hero\HeroService;

class LevelService extends AbstractService implements LevelServiceInterface
{
    const STRENGTH = 'strength';
    const DEXTERITY = 'dexterity';
    const VITALITY = 'vitality';
    const MAGIC = 'magic';

    private $view;
    private $authenticationService;
    private $session;
    private $responseService;

    /** @var  HeroRepository */
    private $heroRepository;

    public function __construct(
        ViewInterface $view,
        AuthenticationServiceInterface $authenticationService,
        SessionInterface $session,
        ResponseServiceInterface $responseService,
        HeroRepositoryInterface $heroRepository
    )
    {
        $this->view = $view;
        $this->authenticationService = $authenticationService;
        $this->session = $session;
        $this->responseService = $responseService;
        $this->heroRepository = $heroRepository;
    }

    public function levelUp()
    {
        $heroId = $this->authenticationService->getHeroId();

        $heroParams = [HeroService::ITEM_IS_EQUIPED, $heroId, $heroId];

        /** @var HeroStatistic $heroStatus */
        $heroStatus = $this->heroRepository->heroInformation($heroParams);

        $returnParams = [
            'strength' => $heroStatus->getStrength(),
            'dexterity' => $heroStatus->getDexterity(),
            'vitality' => $heroStatus->getVitality(),
            'magic' => $heroStatus->getMagic(),
            'levelPoints' => $heroStatus->getLevelPoints()
        ];

        return $returnParams;
    }

    public function levelUpPost($params = [])
    {
        $heroId = isset($params[1]) ? $params[1] : 0;

        if (! $heroId) {
            throw new GameException('Not set heroId');
        }

        $typeStatus = isset($params[0]) ? $params[0] : 0;

        if (! $typeStatus) {
            throw new GameException('Not set type of status');
        }

        /** @var Hero $hero */
        $hero = $this->heroRepository->findOneRowById($heroId, Hero::class);

        $getCountOfLevelPoints = $hero->getLevelPoints();

        if ($getCountOfLevelPoints <= 0) {
            Message::postMessage('You do not have enough points', Message::NEGATIVE_MESSAGE);
            return false;
        }
        $leftPoints = $hero->getLevelPoints();
        $newValuePoints = $leftPoints - 1;
        switch ($typeStatus) {
            case self::STRENGTH :

                $newValue = $hero->getStrength() + 1;
                $this->heroRepository->update($heroId, ['strength' => $newValue, 'level_points' => $newValuePoints]);
                Message::postMessage('Strength +1', Message::POSITIVE_MESSAGE);
                break;
            case self::DEXTERITY :
                $newValue = $hero->getDexterity() + 1;
                $this->heroRepository->update($heroId, ['dexterity' => $newValue, 'level_points' => $newValuePoints]);
                Message::postMessage('Dexterity +1', Message::POSITIVE_MESSAGE);
                break;
            case self::VITALITY :
                $newValue = $hero->getVitality() + 1;
                $this->heroRepository->update($heroId, ['vitality' => $newValue, 'level_points' => $newValuePoints]);
                Message::postMessage('Vitality +1', Message::POSITIVE_MESSAGE);
                break;
            case self::MAGIC :
                $newValue = $hero->getMagic() + 1;
                $this->heroRepository->update($heroId, ['magic' => $newValue, 'level_points' => $newValuePoints]);
                Message::postMessage('Magic +1', Message::POSITIVE_MESSAGE);
                break;
            default :
                Message::postMessage('Not such status', Message::NEGATIVE_MESSAGE);
                break;

        }

        return true;
    }
}