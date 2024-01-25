<?php
/**
 * Copyright © Lucid Modules. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace LucidModules\CustomerGuard\Plugin;

use LucidModules\CustomerGuard\Model\ConfigInterface;
use LucidModules\CustomerGuard\Model\RegisterConditionInterface;
use Magento\Customer\Api\AccountManagementInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Framework\Exception\LocalizedException;

/**
 * Performs Customer registration constraints validation.
 */
class AccountManagementPlugin
{
    /**
     * @param RegisterConditionInterface $registerCondition
     * @param ConfigInterface $config
     */
    public function __construct(
        private readonly RegisterConditionInterface $registerCondition,
        private readonly ConfigInterface $config
    ) {
    }

    /**
     * Apply additional validations.
     *
     * @param AccountManagementInterface $subject
     * @param CustomerInterface $customer
     * @param null $password
     * @param string $redirectUrl
     * @return array
     * @throws LocalizedException
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function beforeCreateAccount(
        AccountManagementInterface $subject,
        CustomerInterface $customer,
        $password = null,
        $redirectUrl = ''
    ): array {
        $this->throwOnFailingCustomerConstraints($customer);

        return [$customer, $password, $redirectUrl];
    }

    /**
     * Throws when customer does not meet configured constraints.
     *
     * @param CustomerInterface $customer
     * @throws LocalizedException
     */
    private function throwOnFailingCustomerConstraints(CustomerInterface $customer): void
    {
        if (!$this->registerCondition->isAllowed($customer)) {
            throw new LocalizedException(__($this->config->getRegisterRestrictionMessage()));
        }
    }

    /**
     * Apply additional validations.
     *
     * @param AccountManagementInterface $subject
     * @param CustomerInterface $customer
     * @param $hash
     * @param string $redirectUrl
     * @return array
     * @throws LocalizedException
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function beforeCreateAccountWithPasswordHash(
        AccountManagementInterface $subject,
        CustomerInterface $customer,
        $hash,
        $redirectUrl = ''
    ): array {
        $this->throwOnFailingCustomerConstraints($customer);

        return [$customer, $hash, $redirectUrl];
    }

    /**
     * Apply additional validations.
     *
     * @param AccountManagementInterface $subject
     * @param CustomerInterface $customer
     * @return array
     * @throws LocalizedException
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function beforeValidate(
        AccountManagementInterface $subject,
        CustomerInterface $customer
    ): array {
        $this->throwOnFailingCustomerConstraints($customer);

        return [$customer];
    }
}
