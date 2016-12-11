<?php
/** @var \FPopov\Core\ViewInterface $this */
/** @var \FPopov\Models\View\Battle\BattleAttackerHeroWinHeroViewModel $model */

$heroId = isset($heroId) ? $heroId : 0;
$monsterId = isset($monsterId) ? $monsterId : 0;
?>

<div class="container">
    <div class="jumbotron">
        <h2>You Win</h2>
        <div><strong>Win Honor: </strong>10</div>
        <div><strong>Honor After Battle: </strong><?php echo $model->getWinnerHonor()?></div>
        <br>
        <ul class="nav nav-pills">
            <li><a href="<?php echo $this->uri('game', 'playHero', [$heroId])?>">Back to menu</a></li>
        </ul>
    </div>
</div>