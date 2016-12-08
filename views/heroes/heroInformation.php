<?php
/** @var \FPopov\Core\ViewInterface $this */
/** @var \FPopov\Models\DB\Hero\HeroStatistic $model */
?>

<div class="container">
    <div class="jumbotron">
        <h2>Data For Hero</h2>
        <div><strong>Hero name: </strong><?php echo $model->getHeroName()?></div>
        <div><strong>Hero type: </strong><?php echo $model->getHeroType()?></div>
        <div><strong>Hero level: </strong><?php echo $model->getLevelNumber()?></div>
        <div><strong>Hero experience: </strong><?php echo $model->getExperience()?></div>
        <div><strong>Hero experience to next level: </strong><?php echo $model->getExperienceToNextLevel()?></div>
        <div><strong>Hero location: </strong><?php echo $model->getCityName()?></div>
        <h3>Resources</h3>
        <div><strong>Hero resources: </strong><?php echo $model->getResources()?></div>
        <h3>Hero Power</h3>
        <div><strong>Hero health: </strong><?php echo $model->getRealHealth()?></div>
        <div><strong>Hero mana: </strong><?php echo $model->getRealMana()?></div>
        <div><strong>Hero max health: </strong><?php echo $model->getMaxHealth()?></div>
        <div><strong>Hero max mana: </strong><?php echo $model->getMaxMana()?></div>
        <div><strong>Hero damage: </strong><?php echo $model->getDamageLowValue() . ' - ' . $model->getDamageHighValue()?></div>
        <div><strong>Hero armor: </strong><?php echo $model->getArmor()?></div>
        <div><strong>Hero strength: </strong><?php echo $model->getStrength()?></div>
        <div><strong>Hero dexterity: </strong><?php echo $model->getDexterity()?></div>
        <div><strong>Hero vitality: </strong><?php echo $model->getVitality()?></div>
        <div><strong>Hero magic: </strong><?php echo $model->getMagic()?></div>
        <div><strong>Hero critical chance: </strong><?php echo $model->getCriticalChance() . '%'?></div>
    </div>
</div>