<?php

namespace CMW\Package\Redirect;

use CMW\Manager\Package\IPackageConfig;
use CMW\Manager\Package\PackageMenuType;
use CMW\Manager\Package\PackageSubMenuType;

class Package implements IPackageConfig
{
    public function name(): string
    {
        return "Redirect";
    }

    public function version(): string
    {
        return "0.0.1";
    }

    public function authors(): array
    {
        return ["Teyir"];
    }

    public function isGame(): bool
    {
        return false;
    }

    public function isCore(): bool
    {
        return false;
    }

    public function menus(): ?array
    {
        return [
            new PackageMenuType(
                lang: "fr",
                icon: "fas fa-directions",
                title: "Redirect",
                url: null,
                permission: null,
                subMenus: [
                    new PackageSubMenuType(
                        title: 'Gestion',
                        permission: 'redirect.show',
                        url: 'redirect/manage',
                    ),
                    new PackageSubMenuType(
                        title: 'Statistiques',
                        permission: 'redirect.stats',
                        url: 'redirect/stats',
                    ),
                ]
            ),
            new PackageMenuType(
                lang: "en",
                icon: "fas fa-directions",
                title: "Redirect",
                url: null,
                permission: null,
                subMenus: [
                    new PackageSubMenuType(
                        title: 'Manage',
                        permission: 'redirect.show',
                        url: 'redirect/list',
                    ),
                    new PackageSubMenuType(
                        title: 'Statistics',
                        permission: 'redirect.stats',
                        url: 'redirect/stats',
                    ),
                ]
            ),
        ];
    }
}