<?php

namespace CMW\Implementation\Redirect\Core;

use CMW\Interface\Core\IMenus;
use CMW\Model\Redirect\RedirectModel;

class RedirectMenusImplementations implements IMenus
{
    public function getRoutes(): array
    {
        $redirections = [];

        foreach ((new RedirectModel())->getRedirects() as $redirect) {
            $redirections[$redirect->getName()] = 'r/' . $redirect->getSlug();
        }

        return $redirections;
    }

    public function getPackageName(): string
    {
        return 'Redirect';
    }
}
