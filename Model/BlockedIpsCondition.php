<?php
/**
 * Copyright © Lucid Solutions. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace LucidSolutions\CustomerGuard\Model;

use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Framework\HTTP\PhpEnvironment\RemoteAddress;

/**
 * Verifies whether customer IP address is not banned.
 */
class BlockedIpsCondition implements RegisterConditionInterface
{
    /**
     * @var ConfigInterface
     */
    private $config;

    /**
     * @var RemoteAddress
     */
    private $remoteAddress;

    /**
     * @param ConfigInterface $config
     * @param RemoteAddress $remoteAddress
     */
    public function __construct(
        ConfigInterface $config,
        RemoteAddress $remoteAddress
    ) {
        $this->config = $config;
        $this->remoteAddress = $remoteAddress;
    }

    /**
     * @inheritDoc
     */
    public function isAllowed(CustomerInterface $customer): bool
    {
        $blockedIps = $this->config->getBlockedIps();
        $ip = $this->remoteAddress->getRemoteAddress();

        return !in_array($ip, $blockedIps);
    }
}
