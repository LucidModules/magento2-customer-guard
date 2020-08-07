<?php

declare(strict_types=1);

namespace LS\CustomerGuard\Model;

use Magento\Customer\Api\Data\CustomerInterface;

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
     * @param RegisterConditionInterface[] $conditions
     */
    public function __construct(
        array $conditions = []
    ) {
        $this->conditions = $conditions;
    }

    /**
     * @inheritDoc
     */
    public function isAllowed(CustomerInterface $customer): bool
    {
        foreach ($this->conditions as $condition) {
            if (!$condition->isAllowed($customer)) {
                return false;
            }
        }

        return true;
    }
}
