<?php

namespace CMW\Controller\Redirect;

use CMW\Controller\users\UsersController;
use CMW\Manager\Filter\FilterManager;
use CMW\Manager\Flash\Alert;
use CMW\Manager\Flash\Flash;
use CMW\Manager\Lang\LangManager;
use CMW\Manager\Package\AbstractController;
use CMW\Manager\Router\Link;
use CMW\Manager\Views\View;
use CMW\Model\Redirect\RedirectLogsModel;
use CMW\Model\Redirect\RedirectModel;
use CMW\Utils\Redirect;
use CMW\Utils\Website;
use JetBrains\PhpStorm\NoReturn;

/**
 * Class: @RedirectController
 * @package Redirect
 * @author Teyir
 * @version 1.0
 */
class RedirectController extends AbstractController
{
    #[Link(path: '/', method: Link::GET, scope: '/cmw-admin/redirect')]
    #[Link('/manage', Link::GET, [], '/cmw-admin/redirect')]
    private function frontRedirectListAdmin(): void
    {
        UsersController::redirectIfNotHavePermissions('core.dashboard', 'redirect.show');

        // Get all redirect
        $redirectList = RedirectModel::getInstance()->getRedirects();

        View::createAdminView('Redirect', 'list')
            ->addStyle('Admin/Resources/Assets/Css/simple-datatables.css')
            ->addScriptAfter('Admin/Resources/Vendors/Simple-datatables/simple-datatables.js',
                'Admin/Resources/Vendors/Simple-datatables/config-datatables.js')
            ->addVariableList(['redirectList' => $redirectList])
            ->view();
    }

    #[NoReturn]
    #[Link('/manage', Link::POST, [], '/cmw-admin/redirect')]
    private function createPost(): void
    {
        UsersController::redirectIfNotHavePermissions('core.dashboard', 'redirect.create');

        $name = FilterManager::filterInputStringPost('name');
        $slug = FilterManager::filterInputStringPost('slug');

        if (RedirectModel::getInstance()->isNameUsed($name)) {
            Flash::send(Alert::ERROR, LangManager::translate('redirect.toast.title_error'),
                LangManager::translate('redirect.toast.create_error_name'));

            Redirect::redirectPreviousRoute();
        }

        if (RedirectModel::getInstance()->isSlugUsed($slug)) {
            Flash::send(Alert::ERROR, LangManager::translate('redirect.toast.title_error'),
                LangManager::translate('redirect.toast.create_error_slug'));

            Redirect::redirectPreviousRoute();
        }

        $target = filter_input(INPUT_POST, 'target', FILTER_SANITIZE_URL);
        $isStoringIp = isset($_POST['storeIp']) ? 1 : 0;

        RedirectModel::getInstance()->createRedirect($name, $slug, $target, $isStoringIp);

        Flash::send(Alert::SUCCESS, LangManager::translate('redirect.toast.title_success'),
            LangManager::translate('redirect.toast.create_success'));

        Redirect::redirectPreviousRoute();
    }

    #[NoReturn]
    #[Link('/manage/edit/:id', Link::POST, ['id' => '[0-9]+'], '/cmw-admin/redirect')]
    private function editPost(int $id): void
    {
        UsersController::redirectIfNotHavePermissions('core.dashboard', 'redirect.edit');

        $name = FilterManager::filterInputStringPost('name');
        $slug = FilterManager::filterInputStringPost('slug');

        if (RedirectModel::getInstance()->checkNameEdit($name, $id) > 0) {
            Flash::send(Alert::ERROR, LangManager::translate('redirect.toast.title_error'),
                LangManager::translate('redirect.toast.create_error_name'));

            Redirect::redirectPreviousRoute();
        }

        if (RedirectModel::getInstance()->checkSlugEdit($slug, $id) > 0) {
            Flash::send(Alert::ERROR, LangManager::translate('redirect.toast.title_error'),
                LangManager::translate('redirect.toast.create_error_slug'));

            Redirect::redirectPreviousRoute();
        }

        $target = filter_input(INPUT_POST, 'target', FILTER_SANITIZE_URL);
        $isStoringIp = isset($_POST['storeIp']) ? 1 : 0;

        RedirectModel::getInstance()->updateRedirect($id, $name, $slug, $target, $isStoringIp);

        Flash::send(Alert::SUCCESS, LangManager::translate('redirect.toast.title_success'),
            LangManager::translate('redirect.toast.edit_success'));

        Redirect::redirectPreviousRoute();
    }

    #[NoReturn]
    #[Link('/manage/delete/:id', Link::GET, ['id' => '[0-9]+'], '/cmw-admin/redirect')]
    private function delete(int $id): void
    {
        UsersController::redirectIfNotHavePermissions('core.dashboard', 'redirect.delete');

        RedirectModel::getInstance()->deleteRedirect($id);

        Flash::send(Alert::SUCCESS, LangManager::translate('redirect.toast.title_success'),
            LangManager::translate('redirect.toast.delete_success'));

        Redirect::redirectPreviousRoute();
    }

    #[Link('/stats', Link::GET, [], '/cmw-admin/redirect')]
    private function stats(): void
    {
        UsersController::redirectIfNotHavePermissions('core.dashboard', 'redirect.stats');

        $stats = RedirectModel::getInstance()->getRedirects();

        $redirectionNumber = RedirectModel::getInstance()->getNumberOfLines();

        $totalClicks = RedirectModel::getInstance()->getTotalClicks();

        $allClicks = redirectLogsModel::getInstance()->getAllClicks();

        View::createAdminView('Redirect', 'stats')
            ->addScriptBefore('Admin/Resources/Vendors/Apexcharts/Js/apexcharts.js',
                'App/Package/Redirect/Views/Assets/Js/main.js')
            ->addVariableList(['allClicks' => $allClicks, 'stats' => $stats,
                'redirectionNumber' => $redirectionNumber, 'totalClicks' => $totalClicks])
            ->view();
    }

    /* //////////////////// PUBLIC //////////////////// */

    // Redirect
    #[Link('/r/:slug', Link::GET, ['slug' => '.*?'])]
    private function redirect(string $slug): void
    {
        // Check if slug exist
        $entity = RedirectModel::getInstance()->getRedirectBySlug($slug);
        if (is_null($entity)) {
            Redirect::redirectToHome();
        }

        // Increase counter
        RedirectModel::getInstance()->addClick($entity->getId());

        // Check if store @ip is enabled
        if ($entity->isStoringIp()) {
            $clientIp = Website::getClientIp();
        } else {
            $clientIp = null;
        }

        // Logs
        RedirectLogsModel::getInstance()->createLog($entity->getId(), $clientIp);

        // Redirect
        http_response_code(302);
        header('Location: ' . $entity->getTarget());
    }
}
