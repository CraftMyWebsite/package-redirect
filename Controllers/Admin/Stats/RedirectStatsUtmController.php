<?php

namespace CMW\Controller\Redirect\Admin\Stats;

use CMW\Controller\Users\UsersController;
use CMW\Manager\Package\AbstractController;
use CMW\Manager\Router\Link;
use CMW\Manager\Views\View;
use CMW\Model\Redirect\RedirectLogsModel;
use CMW\Model\Redirect\RedirectModel;
use CMW\Utils\Redirect;

/**
 * Class: @RedirectStatsUtmController
 * @package Redirect
 * @link https://craftmywebsite.fr/docs/fr/technical/creer-un-package/controllers
 */
class RedirectStatsUtmController extends AbstractController
{
    #[Link('/stats/utm', Link::GET, [], '/cmw-admin/redirect')]
    private function list(): void
    {
        UsersController::redirectIfNotHavePermissions('core.dashboard', 'redirect.stats');

        $redirects = RedirectModel::getInstance()->getRedirects();

        View::createAdminView('Redirect', 'Stats/Utm/list')
            ->addStyle('Admin/Resources/Assets/Css/simple-datatables.css')
            ->addScriptBefore('Admin/Resources/Vendors/Apexcharts/Js/apexcharts.js',
                'App/Package/Redirect/Views/Assets/Js/main.js')
            ->addScriptAfter('Admin/Resources/Vendors/Simple-datatables/simple-datatables.js',
                'Admin/Resources/Vendors/Simple-datatables/config-datatables.js')
            ->addVariableList(['redirects' => $redirects])
            ->view();
    }

    #[Link('/stats/utm/:redirectId', Link::GET, ['redirectId' => '[0-9]+'], '/cmw-admin/redirect')]
    private function item(int $redirectId): void
    {
        UsersController::redirectIfNotHavePermissions('core.dashboard', 'redirect.stats');

        $redirect = RedirectModel::getInstance()->getRedirectById($redirectId);

        if (is_null($redirect)) {
            Redirect::errorPage(404);
        }

        $utm = RedirectLogsModel::getInstance()->getRedirectUtm($redirectId);

        View::createAdminView('Redirect', 'Stats/Utm/item')
            ->addVariableList(['utm' => $utm, 'redirect' => $redirect])
            ->view();
    }
}
