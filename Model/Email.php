<?php

declare(strict_types=1);

namespace LS\CustomerGuard\Model;

/**
 * Customer's email validation
 */
class Email
{
    /**
     * @var string
     */
    private $email;

    /**
     * @param string $email
     */
    public function __construct(string $email)
    {
        $this->email = $email;
    }

    /**
     * Verifies customer email domain.
     *
     * @param string $domain
     * @return bool
     */
    public function domainEquals(string $domain): bool
    {
        return false;
    }
}
