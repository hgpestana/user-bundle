<?php
declare(strict_types=1);

/*
 * This file is part of hgpestana's user bundle.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HGPestana\UserBundle\Repository;


use BadMethodCallException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use HGPestana\UserBundle\Entity\ApiToken;
use InvalidArgumentException;

/**
 * Abstract class ObjectRepository
 *
 * @author Hélder Pestana <hgpestana@gmail.com>
 *
 */
abstract class AbstractObjectRepository implements RepositoryInterface
{

    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var string */
    private $className;

    public function __construct(EntityManagerInterface $entityManager, string $className)
    {
        $this->entityManager = $entityManager;
        $this->className = $className;
    }

    /**
     * {@inheritDoc}
     */
    public function save($apiToken, bool $flush = true): ApiToken
    {
        if (get_class($apiToken) !== $this->getClassName()) {
            throw new InvalidArgumentException(
                sprintf('This repository can only handle instances of %s!', $this->getClassName())
            );
        }

        $this->entityManager->persist($apiToken);
        if ($flush === true) {
            $this->entityManager->flush();
        }
        return $apiToken;
    }

    /**
     * {@inheritDoc}
     */
    public function getClassName(): string
    {
        return $this->className;
    }

    /**
     * {@inheritDoc}
     */
    public function delete($apiToken, bool $flush = true): bool
    {
        if (get_class($apiToken) !== $this->getClassName()) {
            throw new InvalidArgumentException(
                sprintf('This repository can only handle instances of %s!', $this->getClassName())
            );
        }

        $this->entityManager->remove($apiToken);
        if ($flush === true) {
            $this->entityManager->flush();
        }
        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function find($id): ApiToken
    {
        /** @var ApiToken $object */
        $object = $this->entityManager
            ->getRepository($this->getClassName())
            ->find($id);

        return $object;
    }

    /**
     * {@inheritDoc}
     */
    public function findAll(): array
    {
        return $this->findBy([]);
    }

    /**
     * {@inheritDoc}
     */
    public function findBy(array $criteria, ?array $orderBy = null, $limit = null, $offset = null): array
    {
        return $this->entityManager
            ->getRepository($this->getClassName())
            ->findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * {@inheritDoc}
     */
    public function createQueryBuilder(string $alias, string $indexBy = null): QueryBuilder
    {
        return $this->entityManager->createQueryBuilder()
            ->select($alias)
            ->from($this->className, $alias, $indexBy);
    }

    /**
     * Adds support for magic method calls.
     *
     * @param string $method
     * @param array  $arguments
     *
     * @return mixed The returned value from the resolved method.
     *
     * @throws BadMethodCallException If the method called is invalid
     */
    public function __call($method, $arguments)
    {
        if (strpos($method, 'findBy') === 0) {
            return $this->findBy([substr($method, 6) => $arguments[0]], ...array_slice($arguments, 1));
        }

        if (strpos($method, 'findOneBy') === 0) {
            return $this->findOneBy([substr($method, 9) => $arguments[0]]);
        }

        $trace = debug_backtrace();
        $file = $trace[0]['file'];
        $line = $trace[0]['line'];
        throw new BadMethodCallException(
            sprintf('Call to undefined method %s::%s() in %s on line %s.',
                __CLASS__,
                $method,
                $file,
                $line),
            E_USER_ERROR);
    }

    /**
     * {@inheritDoc}
     */
    public function findOneBy(array $criteria): ApiToken
    {
        /** @var ApiToken $object */
        $object = $this->entityManager
            ->getRepository($this->getClassName())
            ->findOneBy($criteria);

        return $object;
    }
}