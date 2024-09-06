<?php

namespace CMW\Model\Redirect;

use CMW\Entity\Redirect\RedirectLogsEntity;
use CMW\Manager\Database\DatabaseManager;
use CMW\Manager\Package\AbstractModel;

/**
 * Class @RedirectLogsModel
 * @package Redirect
 * @author Teyir
 * @version 1.0
 */
class RedirectLogsModel extends AbstractModel
{
    /**
     * @param int $redirectId
     * @param string|null $clientIp
     * @return \CMW\Entity\Redirect\RedirectLogsEntity|null
     */
    public function createLog(int $redirectId, ?string $clientIp): ?RedirectLogsEntity
    {
        $sql = 'INSERT INTO cmw_redirect_logs (redirect_logs_redirect_id, redirect_logs_client_ip) VALUES (:redirect_id, :client_ip)';

        $db = DatabaseManager::getInstance();
        $req = $db->prepare($sql);

        if ($req->execute(['redirect_id' => $redirectId, 'client_ip' => $clientIp])) {
            $id = $db->lastInsertId();
            return $this->getRedirectLogsById($id);
        }

        return null;
    }

    /**
     * @param int $id
     * @return \CMW\Entity\Redirect\RedirectLogsEntity|null
     */
    public function getRedirectLogsById(int $id): ?RedirectLogsEntity
    {
        $sql = 'SELECT redirect_logs_id, redirect_logs_redirect_id, redirect_logs_date, redirect_logs_client_ip 
                FROM cmw_redirect_logs WHERE redirect_logs_id = :id';

        $db = DatabaseManager::getInstance();
        $res = $db->prepare($sql);

        if (!$res->execute(['id' => $id])) {
            return null;
        }

        $res = $res->fetch();

        if (!$res) {
            return null;
        }

        return new RedirectLogsEntity(
            $res['redirect_logs_id'],
            $res['redirect_logs_redirect_id'],
            $res['redirect_logs_date'],
            $res['redirect_logs_client_ip']
        );
    }

    /**
     * @return int
     */
    public function getAllClicks(): int
    {
        $sql = 'SELECT redirect_logs_id FROM cmw_redirect_logs';
        $db = DatabaseManager::getInstance();
        $req = $db->prepare($sql);

        if ($req->execute()) {
            $lines = $req->fetchAll();

            if (!$lines) {
                return 0;
            }

            return count($lines);
        }

        return 0;
    }
}
