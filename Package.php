<?php

namespace CMW\Package\Redirect;

use CMW\Manager\Lang\LangManager;
use CMW\Manager\Package\IPackageConfigV2;
use CMW\Manager\Package\PackageMenuType;
use CMW\Manager\Package\PackageSubMenuType;

class Package implements IPackageConfigV2
{
    public function name(): string
    {
        return 'Redirect';
    }

    public function version(): string
    {
        return '1.2.0';
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
                title: LangManager::translate('redirect.menu.main'),
                url: null,
                permission: null,
                subMenus: [
                    new PackageSubMenuType(
                        title: LangManager::translate('redirect.menu.manage'),
                        permission: 'redirect.show',
                        url: 'redirect/manage',
                        subMenus: []
                    ),
                    new PackageSubMenuType(
                        title: LangManager::translate('redirect.menu.stats.title'),
                        permission: 'redirect.stats',
                        url: '',
                        subMenus: [
                            new PackageSubMenuType(
                                title: LangManager::translate('redirect.menu.stats.general'),
                                permission: 'redirect.stats',
                                url: 'redirect/stats/general',
                                subMenus: []
                            ),
                            new PackageSubMenuType(
                                title: LangManager::translate('redirect.menu.stats.utm'),
                                permission: 'redirect.stats',
                                url: 'redirect/stats/utm',
                                subMenus: []
                            ),
                        ]
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

    public function cmwVersion(): string
    {
        return 'beta-01';
    }

    public function imageLink(): ?string
    {
        return null;
    }

    public function compatiblesPackages(): array
    {
        return [];
    }
}
