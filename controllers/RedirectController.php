<?php
namespace CMW\Controller\Redirect;

use CMW\Controller\CoreController;
use CMW\Controller\users\UsersController;
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

    public function __construct($themePath = null)
    {
        parent::__construct($themePath);
    }

    public function frontRedirectListAdmin(){
        UsersController::isUserHasPermission("redirect.show");
        $redirect = new RedirectModel();

        //Get all redirect
        $redirectList = $redirect->fetchAll();

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
        view('redirect', 'list.admin', ["redirect" => $redirect, "redirectList" => $redirectList], 'admin', $includes);
    }

    public function create(){
        UsersController::isUserHasPermission("redirect.create");

        $redirect = new RedirectModel();

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

        $redirect = new RedirectModel();


        if ($redirect->checkName(filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING)) > 0){

            $_SESSION['toaster'][0]['title'] = REDIRECT_TOAST_TITLE_ERROR;
            $_SESSION['toaster'][0]['type'] = "bg-danger";
            $_SESSION['toaster'][0]['body'] = REDIRECT_TOAST_CREATE_ERROR_NAME;

            header("location: ../redirect/add");

        } elseif ($redirect->checkSlug(filter_input(INPUT_POST, "slug", FILTER_SANITIZE_STRING)) > 0){

            $_SESSION['toaster'][0]['title'] = REDIRECT_TOAST_TITLE_ERROR;
            $_SESSION['toaster'][0]['type'] = "bg-danger";
            $_SESSION['toaster'][0]['body'] = REDIRECT_TOAST_CREATE_ERROR_SLUG;

            header("location: ../redirect/add");
        }
        else {

            $redirect->name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING);
            $redirect->slug = filter_input(INPUT_POST, "slug", FILTER_SANITIZE_STRING);
            $redirect->target = filter_input(INPUT_POST, "target", FILTER_SANITIZE_URL);

            $redirect->create();

            $_SESSION['toaster'][0]['title'] = REDIRECT_TOAST_TITLE_SUCCESS;
            $_SESSION['toaster'][0]['type'] = "bg-success";
            $_SESSION['toaster'][0]['body'] = REDIRECT_TOAST_CREATE_SUCCESS;

            header("location: ../redirect/list");
        }

    }

    public function edit($id){
        UsersController::isUserHasPermission("redirect.edit");

        $redirect = new RedirectModel();
        $redirect->fetch($id);

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


        $redirect = new RedirectModel();

        $redirect->id = $id;

        if ($redirect->checkNameEdit(filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING), $id) > 0){
            $_SESSION['toaster'][0]['title'] = REDIRECT_TOAST_TITLE_ERROR;
            $_SESSION['toaster'][0]['type'] = "bg-danger";
            $_SESSION['toaster'][0]['body'] = REDIRECT_TOAST_CREATE_ERROR_NAME;

            header("location: ../edit/".$redirect->id);

        } elseif ($redirect->checkSlugEdit(filter_input(INPUT_POST, "slug", FILTER_SANITIZE_STRING), $id) > 0){

            $_SESSION['toaster'][0]['title'] = REDIRECT_TOAST_TITLE_ERROR;
            $_SESSION['toaster'][0]['type'] = "bg-danger";
            $_SESSION['toaster'][0]['body'] = REDIRECT_TOAST_CREATE_ERROR_SLUG;

            header("location: ../edit/".$redirect->id);
        } else{

            $redirect->name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING);
            $redirect->slug = filter_input(INPUT_POST, "slug", FILTER_SANITIZE_STRING);
            $redirect->target = filter_input(INPUT_POST, "target", FILTER_SANITIZE_URL);

            $redirect->update();

            $_SESSION['toaster'][0]['title'] = REDIRECT_TOAST_TITLE_SUCCESS;
            $_SESSION['toaster'][0]['type'] = "bg-success";
            $_SESSION['toaster'][0]['body'] = REDIRECT_TOAST_EDIT_SUCCESS;

            header("location: ../list");
        }

    }

    public function delete($id){
        UsersController::isUserHasPermission("redirect.delete");

        $redirect = new RedirectModel();
        $redirect->id = $id;

        $redirect->delete();

        $_SESSION['toaster'][0]['title'] = REDIRECT_TOAST_TITLE_SUCCESS;
        $_SESSION['toaster'][0]['type'] = "bg-success";
        $_SESSION['toaster'][0]['body'] = REDIRECT_TOAST_DELETE_SUCCESS;

        header("location: ../list");
    }

    public function stats(){
        UsersController::isUserHasPermission("redirect.stats");
        $redirect = new RedirectModel();

        $stats = $redirect->getStats();

        $number = $redirect->getNumberOfLines();

        $redirect->getTotalClicks();

        $redirect->getAllClicks();

        $includes = array(
            "scripts" => [
                "before" => [
                    "admin/resources/vendors/chart.js/Chart.min.js",
                    "app/package/redirect/views/assets/js/main.js"
                ]
            ]
        );

        view('redirect', 'stats.admin', ["redirect" => $redirect, "stats" => $stats,
            "number" => $number], 'admin', $includes);
    }

    /* //////////////////// PUBLIC //////////////////// */

    //Redirect
    public function redirect($slug){
        $core = new CoreController();

        $redirect = new RedirectModel();

        $redirect->fetchWithSlug($slug);

        $redirect->redirect($redirect->id);
    }

}