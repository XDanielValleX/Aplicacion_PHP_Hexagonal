<?php

declare(strict_types=1);

namespace App\Infrastructure\Entrypoints\Web\Controllers\Config;

final class WebRoutes
{
    /**
     * @return array<string, array{method: string, auth: bool}>
     */
    public static function getRoutes(): array
    {
        return [
            'home' => ['method' => 'GET', 'auth' => false],

            'auth.login' => ['method' => 'GET', 'auth' => false],
            'auth.authenticate' => ['method' => 'POST', 'auth' => false],
            'auth.logout' => ['method' => 'POST', 'auth' => true],
            'auth.forgot' => ['method' => 'GET', 'auth' => false],
            'auth.send-reset' => ['method' => 'POST', 'auth' => false],

            'users.index' => ['method' => 'GET', 'auth' => true],
            'users.create' => ['method' => 'GET', 'auth' => false],
            'users.store' => ['method' => 'POST', 'auth' => false],
            'users.show' => ['method' => 'GET', 'auth' => true],
            'users.edit' => ['method' => 'GET', 'auth' => true],
            'users.update' => ['method' => 'POST', 'auth' => true],
            'users.destroy' => ['method' => 'POST', 'auth' => true],

            'menus.index' => ['method' => 'GET', 'auth' => true],
            'menus.create' => ['method' => 'GET', 'auth' => true],
            'menus.store' => ['method' => 'POST', 'auth' => true],
            'menus.show' => ['method' => 'GET', 'auth' => true],
            'menus.edit' => ['method' => 'GET', 'auth' => true],
            'menus.update' => ['method' => 'POST', 'auth' => true],
            'menus.destroy' => ['method' => 'POST', 'auth' => true],
        ];
    }
}
