<?php

namespace App\Users\Presentation\Controller;

use App\Shared\Presentation\Controller\AbstractController;
use App\Shared\Presentation\Exception\ValidationException;
use App\Users\Application\Service\UserRegistrationServiceInterface;
use App\Users\Presentation\Resource\UserResource;
use JsonException;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class AuthController extends AbstractController
{
    public function __construct(
        private readonly UserRegistrationServiceInterface $userRegistrationService,
        private readonly JWTTokenManagerInterface $jwtTokenManager,
        private readonly UserProviderInterface $userProvider,
        private readonly UserPasswordHasherInterface $passwordHasher,
    ) {}

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

    /**
     * @throws ValidationException
     * @throws JsonException
     */
    #[Route('/api/auth/login', methods: ['POST'])]
    public function login(Request $request): Response
    {
        $data = $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = $this->userProvider->loadUserByIdentifier($data['email']);

        if (!$user || !$this->passwordHasher->isPasswordValid($user, $data['password'])) {
            throw new AuthenticationException('Credentials are invalid');
        }

        $token = $this->jwtTokenManager->create($user);

        return $this->success(['token' => $token]);
    }
}
