<?php

use CMW\Manager\Env\EnvManager;
use CMW\Manager\Lang\LangManager;
use CMW\Manager\Security\SecurityManager;
use CMW\Utils\Website;

$title = LangManager::translate('redirect.dashboard.title');
$description = LangManager::translate('redirect.dashboard.desc');

?>

<h3><i class="fa-solid fa-sliders"></i> <?= LangManager::translate('redirect.dashboard.desc') ?></h3>


<div class="card">
    <div class="lg:flex justify-between">
        <h6><?= LangManager::translate('redirect.dashboard.title_add') ?></h6>
        <button form="add" type="submit" class="btn-primary">
            <?= LangManager::translate('core.btn.add') ?>
        </button>
    </div>

    <form id="add" method="post" action="">
        <?php SecurityManager::getInstance()->insertHiddenToken() ?>
        <div class="grid-2">
            <div>
                <label for="name"><?= LangManager::translate('redirect.dashboard.name') ?> :</label>
                <div class="input-group">
                    <i class="fa-solid fa-heading"></i>
                    <input type="text" id="name" name="name" required autocomplete="off" maxlength="255"
                           placeholder="<?= LangManager::translate('redirect.dashboard.name_placeholder') ?>">
                </div>
            </div>
            <div>
                <label for="slug"><?= LangManager::translate('redirect.dashboard.slug') ?> :</label>
                <div class="input-group">
                    <i><?= Website::getProtocol() . '://' . $_SERVER['SERVER_NAME'] . EnvManager::getInstance()->getValue('PATH_SUBFOLDER') . 'r/' ?></i>
                    <input type="text" id="slug" name="slug" maxlength="255" required
                           placeholder="<?= LangManager::translate('redirect.dashboard.slug_placeholder') ?>">
                </div>
            </div>
            <div>
                <label for="target"><?= LangManager::translate('redirect.dashboard.target') ?> :</label>
                <div class="input-group">
                    <i class="fa-solid fa-link"></i>
                    <input type="url" id="target" name="target" autocomplete="off" maxlength="255"
                           required
                           placeholder="<?= LangManager::translate('redirect.dashboard.target_placeholder') ?>">
                </div>
            </div>
            <div>
                <div>
                    <label class="toggle">
                        <p class="toggle-label"><?= LangManager::translate('redirect.dashboard.save_ip') ?></p>
                        <input type="checkbox" class="toggle-input" id="storeIp" name="storeIp" checked>
                        <div class="toggle-slider"></div>
                    </label>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="card mt-4">
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
            <?php
                /** @var \CMW\Entity\Redirect\RedirectEntity[] $redirectList */
                foreach ($redirectList as $redirect):
            ?>
                <tr>
                    <td><?= $redirect->getName() ?></td>
                    <td>
                        <a class="link" href="<?= Website::getProtocol() . '://' . $_SERVER['SERVER_NAME'] . EnvManager::getInstance()->getValue('PATH_SUBFOLDER') . 'r/' ?><?= $redirect->getSlug() ?>"
                           target="_blank">
                            <?= Website::getProtocol() . '://' . $_SERVER['SERVER_NAME'] . EnvManager::getInstance()->getValue('PATH_SUBFOLDER') . 'r/' ?><?= $redirect->getSlug() ?>
                        </a>
                    </td>
                    <td><?= mb_strimwidth($redirect->getTarget(), 0, 40, '...') ?></td>
                    <td><?= $redirect->getClick() ?></td>
                    <td class="space-x-2">
                        <button data-modal-toggle="modal-edit-<?= $redirect->getId() ?>" type="button"><i class="text-info me-3 fas fa-edit"></i></button>
                        <button data-modal-toggle="modal-delete-<?= $redirect->getId() ?>" type="button"><i class="text-danger fas fa-trash-alt"></i></button>
                        <div id="modal-delete-<?= $redirect->getId() ?>" class="modal-container">
                            <div class="modal">
                                <div class="modal-header-danger">
                                    <h6><?= LangManager::translate('redirect.modal.delete') ?> <?= $redirect->getName() ?></h6>
                                    <button type="button" data-modal-hide="modal-delete-<?= $redirect->getId() ?>"><i class="fa-solid fa-xmark"></i></button>
                                </div>
                                <div class="modal-body">
                                    <?= LangManager::translate('redirect.modal.deletealert') ?>
                                </div>
                                <div class="modal-footer">
                                    <a href="manage/delete/<?= $redirect->getId() ?>" class="btn-danger">
                                        <?= LangManager::translate('core.btn.delete') ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div id="modal-edit-<?= $redirect->getId() ?>" class="modal-container">
                            <div class="modal">
                                <div class="modal-header">
                                    <h6><?= LangManager::translate('redirect.dashboard.title_edit') ?> <?= $redirect->getName() ?></h6>
                                    <button type="button" data-modal-hide="modal-edit-<?= $redirect->getId() ?>"><i class="fa-solid fa-xmark"></i></button>
                                </div>
                                <form id="edit" action="manage/edit/<?= $redirect->getId() ?>" method="post" enctype="multipart/form-data">
                                    <?php SecurityManager::getInstance()->insertHiddenToken() ?>
                                <div class="modal-body">
                                    <div>
                                        <label for="name"><?= LangManager::translate('redirect.dashboard.name') ?> :</label>
                                        <div class="input-group">
                                            <i class="fa-solid fa-heading"></i>
                                            <input type="text" id="name" name="name"  required autocomplete="off" maxlength="255"
                                                   placeholder="<?= LangManager::translate('redirect.dashboard.name_placeholder') ?>" value="<?= $redirect->getName() ?>">
                                        </div>
                                    </div>
                                    <div>
                                        <label for="slug"><?= LangManager::translate('redirect.dashboard.slug') ?> :</label>
                                        <div class="input-group">
                                            <i><?= Website::getProtocol() . '://' . $_SERVER['SERVER_NAME'] . EnvManager::getInstance()->getValue('PATH_SUBFOLDER') . 'r/' ?></i>
                                            <input type="text" id="slug" name="slug" maxlength="255" required
                                                   placeholder="<?= LangManager::translate('redirect.dashboard.slug_placeholder') ?>" value="<?= $redirect->getSlug() ?>">
                                        </div>
                                    </div>
                                    <div>
                                        <label for="target"><?= LangManager::translate('redirect.dashboard.target') ?> :</label>
                                        <div class="input-group">
                                            <i class="fa-solid fa-link"></i>
                                            <input type="url" id="target" name="target" autocomplete="off" maxlength="255"
                                                   required
                                                   placeholder="<?= LangManager::translate('redirect.dashboard.target_placeholder') ?>" value="<?= $redirect->getTarget() ?>">
                                        </div>
                                    </div>
                                    <div>
                                        <div>
                                            <label class="toggle">
                                                <p class="toggle-label"><?= LangManager::translate('redirect.dashboard.save_ip') ?></p>
                                                <input type="checkbox" class="toggle-input" id="storeIp" name="storeIp" <?= $redirect->isStoringIp() ? 'checked' : '' ?>>
                                                <div class="toggle-slider"></div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn-primary"><?= LangManager::translate('core.btn.save') ?></button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
