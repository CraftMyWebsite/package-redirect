<?php
use CMW\Manager\Lang\LangManager;
use CMW\Utils\SecurityService;
use CMW\Utils\Utils;
$title = LangManager::translate("redirect.dashboard.title");
$description = LangManager::translate("redirect.dashboard.desc");

?>



<div class="d-flex flex-wrap justify-content-between">
    <h3><i class="fa-solid fa-sliders"></i> <span class="m-lg-auto"><?= LangManager::translate("redirect.dashboard.desc") ?></span></h3>
</div>

<section class="row">
    <div class="col-12 col-lg-4">
        <div class="card">
            <div class="card-header">
                <h4><?= LangManager::translate("redirect.dashboard.title_add") ?></h4>
            </div>
            <div class="card-body">
                <form method="post" action="">
                    <?php (new SecurityService())->insertHiddenToken() ?>
                    <h6><?= LangManager::translate("redirect.dashboard.name") ?> :</h6>
                    <div class="form-group position-relative has-icon-left">
                        <input type="text" class="form-control" name="name" required autocomplete="off"
                               placeholder="<?= LangManager::translate("redirect.dashboard.name_placeholder") ?>">
                        <div class="form-control-icon">
                            <i class="fas fa-heading"></i>
                        </div>
                    </div>
                    <h6><?= LangManager::translate("redirect.dashboard.slug") ?> :</h6>
                    <div class="input-group mb-3">
                        <span class="input-group-text" ><?= Utils::getHttpProtocol() . '://' . $_SERVER['SERVER_NAME'] . getenv("PATH_SUBFOLDER") . "r/" ?></span>
                        <input type="text" name="slug" class="form-control" placeholder="<?= LangManager::translate("redirect.dashboard.slug_placeholder") ?>">
                    </div>
                    <h6><?= LangManager::translate("redirect.dashboard.target") ?> :</h6>
                    <div class="form-group position-relative has-icon-left">
                        <input type="text" class="form-control" name="target" autocomplete="off"
                               placeholder="<?= LangManager::translate("redirect.dashboard.target_placeholder") ?>">
                        <div class="form-control-icon">
                            <i class="fas fa-link"></i>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit"
                                class="btn btn-primary"><?= LangManager::translate("core.btn.add") ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-8">
        <div class="card">
            <div class="card-header">
                <h4><?= LangManager::translate("redirect.dashboard.title") ?></h4>
            </div>
            <div class="card-body">
                <table class="table" id="table1">
                    <thead>
                    <tr>
                        <th class="text-center"><?= LangManager::translate("redirect.list_table.id") ?></th>
                        <th class="text-center"><?= LangManager::translate("redirect.list_table.name") ?></th>
                        <th class="text-center"><?= LangManager::translate("redirect.list_table.slug") ?></th>
                        <th class="text-center"><?= LangManager::translate("redirect.list_table.target") ?></th>
                        <th class="text-center"><?= LangManager::translate("redirect.list_table.click") ?></th>
                        <th class="text-center"><?= LangManager::translate("redirect.list_table.edit") ?></th>
                    </tr>
                    </thead>
                    <tbody class="text-center">
                    <?php /** @var \CMW\Entity\Redirect\RedirectEntity[] $redirectList */
                    foreach ($redirectList as $redirect) : ?>
                        <tr>
                            <td><?= $redirect->getId() ?></td>
                            <td><?= $redirect->getName() ?></td>
                            <td><a href="<?= Utils::getHttpProtocol() . '://' . $_SERVER['SERVER_NAME'] . getenv("PATH_SUBFOLDER") . "r/" ?><?= $redirect->getSlug() ?>" target="_blank"><?= Utils::getHttpProtocol() . '://' . $_SERVER['SERVER_NAME'] . getenv("PATH_SUBFOLDER") . "r/" ?><?= $redirect->getSlug() ?></a></td>
                            <td><?= $redirect->getTarget() ?></td>
                            <td><?= $redirect->getClick() ?></td>
                            <td>
                                <a href="../redirect/edit/<?= $redirect->getId() ?>">
                                    <i class="text-primary me-3 fas fa-edit"></i>
                                </a>
                                <a href="delete/<?= $redirect->getId() ?>">
                                    <i class="text-danger fas fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>