<?php
/**
 * Copyright © Lucid Modules. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace LucidModules\CustomerGuard\Model;

use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Framework\HTTP\PhpEnvironment\RemoteAddress;

/**
 * Verifies whether customer IP address is not banned.
 */
class BlockedIpsCondition implements RegisterConditionInterface
{
    /**
     * @param ConfigInterface $config
     * @param RemoteAddress $remoteAddress
     */
    public function __construct(
        private readonly ConfigInterface $config,
        private readonly RemoteAddress $remoteAddress
    ) {
    }

    /**
     * @param CustomerInterface $customer
     * @return bool
     */
    public function isAllowed(CustomerInterface $customer): bool
    {
        $blockedIps = $this->config->getBlockedIps();
        $ip = $this->remoteAddress->getRemoteAddress();

        return !in_array($ip, $blockedIps);
    }
}
