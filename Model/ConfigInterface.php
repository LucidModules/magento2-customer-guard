<?php

declare(strict_types=1);

namespace LS\CustomerGuard\Model;

/**
 * Interface for module configuration
 */
interface ConfigInterface
{
    /**
     * Get disallowed customer email domains.
     *
     * @return string[]
     */
    public function getBlockedEmailDomains(): array;

    /**
     * Get allowed customer email domains.
     *
     * @return string[]
     */
    public function getAllowedEmailDomains(): array;

    /**
     * Get allowed first name length. Returns null if no limit has been set.
     *
     * @return int|null
     */
    public function getMaxFirstNameLength(): ?int;

    /**
     * Get allowed last name length. Returns null if no limit has been set.
     *
     * @return int|null
     */
    public function getMaxLastNameLength(): ?int;

    /**
     * Get message displayed for a customer, when he does not meet conditions for registration.
     *
     * @return string
     */
    public function getRegisterRestrictionMessage(): string;

    /**
     * Get banned customer names.
     *
     * @return string[]
     */
    public function getBlockedCustomerNames(): array;

    /**
     * Get banned from registration customer's IP addresses.
     *
     * @return string[]
     */
    public function getBlockedIps(): array;

    /**
     * Check whether debug mode is enabled.
     *
     * @return bool
     */
    public function getIsDebug(): bool;
}
