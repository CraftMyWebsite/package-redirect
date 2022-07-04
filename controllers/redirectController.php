<?php
namespace CMW\Controller\Redirect;

use CMW\Controller\CoreController;
use CMW\Controller\users\UsersController;
use CMW\Model\Redirect\redirectModel;

/**
 * Class: @redirectController
 * @package redirect
 * @author Teyir
 * @version 1.0
 */

class redirectController extends CoreController
{

    public static string $themePath;

    public function __construct($themePath = null)
    {
        parent::__construct($themePath);
    }

    public function frontRedirectListAdmin(){
        UsersController::isUserHasPermission("redirect.show");
        $redirect = new redirectModel();

        //Get all redirect
        $redirectList = $redirect->fetchAll();

        //Include the view file ("views/list.admin.view.php").
        view('redirect', 'list.admin', ["redirect" => $redirect, "redirectList" => $redirectList], 'admin');
    }

    public function create(){
        UsersController::isUserHasPermission("redirect.create");

        $redirect = new redirectModel();


        view('redirect', 'add.admin', [], 'admin');
    }

    public function createPost(){
        UsersController::isUserHasPermission("redirect.create");

        $redirect = new redirectModel();


        if ($redirect->checkName(filter_input(INPUT_POST, "name")) > 0){

            $_SESSION['toaster'][0]['title'] = REDIRECT_TOAST_TITLE_ERROR;
            $_SESSION['toaster'][0]['type'] = "bg-danger";
            $_SESSION['toaster'][0]['body'] = REDIRECT_TOAST_CREATE_ERROR_NAME;

            header("location: ../redirect/add");

        } elseif ($redirect->checkSlug(filter_input(INPUT_POST, "slug")) > 0){

            $_SESSION['toaster'][0]['title'] = REDIRECT_TOAST_TITLE_ERROR;
            $_SESSION['toaster'][0]['type'] = "bg-danger";
            $_SESSION['toaster'][0]['body'] = REDIRECT_TOAST_CREATE_ERROR_SLUG;

            header("location: ../redirect/add");
        }
        else {

            $redirect->name = filter_input(INPUT_POST, "name");
            $redirect->slug = filter_input(INPUT_POST, "slug");
            $redirect->target = filter_input(INPUT_POST, "target");

            $redirect->create();

            $_SESSION['toaster'][0]['title'] = REDIRECT_TOAST_TITLE_SUCCESS;
            $_SESSION['toaster'][0]['type'] = "bg-success";
            $_SESSION['toaster'][0]['body'] = REDIRECT_TOAST_CREATE_SUCCESS;

            header("location: ../redirect/list");
        }

    }

    public function edit($id){
        UsersController::isUserHasPermission("redirect.edit");

        $redirect = new redirectModel();
        $redirect->fetch($id);


        view('redirect', 'edit.admin', ["redirect" => $redirect], 'admin');
    }

    public function editPost($id){
        UsersController::isUserHasPermission("redirect.edit");


        $redirect = new redirectModel();

        $redirect->id = $id;

        if ($redirect->checkNameEdit(filter_input(INPUT_POST, "name"), $id) > 0){
            $_SESSION['toaster'][0]['title'] = REDIRECT_TOAST_TITLE_ERROR;
            $_SESSION['toaster'][0]['type'] = "bg-danger";
            $_SESSION['toaster'][0]['body'] = REDIRECT_TOAST_CREATE_ERROR_NAME;

            header("location: ../edit/".$redirect->id);

        } elseif ($redirect->checkSlugEdit(filter_input(INPUT_POST, "slug"), $id) > 0){

            $_SESSION['toaster'][0]['title'] = REDIRECT_TOAST_TITLE_ERROR;
            $_SESSION['toaster'][0]['type'] = "bg-danger";
            $_SESSION['toaster'][0]['body'] = REDIRECT_TOAST_CREATE_ERROR_SLUG;

            header("location: ../edit/".$redirect->id);
        } else{

            $redirect->name = filter_input(INPUT_POST, "name");
            $redirect->slug = filter_input(INPUT_POST, "slug");
            $redirect->target = filter_input(INPUT_POST, "target");

            $redirect->update();

            $_SESSION['toaster'][0]['title'] = REDIRECT_TOAST_TITLE_SUCCESS;
            $_SESSION['toaster'][0]['type'] = "bg-success";
            $_SESSION['toaster'][0]['body'] = REDIRECT_TOAST_EDIT_SUCCESS;

            header("location: ../list");
        }

    }

    public function delete($id){
        UsersController::isUserHasPermission("redirect.delete");

        $redirect = new redirectModel();
        $redirect->id = $id;

        $redirect->delete();

        $_SESSION['toaster'][0]['title'] = REDIRECT_TOAST_TITLE_SUCCESS;
        $_SESSION['toaster'][0]['type'] = "bg-success";
        $_SESSION['toaster'][0]['body'] = REDIRECT_TOAST_DELETE_SUCCESS;

        header("location: ../list");
    }

    public function stats(){
        UsersController::isUserHasPermission("redirect.stats");
        $redirect = new redirectModel();

        $stats = $redirect->getStats();

        $number = $redirect->getNumberOfLines();

        $redirect->getTotalClicks();

        $redirect->getAllClicks();

        view('redirect', 'stats.admin', ["redirect" => $redirect, "stats" => $stats, "number" => $number], 'admin');
    }

    /* //////////////////// PUBLIC //////////////////// */

    //Redirect
    public function redirect($slug){
        $core = new CoreController();

        $redirect = new redirectModel();

        $redirect->fetchWithSlug($slug);

        $redirect->redirect($redirect->id);
    }

}