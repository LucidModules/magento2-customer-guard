<?php
/**
 * Copyright © Lucid Modules. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace LucidModules\CustomerGuard\Model;

use Magento\Customer\Api\Data\CustomerInterface;
use Psr\Log\LoggerInterface;

/**
 * Aggregates multiple conditions
 */
class RegisterConditions implements RegisterConditionInterface
{
    /**
     * @param LoggerInterface $logger
     * @param ConfigInterface $config
     * @param RegisterConditionInterface[] $conditions
     */
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly ConfigInterface $config,
        private readonly array $conditions = []
    ) {
    }

    /**
     * @param CustomerInterface $customer
     * @return bool
     */
    public function isAllowed(CustomerInterface $customer): bool
    {
        foreach ($this->conditions as $condition) {
            if (!$condition->isAllowed($customer)) {
                $this->maybeDebugLog($customer, $condition);
                return false;
            }
        }

        return true;
    }

    /**
     * Conditionally log debug info about failed condition
     *
     * @param CustomerInterface $customer
     * @param RegisterConditionInterface $condition
     */
    private function maybeDebugLog(CustomerInterface $customer, RegisterConditionInterface $condition): void
    {
        if (!$this->config->getIsDebug()) {
            return;
        }

        $this->logger->debug(
            'Register was blocked by condition.',
            [
                'customerEmail' => $customer->getEmail(),
                'condition' => get_class($condition)
            ]
        );
    }
}
