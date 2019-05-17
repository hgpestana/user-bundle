<?php


namespace HGPestana\UserBundle\Security\Core\Authentication;

use HGPestana\UserBundle\Entity\ApiToken;
use HGPestana\UserBundle\Entity\User;
use HGPestana\UserBundle\Repository\ApiTokenRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class ApiTokenAuthenticator extends AbstractGuardAuthenticator
{
    private const INVALID_CREDENTIALS_ERROR = 'Invalid credentials supplied! Please try again.';
    private const TOKEN_EXPIRED_ERROR = 'The provided token has expired!';

    /** @var ApiTokenRepository */
    private $apiTokenRepository;

    public function __construct(ApiTokenRepository $apiTokenRepository)
    {
        $this->apiTokenRepository = $apiTokenRepository;
    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
    }

    public function supports(Request $request): ?bool
    {
        // look for header "Authorization: Bearer <token>"
        return $request->headers->has('Authorization')
            && 0 === strpos($request->headers->get('Authorization'), 'Bearer ');
    }

    public function getCredentials(Request $request): ?string
    {
        $authorizationHeader = $request->headers->get('Authorization');
        return substr($authorizationHeader, 7);
    }

    public function getUser($credentials, UserProviderInterface $userProvider): ?User
    {
        /** @var ApiToken $token */
        $token = $this->apiTokenRepository->findOneByToken($credentials);

        if (!$token)
            throw new CustomUserMessageAuthenticationException(self::INVALID_CREDENTIALS_ERROR);

        if ($token->isExpired())
            throw new CustomUserMessageAuthenticationException(self::TOKEN_EXPIRED_ERROR);

        return $token->getUser();
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        return new JsonResponse([
            'message' => $exception->getMessageKey()
        ], 401);
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        return true;
    }

    public function supportsRememberMe()
    {
        return false;
    }
}