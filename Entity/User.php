<?php

/*
 * This file is part of hgpestana's user bundle.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HGPestana\UserBundle\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use Serializable;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Standard user authentication entity
 *
 * @author Hélder Pestana <hgpestana@gmail.com>
 *
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User implements AdvancedUserInterface, Serializable
{
    public const ROLE_DEFAULT = 'ROLE_USER';
    public const ROLE_SUPER_ADMIN = 'ROLE_SUPER_ADMIN';

    /**
     * @var string
     * @ORM\Id
     * @ORM\Column(type="guid")
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;

    /**
     * @var string
     * @Assert\Email
     * @ORM\Column(name="email", type="string", length=50, unique=true)
     */
    private $email;

    /**
     * @var string
     * @Assert\Email
     * @ORM\Column(name="email_canonical", type="string", length=50, unique=true)
     */
    private $emailCanonical;

    /**
     * @var bool
     * @ORM\Column(name="enabled", type="boolean")
     */
    private $enabled;

    /**
     * @var bool
     * @ORM\Column(name="locked", type="boolean")
     */
    private $locked;

    /**
     * @var string
     * @Assert\NotBlank
     * @ORM\Column(name="password", type="string", length=60)
     */
    private $password;

    /**
     * @var DateTime
     * @ORM\Column(name="last_login", type="datetime")
     *
     */
    private $lastLogin;

    /**
     * @var string
     * @ORM\Column(name="confirmation_token", type="string", length=60, unique=true)
     */
    private $confirmationToken;

    /**
     * @var array
     * @ORM\Column(name="roles", type="array")
     */
    private $roles;

    /**
     * @var string
     * @ORM\Column(name="salt", type="string", length=30, nullable=true)
     */
    private $salt;

    /**
     * @var DateTime
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var DateTime
     * @ORM\Column(name="last_updated", type="datetime")
     */
    private $lastUpdated;

    /**
     * @var DateTime
     * @ORM\Column(name="password_requested_at", type="datetime", nullable=true)
     */
    private $passwordRequestedAt;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="ApiToken", mappedBy="user")
     */
    private $apiTokens;

    /**
     * User constructor.
     *
     * @param string      $email
     * @param string      $password
     * @param string|null $salt
     *
     * @throws Exception
     */
    public function __construct(string $email, string $password, string $salt = null)
    {
        $this->email = $email;
        $this->emailCanonical = mb_strtolower($email, 'UTF-8');
        $this->password = $password;
        $this->enabled = false;
        $this->salt = $salt;
        $this->locked = false;
        $this->confirmationToken = bin2hex(random_bytes(60));
    }

    /**
     * {@inheritDoc}
     */
    public function isAccountNonExpired(): bool
    {
        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function isAccountNonLocked(): bool
    {
        return !$this->locked;
    }

    /**
     * {@inheritDoc}
     */
    public function isCredentialsNonExpired(): bool
    {
        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * Enables the user
     *
     * @param bool $enabled
     *
     * @return User
     */
    public function setEnabled(bool $enabled): self
    {
        $this->enabled = $enabled;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Set's the user password. Must be encrypted and persisted.
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getSalt(): ?string
    {
        return $this->salt;
    }

    /**
     * Set's the salt, if required.
     *
     * @param string $salt
     *
     * @return User
     */
    public function setSalt(string $salt): self
    {
        $this->salt = $salt;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getUsername(): ?string
    {
        return $this->email;
    }

    /**
     * {@inheritDoc}
     */
    public function eraseCredentials(): void
    {
    }

    /**
     * {@inheritDoc}
     */
    public function serialize(): ?string
    {
        return serialize([
            $this->password,
            $this->salt,
            $this->enabled,
            $this->id,
            $this->email,
            $this->emailCanonical,
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function unserialize($serialized): void
    {
        $data = unserialize($serialized);
        [
            $this->password,
            $this->salt,
            $this->enabled,
            $this->id,
            $this->email,
            $this->emailCanonical,
        ] = $data;
    }

    /**
     * Get's the last updated datetime
     *
     * @return DateTime
     */
    public function getLastUpdated(): ?DateTime
    {
        return $this->lastUpdated;
    }

    /**
     * Automatically updates the timestamps.
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamps(): void
    {
        $now = new DateTime('now');
        $this->setLastUpdated($now);
        if ($this->getCreatedAt() == null) {
            $this->setCreatedAt($now);
        }
    }

    /**
     * Set's the last updated datetime
     *
     * @param DateTime $lastUpdated
     *
     * @return User
     */
    private function setLastUpdated(DateTime $lastUpdated): self
    {
        $this->lastUpdated = $lastUpdated;
        return $this;
    }

    /**
     * Get's the created at datetime
     *
     * @return DateTime
     */
    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    /**
     * Set's the created at datetime
     *
     * @param DateTime $createdAt
     *
     * @return User
     */
    private function setCreatedAt(DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * Returns the user id
     *
     * @return string
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Returns the canonical username.
     *
     * @return string
     */
    public function getUsernameCanonical(): string
    {
        return $this->emailCanonical;
    }

    /**
     * Returns the email.
     *
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Set's the email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;
        $this->emailCanonical = mb_strtolower($email, 'UTF-8');
        return $this;
    }

    /**
     * Get's the canonical email
     *
     * @return string
     */
    public function getEmailCanonical(): string
    {
        return $this->emailCanonical;
    }

    /**
     * Get's the last login datetime
     *
     * @return DateTime
     */
    public function getLastLogin(): ?DateTime
    {
        return $this->lastLogin;
    }

    /**
     * Set's the last login datetime
     *
     * @param DateTime $lastLogin
     *
     * @return User
     */
    public function setLastLogin(Datetime $lastLogin): self
    {
        $this->lastLogin = $lastLogin;
        return $this;
    }

    /**
     * Get's the confirmation token from the database
     *
     * @return string
     */
    public function getConfirmationToken(): string
    {
        return $this->confirmationToken;
    }

    /**
     * Set's the confirmation token
     *
     * @param string $confirmationToken
     *
     * @return User
     */
    public function setConfirmationToken(string $confirmationToken): self
    {
        $this->confirmationToken = $confirmationToken;
        return $this;
    }

    /**
     * Checks if the user is a super admin
     *
     * @return bool
     */
    public function isSuperAdmin(): bool
    {
        return $this->hasRole(self::ROLE_SUPER_ADMIN);
    }

    public function hasRole(string $role): bool
    {
        return in_array(strtoupper($role), $this->getRoles(), true);
    }

    /**
     * {@inheritDoc}
     */
    public function getRoles(): array
    {
        $roles[] = self::ROLE_DEFAULT;
        return array_unique($this->roles);
    }

    /**
     * Set's the user roles
     *
     * @param array $roles
     *
     * @return User
     */
    public function setRoles(array $roles): self
    {
        $this->roles = [];
        foreach ($roles as $role) {
            $this->addRole($role);
        }
        return $this;
    }

    /**
     * Adds a role to the user
     *
     * @param string $role
     *
     * @return User
     */
    public function addRole(string $role): self
    {
        $role = strtoupper($role);
        if ($role === self::ROLE_DEFAULT) {
            return $this;
        }
        if (!in_array($role, $this->roles, true)) {
            $this->roles[] = $role;
        }
        return $this;
    }

    /**
     * Set's the username
     *
     * @param string $email
     *
     * @return User
     */
    public function setUsername(string $email): self
    {
        return $this->setEmail($email);
    }

    /**
     * Set's the user as superadmin
     *
     * @return User
     */
    public function setSuperAdmin(): self
    {
        $this->addRole(self::ROLE_SUPER_ADMIN);
        return $this;
    }

    /**
     * Unset's the user from the role of superadmin
     *
     * @return User
     */
    public function unsetSuperAdmin(): self
    {
        $this->removeRole(self::ROLE_SUPER_ADMIN);
        return $this;
    }

    /**
     * Removes a user role
     *
     * @param string $role
     *
     * @return User
     */
    public function removeRole(string $role): self
    {
        $key = array_search(strtoupper($role), $this->roles, true);

        if ($key !== false) {
            unset($this->roles[$key]);
            $this->roles = array_values($this->roles);
        }

        return $this;
    }

    /**
     * Get's the password modification request datetime
     *
     * @return null|DateTime
     */
    public function getPasswordRequestedAt(): ?DateTime
    {
        return $this->passwordRequestedAt;
    }

    /**
     * Set's the password modification request datetime
     *
     * @param DateTime $passwordRequestedAt
     *
     * @return User
     */
    public function setPasswordRequestedAt(DateTime $passwordRequestedAt): self
    {
        $this->passwordRequestedAt = $passwordRequestedAt;
        return $this;
    }

    /**
     * Checks if the password modification request hasn't expired.
     *
     * @param $ttl
     *
     * @return bool
     */
    public function isPasswordRequestNonExpired($ttl): bool
    {
        return $this->passwordRequestedAt instanceof DateTime &&
            $this->passwordRequestedAt->getTimestamp() + $ttl > time();
    }

    /**
     * Retuns an array collection with all the api tokens assigned to this user.
     *
     * @return ArrayCollection
     */
    public function getApiTokens(): ArrayCollection
    {
        return $this->apiTokens;
    }

}