<?php
/**
 * Copyright © Lucid Modules. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace LucidModules\CustomerGuard\Model;

use Magento\Customer\Api\Data\CustomerInterface;

/**
 * Verifies whether customer name fits desired length.
 */
class NameLengthCondition implements RegisterConditionInterface
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
        $result = true;
        if ($this->config->getMaxFirstNameLength() > 0) {
            $result &= mb_strlen($customer->getFirstname()) <= $this->config->getMaxFirstNameLength();
        }

        if ($this->config->getMaxLastNameLength() > 0) {
            $result &= mb_strlen($customer->getLastname()) <= $this->config->getMaxLastNameLength();
        }

        return (bool)$result;
    }
}
