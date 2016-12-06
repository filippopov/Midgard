<?php
/** @var \FPopov\Core\ViewInterface $this */
?>

<div class="container">
<form class="form-horizontal">
    <fieldset>
        <legend>Midgard</legend>
        <div class="form-group">
            <div class="col-lg-10">
                <a href="<?php echo $this->uri('users', 'login')?>" class="btn btn-default">Login</a>
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-10">
                <a href="<?php echo $this->uri('users', 'register')?>" class="btn btn-primary">Register</a>
            </div>
        </div>
    </fieldset>
</form>
</div>