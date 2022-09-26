<?php
use CMW\Manager\Lang\LangManager;

$title = LangManager::translate("redirect.dashboard.title");
$description = LangManager::translate("redirect.dashboard.desc");

$scripts = '
<script>
    $(function () {
        $("#users_table").DataTable({
            "responsive": true, 
            "lengthChange": false, 
            "autoWidth": false,
            language: {
                processing:     "' . LangManager::translate("core.datatables.list.processing") . '",
                search:         "' . LangManager::translate("core.datatables.list.search") . '",
                lengthMenu:    "' . LangManager::translate("core.datatables.list.lenghtmenu") . '",
                info:           "' . LangManager::translate("core.datatables.list.info") . '",
                infoEmpty:      "' . LangManager::translate("core.datatables.list.info_empty") . '",
                infoFiltered:   "' . LangManager::translate("core.datatables.list.info_filtered") . '",
                infoPostFix:    "' . LangManager::translate("core.datatables.list.info_postfix") . '",
                loadingRecords: "' . LangManager::translate("core.datatables.list.loadingrecords") . '",
                zeroRecords:    "' . LangManager::translate("core.datatables.list.zerorecords") . '",
                emptyTable:     "' . LangManager::translate("core.datatables.list.emptytable") . '",
                paginate: {
                    first:      "' . LangManager::translate("core.datatables.list.first") . '",
                    previous:   "' . LangManager::translate("core.datatables.list.previous") . '",
                    next:       "' . LangManager::translate("core.datatables.list.next") . '",
                    last:       "' . LangManager::translate("core.datatables.list.last") . '"
                },
                aria: {
                    sortAscending:  "' . LangManager::translate("core.datatables.list.sort.ascending") . '",
                    sortDescending: "' . LangManager::translate("core.datatables.list.sort.descending") . '"
                }
            },
        });
    });
</script>'; ?>

<div class="content">

    <div class="container-fluid">
        <div class="row">

            <div class="col-12">
                <div class="card">

                    <div class="card-header">
                        <h3 class="card-title"><?= LangManager::translate("redirect.dashboard.title") ?></h3>
                    </div>

                    <div class="card-body">

                        <table id="redirect_table" class="table table-bordered table-striped">

                            <thead>
                            <tr>
                                <th><?= LangManager::translate("redirect.list_table.id") ?></th>
                                <th><?= LangManager::translate("redirect.list_table.name") ?></th>
                                <th><?= LangManager::translate("redirect.list_table.slug") ?></th>
                                <th><?= LangManager::translate("redirect.list_table.target") ?></th>
                                <th><?= LangManager::translate("redirect.list_table.click") ?></th>
                                <th><?= LangManager::translate("redirect.list_table.edit") ?></th>
                            </tr>
                            </thead>

                            <tbody>
                            <?php /** @var \CMW\Entity\Redirect\RedirectEntity[] $redirectList */
                            foreach ($redirectList as $redirect) : ?>
                                <tr>
                                    <td><?= $redirect->getId() ?></td>
                                    <td><?= $redirect->getName() ?></td>
                                    <td><?= $redirect->getSlug() ?></td>
                                    <td><?= $redirect->getTarget() ?></td>
                                    <td><?= $redirect->getClick() ?></td>
                                    <td class="text-center">

                                        <a href="../redirect/edit/<?= $redirect->getId() ?>"
                                           class="btn btn-warning"><i class="fas fa-edit"></i></a>

                                        <a href="delete/<?= $redirect->getId() ?>" type="submit"
                                           class="btn btn-danger">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>


                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>

                            <tfoot>
                            <tr>
                                <th><?= LangManager::translate("redirect.list_table.id") ?></th>
                                <th><?= LangManager::translate("redirect.list_table.name") ?></th>
                                <th><?= LangManager::translate("redirect.list_table.slug") ?></th>
                                <th><?= LangManager::translate("redirect.list_table.target") ?></th>
                                <th><?= LangManager::translate("redirect.list_table.click") ?></th>
                                <th><?= LangManager::translate("redirect.list_table.edit") ?></th>
                            </tr>
                            </tfoot>

                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>