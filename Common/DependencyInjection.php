<?php

declare(strict_types=1);

namespace App\Common;

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
use App\Infrastructure\Adapters\Persistence\MySQL\Config\Connection;
use App\Infrastructure\Adapters\Persistence\MySQL\Repository\MenuRestauranteRepositoryMySQL;
use App\Infrastructure\Adapters\Persistence\MySQL\Repository\UserRepositoryMySQL;
use App\Infrastructure\Entrypoints\Web\Controllers\AuthController;
use App\Infrastructure\Entrypoints\Web\Controllers\Mapper\MenuRestauranteWebMapper;
use App\Infrastructure\Entrypoints\Web\Controllers\Mapper\UserWebMapper;
use App\Infrastructure\Entrypoints\Web\Controllers\MenuRestauranteController;
use App\Infrastructure\Entrypoints\Web\Controllers\UserController;

final class DependencyInjection
{
    /**
     * @return array{
     *     userController: UserController,
     *     authController: AuthController,
     *     menuRestauranteController: MenuRestauranteController
     * }
     */
    public static function build(string $projectRoot): array
    {
        /** @var array{host:string,port:int,database:string,username:string,password:string,charset:string} $dbConfig */
        $dbConfig = require $projectRoot . '/config/database.php';

        $connection = new Connection($dbConfig);
        $pdo = $connection->getConnection();

        $userRepository = new UserRepositoryMySQL($pdo);
        $menuRepository = new MenuRestauranteRepositoryMySQL($pdo);

        return [
            'userController' => new UserController(
                new UserWebMapper(),
                new CreateUserService($userRepository),
                new ListUsersService($userRepository),
                new GetUserByIdService($userRepository),
                new UpdateUserService($userRepository),
                new DeleteUserService($userRepository),
            ),
            'authController' => new AuthController(
                new LoginService($userRepository),
                new ForgotPasswordService($userRepository),
            ),
            'menuRestauranteController' => new MenuRestauranteController(
                new MenuRestauranteWebMapper(),
                new CreateMenuRestauranteService($menuRepository),
                new ListMenuRestaurantesService($menuRepository),
                new GetMenuRestauranteByIdService($menuRepository),
                new UpdateMenuRestauranteService($menuRepository),
                new DeleteMenuRestauranteService($menuRepository),
            ),
        ];
    }
}
