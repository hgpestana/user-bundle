<?php
declare(strict_types = 1);

/*
 * This file is part of hgpestana's user bundle.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HGPestana\UserBundle\Manager;


use HGPestana\UserBundle\Entity\User;
use HGPestana\UserBundle\Helper\Setter\SetterInterface;
use HGPestana\UserBundle\Repository\UserRepository;

/**
 * Manager class for the user entity.
 *
 * @author Hélder Pestana <hgpestana@gmail.com>
 */
class UserManager
{
    /** @var UserRepository */
    private $repository;

    /** @var SetterInterface */
    private $setter;

    /**
     * UserManager constructor.
     *
     * @param UserRepository  $repository
     * @param SetterInterface $setter
     */
    public function __construct(UserRepository $repository, SetterInterface $setter)
    {
        $this->repository = $repository;
        $this->setter = $setter;
    }

    /**
     * @param string $username
     * @param string $password
     *
     * @return User
     */
    public function create(string $username, string $password) : User
    {
        return new User($username, $password);
    }

    /**
     * @param User $user
     *
     * @return bool
     */
    public function delete(User $user) : bool
    {
        return $this->repository->delete($user);
    }

    /**
     * @param User  $user
     * @param array $parameters
     *
     * @return User
     */
    public function update(User $user, array $parameters) : User
    {
        /** @var User $user */
        /** @noinspection CallableParameterUseCaseInTypeContextInspection */
        $user = $this->setter->set($user, $parameters);
        return $this->save($user);
    }

    /**
     * @param User $user
     *
     * @return User
     */
    public function save(User $user) : User
    {
        return $this->repository->save($user);
    }
}