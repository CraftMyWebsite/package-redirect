<?php
$title = REDIRECT_DASHBOARD_TITLE_STATS;
$description = REDIRECT_DASHBOARD_DESC_STATS;

ob_start();
/* @var redirectModel[] $stats */
/* @var redirectModel[] $redirect */
/* @var redirectModel[] $number */ ?>

<div class="container-fluid">
    <div class="row">

        <!-- Number of redirect -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3><?= number_format($number) ?></h3>

                    <p><?= REDIRECT_DASHBOARD_STATS_NUMBER ?></p>
                </div>
                <div class="icon">
                    <i class="fas fa-chart-area"></i>
                </div>
            </div>
        </div>

        <!-- Number of clicks (redirect actives) -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3><?= number_format($redirect->totalClicks) ?></h3>

                    <p><?= REDIRECT_DASHBOARD_STATS_CLICKS_ACTIVES ?></p>
                </div>
                <div class="icon">
                    <i class="fas fa-chart-pie"></i>
                </div>
            </div>
        </div>

        <!-- Number of clicks (total) -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3><?= number_format($redirect->getAllClicks()) ?></h3>

                    <p><?= REDIRECT_DASHBOARD_STATS_CLICKS_TOTAUX ?></p>
                </div>
                <div class="icon">
                    <i class="fas fa-chart-line"></i>
                </div>
            </div>
        </div>


    </div>


    <div class="row">
        <!-- STATS CLICKS PER REDIRECT-->
        <div class="col-6">
            <div class="card card-danger">
                <div class="card-header">
                    <h3 class="card-title"><?= REDIRECT_DASHBOARD_STATS_TITLE_CLICK ?></h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chartjs-size-monitor">
                        <div class="chartjs-size-monitor-expand">
                            <div class=""></div>
                        </div>
                        <div class="chartjs-size-monitor-shrink">
                            <div class=""></div>
                        </div>
                    </div>
                    <canvas id="chartGlobal"></canvas>
                </div>

            </div>
        </div>

        <!--//todo why not create a chart with date and clicks per redirect -->

    </div>
</div>


<script>
    //Chart config
    var ctx = document.getElementById('chartGlobal').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            //website name
            labels: [
                <?php foreach ($stats as $items):?>
                <?=json_encode($items['name']) . ","?>
                <?php endforeach;?>
            ],
            datasets: [{
                //Number of clicks
                data: [
                    <?php foreach ($stats as $items):?>
                    <?=json_encode($items['click']) . ","?>
                    <?php endforeach;?>
                ],
                //Color (random)
                backgroundColor: [
                    <?php for ($i = 0; $i < $number; $i++): ?>
                    <?= "random_rgb()," ?>
                    <?php endfor; ?>
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>


<?php $content = ob_get_clean(); ?>

<?php require(getenv("PATH_ADMIN_VIEW") . 'template.php'); ?>
