<?php


namespace HGPestana\UserBundle\Security\Core\Authentication;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class EmailPasswordAuthenticator extends AbstractGuardAuthenticator
{

    public function supports(Request $request)
    {
        // look for header "Authorization: Basic <64bit encoded keypair>"
        return $request->headers->has('Authorization')
            && 0 === strpos($request->headers->get('Authorization'), 'Basic ');
    }

    public function getCredentials(Request $request)
    {
        $credentialsHeader = $request->headers->get('Authorization');
        $credentials = explode(":", base64_decode($credentialsHeader, 6));

        if (count($credentials) != 2) {
            throw new CustomUserMessageAuthenticationException("Invalid credentials supplied.");
        }

        return [
            'email' => $credentials[0],
            'password' => $credentials[1],
        ];
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        // TODO: Implement getUser() method.
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        // TODO: Implement checkCredentials() method.
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        // todo
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        // TODO: Implement onAuthenticationFailure() method.
    }

    public function supportsRememberMe()
    {
        // TODO: Implement supportsRememberMe() method.
    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
        // TODO: Implement start() method.
    }

    protected function getLoginUrl()
    {
        // TODO: Implement getLoginUrl() method.
    }
}