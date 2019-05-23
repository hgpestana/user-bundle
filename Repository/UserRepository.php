<?php

/*
 * This file is part of hgpestana's user bundle.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HGPestana\UserBundle\Repository;


use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use HGPestana\UserBundle\Entity\ApiToken;
use HGPestana\UserBundle\Entity\User;

/**
 * Class UserRepository
 *
 * @author Hélder Pestana <hgpestana@gmail.com>
 *
 * @method findOneByEmail(string $email, array $orderBy = null)
 */
class UserRepository extends EntityRepository
{
    /**
     * Persists the object to the database.
     *
     * @param User $user
     * @param bool $flush
     *
     * @return User
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function save(User $user, $flush = true): User
    {
        $this->_em->persist($user);
        if ($flush === true) {
            $this->_em->flush();
        }
        return $user;
    }

    /**
     * Deletes the object from the database.
     *
     * @param User $user
     * @param bool $flush
     *
     * @return bool
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function delete(User $user, $flush = true): bool
    {
        $this->_em->remove($user);
        if ($flush === true) {
            $this->_em->flush();
        }
        return true;
    }

    /**
     * Returns a single user using the api token
     *
     * @param string      $token
     * @param string|null $orderBy
     *
     * @return User|null
     * @throws NonUniqueResultException
     */
    public function findOneByToken(string $token, string $orderBy = null): ?User
    {
        $queryBuilder = $this->createQueryBuilder('u')
            ->join('u.apiTokens', 'a')
            ->where('a.token = :token')
            ->where('a.description = :description')
            ->setParameter(':token', $token)
            ->setParameter(':description', ApiToken::PLATFORM_KEY)
            ->orderBy($orderBy);

        return $queryBuilder->getQuery()->getOneOrNullResult(AbstractQuery::HYDRATE_OBJECT);
    }
}