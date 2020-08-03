<?php

declare(strict_types=1);

namespace LS\CustomerGuard\Plugin;

use LS\CustomerGuard\Model\RegisterConditionInterface;
use Magento\Customer\Model\CustomerExtractor;
use Magento\Customer\Model\Registration;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Message\ManagerInterface as MessageManager;

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
     * @param RequestInterface $request
     * @param CustomerExtractor $customerExtractor
     * @param RegisterConditionInterface $registerCondition
     * @param MessageManager $messageManager
     */
    public function __construct(
        RequestInterface $request,
        CustomerExtractor $customerExtractor,
        RegisterConditionInterface $registerCondition,
        MessageManager $messageManager
    ) {
        $this->request = $request;
        $this->customerExtractor = $customerExtractor;
        $this->registerCondition = $registerCondition;
        $this->messageManager = $messageManager;
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
            // TODO: retrieve message from config
            $this->messageManager->addErrorMessage('You are not allowed to register with this data');
        }

        return $isAllowed;
    }
}
