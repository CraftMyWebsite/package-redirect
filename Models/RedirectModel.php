<?php

namespace CMW\Model\Redirect;

use CMW\Entity\Redirect\RedirectEntity;
use CMW\Manager\Database\DatabaseManager;
use CMW\Manager\Package\AbstractModel;

/**
 * Class @redirectModel
 * @package Redirect
 * @author Teyir
 * @version 1.0
 */
class RedirectModel extends AbstractModel
{

    public function createRedirect(string $name, string $slug, string $target): ?RedirectEntity
    {
        $var = array(
            "name" => $name,
            "slug" => $slug,
            "target" => $target
        );

        $sql = "INSERT INTO cmw_redirect (redirect_name, redirect_slug, redirect_target) VALUES (:name, :slug, :target)";

        $db = DatabaseManager::getInstance();
        $req = $db->prepare($sql);

        if ($req->execute($var)) {
            $id = $db->lastInsertId();
            return $this->getRedirectById($id);
        }

        return null;

    }

    /**
     * @return RedirectEntity[]
     */
    public function getRedirects(): array
    {

        $sql = "SELECT * FROM cmw_redirect";
        $db = DatabaseManager::getInstance();
        $res = $db->prepare($sql);

        if (!$res->execute()) {
            return array();
        }

        $toReturn = array();

        while ($redirect = $res->fetch()) {
            $toReturn[] = $this->getRedirectById($redirect["redirect_id"]);
        }

        return $toReturn;
    }

    public function getRedirectById($id): ?RedirectEntity
    {


        $sql = "SELECT * FROM cmw_redirect WHERE redirect_id=:id";

        $db = DatabaseManager::getInstance();
        $res = $db->prepare($sql);

        if (!$res->execute(array("id" => $id))) {
            return null;
        }

        $res = $res->fetch();

        return new RedirectEntity(
            $res['redirect_id'],
            $res['redirect_name'],
            $res['redirect_slug'],
            $res['redirect_target'],
            $res['redirect_click'],
            $res['redirect_is_define'],
            $this->getTotalClicks()
        );
    }

    public function getRedirectBySlug($slug): ?RedirectEntity
    {
        $sql = "SELECT * FROM cmw_redirect WHERE redirect_slug=:slug";

        $db = DatabaseManager::getInstance();
        $res = $db->prepare($sql);

        if (!$res->execute(array("slug" => $slug))) {
            return null;
        }

        $res = $res->fetch();

        if (!empty($res)) {
            return new RedirectEntity(
                $res['redirect_id'],
                $res['redirect_name'],
                $res['redirect_slug'],
                $res['redirect_target'],
                $res['redirect_click'],
                $res['redirect_is_define'],
                $this->getTotalClicks()
            );
        }

        header("location: " . getenv("PATH_SUBFOLDER"));

        return null;
    }

    public function updateRedirect(int $id, string $name, string $slug, string $target): ?RedirectEntity
    {
        $var = array(
            "id" => $id,
            "name" => $name,
            "slug" => $slug,
            "target" => $target
        );

        $sql = "UPDATE cmw_redirect SET redirect_name=:name, redirect_slug=:slug, redirect_target=:target WHERE redirect_id=:id";

        $db = DatabaseManager::getInstance();
        $req = $db->prepare($sql);

        if ($req->execute($var)) {
            return $this->getRedirectById($id);
        }

        return null;
    }

    public function deleteRedirect(int $id): void
    {

        $sql = "DELETE FROM cmw_redirect WHERE redirect_id=:id";

        $db = DatabaseManager::getInstance();
        $req = $db->prepare($sql);
        $req->execute(array("id" => $id));
    }

    public function addClick($id): void
    {

        $sql = "UPDATE cmw_redirect SET redirect_click = redirect_click+1 WHERE redirect_id=:id";

        $db = DatabaseManager::getInstance();
        $req = $db->prepare($sql);
        $req->execute(array("id" => $id));
    }


    public function redirect($id): void
    {
        $res = $this->getRedirectById($id);
        $this->addClick($id);
        (new RedirectLogsModel())->createLog($id);

        header('Location: ' . $res?->getTarget());
    }


    public function getNumberOfLines(): int
    {
        $sql = "SELECT redirect_id FROM cmw_redirect";
        $db = DatabaseManager::getInstance();
        $req = $db->prepare($sql);
        $res = $req->execute();

        if ($res) {
            $lines = $req->fetchAll();

            return count($lines);
        }

        return 0;
    }

    public function getTotalClicks(): int
    {
        $toReturn = 0;

        $sql = "SELECT SUM(redirect_click) FROM cmw_redirect";
        $db = DatabaseManager::getInstance();
        $req = $db->prepare($sql);

        if ($req->execute()) {
            $result = $req->fetch();


            (empty($result['SUM(click)'])) ?: $toReturn = $result['SUM(redirect_click)'];
        }

        return $toReturn;
    }


    public function checkName($name): int
    {

        $sql = "SELECT redirect_name FROM cmw_redirect WHERE redirect_name=:name";

        $db = DatabaseManager::getInstance();
        $req = $db->prepare($sql);

        if ($req->execute(array("name" => $name))) {
            $lines = $req->fetchAll();

            return count($lines);
        }

        return 0;
    }

    public function checkSlug($slug): int
    {

        $sql = "SELECT redirect_slug FROM cmw_redirect WHERE redirect_slug=:slug";

        $db = DatabaseManager::getInstance();
        $req = $db->prepare($sql);

        if ($req->execute(array("slug" => $slug))) {
            $lines = $req->fetchAll();

            return count($lines);
        }

        return 0;
    }

    public function checkNameEdit($name, $id): int
    {
        $var = array(
            "name" => $name,
            "id" => $id
        );

        $sql = "SELECT redirect_name FROM cmw_redirect WHERE redirect_name=:name AND redirect_id != :id";

        $db = DatabaseManager::getInstance();
        $req = $db->prepare($sql);

        if ($req->execute($var)) {
            $lines = $req->fetchAll();

            return count($lines);
        }

        return 0;
    }

    public function checkSlugEdit($slug, $id): int
    {
        $var = array(
            "slug" => $slug,
            "id" => $id
        );

        $sql = "SELECT redirect_slug FROM cmw_redirect WHERE redirect_slug=:slug AND redirect_id != :id";

        $db = DatabaseManager::getInstance();
        $req = $db->prepare($sql);

        if ($req->execute($var)) {
            $lines = $req->fetchAll();

            return count($lines);
        }

        return 0;
    }

}
