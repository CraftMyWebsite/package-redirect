<?php
$title = REDIRECT_DASHBOARD_TITLE;
$description = REDIRECT_DASHBOARD_DESC;

$scripts = '
<script>
    $(function () {
        $("#redirect_table").DataTable({
            "responsive": true, 
            "lengthChange": false, 
            "autoWidth": false,
            language: {
                processing:     "' . CORE_DATATABLES_LIST_PROCESSING . '",
                search:         "' . CORE_DATATABLES_LIST_SEARCH . '",
                lengthMenu:     "' . CORE_DATATABLES_LIST_LENGTHMENU . '",
                info:           "' . CORE_DATATABLES_LIST_INFO . '",
                infoEmpty:      "' . CORE_DATATABLES_LIST_INFOEMPTY . '",
                infoFiltered:   "' . CORE_DATATABLES_LIST_INFOFILTERED . '",
                infoPostFix:    "' . CORE_DATATABLES_LIST_INFOPOSTFIX . '",
                loadingRecords: "' . CORE_DATATABLES_LIST_LOADINGRECORDS . '",
                zeroRecords:    "' . CORE_DATATABLES_LIST_ZERORECORDS . '",
                emptyTable:     "' . CORE_DATATABLES_LIST_EMPTYTABLE . '",
                paginate: {
                    first:      "' . CORE_DATATABLES_LIST_FIRST . '",
                    previous:   "' . CORE_DATATABLES_LIST_PREVIOUS . '",
                    next:       "' . CORE_DATATABLES_LIST_NEXT . '",
                    last:       "' . CORE_DATATABLES_LIST_LAST . '"
                },
                aria: {
                    sortAscending:  "' . CORE_DATATABLES_LIST_SORTASCENDING . '",
                    sortDescending: "' . CORE_DATATABLES_LIST_SORTDESCENDING . '"
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
                        <h3 class="card-title"><?= REDIRECT_DASHBOARD_TITLE ?></h3>
                    </div>

                    <div class="card-body">

                        <table id="redirect_table" class="table table-bordered table-striped">

                            <thead>
                            <tr>
                                <th><?= REDIRECT_LIST_TABLE_ID ?></th>
                                <th><?= REDIRECT_LIST_TABLE_NAME ?></th>
                                <th><?= REDIRECT_LIST_TABLE_SLUG ?></th>
                                <th><?= REDIRECT_LIST_TABLE_TARGET ?></th>
                                <th><?= REDIRECT_LIST_TABLE_CLICK ?></th>
                                <th><?= REDIRECT_LIST_TABLE_EDIT ?></th>
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
                                <th><?= REDIRECT_LIST_TABLE_ID ?></th>
                                <th><?= REDIRECT_LIST_TABLE_NAME ?></th>
                                <th><?= REDIRECT_LIST_TABLE_SLUG ?></th>
                                <th><?= REDIRECT_LIST_TABLE_TARGET ?></th>
                                <th><?= REDIRECT_LIST_TABLE_CLICK ?></th>
                                <th><?= REDIRECT_LIST_TABLE_EDIT ?></th>
                            </tr>
                            </tfoot>

                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>