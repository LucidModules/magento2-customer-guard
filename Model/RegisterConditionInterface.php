<?php

declare(strict_types=1);

namespace LS\CustomerGuard\Model;

use Magento\Customer\Api\Data\CustomerInterface;

interface RegisterConditionInterface
{
    /**
     * Return true when customer registration is allowed.
     *
     * @param CustomerInterface $customer
     * @return bool
     */
    public function isAllowed(CustomerInterface $customer): bool;
}
