<?php

namespace CMW\Controller\Redirect;

use CMW\Controller\Core\CoreController;
use CMW\Controller\users\UsersController;
use CMW\Model\Redirect\RedirectLogsModel;
use CMW\Model\Redirect\RedirectModel;
use CMW\Router\Link;
use CMW\Utils\View;

/**
 * Class: @redirectController
 * @package redirect
 * @author Teyir
 * @version 1.0
 */
class RedirectController extends CoreController
{

    public static string $themePath;
    private RedirectModel $redirectModel;
    private RedirectLogsModel $redirectLogsModel;

    public function __construct($themePath = null)
    {
        parent::__construct($themePath);
        $this->redirectModel = new RedirectModel();
        $this->redirectLogsModel = new RedirectLogsModel();
    }

    #[Link(path: "/", method: Link::GET, scope: "/cmw-admin/redirect")]
    #[Link("/list", Link::GET, [], "/cmw-admin/redirect")]
    public function frontRedirectListAdmin(): void
    {
        UsersController::redirectIfNotHavePermissions("core.dashboard", "redirect.show");


        //Get all redirect
        $redirectList = $this->redirectModel->getRedirects();


        View::createAdminView('redirect', 'list')
            ->addStyle("admin/resources/vendors/simple-datatables/style.css","admin/resources/assets/css/pages/simple-datatables.css")
            ->addScriptAfter("admin/resources/vendors/simple-datatables/umd/simple-datatables.js",
                "admin/resources/assets/js/pages/simple-datatables.js")
            ->addVariableList(["redirectList" => $redirectList])
            ->view();
    }

    #[Link("/list", Link::GET, [], "/cmw-admin/redirect")]
    public function create(): void
    {
        UsersController::redirectIfNotHavePermissions("core.dashboard", "redirect.create");

        View::createAdminView('redirect', 'list')
            ->addScriptBefore("app/package/redirect/views/assets/js/main.js")
            ->view();
    }

    #[Link("/list", Link::POST, [], "/cmw-admin/redirect")]
    public function createPost(): void
    {
        UsersController::redirectIfNotHavePermissions("core.dashboard", "redirect.create");


        if ($this->redirectModel->checkName(filter_input(INPUT_POST, "name")) > 0) {

            $_SESSION['toaster'][0]['title'] = "REDIRECT_TOAST_TITLE_ERROR";
            $_SESSION['toaster'][0]['type'] = "bg-danger";
            $_SESSION['toaster'][0]['body'] = "REDIRECT_TOAST_CREATE_ERROR_NAME";

            header("location: ../redirect/list");

        } elseif ($this->redirectModel->checkSlug(filter_input(INPUT_POST, "slug")) > 0) {

            $_SESSION['toaster'][0]['title'] = "REDIRECT_TOAST_TITLE_ERROR";
            $_SESSION['toaster'][0]['type'] = "bg-danger";
            $_SESSION['toaster'][0]['body'] = "REDIRECT_TOAST_CREATE_ERROR_SLUG";

            header("location: ../redirect/list");
        } else {

            $name = filter_input(INPUT_POST, "name");
            $slug = filter_input(INPUT_POST, "slug");
            $target = filter_input(INPUT_POST, "target", FILTER_SANITIZE_URL);

            $this->redirectModel->createRedirect($name, $slug, $target);

            $_SESSION['toaster'][0]['title'] = "REDIRECT_TOAST_TITLE_SUCCESS";
            $_SESSION['toaster'][0]['type'] = "bg-success";
            $_SESSION['toaster'][0]['body'] = "REDIRECT_TOAST_CREATE_SUCCESS";

            header("location: ../redirect/list");
        }

    }

