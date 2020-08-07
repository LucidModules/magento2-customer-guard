<?php

declare(strict_types=1);

namespace LS\CustomerGuard\Plugin;

use LS\CustomerGuard\Model\RegisterConditionInterface;
use LS\CustomerGuard\Model\ConfigInterface;
use Magento\Customer\Model\CustomerExtractor;
use Magento\Customer\Model\Registration;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Message\ManagerInterface as MessageManager;

/**
 * Performs Customer registration constraints validation
 */
class CustomerRegistrationPlugin
{
    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var CustomerExtractor
     */
    private $customerExtractor;

    /**
     * @var RegisterConditionInterface
     */
    private $registerCondition;

    /**
     * @var MessageManager
     */
    private $messageManager;

    /**
     * @var ConfigInterface
     */
    private $config;

    /**
     * @param RequestInterface $request
     * @param CustomerExtractor $customerExtractor
     * @param RegisterConditionInterface $registerCondition
     * @param MessageManager $messageManager
     * @param ConfigInterface $config
     */
    public function __construct(
        RequestInterface $request,
        CustomerExtractor $customerExtractor,
        RegisterConditionInterface $registerCondition,
        MessageManager $messageManager,
        ConfigInterface $config
    ) {
        $this->request = $request;
        $this->customerExtractor = $customerExtractor;
        $this->registerCondition = $registerCondition;
        $this->messageManager = $messageManager;
        $this->config = $config;
    }

    /**
     * If previous validations succeed, adds configured restrictions of this module.
     *
     * @param Registration $subject
     * @param bool $result
     * @return bool
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterIsAllowed(
        Registration $subject,
        bool $result
    ): bool {
        if (!$result) {
            return false;
        }

        $customer = $this->customerExtractor->extract('customer_account_create', $this->request);
        $isAllowed = $this->registerCondition->isAllowed($customer);
        if (!$isAllowed) {
            $this->messageManager->addErrorMessage($this->config->getRegisterRestrictionMessage());
        }

        return $isAllowed;
    }
}
