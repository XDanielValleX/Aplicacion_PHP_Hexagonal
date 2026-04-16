<?php

declare(strict_types=1);

use App\Common\ClassLoader;
use App\Common\DependencyInjection;
use App\Domain\Exceptions\DomainException;
use App\Infrastructure\Entrypoints\Web\Controllers\Config\WebRoutes;
use App\Infrastructure\Entrypoints\Web\Controllers\Dto\CreateMenuRestauranteRequest;
use App\Infrastructure\Entrypoints\Web\Controllers\Dto\CreateUserRequest;
use App\Infrastructure\Entrypoints\Web\Controllers\Dto\ForgotPasswordRequest;
use App\Infrastructure\Entrypoints\Web\Controllers\Dto\LoginWebRequest;
use App\Infrastructure\Entrypoints\Web\Controllers\Dto\UpdateMenuRestauranteRequest;
use App\Infrastructure\Entrypoints\Web\Controllers\Dto\UpdateUserRequest;
use App\Infrastructure\Entrypoints\Web\Presentation\Flash;
use App\Infrastructure\Entrypoints\Web\Presentation\View;

require_once __DIR__ . '/../Common/ClassLoader.php';
ClassLoader::register(dirname(__DIR__));

$projectRoot = dirname(__DIR__);

$secure = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
ini_set('session.use_strict_mode', '1');
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'secure' => $secure,
    'httponly' => true,
    'samesite' => 'Lax',
]);

