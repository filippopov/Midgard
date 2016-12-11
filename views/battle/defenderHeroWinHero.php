<?php
/** @var \FPopov\Core\ViewInterface $this */
/** @var \FPopov\Models\View\Battle\BattleDefenderHeroWinHeroViewModel $model */

$heroId = isset($heroId) ? $heroId : 0;
$monsterId = isset($monsterId) ? $monsterId : 0;
?>

<div class="container">
    <div class="jumbotron">
        <h2>You Lose</h2>
        <div><strong>Lost Honor: </strong>10</div>
        <div><strong>Honor After Battle: </strong><?php echo $model->getLoseHonor()?></div>
        <div><strong>Health After Battle: </strong><?php echo $model->getHeroHalfFromMaxHP()?></div>
        <br>
        <ul class="nav nav-pills">
            <li><a href="<?php echo $this->uri('game', 'playHero', [$heroId])?>">Back to menu</a></li>
        </ul>
    </div>
</div>