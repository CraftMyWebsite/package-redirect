<?php

namespace CMW\Implementation\Redirect;

use CMW\Interface\Core\IMenus;
use CMW\Model\Redirect\RedirectModel;

class RedirectMenusImplementations implements IMenus {

    public function getRoutes(): array
    {
        
        $redirections = [];

        foreach ((new RedirectModel())->getRedirects() as $redirect) {
            $redirections = "r/" . $redirect->getSlug();
        }
        
        return $redirections;
    }

    public function getPackageName(): string
    {
        return 'Redirect';
    }
}