session_start();

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Guard: redirect attempts to access non-public paths.
$requestPath = rtrim((string) (parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/'), '/');
$scriptName = str_replace('\\', '/', (string) ($_SERVER['SCRIPT_NAME'] ?? '/index.php'));
$publicBase = rtrim(str_replace('\\', '/', dirname($scriptName)), '/');
if ($requestPath !== $publicBase && !str_starts_with($requestPath, $publicBase . '/')) {
    $dest = isset($_SESSION['auth']['id']) ? 'home' : 'auth.login';
    header('Location: ' . $publicBase . '/index.php?route=' . $dest);
    exit;
}

$view = new View(
    $publicBase,
    $projectRoot . '/Infrastructure/Entrypoints/Web/Presentation/views',
);

try {
    $container = DependencyInjection::build($projectRoot);
    $userController = $container['userController'];
    $authController = $container['authController'];
    $menuRestauranteController = $container['menuRestauranteController'];
} catch (Throwable $e) {
    http_response_code(500);
    $view->render('errors/500', ['message' => 'Configura MySQL y la tabla users (ver database/schema.sql).']);
    exit;
}

$routes = WebRoutes::getRoutes();

$routeName = (string) ($_GET['route'] ?? 'home');
$route = $routes[$routeName] ?? null;

if ($route === null) {
    http_response_code(404);
    $view->render('errors/404', ['route' => $routeName]);
    exit;
}

$method = strtoupper((string) ($_SERVER['REQUEST_METHOD'] ?? 'GET'));
if ($method !== $route['method']) {
    http_response_code(405);
    $view->render('errors/500', ['message' => 'Método no permitido']);
    exit;
}

if (($route['auth'] ?? false) && empty($_SESSION['auth']['id'])) {
    Flash::error('Debes iniciar sesión.');
    $view->redirect('auth.login');
}

if ($method === 'POST') {
    $token = (string) ($_POST['_csrf'] ?? '');
    $sessionToken = (string) ($_SESSION['csrf_token'] ?? '');

    if ($sessionToken === '' || !hash_equals($sessionToken, $token)) {
        http_response_code(400);
        $view->render('errors/500', ['message' => 'CSRF inválido']);
        exit;
    }
}

try {
    switch ($routeName) {
        case 'home':
            $view->render('home');
            break;

        case 'auth.login':
            if (!empty($_SESSION['auth']['id'])) {
                $view->redirect('home');
            }

            $view->render('auth/login');
            break;

        case 'auth.authenticate':
            $request = LoginWebRequest::fromArray($_POST);

            try {
                $auth = $authController->authenticate($request);

                session_regenerate_id(true);
                $_SESSION['auth'] = $auth;

                Flash::success('Bienvenido.');
                $view->redirect('home');
            } catch (DomainException $e) {
                $old = $_POST;
                unset($old['_csrf'], $old['password']);

                Flash::setOld($old);
                Flash::error($e->getMessage());
                $view->redirect('auth.login');
            }
            break;

        case 'auth.logout':
            $_SESSION = [];
            session_regenerate_id(true);
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

            Flash::success('Sesión cerrada.');
            $view->redirect('auth.login');
            break;

        case 'auth.forgot':
            if (!empty($_SESSION['auth']['id'])) {
                $view->redirect('home');
            }

            $view->render('auth/forgot-password');
            break;

        case 'auth.send-reset':
            $request = ForgotPasswordRequest::fromArray($_POST);
            $authController->sendReset($request);

            Flash::success('Si el correo existe, enviaremos instrucciones. En local: revisa storage/mails/.');
            $view->redirect('auth.login');
            break;

        case 'users.index':
            $users = $userController->index();
            $view->render('users/list', [
                'users' => $users,
            ]);
            break;

        case 'users.create':
            $view->render('users/create');
            break;

        case 'users.store':
            $request = CreateUserRequest::fromArray($_POST);

            try {
                $userController->store($request);
                Flash::success('Usuario creado correctamente.');
                $view->redirect('users.index');
            } catch (DomainException $e) {
                $old = $_POST;
                unset($old['_csrf'], $old['password']);

                Flash::setOld($old);
                Flash::error($e->getMessage());
                $view->redirect('users.create');
            }
            break;

        case 'users.show':
            try {
                $id = (int) ($_GET['id'] ?? 0);
                $user = $userController->show($id);

                $view->render('users/show', [
                    'user' => $user,
                ]);
            } catch (DomainException $e) {
                Flash::error($e->getMessage());
                $view->redirect('users.index');
            }
            break;

        case 'users.edit':
            try {
                $id = (int) ($_GET['id'] ?? 0);
                $user = $userController->edit($id);

                $view->render('users/edit', [
                    'user' => $user,
                ]);
            } catch (DomainException $e) {
                Flash::error($e->getMessage());
                $view->redirect('users.index');
            }
            break;

        case 'users.update':
            $request = UpdateUserRequest::fromArray($_POST);

            try {
                $userController->update($request);
                Flash::success('Usuario actualizado correctamente.');
                $view->redirect('users.index');
            } catch (DomainException $e) {
                $old = $_POST;
                unset($old['_csrf'], $old['password']);

                Flash::setOld($old);
                Flash::error($e->getMessage());
                $view->redirect('users.edit', ['id' => $request->id]);
            }
            break;

        case 'users.destroy':
            try {
                $id = (int) ($_POST['id'] ?? 0);
                $userController->destroy($id);
                Flash::success('Usuario eliminado.');
            } catch (DomainException $e) {
                Flash::error($e->getMessage());
            }

            $view->redirect('users.index');
            break;

        case 'menus.index':
            $items = $menuRestauranteController->index();
            $view->render('menus/list', [
                'items' => $items,
            ]);
            break;

        case 'menus.create':
            $view->render('menus/create');
            break;

        case 'menus.store':
            $request = CreateMenuRestauranteRequest::fromArray($_POST);

            try {
                $menuRestauranteController->store($request);
                Flash::success('Registro creado correctamente.');
                $view->redirect('menus.index');
            } catch (DomainException $e) {
                $old = $_POST;
                unset($old['_csrf']);

                Flash::setOld($old);
                Flash::error($e->getMessage());
                $view->redirect('menus.create');
            }
            break;

        case 'menus.show':
            try {
                $id = (int) ($_GET['id'] ?? 0);
                $item = $menuRestauranteController->show($id);

                $view->render('menus/show', [
                    'item' => $item,
                ]);
            } catch (DomainException $e) {
                Flash::error($e->getMessage());
                $view->redirect('menus.index');
            }
            break;

        case 'menus.edit':
            try {
                $id = (int) ($_GET['id'] ?? 0);
                $item = $menuRestauranteController->edit($id);

                $view->render('menus/edit', [
                    'item' => $item,
                ]);
            } catch (DomainException $e) {
                Flash::error($e->getMessage());
                $view->redirect('menus.index');
            }
            break;

        case 'menus.update':
            $request = UpdateMenuRestauranteRequest::fromArray($_POST);

            try {
                $menuRestauranteController->update($request);
                Flash::success('Registro actualizado correctamente.');
                $view->redirect('menus.index');
            } catch (DomainException $e) {
                $old = $_POST;
                unset($old['_csrf']);

                Flash::setOld($old);
                Flash::error($e->getMessage());
                $view->redirect('menus.edit', ['id' => $request->id]);
            }
            break;

        case 'menus.destroy':
            try {
                $id = (int) ($_POST['id'] ?? 0);
                $menuRestauranteController->destroy($id);
                Flash::success('Registro eliminado.');
            } catch (DomainException $e) {
                Flash::error($e->getMessage());
            }

            $view->redirect('menus.index');
            break;

        default:
            http_response_code(500);
            $view->render('errors/500', ['message' => 'Ruta no implementada']);
            break;
    }
} catch (Throwable $e) {
    http_response_code(500);
    $view->render('errors/500');
}
