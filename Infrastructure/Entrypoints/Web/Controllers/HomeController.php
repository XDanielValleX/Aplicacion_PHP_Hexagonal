<?php

declare(strict_types=1);

namespace App\Infrastructure\Entrypoints\Web\Controllers;

use App\Infrastructure\Entrypoints\Web\Presentation\View;

final class HomeController
{
    public function __construct(
        private readonly View $view,
    ) {
    }

    public function home(): void
    {
        $this->view->render('home');
    }
}
