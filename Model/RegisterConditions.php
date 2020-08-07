<?php

declare(strict_types=1);

namespace LS\CustomerGuard\Model;

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
     * @param LoggerInterface $logger
     * @param RegisterConditionInterface[] $conditions
     */
    public function __construct(
        LoggerInterface $logger,
        array $conditions = []
    ) {
        $this->conditions = $conditions;
        $this->logger = $logger;
    }

    /**
     * @inheritDoc
     */
    public function isAllowed(CustomerInterface $customer): bool
    {
        foreach ($this->conditions as $condition) {
            if (!$condition->isAllowed($customer)) {
                $this->logger->debug('Condition blocked: ' . get_class($condition));
                return false;
            }
        }

        return true;
    }
}
