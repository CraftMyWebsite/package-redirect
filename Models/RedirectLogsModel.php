<?php

namespace CMW\Model\Redirect;

use CMW\Entity\Redirect\RedirectLogsEntity;
use CMW\Entity\Redirect\RedirectUtmEntity;
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
     * @return int|null
     */
    public function createLog(int $redirectId, ?string $clientIp): ?int
    {
        $sql = 'INSERT INTO cmw_redirect_logs (redirect_id, client_ip) VALUES (:redirect_id, :client_ip)';

        $db = DatabaseManager::getInstance();
        $req = $db->prepare($sql);

        if (!$req->execute(['redirect_id' => $redirectId, 'client_ip' => $clientIp])) {
            return null;
        }

        return $db->lastInsertId();
    }

    /**
     * @param int $id
     * @return RedirectLogsEntity|null
     */
    public function getRedirectLogsById(int $id): ?RedirectLogsEntity
    {
        $sql = 'SELECT id, redirect_id, date, client_ip 
                FROM cmw_redirect_logs WHERE id = :id';

        $db = DatabaseManager::getInstance();
        $res = $db->prepare($sql);

        if (!$res->execute(['id' => $id])) {
            return null;
        }

        $res = $res->fetch();

        if (!$res) {
            return null;
        }

        //TODO IMPROVE THAT
        return new RedirectLogsEntity(
            $res['id'],
            $res['redirect_id'],
            $res['date'],
            $res['client_ip']
        );
    }

    /**
     * @return int
     */
    public function getAllClicks(): int
    {
        $sql = 'SELECT id FROM cmw_redirect_logs';
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

    /**
     * @param int $logId
     * @param string $key
     * @param string $value
     * @return bool
     * @desc Store UTM in logs_utm
     */
    public function storeUtm(int $logId, string $key, string $value): bool
    {
        $data = [
            'log_id' => $logId,
            'key' => $key,
            'value' => $value,
        ];

        $sql = "INSERT INTO cmw_redirect_logs_utm (log_id, `key`, value) 
                    VALUES (:log_id, :key, :value)";
        $db = DatabaseManager::getInstance();
        return $db->prepare($sql)->execute($data);
    }

    /**
     * @param int $redirectId
     * @return RedirectUtmEntity[]
     */
    public function getRedirectUtm(int $redirectId): array
    {
        $sql = "SELECT * FROM cmw_redirect_logs_utm 
                JOIN cmw.cmw_redirect_logs crl on cmw_redirect_logs_utm.log_id = crl.id
                WHERE crl.redirect_id = :redirect_id";
        $db = DatabaseManager::getInstance();
        $req = $db->prepare($sql);

        if (!$req->execute(['redirect_id' => $redirectId])) {
            return [];
        }

        $res = $req->fetchAll();

        if (!$res) {
            return [];
        }

        return RedirectUtmEntity::toEntityList($res);
    }
}
