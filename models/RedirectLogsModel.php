<?php

namespace CMW\Model\Redirect;

use CMW\Entity\Redirect\RedirectLogsEntity;
use CMW\Manager\Database\DatabaseManager;
use CMW\Utils\Utils;

/**
 * Class @redirectLogsModel
 * @package Redirect
 * @author Teyir
 * @version 1.0
 */
class RedirectLogsModel extends DatabaseManager
{
    public function createLog($id): ?RedirectLogsEntity
    {

        $sql = "INSERT INTO cmw_redirect_logs (redirect_logs_redirect_id, redirect_logs_client_ip) VALUES (:redirect_id, :client_ip)";

        $db = self::getInstance();
        $req = $db->prepare($sql);

        if ($req->execute(array("redirect_id" => $id, "client_ip" => Utils::getClientIp()))) {
            $id = $db->lastInsertId();
            return $this->getRedirectLogsById($id);
        }

        return null;
    }

    public function getRedirectLogsById(int $id): ?RedirectLogsEntity
    {
        $sql = "SELECT redirect_logs_id, redirect_logs_redirect_id, redirect_logs_date, redirect_logs_client_ip 
                FROM cmw_redirect_logs WHERE redirect_logs_id = :id";

        $db = self::getInstance();
        $res = $db->prepare($sql);

        if (!$res->execute(array("id" => $id))) {
            return null;
        }

        $res = $res->fetch();

        return new RedirectLogsEntity(
          $res['redirect_logs_id'],
            $res['redirect_logs_redirect_id'],
            $res['redirect_logs_date'],
            $res['redirect_logs_client_ip']
        );
    }

    public function getAllClicks(): int
    {
        $sql = "SELECT redirect_logs_id FROM cmw_redirect_logs";
        $db = self::getInstance();
        $req = $db->prepare($sql);

        if ($req->execute()) {
            $lines = $req->fetchAll();

            return count($lines);
        }

        return 0;
    }
}