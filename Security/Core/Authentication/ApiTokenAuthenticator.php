<?php
declare(strict_types=1);

/*
 * This file is part of hgpestana's user bundle.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HGPestana\UserBundle\Security\Core\Authentication;

use Exception;
use HGPestana\UserBundle\Entity\ApiToken;
use HGPestana\UserBundle\Entity\User;
use HGPestana\UserBundle\Repository\RepositoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

/**
 * Responsible for providing basic API authentication using
 * the API token entity defined in the bundle.
 *
 * @author Hélder Pestana <hgpestana@gmail.com>
 */
final class ApiTokenAuthenticator extends AbstractGuardAuthenticator
{
    private const INVALID_CREDENTIALS_ERROR = 'Invalid credentials supplied! Please try again.';
    private const TOKEN_EXPIRED_ERROR = 'The provided token has expired!';

    /** @var RepositoryInterface */
    private $apiTokenRepository;

    public function __construct(RepositoryInterface $apiTokenRepository)
    {
        $this->apiTokenRepository = $apiTokenRepository;
    }

    /**
     * {@inheritDoc}
     */
    public function start(Request $request, AuthenticationException $authException = null): ?JsonResponse
    {
    }

    /**
     * {@inheritDoc}
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey): ?JsonResponse
    {
    }

    /**
     * {@inheritDoc}
     */
    public function supports(Request $request): ?bool
    {
        // look for header "Authorization: Bearer <token>"
        return $request->headers->has('Authorization')
            && 0 === strpos($request->headers->get('Authorization'), 'Bearer ');
    }

    /**
     * {@inheritDoc}
     */
    public function getCredentials(Request $request): ?string
    {
        $authorizationHeader = $request->headers->get('Authorization');
        return substr($authorizationHeader, 7);
    }

    /**
     * {@inheritDoc}
     * @throws Exception
     */
    public function getUser($credentials, UserProviderInterface $userProvider): ?User
    {
        /** @var ApiToken $token */
        $token = $this->apiTokenRepository->findOneByToken($credentials);

        if (!$token) {
            throw new CustomUserMessageAuthenticationException(self::INVALID_CREDENTIALS_ERROR);
        }

        if ($token->isExpired()) {
            throw new CustomUserMessageAuthenticationException(self::TOKEN_EXPIRED_ERROR);
        }

        return $token->getUser();
    }

    /**
     * {@inheritDoc}
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): JsonResponse
    {
        return new JsonResponse([
            'message' => $exception->getMessageKey(),
        ], 401);
    }

    /**
     * {@inheritDoc}
     */
    public function checkCredentials($credentials, UserInterface $user): bool
    {
        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function supportsRememberMe(): bool
    {
        return false;
    }
}