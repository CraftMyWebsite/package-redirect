<?php

use CMW\Manager\Lang\LangManager;
use CMW\Utils\SecurityService;
use CMW\Utils\Utils;

$title = LangManager::translate("redirect.dashboard.title_edit");
$description = LangManager::translate("redirect.dashboard.desc_edit");

/* @var \CMW\Entity\Redirect\RedirectEntity $redirect */
?>


    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <form action="" method="post">
                        <?php (new SecurityService())->insertHiddenToken() ?>
                        <div class="card card-primary">

                            <div class="card-header">
                                <h3 class="card-title"><?= LangManager::translate("redirect.dashboard.title_edit") ?> :</h3>
                            </div>

                            <div class="card-body">

                                <label for="name"><?= LangManager::translate("redirect.dashboard.name") ?></label>
                                <div class="input-group mb-3">

                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-heading"></i></span>
                                    </div>
                                    <input type="text" value="<?= $redirect->getName() ?>" name="name"
                                           class="form-control"
                                           placeholder="<?= LangManager::translate("redirect.dashboard.name_placeholder") ?>" required>

                                </div>

                                <label class="mt-4" for="slug"><?= LangManager::translate("redirect.dashboard.slug") ?></label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><?= Utils::getHttpProtocol() . '://' . $_SERVER['SERVER_NAME'] . getenv("PATH_SUBFOLDER") . "r/" ?></span>
                                    </div>
                                    <input type="text" value="<?= $redirect->getSlug() ?>" name="slug"
                                           class="form-control"
                                           placeholder="<?= LangManager::translate("redirect.dashboard.slug_placeholder") ?>" required>
                                </div>
                                <small class="form-text"><?= LangManager::translate("redirect.dashboard.slug_hint") ?></small>

                                <label class="mt-4" for="target"><?= LangManager::translate("redirect.dashboard.target") ?></label>
                                <div class="input-group mb-3">

                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-link"></i></span>
                                    </div>
                                    <input type="text" value="<?= $redirect->getTarget() ?>" name="target"
                                           class="form-control"
                                           placeholder="<?= LangManager::translate("redirect.dashboard.target_placeholder") ?>" required>

                                </div>

                            </div>


                            <div class="card-footer">
                                <button type="submit"
                                        class="btn btn-primary float-right"><?= LangManager::translate("core.btn.save") ?></button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>