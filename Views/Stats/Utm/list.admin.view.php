<?php

use CMW\Entity\Redirect\RedirectEntity;
use CMW\Manager\Env\EnvManager;
use CMW\Manager\Lang\LangManager;
use CMW\Utils\Website;

/* @var RedirectEntity[] $redirects */

Website::setTitle(LangManager::translate('redirect.dashboard.stats.utm.title'));
Website::setDescription(LangManager::translate('redirect.dashboard.stats.utm.description'));
?>

<h3>
    <i class="fa-solid fa-chart-area"></i>
    <?= LangManager::translate('redirect.dashboard.stats.utm.heading') ?>
</h3>


<div class="card">
    <h6><?= LangManager::translate('redirect.dashboard.title') ?></h6>
    <div class="table-container table-container-striped">
        <table class="table" id="table1">
            <thead>
            <tr>
                <th class="text-center"><?= LangManager::translate('redirect.list_table.name') ?></th>
                <th class="text-center"><?= LangManager::translate('redirect.list_table.slug') ?></th>
                <th class="text-center"><?= LangManager::translate('redirect.list_table.target') ?></th>
                <th class="text-center"><?= LangManager::translate('redirect.list_table.click') ?></th>
                <th class="text-center"><?= LangManager::translate('redirect.list_table.edit') ?></th>
            </tr>
            </thead>
            <tbody class="text-center">
            <?php foreach ($redirects as $redirect): ?>
                <tr>
                    <td><?= $redirect->getName() ?></td>
                    <td>
                        <a class="link"
                           href="<?= Website::getProtocol() . '://' . $_SERVER['SERVER_NAME'] . EnvManager::getInstance()->getValue('PATH_SUBFOLDER') . 'r/' ?><?= $redirect->getSlug() ?>"
                           target="_blank">
                            <?= Website::getProtocol() . '://' . $_SERVER['SERVER_NAME'] . EnvManager::getInstance()->getValue('PATH_SUBFOLDER') . 'r/' ?><?= $redirect->getSlug() ?>
                        </a>
                    </td>
                    <td><?= mb_strimwidth($redirect->getTarget(), 0, 40, '...') ?></td>
                    <td><?= $redirect->getClick() ?></td>
                    <td class="space-x-2">
                        <a href="utm/<?= $redirect->getId() ?>"><i class="text-info me-3 fas fa-chart-bar"></i></a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
