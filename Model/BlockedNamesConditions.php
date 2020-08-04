<?php

declare(strict_types=1);

namespace LS\CustomerGuard\Model;

use Magento\Customer\Api\Data\CustomerInterface;

/**
 * Verifies whether customer name is not banned.
 */
class BlockedNamesConditions implements RegisterConditionInterface
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
        $bannedNames = $this->config->getBlockedCustomerNames();

        return !in_array($customer->getFirstname(), $bannedNames)
            && !in_array($customer->getLastname(), $bannedNames);
    }
}
