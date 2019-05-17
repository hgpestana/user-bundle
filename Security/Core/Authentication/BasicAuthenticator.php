<?php


namespace HGPestana\UserBundle\Security\Core\Authentication;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use HGPestana\UserBundle\Entity\ApiToken;
use HGPestana\UserBundle\Entity\User;
use HGPestana\UserBundle\Repository\UserRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class BasicAuthenticator extends AbstractGuardAuthenticator
{
    private const INVALID_CREDENTIALS_ERROR = 'Invalid credentials supplied! Please try again.';
    private const PLATFORM_KEY = 'PLATFORM';
    private const API_KEY = 'api_key';
    private const MESSAGE_KEY = 'message';

    /** @var UserRepository */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function supports(Request $request): bool
    {
        // look for header "Authorization: Basic <64bit encoded keypair>"
        return $request->headers->has('Authorization')
            && 0 === strpos($request->headers->get('Authorization'), 'Basic ');
    }

    public function getCredentials(Request $request): ?array
    {
        $credentialsHeader = $request->headers->get('Authorization');
        $credentials = explode(":", base64_decode($credentialsHeader, 6));

        if (count($credentials) != 2)
            throw new CustomUserMessageAuthenticationException(self::INVALID_CREDENTIALS_ERROR);

        return [
            'email' => $credentials[0],
            'password' => $credentials[1],
        ];
    }

    public function getUser($credentials, UserProviderInterface $userProvider): ?User
    {
        /** @var User $user */
        $user = $this->userRepository->findOneByEmail($credentials['email']);

        if (!$user)
            throw new CustomUserMessageAuthenticationException(self::INVALID_CREDENTIALS_ERROR);

        return $user;
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        // TODO: Implement checkCredentials() method.
    }

    /**
     * Returns a JsonResponse with a valid platform API token for the logged in user
     *
     * @param Request $request
     * @param TokenInterface $token
     * @param string $providerKey
     *
     * @return JsonResponse
     * @throws \Exception
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey): JsonResponse
    {
        /** @var User $user */
        $user = $token->getUser();
        $results = $this->getUserValidPlatformTokens($user);

        if ($results->count() > 0) {

            /** @var ApiToken $token */
            $token = $results->first();

        } else {

            /** @var ApiToken $token */
            $token = $this->generateValidPlatformToken($user);
        }

        return new JsonResponse(
            [
                self::API_KEY => $token->getToken()
            ],
            Response::HTTP_OK
        );
    }

    /**
     * Returns an ArrayCollection of the user's valid API tokens for the platform.
     *
     * @param User $user
     *
     * @return ArrayCollection|null
     * @throws \Exception
     */
    private function getUserValidPlatformTokens(User $user): ?ArrayCollection
    {
        $criteria = Criteria::create()
            ->where(Criteria::expr()->eq('description', self::PLATFORM_KEY))
            ->andWhere(Criteria::expr()->gte('expiresAt', new \DateTime()));

        return $user->getApiTokens()->matching($criteria);
    }

    /**
     * Returns a valid API platform token for the user.
     *
     * @param User $user
     *
     * @return ApiToken|null
     */
    private function generateValidPlatformToken(User $user): ?ApiToken
    {
        $token = new ApiToken($user, self::PLATFORM_KEY, true);

        $user->getApiTokens()->add($token);

        $this->userRepository->save($user);

        return $token;
    }

    /**
     * Returns a JsonResponse with an error message
     *
     * @param Request $request
     * @param AuthenticationException $exception
     *
     * @return JsonResponse
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): JsonResponse
    {
        return new JsonResponse([
            self::MESSAGE_KEY => $exception->getMessageKey()
        ], 401);
    }

    public function supportsRememberMe(): bool
    {
        return false;
    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
        // TODO: Implement start() method.
    }
}