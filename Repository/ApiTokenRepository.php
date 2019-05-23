<?php

/*
 * This file is part of hgpestana's user bundle.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HGPestana\UserBundle\Repository;


use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use HGPestana\UserBundle\Entity\ApiToken;

/**
 * Class ApiTokenRepository
 *
 * @author Hélder Pestana <hgpestana@gmail.com>
 *
 * @method findOneByToken(string $token, array $orderBy = null)
 */
class ApiTokenRepository extends EntityRepository
{
    /**
     * Persists the object to the database.
     *
     * @param ApiToken $apiToken
     * @param bool     $flush
     *
     * @return ApiToken
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function save(ApiToken $apiToken, $flush = true): ApiToken
    {
        $this->_em->persist($apiToken);
        if ($flush === true) {
            $this->_em->flush();
        }

        return $apiToken;
    }

    /**
     * Deletes the object from the database.
     *
     * @param ApiToken $apiToken
     * @param bool     $flush
     *
     * @return bool
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function delete(ApiToken $apiToken, $flush = true): bool
    {
        $this->_em->remove($apiToken);
        if ($flush === true) {
            $this->_em->flush();
        }
        return true;
    }
}