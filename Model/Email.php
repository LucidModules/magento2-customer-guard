<?php
/**
 * Copyright © Lucid Modules. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace LucidModules\CustomerGuard\Model;

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
     * @var string
     */
    private $domain;

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
        return strcasecmp((string)$this->getDomain(), $domain) === 0;
    }

    /**
     * Get domain for this email
     *
     * @return string|null
     */
    private function getDomain(): ?string
    {
        if (!$this->domain) {
            $this->domain = explode('@', $this->email);
            $this->domain = $this->domain[1] ?? null;
        }

        return $this->domain;
    }
}
