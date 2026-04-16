<?php

declare(strict_types=1);

namespace App\Infrastructure\Entrypoints\Web\Controllers;

use App\Application\Ports\In\ForgotPasswordUseCase;
use App\Application\Ports\In\LoginUseCase;
use App\Application\Services\Dto\Commands\ForgotPasswordCommand;
use App\Application\Services\Dto\Commands\LoginCommand;
use App\Infrastructure\Entrypoints\Web\Controllers\Dto\ForgotPasswordRequest;
use App\Infrastructure\Entrypoints\Web\Controllers\Dto\LoginWebRequest;
use Throwable;

final class AuthController
{
    public function __construct(
        private readonly LoginUseCase $login,
        private readonly ForgotPasswordUseCase $forgotPassword,
    ) {
    }

    /**
     * @return array{id:int,name:string,email:string,role:int}
     */
    public function authenticate(LoginWebRequest $request): array
    {
        $user = $this->login->execute(new LoginCommand($request->email, $request->password));

        return [
            'id' => $user->id()?->value() ?? 0,
            'name' => $user->name()->value(),
            'email' => $user->email()->value(),
            'role' => $user->roleId()->value(),
        ];
    }

    public function sendReset(ForgotPasswordRequest $request): void
    {
        // Always behave the same way (avoid user enumeration)
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
