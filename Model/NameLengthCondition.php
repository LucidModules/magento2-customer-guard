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
