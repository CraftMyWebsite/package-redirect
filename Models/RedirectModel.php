<?php

namespace CMW\Model\Redirect;

use CMW\Entity\Redirect\RedirectEntity;
use CMW\Manager\Database\DatabaseManager;
use CMW\Manager\Package\AbstractModel;
use CMW\Utils\Redirect;

/**
 * Class @RedirectModel
 * @package Redirect
 * @author Teyir
 * @version 1.0
 */
class RedirectModel extends AbstractModel
{
    /**
     * @param string $name
     * @param string $slug
     * @param string $target
     * @param int $storeIp
     * @return RedirectEntity|null
     */
    public function createRedirect(string $name, string $slug, string $target, int $storeIp): ?RedirectEntity
    {
        $var = [
            'name' => $name,
            'slug' => $slug,
            'target' => $target,
            'ip' => $storeIp,
        ];

        $sql = 'INSERT INTO cmw_redirect (name, slug, target, store_ip) 
                        VALUES (:name, :slug, :target, :ip)';

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
        $sql = 'SELECT * FROM cmw_redirect';
        $db = DatabaseManager::getInstance();
        $res = $db->prepare($sql);

        if (!$res->execute()) {
            return [];
        }

        $toReturn = [];

        //TODO IMPROVE THAT
        while ($redirect = $res->fetch()) {
            $toReturn[] = $this->getRedirectById($redirect['id']);
        }

        return $toReturn;
    }

    /**
     * @param int $id
     * @return RedirectEntity|null
     */
    public function getRedirectById(int $id): ?RedirectEntity
    {
        $sql = 'SELECT * FROM cmw_redirect WHERE id=:id';

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
        return new RedirectEntity(
            $res['id'],
            $res['name'],
            $res['slug'],
            $res['target'],
            $res['click'],
            $res['is_define'],
            $this->getTotalClicks(),
            $res['store_ip'],
        );
    }

    /**
     * @param string $slug
     * @return RedirectEntity|null
     */
    public function getRedirectBySlug(string $slug): ?RedirectEntity
    {
        $sql = 'SELECT * FROM cmw_redirect WHERE slug=:slug';

        $db = DatabaseManager::getInstance();
        $res = $db->prepare($sql);

        if (!$res->execute(['slug' => $slug])) {
            return null;
        }

        $res = $res->fetch();

        //TODO IMPROVE THAT
        if (!empty($res)) {
            return new RedirectEntity(
                $res['id'],
                $res['name'],
                $res['slug'],
                $res['target'],
                $res['click'],
                $res['is_define'],
                $this->getTotalClicks(),
                $res['store_ip'],
            );
        }

        Redirect::redirectToHome();
    }

    /**
     * @param int $id
     * @param string $name
     * @param string $slug
     * @param string $target
     * @param int $storeIp
     * @return RedirectEntity|null
     */
    public function updateRedirect(int $id, string $name, string $slug, string $target, int $storeIp): ?RedirectEntity
    {
        $var = [
            'id' => $id,
            'name' => $name,
            'slug' => $slug,
            'target' => $target,
            'ip' => $storeIp,
        ];

        $sql = 'UPDATE cmw_redirect SET name=:name, slug=:slug, target=:target, 
                        store_ip = :ip 
                        WHERE id=:id';

        $db = DatabaseManager::getInstance();
        $req = $db->prepare($sql);

        if ($req->execute($var)) {
            return $this->getRedirectById($id);
        }

        return null;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function deleteRedirect(int $id): bool
    {
        $sql = 'DELETE FROM cmw_redirect WHERE id=:id';

        $db = DatabaseManager::getInstance();
        return $db->prepare($sql)->execute(['id' => $id]);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function addClick(int $id): bool
    {
        $sql = 'UPDATE cmw_redirect SET click = click+1 WHERE id=:id';

        $db = DatabaseManager::getInstance();
        return $db->prepare($sql)->execute(['id' => $id]);
    }

    /**
     * @return int
     */
    public function getNumberOfLines(): int
    {
        $sql = 'SELECT id FROM cmw_redirect';
        $db = DatabaseManager::getInstance();
        $req = $db->prepare($sql);
        $res = $req->execute();

        if ($res) {
            $lines = $req->fetchAll();

            return count($lines);
        }

        return 0;
    }

    /**
     * @return int
     */
    public function getTotalClicks(): int
    {
        $sql = 'SELECT SUM(click) as `count` FROM cmw_redirect';
        $db = DatabaseManager::getInstance();
        $req = $db->prepare($sql);

        if (!$req->execute()) {
            return 0;
        }

        $res = $req->fetch();

        if (!$res) {
            return 0;
        }

        return $res['count'];
    }

    /**
     * @param string $name
     * @return bool
     */
    public function isNameUsed(string $name): bool
    {
        $sql = 'SELECT name FROM cmw_redirect WHERE name=:name';

        $db = DatabaseManager::getInstance();
        $req = $db->prepare($sql);

        if ($req->execute(['name' => $name])) {
            $lines = $req->fetchAll();

            return count($lines) >= 1;
        }

        return false;
    }

    /**
     * @param string $slug
     * @return bool
     */
    public function isSlugUsed(string $slug): bool
    {
        $sql = 'SELECT slug FROM cmw_redirect WHERE slug=:slug';

        $db = DatabaseManager::getInstance();
        $req = $db->prepare($sql);

        if ($req->execute(['slug' => $slug])) {
            $lines = $req->fetchAll();

            return count($lines) >= 1;
        }

        return false;
    }

    /**
     * @param string $name
     * @param int $id
     * @return int
     */
    public function checkNameEdit(string $name, int $id): int
    {
        $var = [
            'name' => $name,
            'id' => $id,
        ];

        $sql = 'SELECT name FROM cmw_redirect WHERE name=:name AND id != :id';

        $db = DatabaseManager::getInstance();
        $req = $db->prepare($sql);

        if ($req->execute($var)) {
            $lines = $req->fetchAll();

            return count($lines);
        }

        return 0;
    }

    /**
     * @param $slug
     * @param $id
     * @return int
     */
    public function checkSlugEdit($slug, $id): int
    {
        $var = [
            'slug' => $slug,
            'id' => $id,
        ];

        $sql = 'SELECT slug FROM cmw_redirect WHERE slug=:slug AND id != :id';

        $db = DatabaseManager::getInstance();
        $req = $db->prepare($sql);

        if ($req->execute($var)) {
            $lines = $req->fetchAll();

            return count($lines);
        }

        return 0;
    }
}
