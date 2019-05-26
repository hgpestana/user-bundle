<?php
declare(strict_types=1);

/*
 * This file is part of hgpestana's user bundle.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HGPestana\UserBundle\Repository;


use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\NonUniqueResultException;
use HGPestana\UserBundle\Entity\ApiToken;
use HGPestana\UserBundle\Entity\User;

/**
 * Repository class for the user entity.
 *
 * @author Hélder Pestana <hgpestana@gmail.com>
 */
final class UserRepository extends ObjectRepository
{
    /**
     * Returns a single user using the api token
     *
     * @param string $token
     *
     * @return User|null
     * @throws NonUniqueResultException
     */
    public function findOneByToken(string $token): ?User
    {
        $queryBuilder = $this->createQueryBuilder('u')
            ->join('u.apiTokens', 'a')
            ->where('a.token = :token')
            ->where('a.description = :description')
            ->setParameter(':token', $token)
            ->setParameter(':description', ApiToken::PLATFORM_KEY);

        return $queryBuilder->getQuery()->getOneOrNullResult(AbstractQuery::HYDRATE_OBJECT);
    }
}