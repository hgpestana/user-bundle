<?php

/*
 * This file is part of hgpestana's user bundle.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace HGPestana\UserBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Exception;

/**
 * Standard api token entity
 *
 * @author Hélder Pestana <hgpestana@gmail.com>
 *
 * @ORM\Entity
 * @ORM\Table(name="user_api_token")
 */
final class ApiToken extends TimeProperties
{

    public const PLATFORM_KEY = 'PLATFORM';

    /**
     * @var string
     * @ORM\Id
     * @ORM\Column(type="guid")
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="token", type="string", length=60)
     */
    private $token;

    /**
     * @var string
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var DateTime
     * @ORM\Column(name="expires_at", type="datetime")
     */
    private $expiresAt;

    /**
     * @var bool
     * @ORM\Column(name="immutable", type="boolean")
     */
    private $immutable;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User", inversedBy="apiTokens")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * ApiToken constructor.
     *
     * @param User   $user
     * @param string $description
     * @param bool   $immutable
     *
     * @throws Exception
     */
    public function __construct(User $user, string $description, bool $immutable = false)
    {
        $this->token = bin2hex(random_bytes(60));
        $this->description = $description;
        $this->user = $user;
        $this->immutable = $immutable;
        $this->expiresAt = new DateTime('+1 month');
    }

    /**
     * Get's the token id
     *
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Get's the token
     *
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * Get's the token's user
     *
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * Get's the token's description
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Set's the token's description
     *
     * @param string $description
     *
     * @return ApiToken
     */
    public function setDescription(string $description): self
    {
        if (!$this->immutable) {
            $this->description = $description;
        }

        return $this;
    }

    /**
     * Get's the immutable flag
     *
     * @return bool
     */
    public function getImmutable(): bool
    {
        return $this->immutable;
    }

    /**
     * Invalidates a token
     *
     * @return ApiToken
     * @throws Exception
     */
    public function invalidateKey(): self
    {
        $this->expiresAt = new DateTime('-1 year');
        return $this;
    }

    /**
     * Checks if a token has expired
     *
     * @return bool
     * @throws Exception
     */
    public function isExpired(): bool
    {
        return $this->getExpiresAt() <= new DateTime();
    }

    /**
     * Get's the token's expiration datetime
     *
     * @return DateTime
     */
    public function getExpiresAt(): DateTime
    {
        return $this->expiresAt;
    }

    /**
     * Set's the token's expiration datetime
     *
     * @param DateTime $expiresAt
     *
     * @return ApiToken
     */
    public function setExpiresAt(DateTime $expiresAt): self
    {
        if (!$this->immutable) {
            $this->expiresAt = $expiresAt;
        }

        return $this;
    }

}