<?php

namespace CMW\Package\Redirect;

use CMW\Manager\Package\IPackageConfig;
use CMW\Manager\Package\PackageMenuType;
use CMW\Manager\Package\PackageSubMenuType;

class Package implements IPackageConfig
{
    public function name(): string
    {
        return 'Redirect';
    }

    public function version(): string
    {
        return '0.0.1';
    }

    public function authors(): array
    {
        return ['Teyir'];
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
                icon: 'fas fa-directions',
                title: 'Redirect',
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
        ];
    }

    public function requiredPackages(): array
    {
        return ['Core'];
    }

    public function uninstall(): bool
    {
        // Return true, we don't need other operations for uninstall.
        return true;
    }
}
