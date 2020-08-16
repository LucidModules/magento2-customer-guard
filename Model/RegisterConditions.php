<?php
/**
 * Copyright © Lucid Solutions. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace LucidSolutions\CustomerGuard\Model;

use Magento\Customer\Api\Data\CustomerInterface;
use Psr\Log\LoggerInterface;

/**
 * Aggregates multiple conditions
 */
class RegisterConditions implements RegisterConditionInterface
{
    /**
     * @var RegisterConditionInterface[]
     */
    private $conditions;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var ConfigInterface
     */
    private $config;

    /**
     * @param LoggerInterface $logger
     * @param ConfigInterface $config
     * @param RegisterConditionInterface[] $conditions
     */
    public function __construct(
        LoggerInterface $logger,
        ConfigInterface $config,
        array $conditions = []
    ) {
        $this->conditions = $conditions;
        $this->logger = $logger;
        $this->config = $config;
    }

    /**
     * @inheritDoc
     */
    public function isAllowed(CustomerInterface $customer): bool
    {
        foreach ($this->conditions as $condition) {
            if (!$condition->isAllowed($customer)) {
                if ($this->config->getIsDebug()) {
                    $this->logDebugData($customer, $condition);
                }
                return false;
            }
        }

        return true;
    }

    /**
     * Log debug info about failed condition
     *
     * @param CustomerInterface $customer
     * @param RegisterConditionInterface $condition
     */
    private function logDebugData(CustomerInterface $customer, RegisterConditionInterface $condition): void
    {
        $this->logger->debug(
            'Register was blocked by condition.',
            [
                'customerEmail' => $customer->getEmail(),
                'condition' => get_class($condition)
            ]
        );
    }

}