    #[Link("/edit/:id", Link::GET, ["id" => "[0-9]+"], "/cmw-admin/redirect")]
    public function edit(int $id): void
    {
        UsersController::redirectIfNotHavePermissions("core.dashboard", "redirect.edit");

        $redirect = $this->redirectModel->getRedirectById($id);

        View::createAdminView('redirect', 'edit')
            ->addScriptBefore("app/package/redirect/views/assets/js/main.js")
            ->addVariableList(["redirect" => $redirect])
            ->view();
    }

    #[Link("/edit/:id", Link::POST, ["id" => "[0-9]+"], "/cmw-admin/redirect")]
    public function editPost(int $id): void
    {
        UsersController::redirectIfNotHavePermissions("core.dashboard", "redirect.edit");


        if ($this->redirectModel->checkNameEdit(filter_input(INPUT_POST, "name"), $id) > 0) {
            $_SESSION['toaster'][0]['title'] = "REDIRECT_TOAST_TITLE_ERROR";
            $_SESSION['toaster'][0]['type'] = "bg-danger";
            $_SESSION['toaster'][0]['body'] = "REDIRECT_TOAST_CREATE_ERROR_NAME";

            header("location: ../edit/" . $id);

        } elseif ($this->redirectModel->checkSlugEdit(filter_input(INPUT_POST, "slug"), $id) > 0) {

            $_SESSION['toaster'][0]['title'] = "REDIRECT_TOAST_TITLE_ERROR";
            $_SESSION['toaster'][0]['type'] = "bg-danger";
            $_SESSION['toaster'][0]['body'] = "REDIRECT_TOAST_CREATE_ERROR_SLUG";

            header("location: ../edit/" . $id);
        } else {

            $name = filter_input(INPUT_POST, "name");
            $slug = filter_input(INPUT_POST, "slug");
            $target = filter_input(INPUT_POST, "target", FILTER_SANITIZE_URL);

            $this->redirectModel->updateRedirect($id, $name, $slug, $target);

            $_SESSION['toaster'][0]['title'] = "REDIRECT_TOAST_TITLE_SUCCESS";
            $_SESSION['toaster'][0]['type'] = "bg-success";
            $_SESSION['toaster'][0]['body'] = "REDIRECT_TOAST_EDIT_SUCCESS";

            header("location: ../list");
        }

    }

    #[Link("/delete/:id", Link::GET, ["id" => "[0-9]+"], "/cmw-admin/redirect")]
    public function delete(int $id): void
    {
        UsersController::redirectIfNotHavePermissions("core.dashboard", "redirect.delete");


        $this->redirectModel->deleteRedirect($id);

        $_SESSION['toaster'][0]['title'] = "REDIRECT_TOAST_TITLE_SUCCESS";
        $_SESSION['toaster'][0]['type'] = "bg-success";
        $_SESSION['toaster'][0]['body'] = "REDIRECT_TOAST_DELETE_SUCCESS";

        header("location: ../list");
    }

    #[Link("/stats", Link::GET, [], "/cmw-admin/redirect")]
    public function stats(): void
    {
        UsersController::redirectIfNotHavePermissions("core.dashboard", "redirect.stats");


        $stats = $this->redirectModel->getRedirects();

        $redirectionNumber = $this->redirectModel->getNumberOfLines();

        $totalClicks = $this->redirectModel->getTotalClicks();

        $allClicks = $this->redirectLogsModel->getAllClicks();


        View::createAdminView('redirect', 'stats')
            ->addScriptBefore("admin/resources/vendors/chart/chart.min.js", "app/package/redirect/views/assets/js/main.js")
            ->addVariableList(["allClicks" => $allClicks, "stats" => $stats, "redirectionNumber" => $redirectionNumber, "totalClicks" => $totalClicks])
            ->view();
    }

    /* //////////////////// PUBLIC //////////////////// */

    //Redirect
    #[Link("/r/:slug", Link::GET, ["slug" => ".*?"])]
    public function redirect(string $slug): void
    {
        $entity = $this->redirectModel->getRedirectBySlug($slug);

        $this->redirectModel->redirect($entity?->getId());
    }

}
