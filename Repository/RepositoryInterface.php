<?php

/*
 * This file is part of hgpestana's user bundle.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HGPestana\UserBundle\Repository;


use Doctrine\ORM\QueryBuilder;
use UnexpectedValueException;

/**
 * Interface responsible for defining the minimum necessary methods that need to be implemented in the
 * repository classes.
 *
 * @author Hélder Pestana <hgpestana@gmail.com>
 */
interface RepositoryInterface
{
    /**
     * Saves an object to the database
     *
     * @param mixed $object The object to be saved.
     * @param bool  $flush If the database should be flushed.
     *
     * @return object|null The object.
     */
    public function save($object, bool $flush = true);

    /**
     * Deletes an object from the database
     *
     * @param mixed $object The object to be deleted.
     * @param bool  $flush If the database should be flushed.
     *
     * @return bool
     */
    public function delete($object, bool $flush = true): bool;

    /**
     * Finds an object by its primary key / identifier.
     *
     * @param mixed $id The identifier.
     *
     * @return object|null The object.
     */
    public function find($id);

    /**
     * Finds all objects in the repository.
     *
     * @return object[] The objects.
     */
    public function findAll(): array;

    /**
     * Finds objects by a set of criteria.
     *
     * Optionally sorting and limiting details can be passed. An implementation may throw
     * an UnexpectedValueException if certain values of the sorting or limiting details are
     * not supported.
     *
     * @param mixed[]       $criteria
     * @param string[]|null $orderBy
     * @param int|null      $limit
     * @param int|null      $offset
     *
     * @return object[] The objects.
     *
     * @throws UnexpectedValueException
     */
    public function findBy(array $criteria, ?array $orderBy = null, $limit = null, $offset = null): array;

    /**
     * Finds a single object by a set of criteria.
     *
     * @param mixed[] $criteria The criteria.
     *
     * @return object|null The object.
     */
    public function findOneBy(array $criteria);

    /**
     * Returns the class name of the object managed by the repository.
     *
     * @return string
     */
    public function getClassName(): string;

    /**
     * Creates a new QueryBuilder instance that is prepopulated for this entity name.
     *
     * @param string $alias
     * @param string $indexBy The index for the from.
     *
     * @return QueryBuilder
     */
    public function createQueryBuilder(string $alias, string $indexBy = null): QueryBuilder;
}