<?php
/**
 * Copyright © Lucid Modules. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace LucidModules\CustomerGuard\Model;

use Magento\Customer\Api\Data\CustomerInterface;

/**
 * Verifies whether customer has blocked or allowed email domain.
 */
class EmailDomainsCondition implements RegisterConditionInterface
{
    /**
     * @var ConfigInterface
     */
    private $config;

    /**
     * @var EmailFactory
     */
    private $emailFactory;

    /**
     * @param ConfigInterface $config
     * @param EmailFactory $emailFactory
     */
    public function __construct(
        ConfigInterface $config,
        EmailFactory $emailFactory
    ) {
        $this->config = $config;
        $this->emailFactory = $emailFactory;
    }

    /**
     * @inheritDoc
     */
    public function isAllowed(CustomerInterface $customer): bool
    {
        /** @var Email $email */
        $email = $this->emailFactory->create(['email' => $customer->getEmail()]);

        return !$this->isDomainBlocked($email) && $this->isDomainAllowed($email);
    }

    /**
     * Check whether customer email domain is banned for registration.
     *
     * @param Email $email
     * @return bool
     */
    private function isDomainBlocked(Email $email): bool
    {
        $blockedEmailDomains = $this->config->getBlockedEmailDomains();
        foreach ($blockedEmailDomains as $blockedEmailDomain) {
            if ($email->domainEquals($blockedEmailDomain)) {
                return true;
            }
        }

        return false;
    }

    /**
     * If config has allowed domains, verify whether customer domain is allowed.
     *
     * Returns true if no allowed domains are provided.
     *
     * @param Email $email
     * @return bool
     */
    private function isDomainAllowed(Email $email): bool
    {
        $allowedEmailDomains = $this->config->getAllowedEmailDomains();

        if (empty($allowedEmailDomains)) {
            return true;
        }

        foreach ($allowedEmailDomains as $allowedEmailDomain) {
            if ($email->domainEquals($allowedEmailDomain)) {
                return true;
            }
        }

        return false;
    }
}
