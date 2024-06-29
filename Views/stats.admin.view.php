<?php

use CMW\Manager\Lang\LangManager;

$title = LangManager::translate("redirect.dashboard.title_stats");
$description = LangManager::translate("redirect.dashboard.desc_stats");

/* @var \CMW\Entity\Redirect\RedirectEntity[] $stats */
/* @var \CMW\Model\Redirect\RedirectModel $redirectionNumber */
/* @var \CMW\Model\Redirect\RedirectModel $totalClicks */
/* @var \CMW\Entity\Redirect\RedirectEntity[] $allClicks */ ?>

<h3><i class="fas fa-chart-area"></i> <?= LangManager::translate("redirect.dashboard.title_stats") ?></h3>

<div class="grid-3">
    <div class="col-span-2 card">
        <h6><?= LangManager::translate("redirect.dashboard.stats_clicks_total") ?></h6>
        <div id="chart"></div>
    </div>
    <div class="card">
        <h6>Quelques chiffres</h6>
        <div class="alert alert-primary">
            <h4 class="alert-heading text-center"><?= number_format($redirectionNumber) ?> <span
                    style="font-size: smaller;"><?= LangManager::translate("redirect.dashboard.stats_number") ?></span>
            </h4>
        </div>
        <div class="alert alert-primary text-center">
            <h4 class="alert-heading"><?= number_format($totalClicks) ?> <span
                    style="font-size: smaller;"><?= LangManager::translate("redirect.dashboard.stats_clicks_actives") ?></span>
            </h4>
        </div>
        <div class="alert alert-primary text-center">
            <h4 class="alert-heading"><?= number_format($allClicks) ?> <span
                    style="font-size: smaller;"><?= LangManager::translate("redirect.dashboard.stats_clicks_total") ?></span>
            </h4>
        </div>
    </div>
</div>

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