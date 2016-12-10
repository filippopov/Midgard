<?php
/** @var \FPopov\Core\ViewInterface $this */
/** @var \FPopov\Models\View\Battle\BattleHeroWinMonsterViewModel $model */

$heroId = isset($heroId) ? $heroId : 0;
$monsterId = isset($monsterId) ? $monsterId : 0;
?>

<div class="container">
    <div class="jumbotron">
        <h2>You Win</h2>
        <div><strong>Kill: </strong><?php echo $model->getMonsterType()?></div>
        <h2>Reward</h2>
        <div><strong>Experience: </strong><?php echo $model->getExperience()?></div>
        <div><strong>Gold: </strong><?php echo $model->getGold()?></div>
        <div><strong>Item Name: </strong><?php echo $model->getItemName()?></div>
        <br>
        <ul class="nav nav-pills">
            <li><a href="<?php echo $this->uri('game', 'playHero', [$heroId])?>">Back to menu</a></li>
        </ul>
    </div>
</div>