<?php

declare(strict_types=1);

use App\Application\Services\CreateMenuRestauranteService;
use App\Application\Services\CreateUserService;
use App\Application\Services\DeleteMenuRestauranteService;
use App\Application\Services\DeleteUserService;
use App\Application\Services\ForgotPasswordService;
use App\Application\Services\GetMenuRestauranteByIdService;
use App\Application\Services\GetUserByIdService;
use App\Application\Services\ListMenuRestaurantesService;
use App\Application\Services\ListUsersService;
use App\Application\Services\LoginService;
use App\Application\Services\UpdateMenuRestauranteService;
use App\Application\Services\UpdateUserService;
use App\Infrastructure\Entrypoints\Web\Controllers\AuthController;
use App\Infrastructure\Entrypoints\Web\Controllers\Config\WebRoutes;
use App\Infrastructure\Entrypoints\Web\Controllers\HomeController;
use App\Infrastructure\Entrypoints\Web\Controllers\Mapper\MenuRestauranteWebMapper;
use App\Infrastructure\Entrypoints\Web\Controllers\Mapper\UserWebMapper;
use App\Infrastructure\Entrypoints\Web\Controllers\MenuRestauranteController;
use App\Infrastructure\Entrypoints\Web\Controllers\UserController;
use App\Infrastructure\Entrypoints\Web\Presentation\Flash;
use App\Infrastructure\Entrypoints\Web\Presentation\View;
use App\Infrastructure\Adapters\Persistence\MySQL\Config\Connection;
use App\Infrastructure\Adapters\Persistence\MySQL\Repository\MenuRestauranteRepositoryMySQL;
use App\Infrastructure\Adapters\Persistence\MySQL\Repository\UserRepositoryMySQL;

$vendorAutoload = __DIR__ . '/../vendor/autoload.php';
if (is_file($vendorAutoload)) {
    require $vendorAutoload;
} else {
    require __DIR__ . '/../bootstrap/autoload.php';
}

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
    __DIR__ . '/../Infrastructure/Entrypoints/Web/Presentation/views',
);

try {
    /** @var array{host:string,port:int,database:string,username:string,password:string,charset:string} $dbConfig */
    $dbConfig = require __DIR__ . '/../config/database.php';
    $connection = new Connection($dbConfig);
    $pdo = $connection->getConnection();
    $userRepository = new UserRepositoryMySQL($pdo);
    $menuRepository = new MenuRestauranteRepositoryMySQL($pdo);

    $userController = new UserController(
        $view,
        new UserWebMapper(),
        new CreateUserService($userRepository),
        new ListUsersService($userRepository),
        new GetUserByIdService($userRepository),
        new UpdateUserService($userRepository),
        new DeleteUserService($userRepository),
    );

    $authController = new AuthController(
        $view,
        new LoginService($userRepository),
        new ForgotPasswordService($userRepository),
    );

    $menuRestauranteController = new MenuRestauranteController(
        $view,
        new MenuRestauranteWebMapper(),
        new CreateMenuRestauranteService($menuRepository),
        new ListMenuRestaurantesService($menuRepository),
        new GetMenuRestauranteByIdService($menuRepository),
        new UpdateMenuRestauranteService($menuRepository),
        new DeleteMenuRestauranteService($menuRepository),
    );
} catch (Throwable $e) {
    http_response_code(500);
    $view->render('errors/500', ['message' => 'Configura MySQL y la tabla users (ver database/schema.sql).']);
    exit;
}

$homeController = new HomeController($view);

$routes = WebRoutes::getRoutes($homeController, $userController, $authController, $menuRestauranteController);

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
    ($route['handler'])();
} catch (Throwable $e) {
    http_response_code(500);
    $view->render('errors/500');
}
