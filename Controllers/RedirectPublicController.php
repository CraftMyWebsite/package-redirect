<?php

namespace CMW\Controller\Redirect;

use CMW\Manager\Filter\FilterManager;
use CMW\Manager\Package\AbstractController;
use CMW\Manager\Router\Link;
use CMW\Model\Redirect\RedirectLogsModel;
use CMW\Model\Redirect\RedirectModel;
use CMW\Type\Redirect\Utm;
use CMW\Utils\Client;
use CMW\Utils\Redirect;

/**
 * Class: @RedirectPublicController
 * @package Redirect
 * @author Teyir
 * @link https://craftmywebsite.fr/docs/fr/technical/creer-un-package/controllers
 */
class RedirectPublicController extends AbstractController
{
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
            $clientIp = Client::getIp();
        } else {
            $clientIp = null;
        }

        // Logs
        $logId = RedirectLogsModel::getInstance()->createLog($entity->getId(), $clientIp);

        // Redirect
        http_response_code(302);
        header('Location: ' . $this->buildTargetUrl($logId, $entity->getTarget()));
    }

    /**
     * @return array
     * @desc Get UTM parameters, return empty array if not found
     */
    private function getUtm(): array
    {
        $toReturn = [];

        foreach ($_GET as $key => $value) {
            if (in_array($key, Utm::values(), false)) {
                $toReturn[$key] = FilterManager::filterData($value, 255);
            }
        }

        return $toReturn;
    }

    /**
     * @param int|null $logId
     * @param string $target
     * @return string
     * @desc Build target URL with UTM parameters
     */
    private function buildTargetUrl(?int $logId, string $target): string
    {
        $toReturn = $target;

        $utm = $this->getUtm();

        if (!empty($utm)) {

            $toReturn .= '?';
            foreach ($utm as $key => $value) {
                //Log the UTM parameters
                if (!is_null($logId)) {
                    RedirectLogsModel::getInstance()->storeUtm($logId, $key, $value);
                }

                $toReturn .= $key . '=' . $value . '&';
            }
            $toReturn = rtrim($toReturn, '&');
        }

        return $toReturn;
    }
}
