<?php
/** @var \FPopov\Core\ViewInterface $this */
/** @var \FPopov\Models\View\Level\LevelDataViewModel $model */

$heroId = isset($heroId) ? $heroId : 0;

?>
<div class="container">
    <div class="jumbotron">
        <h2>Level up your status</h2>
        <div><strong>Left Points: </strong><?php echo $model->getLevelPoints()?></div>
        <br>
        <div>1STR = 1/2 DMG</div>
        <div><strong>Strength: </strong><?php echo $model->getStrength()?></div>
        <div>
            <form method="post" action="<?php echo $this->uri('level', 'levelUpPost', [
                'status' => 'strength',
                'heroId' => $heroId]) ?>">
                <button type="submit" class="btn btn-default">+</button>
            </form>
        </div>
        <br>
        <div>1DEX = 2 Armor and 0.01 Critical</div>
        <div><strong>Dexterity: </strong><?php echo $model->getDexterity()?></div>
        <div>
            <form method="post" action="<?php echo $this->uri('level', 'levelUpPost', [
                'status' => 'dexterity',
                'heroId' => $heroId]) ?>">
                <button type="submit" class="btn btn-default">+</button>
            </form>
        </div>
        <br>
        <div>1VIT = 10HP</div>
        <div><strong>Vitality: </strong><?php echo $model->getVitality()?></div>
        <div>
            <form method="post" action="<?php echo $this->uri('level', 'levelUpPost', [
                'status' => 'vitality',
                'heroId' => $heroId]) ?>">
                <button type="submit" class="btn btn-default">+</button>
            </form>
        </div>
        <br>
        <div>1MAG = 10MP</div>
        <div><strong>Magic: </strong><?php echo $model->getMagic()?></div>
        <div>
            <form method="post" action="<?php echo $this->uri('level', 'levelUpPost', [
                'status' => 'magic',
                'heroId' => $heroId]) ?>">
                <button type="submit" class="btn btn-default">+</button>
            </form>
        </div>
        <br>
        <ul class="nav nav-pills">
            <li><a href="<?php echo $this->uri('game', 'playHero', [$heroId])?>">Back to menu</a></li>
        </ul>
    </div>
</div>