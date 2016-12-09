<?php
/**
 * @var \FPopov\Core\ViewInterface $this
 */
?>

<div id="tablesContainer" class="col-md-12">
    <?php require 'views/partials/grid/table.php'; ?>
</div>


<a href="<?php echo $this->uri('heroes', 'choseHeroToPlay') ?>" class="btn btn-default">Back</a>