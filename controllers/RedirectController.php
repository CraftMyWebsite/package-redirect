<?php
namespace CMW\Controller\Redirect;

use CMW\Controller\CoreController;
use CMW\Controller\users\UsersController;
use CMW\Model\Redirect\RedirectLogsModel;
use CMW\Model\Redirect\RedirectModel;

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

    public function frontRedirectListAdmin(){
        UsersController::isUserHasPermission("redirect.show");


        //Get all redirect
        $redirectList = $this->redirectModel->getRedirects();

        $includes = array(
            "scripts" => [
                "before" => [
                    "admin/resources/vendors/bootstrap/js/bootstrap.bundle.min.js",
                    "admin/resources/vendors/datatables/jquery.dataTables.min.js",
                    "admin/resources/vendors/datatables-bs4/js/dataTables.bootstrap4.min.js",
                    "admin/resources/vendors/datatables-responsive/js/dataTables.responsive.min.js",
                    "admin/resources/vendors/datatables-responsive/js/responsive.bootstrap4.min.js",
                    "admin/resources/vendors/datatables-buttons/js/dataTables.buttons.min.js",

                ]
            ],
            "styles" => [
                "admin/resources/vendors/datatables-bs4/css/dataTables.bootstrap4.min.css",
                "admin/resources/vendors/datatables-responsive/css/responsive.bootstrap4.min.css"
            ]);


        //Include the view file ("views/list.admin.view.php").
        view('redirect', 'list.admin', ["redirectList" => $redirectList], 'admin', $includes);
    }

    public function create(){
        UsersController::isUserHasPermission("redirect.create");

        $includes = array(
            "scripts" => [
                "before" => [
                    "app/package/redirect/views/assets/js/main.js"
                ]
            ]
        );

        view('redirect', 'add.admin', [], 'admin', $includes);
    }

    public function createPost(){
        UsersController::isUserHasPermission("redirect.create");


        if ($this->redirectModel->checkName(filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING)) > 0){

            $_SESSION['toaster'][0]['title'] = REDIRECT_TOAST_TITLE_ERROR;
            $_SESSION['toaster'][0]['type'] = "bg-danger";
            $_SESSION['toaster'][0]['body'] = REDIRECT_TOAST_CREATE_ERROR_NAME;

            header("location: ../redirect/add");

        } elseif ($this->redirectModel->checkSlug(filter_input(INPUT_POST, "slug", FILTER_SANITIZE_STRING)) > 0){

            $_SESSION['toaster'][0]['title'] = REDIRECT_TOAST_TITLE_ERROR;
            $_SESSION['toaster'][0]['type'] = "bg-danger";
            $_SESSION['toaster'][0]['body'] = REDIRECT_TOAST_CREATE_ERROR_SLUG;

            header("location: ../redirect/add");
        }
        else {

            $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING);
            $slug = filter_input(INPUT_POST, "slug", FILTER_SANITIZE_STRING);
            $target = filter_input(INPUT_POST, "target", FILTER_SANITIZE_URL);

            $this->redirectModel->createRedirect($name, $slug, $target);

            $_SESSION['toaster'][0]['title'] = REDIRECT_TOAST_TITLE_SUCCESS;
            $_SESSION['toaster'][0]['type'] = "bg-success";
            $_SESSION['toaster'][0]['body'] = REDIRECT_TOAST_CREATE_SUCCESS;

            header("location: ../redirect/list");
        }

    }

    public function edit($id){
        UsersController::isUserHasPermission("redirect.edit");

        $redirect = $this->redirectModel->getRedirectById($id);

        $includes = array(
            "scripts" => [
                "before" => [
                    "app/package/redirect/views/assets/js/main.js"
                ]
            ]
        );

        view('redirect', 'edit.admin', ["redirect" => $redirect], 'admin', $includes);
    }

    public function editPost($id){
        UsersController::isUserHasPermission("redirect.edit");


        if ($this->redirectModel->checkNameEdit(filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING), $id) > 0){
            $_SESSION['toaster'][0]['title'] = REDIRECT_TOAST_TITLE_ERROR;
            $_SESSION['toaster'][0]['type'] = "bg-danger";
            $_SESSION['toaster'][0]['body'] = REDIRECT_TOAST_CREATE_ERROR_NAME;

            header("location: ../edit/". $id);

        } elseif ($this->redirectModel->checkSlugEdit(filter_input(INPUT_POST, "slug", FILTER_SANITIZE_STRING), $id) > 0){

            $_SESSION['toaster'][0]['title'] = REDIRECT_TOAST_TITLE_ERROR;
            $_SESSION['toaster'][0]['type'] = "bg-danger";
            $_SESSION['toaster'][0]['body'] = REDIRECT_TOAST_CREATE_ERROR_SLUG;

            header("location: ../edit/". $id);
        } else{

            $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING);
            $slug = filter_input(INPUT_POST, "slug", FILTER_SANITIZE_STRING);
            $target = filter_input(INPUT_POST, "target", FILTER_SANITIZE_URL);

            $this->redirectModel->updateRedirect($id, $name, $slug, $target);

            $_SESSION['toaster'][0]['title'] = REDIRECT_TOAST_TITLE_SUCCESS;
            $_SESSION['toaster'][0]['type'] = "bg-success";
            $_SESSION['toaster'][0]['body'] = REDIRECT_TOAST_EDIT_SUCCESS;

            header("location: ../list");
        }

    }

    public function delete($id){
        UsersController::isUserHasPermission("redirect.delete");


        $this->redirectModel->deleteRedirect($id);

        $_SESSION['toaster'][0]['title'] = REDIRECT_TOAST_TITLE_SUCCESS;
        $_SESSION['toaster'][0]['type'] = "bg-success";
        $_SESSION['toaster'][0]['body'] = REDIRECT_TOAST_DELETE_SUCCESS;

        header("location: ../list");
    }

    public function stats(){
        UsersController::isUserHasPermission("redirect.stats");


        $stats = $this->redirectModel->getRedirects();

        $redirectionNumber = $this->redirectModel->getNumberOfLines();

        $totalClicks = $this->redirectModel->getTotalClicks();

        $allClicks = $this->redirectLogsModel->getAllClicks();

        $includes = array(
            "scripts" => [
                "before" => [
                    "admin/resources/vendors/chart.js/Chart.min.js",
                    "app/package/redirect/views/assets/js/main.js"
                ]
            ]
        );

        view('redirect', 'stats.admin', ["allClicks" => $allClicks, "stats" => $stats,
            "redirectionNumber" => $redirectionNumber, "totalClicks" => $totalClicks], 'admin', $includes);
    }

    /* //////////////////// PUBLIC //////////////////// */

    //Redirect
    public function redirect($slug){
        $entity = $this->redirectModel->getRedirectBySlug($slug);

        $this->redirectModel->redirect($entity->getId());
    }

}