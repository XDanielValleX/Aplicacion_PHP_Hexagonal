<?php

declare(strict_types=1);

namespace App\Infrastructure\Entrypoints\Web\Controllers\Config;

use App\Infrastructure\Entrypoints\Web\Controllers\AuthController;
use App\Infrastructure\Entrypoints\Web\Controllers\Dto\CreateMenuRestauranteRequest;
use App\Infrastructure\Entrypoints\Web\Controllers\Dto\CreateUserRequest;
use App\Infrastructure\Entrypoints\Web\Controllers\Dto\ForgotPasswordRequest;
use App\Infrastructure\Entrypoints\Web\Controllers\Dto\LoginWebRequest;
use App\Infrastructure\Entrypoints\Web\Controllers\Dto\UpdateMenuRestauranteRequest;
use App\Infrastructure\Entrypoints\Web\Controllers\Dto\UpdateUserRequest;
use App\Infrastructure\Entrypoints\Web\Controllers\HomeController;
use App\Infrastructure\Entrypoints\Web\Controllers\MenuRestauranteController;
use App\Infrastructure\Entrypoints\Web\Controllers\UserController;

final class WebRoutes
{
    /**
     * @return array<string, array{method: string, auth: bool, handler: callable}>
     */
    public static function getRoutes(
        HomeController $homeController,
        UserController $userController,
        AuthController $authController,
        MenuRestauranteController $menuRestauranteController,
    ): array {
        return [
            'home' => [
                'method' => 'GET',
                'auth' => false,
                'handler' => static function () use ($homeController): void {
                    $homeController->home();
                },
            ],

            'auth.login' => [
                'method' => 'GET',
                'auth' => false,
                'handler' => static function () use ($authController): void {
                    $authController->loginForm();
                },
            ],
            'auth.authenticate' => [
                'method' => 'POST',
                'auth' => false,
                'handler' => static function () use ($authController): void {
                    $authController->authenticate(LoginWebRequest::fromArray($_POST));
                },
            ],
            'auth.logout' => [
                'method' => 'POST',
                'auth' => true,
                'handler' => static function () use ($authController): void {
                    $authController->logout();
                },
            ],
            'auth.forgot' => [
                'method' => 'GET',
                'auth' => false,
                'handler' => static function () use ($authController): void {
                    $authController->forgotPasswordForm();
                },
            ],
            'auth.send-reset' => [
                'method' => 'POST',
                'auth' => false,
                'handler' => static function () use ($authController): void {
                    $authController->sendReset(ForgotPasswordRequest::fromArray($_POST));
                },
            ],

            'users.index' => [
                'method' => 'GET',
                'auth' => true,
                'handler' => static function () use ($userController): void {
                    $userController->index();
                },
            ],
            'users.create' => [
                'method' => 'GET',
                'auth' => false,
                'handler' => static function () use ($userController): void {
                    $userController->create();
                },
            ],
            'users.store' => [
                'method' => 'POST',
                'auth' => false,
                'handler' => static function () use ($userController): void {
                    $userController->store(CreateUserRequest::fromArray($_POST));
                },
            ],
            'users.show' => [
                'method' => 'GET',
                'auth' => true,
                'handler' => static function () use ($userController): void {
                    $userController->show((int) ($_GET['id'] ?? 0));
                },
            ],
            'users.edit' => [
                'method' => 'GET',
                'auth' => true,
                'handler' => static function () use ($userController): void {
                    $userController->edit((int) ($_GET['id'] ?? 0));
                },
            ],
            'users.update' => [
                'method' => 'POST',
                'auth' => true,
                'handler' => static function () use ($userController): void {
                    $userController->update(UpdateUserRequest::fromArray($_POST));
                },
            ],
            'users.destroy' => [
                'method' => 'POST',
                'auth' => true,
                'handler' => static function () use ($userController): void {
                    $userController->destroy((int) ($_POST['id'] ?? 0));
                },
            ],

            'menus.index' => [
                'method' => 'GET',
                'auth' => true,
                'handler' => static function () use ($menuRestauranteController): void {
                    $menuRestauranteController->index();
                },
            ],
            'menus.create' => [
                'method' => 'GET',
                'auth' => true,
                'handler' => static function () use ($menuRestauranteController): void {
                    $menuRestauranteController->create();
                },
            ],
            'menus.store' => [
                'method' => 'POST',
                'auth' => true,
                'handler' => static function () use ($menuRestauranteController): void {
                    $menuRestauranteController->store(CreateMenuRestauranteRequest::fromArray($_POST));
                },
            ],
            'menus.show' => [
                'method' => 'GET',
                'auth' => true,
                'handler' => static function () use ($menuRestauranteController): void {
                    $menuRestauranteController->show((int) ($_GET['id'] ?? 0));
                },
            ],
            'menus.edit' => [
                'method' => 'GET',
                'auth' => true,
                'handler' => static function () use ($menuRestauranteController): void {
                    $menuRestauranteController->edit((int) ($_GET['id'] ?? 0));
                },
            ],
            'menus.update' => [
                'method' => 'POST',
                'auth' => true,
                'handler' => static function () use ($menuRestauranteController): void {
                    $menuRestauranteController->update(UpdateMenuRestauranteRequest::fromArray($_POST));
                },
            ],
            'menus.destroy' => [
                'method' => 'POST',
                'auth' => true,
                'handler' => static function () use ($menuRestauranteController): void {
                    $menuRestauranteController->destroy((int) ($_POST['id'] ?? 0));
                },
            ],
        ];
    }
}
