<?php

use CMW\Manager\Env\EnvManager;
use CMW\Manager\Lang\LangManager;
use CMW\Manager\Security\SecurityManager;
use CMW\Utils\Website;

$title = LangManager::translate("redirect.dashboard.title_edit");
$description = LangManager::translate("redirect.dashboard.desc_edit");

/* @var \CMW\Entity\Redirect\RedirectEntity $redirect */
?>
<div class="d-flex flex-wrap justify-content-between">
    <h3><i class="fa-solid fa-gears"></i> <span
            class="m-lg-auto"><?= LangManager::translate("redirect.dashboard.title_edit") ?></span></h3>
    <div class="buttons">
        <button form="edit" type="submit"
                class="btn btn-primary"><?= LangManager::translate("core.btn.save", lineBreak: true) ?></button>
    </div>
</div>

<section class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4><?= LangManager::translate("redirect.dashboard.title_edit") ?></h4>
            </div>
            <div class="card-body">
                <form id="edit" action="" method="post" enctype="multipart/form-data">
                    <?php (new SecurityManager())->insertHiddenToken() ?>
                    <div class="row">
                        <div class="col-md-6">
                            <h6><?= LangManager::translate("redirect.dashboard.name") ?> :</h6>
                            <div class="form-group position-relative has-icon-left">
                                <input type="text" name="name" class="form-control" value="<?= $redirect->getName() ?>"
                                       placeholder="<?= LangManager::translate("redirect.dashboard.name_placeholder") ?>"
                                       required>
                                <div class="form-control-icon">
                                    <i class="fas fa-heading"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6><?= LangManager::translate("redirect.dashboard.slug") ?> :</h6>
                            <div class="input-group mb-3">
                                <span
                                    class="input-group-text"><?= Website::getProtocol() . '://' . $_SERVER['SERVER_NAME'] . EnvManager::getInstance()->getValue("PATH_SUBFOLDER") . "r/" ?></span>
                                <input type="text" name="slug" value="<?= $redirect->getSlug() ?>"
                                       placeholder="<?= LangManager::translate("redirect.dashboard.slug_placeholder") ?>"
                                       class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6><?= LangManager::translate("redirect.dashboard.target") ?> :</h6>
                            <div class="form-group position-relative has-icon-left">
                                <input type="text" value="<?= $redirect->getTarget() ?>" name="target"
                                       class="form-control"
                                       placeholder="<?= LangManager::translate("redirect.dashboard.target_placeholder") ?>"
                                       required>
                                <div class="form-control-icon">
                                    <i class="fa-solid fa-circle-info"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 align-self-center">
                            <div class="form-check form-switch">
                                <label class="form-check-label" for="storeIp"><?= LangManager::translate('redirect.dashboard.save_ip') ?></label>
                                <input class="form-check-input" type="checkbox" id="storeIp"
                                       name="storeIp" <?= $redirect->isStoringIp() ? 'checked' : '' ?>>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>