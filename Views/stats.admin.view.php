<?php

use CMW\Manager\Lang\LangManager;

$title = LangManager::translate("redirect.dashboard.title_stats");
$description = LangManager::translate("redirect.dashboard.desc_stats");

/* @var \CMW\Entity\Redirect\RedirectEntity[] $stats */
/* @var \CMW\Model\Redirect\RedirectModel $redirectionNumber */
/* @var \CMW\Model\Redirect\RedirectModel $totalClicks */
/* @var \CMW\Entity\Redirect\RedirectEntity[] $allClicks */ ?>

<div class="d-flex flex-wrap justify-content-between">
    <h3><i class="fas fa-chart-area"></i> <span
            class="m-lg-auto"><?= LangManager::translate("redirect.dashboard.title_stats") ?></span></h3>
</div>

<section class="row">
    <div class="col-12 col-lg-6">
        <div class="card">
            <div class="card-header">
                <div class="d-flex flex-wrap justify-content-between">
                    <h4><?= LangManager::translate("redirect.dashboard.stats_clicks_total") ?></h4>
                </div>
            </div>
            <div class="card-body">
                <div id="chart">
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-6">
        <div class="card">
            <div class="card-header">
                <h4>Quelques chiffres</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <div class="alert alert-primary">
                            <h4 class="alert-heading text-center"><?= number_format($redirectionNumber) ?> <span
                                    style="font-size: smaller;"><?= LangManager::translate("redirect.dashboard.stats_number") ?></span>
                            </h4>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="alert alert-primary text-center">
                            <h4 class="alert-heading"><?= number_format($totalClicks) ?> <span
                                    style="font-size: smaller;"><?= LangManager::translate("redirect.dashboard.stats_clicks_actives") ?></span>
                            </h4>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="alert alert-primary text-center">
                            <h4 class="alert-heading"><?= number_format($allClicks) ?> <span
                                    style="font-size: smaller;"><?= LangManager::translate("redirect.dashboard.stats_clicks_total") ?></span>
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    var options = {
        series: [<?php foreach ($stats as $items):?>
            <?php try {
            echo json_encode($items->getClick(), JSON_THROW_ON_ERROR) . ",";
        } catch (JsonException $e) {
            echo $e;
        }?>
            <?php endforeach;?>],
        chart: {
            width: 600,
            type: 'pie',
        },
        labels: [<?php foreach ($stats as $items):?>
            <?php try {
            echo json_encode($items->getName(), JSON_THROW_ON_ERROR) . ",";
        } catch (JsonException $e) {
            echo $e;
        }?>
            <?php endforeach;?>],
        responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                    width: 200
                },
                legend: {
                    position: 'right'
                }
            }
        }]
    };

    var chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();
</script>