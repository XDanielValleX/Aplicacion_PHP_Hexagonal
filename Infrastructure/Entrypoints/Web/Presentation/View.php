<?php

declare(strict_types=1);

namespace App\Infrastructure\Entrypoints\Web\Presentation;

final class View
{
    public function __construct(
        private readonly string $basePath,
        private readonly string $viewsPath,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public function render(string $template, array $data = []): void
    {
        $templateFile = $this->viewsPath . '/' . ltrim($template, '/') . '.php';
        $templateFile = str_replace('\\', '/', $templateFile);

        if (!is_file($templateFile)) {
            http_response_code(500);
            echo 'Template not found.';
            return;
        }

        $data = array_merge([
            'basePath' => $this->basePath,
            'auth' => $_SESSION['auth'] ?? null,
            'csrfToken' => $_SESSION['csrf_token'] ?? '',
            'flash' => Flash::consume(),
        ], $data);

        extract($data, EXTR_SKIP);

        require $this->viewsPath . '/layouts/header.php';
        require $this->viewsPath . '/layouts/menu.php';
        require $templateFile;
        require $this->viewsPath . '/layouts/footer.php';
    }

    /**
     * @param array<string, scalar> $params
     */
    public function routeUrl(string $route, array $params = []): string
    {
        $query = array_merge(['route' => $route], $params);

        return $this->basePath . '/index.php?' . http_build_query($query);
    }

    /**
     * @param array<string, scalar> $params
     */
    public function redirect(string $route, array $params = []): void
    {
        header('Location: ' . $this->routeUrl($route, $params));
        exit;
    }
}
