<?php

namespace CMW\Model\Redirect;

use CMW\Model\manager;


/**
 * Class @redirectModel
 * @package Redirect
 * @author Teyir
 * @version 1.0
 */
class redirectModel extends manager
{
    public ?int $id;
    public string $name;
    public string $slug;
    public string $target;
    public int $click;
    public int $isDefine;
    public int $totalClicks;


    public function create(): void
    {
        $var = array(
            "name" => $this->name,
            "slug" => $this->slug,
            "target" => $this->target
        );

        $sql = "INSERT INTO cmw_redirect (name, slug, target) VALUES (:name, :slug, :target)";

        $db = manager::dbConnect();
        $req = $db->prepare($sql);
        $req->execute($var);

    }

    public function fetchAll(): array
    {

        $sql = "SELECT * FROM cmw_redirect";
        $db = manager::dbConnect();
        $req = $db->prepare($sql);
        $res = $req->execute();

        if ($res) {
            return $req->fetchAll();
        }


        return [];
    }

    public function fetch($id): void
    {
        $var = array(
            "id" => $id
        );

        $sql = "SELECT * FROM cmw_redirect WHERE id=:id";

        $db = manager::dbConnect();
        $req = $db->prepare($sql);

        if ($req->execute($var)) {
            $result = $req->fetch();
            foreach ($result as $key => $property) {

                //to camel case all keys
                $key = explode('_', $key);
                $firstElement = array_shift($key);
                $key = array_map('ucfirst', $key);
                array_unshift($key, $firstElement);
                $key = implode('', $key);

                if (property_exists(redirectModel::class, $key)) {
                    $this->$key = $property;
                }
            }
        }
    }

    public function fetchWithSlug($slug): void
    {
        $var = array(
            "slug" => $slug
        );

        $sql = "SELECT * FROM cmw_redirect WHERE slug=:slug";

        $db = manager::dbConnect();
        $req = $db->prepare($sql);

        if ($req->execute($var)) {

            $result = $req->fetch();
            if (empty($result)) {
                header("location: " . getenv("PATH_SUBFOLDER"));
            }

            foreach ($result as $key => $property) {

                //to camel case all keys
                $key = explode('_', $key);
                $firstElement = array_shift($key);
                $key = array_map('ucfirst', $key);
                array_unshift($key, $firstElement);
                $key = implode('', $key);

                if (property_exists(redirectModel::class, $key)) {
                    $this->$key = $property;
                }
            }
        }
    }

    public function update(): void
    {
        $var = array(
            "id" => $this->id,
            "name" => $this->name,
            "slug" => $this->slug,
            "target" => $this->target
        );

        $sql = "UPDATE cmw_redirect SET name=:name, slug=:slug, target=:target WHERE id=:id";

        $db = manager::dbConnect();
        $req = $db->prepare($sql);
        $req->execute($var);
    }

    public function delete(): void
    {
        $var = array(
            "id" => $this->id
        );

        $sql = "DELETE FROM cmw_redirect WHERE id=:id";

        $db = manager::dbConnect();
        $req = $db->prepare($sql);
        $req->execute($var);
    }

    public function addClick($id): void
    {
        $var = array(
            "id" => $id
        );

        $sql = "UPDATE cmw_redirect SET click = click+1 WHERE id=:id";

        $db = manager::dbConnect();
        $req = $db->prepare($sql);
        $req->execute($var);
    }

    public function addLog($id): void
    {
        $var = array(
            "redirect_id" => $id
        );

        $sql = "INSERT INTO cmw_redirect_logs (redirect_id) VALUES (:redirect_id)";

        $db = manager::dbConnect();
        $req = $db->prepare($sql);
        $req->execute($var);

    }


    public function redirect($id): void
    {
        $this->fetch($id);
        $this->addClick($id);
        $this->addLog($id);

        header('Location: ' . $this->target);

    }


    public function getStats(): array
    {
        $sql = "SELECT `name`,`click` FROM cmw_redirect";
        $db = manager::dbConnect();
        $req = $db->prepare($sql);
        $res = $req->execute();

        if ($res) {
            return $req->fetchAll();
        }

        return [];
    }

    public function getNumberOfLines(): int
    {
        $sql = "SELECT id FROM cmw_redirect";
        $db = manager::dbConnect();
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
        $sql = "SELECT SUM(click) FROM cmw_redirect";
        $db = manager::dbConnect();
        $req = $db->prepare($sql);

        if ($req->execute()) {
            $result = $req->fetch();

            (empty($result['SUM(click)'])) ? $this->totalClicks = 0 : $this->totalClicks = $result['SUM(click)'];
        }
        return $this->totalClicks;
    }

    public function getAllClicks(): int
    {
        $sql = "SELECT id FROM cmw_redirect_logs";
        $db = manager::dbConnect();
        $req = $db->prepare($sql);

        if ($req->execute()) {
            $lines = $req->fetchAll();

            return count($lines);
        }

        return 0;
    }

    public function checkName($name): int
    {
        $var = array(
            "name" => $name
        );

        $sql = "SELECT name FROM cmw_redirect WHERE name=:name";

        $db = manager::dbConnect();
        $req = $db->prepare($sql);

        if ($req->execute($var)) {
            $lines = $req->fetchAll();

            return count($lines);
        }

        return 0;
    }

    public function checkSlug($slug): int
    {
        $var = array(
            "slug" => $slug
        );

        $sql = "SELECT slug FROM cmw_redirect WHERE slug=:slug";

        $db = manager::dbConnect();
        $req = $db->prepare($sql);

        if ($req->execute($var)) {
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

        $sql = "SELECT name FROM cmw_redirect WHERE name=:name AND id != :id";

        $db = manager::dbConnect();
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

        $sql = "SELECT slug FROM cmw_redirect WHERE slug=:slug AND id != :id";

        $db = manager::dbConnect();
        $req = $db->prepare($sql);

        if ($req->execute($var)) {
            $lines = $req->fetchAll();

            return count($lines);
        }

        return 0;
    }

}
