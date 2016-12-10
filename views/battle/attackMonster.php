<?php
/** @var \FPopov\Core\ViewInterface $this */
/** @var \FPopov\Models\View\Battle\BattleHeroMonsterViewModel $model */

$heroId = isset($heroId) ? $heroId : 0;
$monsterId = isset($monsterId) ? $monsterId : 0;
?>

<div class="container">
    <div class="jumbotron">
        <h2>Monster</h2>
        <div><strong>Monster type: </strong><?php echo $model->getMonsterType()?></div>
        <div><strong>Monster damage: </strong><?php echo $model->getMonsterDamageLowValue() . ' - ' . $model->getMonsterDamageHighValue()?></div>
        <div><strong>Monster armor: </strong><?php echo $model->getMonsterArmor()?></div>
        <?php if ($model->getMonsterAndHeroInBattle()) : ?>
            <div><strong>Monster health: </strong><?php echo $model->getMonsterRealHealth()?></div>
        <?php else: ?>
            <div><strong>Monster health: </strong><?php echo $model->getMonsterHealth()?></div>
        <?php endif; ?>
        <h2>Player</h2>
        <div><strong>Hero type: </strong><?php echo $model->getHeroType()?></div>
        <div><strong>Hero name: </strong><?php echo $model->getHeroName()?></div>
        <div><strong>Hero level: </strong><?php echo $model->getHeroLevelNumber()?></div>
        <div><strong>Hero damage: </strong><?php echo $model->getHeroDamageLowValue() . ' - ' . $model->getHeroDamageHighValue()?></div>
        <div><strong>Hero critical chance: </strong><?php echo $model->getHeroCriticalChance() . '%'?></div>
        <div><strong>Hero armor: </strong><?php echo $model->getHeroArmor()?></div>
        <div><strong>Hero max health: </strong><?php echo $model->getHeroMaxHealth()?></div>
        <div><strong>Hero max mana: </strong><?php echo $model->getHeroMaxMana()?></div>
        <div><strong>Hero health: </strong><?php echo $model->getHeroRealHealth()?></div>
        <div><strong>Hero mana: </strong><?php echo $model->getHeroRealMana()?></div>
        <br>
        <ul class="nav nav-pills">
            <li><form method="post" action="<?php echo $this->uri('battle', 'attack', [
                    'attackCreature' => 'monster',
                    'attacker' => $heroId,
                    'defender' => $monsterId])?>">
                    <button name="attack" type="submit" class="btn btn-default" value="attack">Attack</button>
                </form></li>
            <li><form method="post" action="<?php echo $this->uri('battle', 'runFromBattle', [
                    'attackCreature' => 'monster',
                    'attacker' => $heroId,
                    'defender' => $monsterId])?>">
                    <button name="attack" type="submit" class="btn btn-default" value="attack">Run from battle</button>
                </form></li>
        </ul>
    </div>
</div>



