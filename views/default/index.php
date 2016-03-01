<div class="row">
    <div class="col-xs-12">
        <h1>System in Maintenance</h1>

        <p>The system is currently in being maintained. At the moment, the following tasks are being performed:</p>
        <p>
            <?= humanized\maintenance\models\Maintenance::current()->comment ?>
        </p>
        <p>We forgot to mention:</p><h4>We're sorry!</h4> <p>Please try again later</p>
    </div>
</div>
