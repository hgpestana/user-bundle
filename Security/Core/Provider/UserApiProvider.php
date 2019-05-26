<?php
declare(strict_types=1);

/*
 * This file is part of hgpestana's user bundle.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HGPestana\UserBundle\Security\Core\Provider;


use Doctrine\ORM\NonUniqueResultException;
use HGPestana\UserBundle\Entity\User;
use HGPestana\UserBundle\Repository\RepositoryInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

final class UserApiProvider implements UserProviderInterface
{

    /** @var RepositoryInterface */
    private $repository;

    /**
     * UserProvider constructor.
     *
     * @param RepositoryInterface $repository
     */
    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * {@inheritDoc}
     * @throws NonUniqueResultException
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
     * @throws NonUniqueResultException
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
     * @throws NonUniqueResultException
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
