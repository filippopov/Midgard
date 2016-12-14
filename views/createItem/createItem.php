<?php
/** @var \FPopov\Core\ViewInterface $this */
/** @var \FPopov\Models\View\CreateItem\CreateItemViewModel $model */

$heroId = isset($heroId) ? $heroId : 0;
?>

<div class="container">
    <div class="jumbotron">
        <h2>Create Item: <strong><?php echo $model->getName()?></strong></h2>
        <div>Need time to create item: <strong><?php echo $model->getDuration()?></strong></div>
        <?php if ($model->getStatus() == 'stop') : ?>
            <div>
                <form method="post" action="<?php echo $this->uri('createItem', 'startItem', [
                    'typeOfRecipesId' => $model->getTypeOfRecipesId()]) ?>">
                    <button type="submit" class="btn btn-default">Create Item</button>
                </form>
            </div>
        <?php elseif ($model->getStatus() == 'inProgress') : ?>
            <div>Time to create item: <strong><?php echo $model->getTimeToCreateItem()?></strong></div>
        <?php elseif ($model->getStatus() == 'finish') : ?>
            <div>
                <form method="post" action="<?php echo $this->uri('createItem', 'takeItem', [
                    'typeOfRecipesId' => $model->getTypeOfRecipesId()]) ?>">
                    <button type="submit" class="btn btn-default">Take Item</button>
                </form>
            </div>
        <?php endif; ?>

        <br>
        <ul class="nav nav-pills">
            <li><a href="<?php echo $this->uri('game', 'playHero', [$heroId])?>">Back to menu</a></li>
            <li><a href="<?php echo $this->uri('createItem', 'createItem', [$model->getTypeOfRecipesId()])?>">Refresh</a></li>
        </ul>
    </div>
</div>