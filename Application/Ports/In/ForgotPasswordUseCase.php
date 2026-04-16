<?php

declare(strict_types=1);

namespace App\Application\Ports\In;

use App\Application\Services\Dto\Commands\ForgotPasswordCommand;
use App\Domain\Models\UserModel;

interface ForgotPasswordUseCase
{
    /**
     * @return array{user: UserModel, tempPassword: string}|null
     */
    public function execute(ForgotPasswordCommand $command): ?array;
}
