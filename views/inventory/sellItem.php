<?php
/** @var \FPopov\Core\ViewInterface $this */
/** @var \FPopov\Models\View\Inventory\SellItemViewModel $model */

$heroId = isset($heroId) ? $heroId : 0;
?>

<div class="container">
    <div class="jumbotron">
        <div class="well bs-component">
            <form class="form-horizontal" method="post" action="<?php echo $this->uri('inventory', 'sellItemPost')?>">
                <fieldset>
                    <legend>Send Item To Auction</legend>
                    <div class="form-group">
                        <label for="priceId" class="col-lg-2 control-label">Set Price</label>
                        <div class="col-lg-10">
                            <input class="form-control" name="price" id="priceId" placeholder="Set Price" type="number">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-10">
                            <input class="form-control" name="itemId" value="<?php echo $model->getItemId()?>" type="hidden">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-10 col-lg-offset-2">
                            <a href="<?php echo $this->uri('inventory', 'inventory')?>" class="btn btn-default">Back to inventory</a>
                            <button name="login" type="submit" class="btn btn-primary">Send to Auction</button>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>