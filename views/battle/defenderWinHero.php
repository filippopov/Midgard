<?php
/** @var \FPopov\Core\ViewInterface $this */
/** @var \FPopov\Models\View\Battle\BattleMonsterWinHeroViewModel $model */

$heroId = isset($heroId) ? $heroId : 0;
$monsterId = isset($monsterId) ? $monsterId : 0;
?>

<div class="container">
    <div class="jumbotron">
        <h2>You Lose</h2>
        <div><strong>Killed By: </strong><?php echo $model->getMonsterType()?></div>
        <h2>Reward</h2>
        <div><strong>Lost Experience: </strong><?php echo $model->getLostExperience()?></div>
        <div><strong>Health After Battle: </strong><?php echo $model->getHeroHealth()?></div>
        <br>
        <ul class="nav nav-pills">
            <li><a href="<?php echo $this->uri('game', 'playHero', [$heroId])?>">Back to menu</a></li>
        </ul>
    </div>
</div>