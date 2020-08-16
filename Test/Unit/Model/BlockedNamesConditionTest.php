<?php
/**
 * Copyright © Lucid Solutions. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace LucidSolutions\CustomerGuard\Test\Unit\Model;

use LucidSolutions\CustomerGuard\Model\BlockedNamesCondition;
use LucidSolutions\CustomerGuard\Model\ConfigInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class BlockedNamesConditionTest extends TestCase
{
    /**
     * BlockedNamesCondition::isAllowed should return true
     *
     * when domain lastName and firstName are not banned.
     *
     * @return void
     */
    public function testValidLengthReturnsTrue(): void
    {
        $bannedNames = ['foo', 'bar'];
        $configMock = $this->getConfigMock($bannedNames);
        $nameLengthCondition = $this->getBlockedNamesCondition($configMock);
        $customerMock = $this->getCustomerMock('john', 'doe');

        $this->assertEquals(true, $nameLengthCondition->isAllowed($customerMock));
    }

    /**
     * BlockedNamesCondition::isAllowed should return false
     *
     * when domain lastName and firstName are banned.

     * @return void
     */
    public function testInvalidLengthReturnsFalse(): void
    {
        $bannedNames = ['foo', 'bar'];
        $configMock = $this->getConfigMock($bannedNames);
        $nameLengthCondition = $this->getBlockedNamesCondition($configMock);

        $customerMock = $this->getCustomerMock('foo', 'doe');
        $this->assertEquals(false, $nameLengthCondition->isAllowed($customerMock));

        $customerMock = $this->getCustomerMock('john', 'bar');
        $this->assertEquals(false, $nameLengthCondition->isAllowed($customerMock));
    }

    /**
     * Get instance for testing
     *
     * @param ConfigInterface $config
     * @return BlockedNamesCondition
     */
    private function getBlockedNamesCondition(ConfigInterface $config): BlockedNamesCondition
    {
        /** @var BlockedNamesCondition $blockedNamesCondition */
        $blockedNamesCondition = (new ObjectManager($this))
            ->getObject(BlockedNamesCondition::class, ['config' => $config]);

        return $blockedNamesCondition;
    }

    /**
     * Get config mock
     *
     * @param string[] $blockedNames
     * @return ConfigInterface|MockObject
     */
    private function getConfigMock(array $blockedNames)
    {
        $configMock = $this->getMockBuilder(ConfigInterface::class)
            ->getMock();
        $configMock->method('getBlockedCustomerNames')
            ->willReturn($blockedNames);

        return $configMock;
    }

    /**
     * Get customer mock
     *
     * @param string $firstName
     * @param string $lastName
     * @return CustomerInterface|MockObject
     */
    private function getCustomerMock(string $firstName, string $lastName): CustomerInterface
    {
        $customerMock = $this->getMockBuilder(CustomerInterface::class)
            ->getMock();
        $customerMock->method('getFirstname')
            ->willReturn($firstName);
        $customerMock->method('getLastname')
            ->willReturn($lastName);

        return $customerMock;
    }
}
