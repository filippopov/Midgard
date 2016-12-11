<?php
/** @var \FPopov\Core\ViewInterface $this */
/** @var \FPopov\Models\View\Battle\BattleHeroDefenderHeroViewModel $model */

$heroId = isset($heroId) ? $heroId : 0;
$defenderId = isset($defenderId) ? $defenderId : 0;
?>
<div class="container">
    <div class="jumbotron">
        <h2>Defender Player</h2>
        <div><strong>Defender Hero type: </strong><?php echo $model->getDefenderHeroType()?></div>
        <div><strong>Defender Hero name: </strong><?php echo $model->getDefenderHeroName()?></div>
        <div><strong>Defender Hero level: </strong><?php echo $model->getDefenderHeroLevelNumber()?></div>
        <div><strong>Defender Hero damage: </strong><?php echo $model->getDefenderHeroDamageLowValue() . ' - ' . $model->getDefenderHeroDamageHighValue()?></div>
        <div><strong>Defender Hero critical chance: </strong><?php echo $model->getDefenderHeroCriticalChance()?></div>
        <div><strong>Defender Hero armor: </strong><?php echo $model->getDefenderHeroArmor()?></div>
        <div><strong>Defender Hero mana: </strong><?php echo $model->getDefenderHeroMana()?></div>
        <?php if ($model->getHeroAndDefendHeroInBattle()) : ?>
            <div><strong>Defender Hero health: </strong><?php echo $model->getDefendHeroRealHealth()?></div>
        <?php else: ?>
            <div><strong>Defender Hero health: </strong><?php echo $model->getDefenderHeroHealth()?></div>
        <?php endif; ?>
        <h2>Attack Player</h2>
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
                    'attackCreature' => 'player',
                    'attacker' => $heroId,
                    'defender' => $defenderId])?>">
                    <button name="attack" type="submit" class="btn btn-default" value="attack">Attack</button>
                </form></li>
            <li><form method="post" action="<?php echo $this->uri('battle', 'runFromBattle', [
                    'attackCreature' => 'player',
                    'attacker' => $heroId,
                    'defender' => $defenderId])?>">
                    <button name="attack" type="submit" class="btn btn-default" value="attack">Run from battle</button>
                </form></li>
        </ul>
    </div>
</div>