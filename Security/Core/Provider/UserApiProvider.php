<?php


namespace HGPestana\UserBundle\Security\Core\Provider;


use HGPestana\UserBundle\Entity\User;
use HGPestana\UserBundle\Repository\UserRepository;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserApiProvider implements UserProviderInterface
{

    /** @var UserRepository */
    private $repository;

    /**
     * UserProvider constructor.
     *
     * @param UserRepository $repository
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * {@inheritDoc}
     */
    public function loadUserByUsername($apiToken): User
    {
        return $this->fetchUser($apiToken);
    }

    /**
     * Fetches the user from the database using the given parameter.
     *
     * @param string $apiToken
     *
     * @return User
     * @throws UsernameNotFoundException
     */
    private function fetchUser(string $apiToken): User
    {
        $user = $this->repository->findOneByToken($apiToken);
        if ($user === null) {
            throw new UsernameNotFoundException(
                sprintf('No user with the provided token "%s" could be found.', $apiToken)
            );
        }
        return $user;
    }

    /**
     * {@inheritDoc}
     */
    public function refreshUser(UserInterface $user): User
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(
                sprintf('Instances of "%s" are not supported.', get_class($user))
            );
        }
        $username = $user->getUsername();

        return $this->fetchUser($username);
    }

    /**
     * {@inheritDoc}
     */
    public function supportsClass($class): bool
    {
        return User::class === $class;
    }
}
