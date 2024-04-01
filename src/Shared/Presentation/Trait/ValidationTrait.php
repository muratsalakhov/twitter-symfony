<?php

declare(strict_types=1);

namespace App\Shared\Presentation\Trait;

use App\Shared\Presentation\Exception\ValidationException;
use JsonException;
use Rakit\Validation\Validator;
use Symfony\Component\HttpFoundation\Request;

trait ValidationTrait
{
    /**
     * @throws ValidationException
     * @throws JsonException
     */
    protected function validate(Request $request, array $rules, array $messages = []): array
    {
        $data = $this->getRequestData($request);

        $validator = new Validator();
        $validation = $validator->make($data, $rules, $messages);

        $validation->validate();

        if ($validation->fails()) {
            $errors = $validation->errors()->toArray();
            $firstError = array_shift($errors);
            throw new ValidationException(array_shift($firstError));
        }

        return $validation->getValidData();
    }

    /**
     * @throws JsonException
     */
    protected function getRequestData(Request $request): array
    {
        $contentType = $request->headers->get('Content-Type');
        if (str_contains($contentType, 'application/json')) {
            $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
        } else {
            $data = array_merge($request->request->all(), $request->files->all());
        }

        return $data;
    }
}