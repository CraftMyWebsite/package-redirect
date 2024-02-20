<?php

namespace CMW\Controller\Redirect;

use CMW\Manager\Flash\Alert;
use CMW\Manager\Flash\Flash;
use CMW\Manager\Lang\LangManager;
use CMW\Manager\Package\AbstractController;
use CMW\Controller\users\UsersController;
use CMW\Manager\Requests\Request;
use CMW\Manager\Router\Link;
use CMW\Model\Redirect\RedirectLogsModel;
use CMW\Model\Redirect\RedirectModel;
use CMW\Manager\Views\View;
use CMW\Utils\Redirect;

/**
 * Class: @redirectController
 * @package redirect
 * @author Teyir
 * @version 1.0
 */
class RedirectController extends AbstractController
{
    #[Link(path: "/", method: Link::GET, scope: "/cmw-admin/redirect")]
    #[Link("/list", Link::GET, [], "/cmw-admin/redirect")]
    private function frontRedirectListAdmin(): void
    {
        UsersController::redirectIfNotHavePermissions("core.dashboard", "redirect.show");

        //Get all redirect
        $redirectList = redirectModel::getInstance()->getRedirects();


        View::createAdminView('Redirect', 'list')
            ->addStyle("Admin/Resources/Vendors/Simple-datatables/style.css", "Admin/Resources/Assets/Css/Pages/simple-datatables.css")
            ->addScriptAfter("Admin/Resources/Vendors/Simple-datatables/Umd/simple-datatables.js",
                "Admin/Resources/Assets/Js/Pages/simple-datatables.js")
            ->addVariableList(["redirectList" => $redirectList])
            ->view();
    }

    #[Link("/list", Link::GET, [], "/cmw-admin/redirect")]
    private function create(): void
    {
        UsersController::redirectIfNotHavePermissions("core.dashboard", "redirect.create");

        View::createAdminView('Redirect', 'list')
            ->addScriptBefore("App/Package/redirect/Views/Assets/Js/main.js")
            ->view();
    }

    #[Link("/list", Link::POST, [], "/cmw-admin/redirect")]
    private function createPost(): void
    {
        UsersController::redirectIfNotHavePermissions("core.dashboard", "redirect.create");


        if (redirectModel::getInstance()->checkName(filter_input(INPUT_POST, "name")) > 0) {

            Flash::send(Alert::ERROR, LangManager::translate("redirect.toast.title_error"),
                LangManager::translate("redirect.toast.create_error_name"));

            Redirect::redirectPreviousRoute();

        } elseif (redirectModel::getInstance()->checkSlug(filter_input(INPUT_POST, "slug")) > 0) {

            Flash::send(Alert::ERROR, LangManager::translate("redirect.toast.title_error"),
                LangManager::translate("redirect.toast.create_error_slug"));

            Redirect::redirectPreviousRoute();
        } else {

            $name = filter_input(INPUT_POST, "name");
            $slug = filter_input(INPUT_POST, "slug");
            $target = filter_input(INPUT_POST, "target", FILTER_SANITIZE_URL);

            redirectModel::getInstance()->createRedirect($name, $slug, $target);

            Flash::send(Alert::SUCCESS, LangManager::translate("redirect.toast.title_success"),
                LangManager::translate("redirect.toast.create_success"));

            Redirect::redirectPreviousRoute();
        }

    }

    #[Link("/edit/:id", Link::GET, ["id" => "[0-9]+"], "/cmw-admin/redirect")]
    private function edit(Request $request, int $id): void
    {
        UsersController::redirectIfNotHavePermissions("core.dashboard", "redirect.edit");

        $redirect = redirectModel::getInstance()->getRedirectById($id);

        View::createAdminView('Redirect', 'edit')
            ->addScriptBefore("App/Package/redirect/Views/Assets/Js/main.js")
            ->addVariableList(["redirect" => $redirect])
            ->view();
    }

    #[Link("/edit/:id", Link::POST, ["id" => "[0-9]+"], "/cmw-admin/redirect")]
    private function editPost(Request $request, int $id): void
    {
        UsersController::redirectIfNotHavePermissions("core.dashboard", "redirect.edit");


        if (redirectModel::getInstance()->checkNameEdit(filter_input(INPUT_POST, "name"), $id) > 0) {
            Flash::send(Alert::ERROR, LangManager::translate("redirect.toast.title_error"),
                LangManager::translate("redirect.toast.create_error_name"));


            Redirect::redirect("../edit/" . $id);

        } elseif (redirectModel::getInstance()->checkSlugEdit(filter_input(INPUT_POST, "slug"), $id) > 0) {

            Flash::send(Alert::ERROR, LangManager::translate("redirect.toast.title_error"),
                LangManager::translate("redirect.toast.create_error_slug"));

            Redirect::redirect("../edit/" . $id);
        } else {

            $name = filter_input(INPUT_POST, "name");
            $slug = filter_input(INPUT_POST, "slug");
            $target = filter_input(INPUT_POST, "target", FILTER_SANITIZE_URL);

            redirectModel::getInstance()->updateRedirect($id, $name, $slug, $target);

            Flash::send(Alert::SUCCESS, LangManager::translate("redirect.toast.title_success"),
                LangManager::translate("redirect.toast.edit_success"));

            Redirect::redirectPreviousRoute();
        }

    }

    #[Link("/delete/:id", Link::GET, ["id" => "[0-9]+"], "/cmw-admin/redirect")]
    private function delete(Request $request, int $id): void
    {
        UsersController::redirectIfNotHavePermissions("core.dashboard", "redirect.delete");


        redirectModel::getInstance()->deleteRedirect($id);

        Flash::send(Alert::SUCCESS, LangManager::translate("redirect.toast.title_success"),
            LangManager::translate("redirect.toast.delete_success"));

        Redirect::redirectPreviousRoute();
    }

    #[Link("/stats", Link::GET, [], "/cmw-admin/redirect")]
    private function stats(): void
    {
        UsersController::redirectIfNotHavePermissions("core.dashboard", "redirect.stats");


        $stats = redirectModel::getInstance()->getRedirects();

        $redirectionNumber = redirectModel::getInstance()->getNumberOfLines();

        $totalClicks = redirectModel::getInstance()->getTotalClicks();

        $allClicks = redirectLogsModel::getInstance()->getAllClicks();


        View::createAdminView('Redirect', 'stats')
            ->addScriptBefore("Admin/Resources/Vendors/Apexcharts/Js/apexcharts.js", "App/Package/Redirect/Views/Assets/Js/main.js")
            ->addVariableList(["allClicks" => $allClicks, "stats" => $stats, "redirectionNumber" => $redirectionNumber, "totalClicks" => $totalClicks])
            ->view();
    }

    /* //////////////////// PUBLIC //////////////////// */

    //Redirect
    #[Link("/r/:slug", Link::GET, ["slug" => ".*?"])]
    private function redirect(Request $request, string $slug): void
    {
        $entity = redirectModel::getInstance()->getRedirectBySlug($slug);

        redirectModel::getInstance()->redirect($entity?->getId());
    }

}
