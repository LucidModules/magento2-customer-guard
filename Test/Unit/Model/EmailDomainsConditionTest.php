<?php
/**
 * Copyright © Lucid Modules. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace LucidModules\CustomerGuard\Test\Unit\Model;

use LucidModules\CustomerGuard\Model\ConfigInterface;
use LucidModules\CustomerGuard\Model\EmailDomainsCondition;
use LucidModules\CustomerGuard\Model\Email;
use LucidModules\CustomerGuard\Model\EmailFactory;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class EmailDomainsConditionTest extends TestCase
{
    /**
     * @var ConfigInterface|MockObject
     */
    private MockObject|ConfigInterface $configMock;

    /**
     * @var EmailDomainsCondition
     */
    private EmailDomainsCondition $emailDomainsCondition;

    /**
     * @var MockObject|CustomerInterface
     */
    private CustomerInterface|MockObject $customerMock;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $objectManager = new ObjectManager($this);
        $emailFactory = $this->getMockBuilder(EmailFactory::class)
            ->setMethods(['create'])
            ->disableOriginalConstructor()
            ->getMock();
        $emailFactory->method('create')->willReturnCallback(function ($data) use ($objectManager) {
            return $objectManager->getObject(Email::class, $data);
        });
        $this->configMock = $this->getMockBuilder(ConfigInterface::class)->getMock();
        $this->customerMock = $this->getMockBuilder(CustomerInterface::class)->getMock();
        $this->emailDomainsCondition = $objectManager->getObject(
            EmailDomainsCondition::class,
            [
                'config' => $this->configMock,
                'emailFactory' => $emailFactory
            ]
        );
    }

    /**
     * @dataProvider isAllowedDataProvider
     * @param bool $expectedResult
     * @param array $blockedDomains
     * @param array $allowedDomains
     * @param string $customerEmail
     */
    public function testIsAllowed(
        bool $expectedResult,
        array $blockedDomains,
        array $allowedDomains,
        string $customerEmail
    ): void {
        $this->configMock->method('getBlockedEmailDomains')->willReturn($blockedDomains);
        $this->configMock->method('getAllowedEmailDomains')->willReturn($allowedDomains);
        $this->customerMock->method('getEmail')->willReturn($customerEmail);

        $this->assertEquals($expectedResult, $this->emailDomainsCondition->isAllowed($this->customerMock));
    }

    /**
     * Is allowed test data provider
     *
     * @return array
     */
    public function isAllowedDataProvider(): array
    {
        return [
            [true, ['example.com'], [], 'john@doe.com'],
            [true, ['example.com'], ['doe.com'], 'john@doe.com'],
            [true, [], ['doe.com'], 'john@doe.com'],
            [true, [], [], 'john@doe.com'],
            [false, ['example.com'], [], 'john@example.com'],
            [false, ['example.com'], ['doe'], 'john@other.com'],
            [false, [], ['doe'], 'john@other.com'],
        ];
    }
}
