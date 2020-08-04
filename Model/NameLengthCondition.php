<?php

declare(strict_types=1);

namespace LS\CustomerGuard\Model;

use Magento\Customer\Api\Data\CustomerInterface;

/**
 * Verifies whether customer name fits desired length.
 */
class NameLengthCondition implements RegisterConditionInterface
{
    /**
     * @var ConfigInterface
     */
    private $config;

    /**
     * @param ConfigInterface $config
     */
    public function __construct(
        ConfigInterface $config
    ) {
        $this->config = $config;
    }

    /**
     * @inheritDoc
     */
    public function isAllowed(CustomerInterface $customer): bool
    {
        return mb_strlen($customer->getLastname()) <= $this->config->getMaxLastNameLength()
            && mb_strlen($customer->getFirstname()) <= $this->config->getMaxFirstNameLength();
    }
}
