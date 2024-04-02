<?php

declare(strict_types=1);

namespace App\Shared\Presentation\Exception;

use Symfony\Component\HttpFoundation\Response;

class ValidationException extends \Exception
{
    public function __construct(string $message = 'Validation exception', int $code = Response::HTTP_UNPROCESSABLE_ENTITY, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
