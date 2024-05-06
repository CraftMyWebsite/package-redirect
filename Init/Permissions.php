<?php

namespace CMW\Permissions\Redirect;

use CMW\Manager\Lang\LangManager;
use CMW\Manager\Permission\IPermissionInit;
use CMW\Manager\Permission\PermissionInitType;

class Permissions implements IPermissionInit
{
    public function permissions(): array
    {
        return [
            new PermissionInitType(
                code: 'redirect.show',
                description: LangManager::translate('redirect.permissions.redirect.show'),
            ),
            new PermissionInitType(
                code: 'redirect.create',
                description: LangManager::translate('redirect.permissions.redirect.create'),
            ),
            new PermissionInitType(
                code: 'redirect.edit',
                description: LangManager::translate('redirect.permissions.redirect.edit'),
            ),
            new PermissionInitType(
                code: 'redirect.delete',
                description: LangManager::translate('redirect.permissions.redirect.delete'),
            ),
            new PermissionInitType(
                code: 'redirect.stats',
                description: LangManager::translate('redirect.permissions.redirect.stats'),
            ),
        ];
    }

}