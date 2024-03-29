<?php
/**
 * Copyright © Lucid Modules. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace LucidModules\CustomerGuard\Model;

use Magento\Customer\Api\Data\CustomerInterface;

/**
 * Verifies whether customer name is not banned.
 */
class BlockedNamesCondition implements RegisterConditionInterface
{
    /**
     * @param ConfigInterface $config
     */
    public function __construct(
        private readonly ConfigInterface $config
    ) {
    }

    /**
     * @param CustomerInterface $customer
     * @return bool
     */
    public function isAllowed(CustomerInterface $customer): bool
    {
        $bannedNames = $this->config->getBlockedCustomerNames();

        return !in_array($customer->getFirstname(), $bannedNames)
            && !in_array($customer->getLastname(), $bannedNames);
    }
}
