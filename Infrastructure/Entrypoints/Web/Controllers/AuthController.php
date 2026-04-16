<?php

declare(strict_types=1);

namespace App\Infrastructure\Entrypoints\Web\Controllers;

use App\Application\Commands\ForgotPasswordCommand;
use App\Application\Commands\LoginCommand;
use App\Application\Services\ForgotPasswordService;
use App\Application\Services\LoginService;
use App\Domain\Exceptions\DomainException;
use App\Infrastructure\Entrypoints\Web\Controllers\Dto\ForgotPasswordRequest;
use App\Infrastructure\Entrypoints\Web\Controllers\Dto\LoginWebRequest;
use App\Infrastructure\Entrypoints\Web\Presentation\Flash;
use App\Infrastructure\Entrypoints\Web\Presentation\View;
use Throwable;

final class AuthController
{
    public function __construct(
        private readonly View $view,
        private readonly LoginService $login,
        private readonly ForgotPasswordService $forgotPassword,
    ) {
    }

    public function loginForm(): void
    {
        if (!empty($_SESSION['auth']['id'])) {
            $this->view->redirect('home');
        }

        $this->view->render('auth/login');
    }

    public function authenticate(LoginWebRequest $request): void
    {
        try {
            $user = $this->login->execute(new LoginCommand($request->email, $request->password));

            session_regenerate_id(true);
            $_SESSION['auth'] = [
                'id' => $user->id()?->value() ?? 0,
                'name' => $user->name()->value(),
                'email' => $user->email()->value(),
                'role' => $user->roleId()->value(),
            ];

            Flash::success('Bienvenido.');
            $this->view->redirect('home');
        } catch (DomainException $e) {
            Flash::error($e->getMessage());
            $this->view->redirect('auth.login');
        }
    }

    public function logout(): void
    {
        $_SESSION = [];

        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
        }

        session_destroy();

        // Start a fresh session so flash messaging still works after logout.
        session_start();
        Flash::success('Sesión cerrada.');
        $this->view->redirect('auth.login');
    }

    public function forgotPasswordForm(): void
    {
        $this->view->render('auth/forgot-password');
    }

    public function sendReset(ForgotPasswordRequest $request): void
    {
        // Always show the same message (avoid user enumeration)
        try {
            $result = $this->forgotPassword->execute(new ForgotPasswordCommand($request->email));

            if ($result !== null) {
                $user = $result['user'];
                $tempPassword = $result['tempPassword'];

                $to = $user->email()->value();
                $subject = 'Recuperación de contraseña';
                $htmlBody = $this->renderForgotPasswordEmail(
                    $user->name()->value(),
                    $tempPassword,
                );

                $this->deliverEmail($to, $subject, $htmlBody);
            }
        } catch (Throwable $e) {
            // Intentionally ignored.
        }

        Flash::success('Si el correo existe, enviaremos instrucciones. En local: revisa storage/mails/.');
        $this->view->redirect('auth.login');
    }

    private function renderForgotPasswordEmail(string $name, string $tempPassword): string
    {
        $projectRoot = dirname(__DIR__, 4);
        $templatePath = $projectRoot . '/Infrastructure/Entrypoints/Web/Presentation/views/emails/forgot-password.php';

        ob_start();
        require $templatePath;

        return (string) ob_get_clean();
    }

    private function deliverEmail(string $to, string $subject, string $htmlBody): void
    {
        $headers = implode("\r\n", [
            'MIME-Version: 1.0',
            'Content-type: text/html; charset=UTF-8',
            'From: no-reply@localhost',
        ]);

        // In local environments this might be disabled; we still keep the flow.
        @mail($to, $subject, $htmlBody, $headers);

        // Also write the email to a local file so you can verify it in XAMPP.
        $projectRoot = dirname(__DIR__, 4);
        $dir = $projectRoot . '/storage/mails';
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $safeTo = preg_replace('/[^a-z0-9]+/i', '_', strtolower($to)) ?: 'email';
        $file = $dir . '/forgot-password_' . date('Ymd_His') . '_' . $safeTo . '.html';
        @file_put_contents($file, $htmlBody);
    }
}
