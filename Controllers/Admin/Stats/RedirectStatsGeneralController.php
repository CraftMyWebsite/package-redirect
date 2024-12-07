<?php

namespace CMW\Controller\Redirect\Admin\Stats;

use CMW\Controller\Users\UsersController;
use CMW\Manager\Package\AbstractController;
use CMW\Manager\Router\Link;
use CMW\Manager\Views\View;
use CMW\Model\Redirect\RedirectLogsModel;
use CMW\Model\Redirect\RedirectModel;

/**
 * Class: @RedirectStatsGeneralController
 * @package Redirect
 * @link https://craftmywebsite.fr/docs/fr/technical/creer-un-package/controllers
 */
class RedirectStatsGeneralController extends AbstractController
{
    #[Link('/stats/general', Link::GET, [], '/cmw-admin/redirect')]
    private function general(): void
    {
        UsersController::redirectIfNotHavePermissions('core.dashboard', 'redirect.stats');

        $stats = RedirectModel::getInstance()->getRedirects();

        $redirectionNumber = RedirectModel::getInstance()->getNumberOfLines();

        $totalClicks = RedirectModel::getInstance()->getTotalClicks();

        $allClicks = redirectLogsModel::getInstance()->getAllClicks();

        View::createAdminView('Redirect', 'Stats/general')
            ->addScriptBefore('Admin/Resources/Vendors/Apexcharts/Js/apexcharts.js',
                'App/Package/Redirect/Views/Assets/Js/main.js')
            ->addVariableList(['allClicks' => $allClicks, 'stats' => $stats,
                'redirectionNumber' => $redirectionNumber, 'totalClicks' => $totalClicks])
            ->view();
    }
}
