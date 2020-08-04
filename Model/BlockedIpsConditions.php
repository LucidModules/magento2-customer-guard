<?php

declare(strict_types=1);

namespace LS\CustomerGuard\Model;

use Magento\Customer\Api\Data\CustomerInterface;

/**
 * Verifies whether customer IP address is not banned.
 */
class BlockedIpsConditions implements RegisterConditionInterface
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
        return true; // TODO: retrieve IP from request or somewhat
    }
}
