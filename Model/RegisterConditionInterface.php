<?php
/**
 * Copyright © Lucid Modules. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace LucidModules\CustomerGuard\Model;

use Magento\Customer\Api\Data\CustomerInterface;

/**
 * Interface defining contract for Register Conditions.
 */
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
