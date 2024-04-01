<?php

namespace App\Users\Presentation\Controller;

use App\Shared\Presentation\Controller\AbstractController;
use App\Shared\Presentation\Exception\ValidationException;
use App\Users\Application\Service\UserRegistrationServiceInterface;
use App\Users\Presentation\Resource\UserResource;
use JsonException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AuthController extends AbstractController
{
    public function __construct(private readonly UserRegistrationServiceInterface $userRegistrationService)
    {
    }

    /**
     * @throws ValidationException
     * @throws JsonException
     */
    #[Route('/api/auth/register', methods: ['POST'])]
    public function register(Request $request): Response
    {
        $data = $this->validate($request, [
            'email' => 'required|email',
            'name' => 'required',
            'password' => 'required|min:6',
        ]);

        $user = $this->userRegistrationService->register($data['name'], $data['email'], $data['password']);

        return $this->success(
            UserResource::make($user)
        );
    }
}