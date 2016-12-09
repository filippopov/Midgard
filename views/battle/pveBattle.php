<?php
/**
 * @var \FPopov\Core\ViewInterface $this
 */

    $heroId = isset($heroId) ? $heroId : 0;
?>


<?php require_once 'views/partials/grid/filter.php'; ?>

    <div id="tablesContainer" class="col-md-12">
        <?php require 'views/partials/grid/table.php'; ?>
    </div>

<?php require 'views/partials/grid/pagination.php' ?>



<a href="<?php echo $this->uri('game', 'playHero', [$heroId]) ?>" class="btn btn-default">Back</a>
