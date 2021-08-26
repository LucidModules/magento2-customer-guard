<?php
/**
 * Copyright © Lucid Modules. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace LucidModules\CustomerGuard\Test\Unit\Model;

use LucidModules\CustomerGuard\Model\ConfigInterface;
use LucidModules\CustomerGuard\Model\NameLengthCondition;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class NameLengthConditionTest extends TestCase
{
    /**
     * NameLengthCondition::isAllowed should return true
     *
     * when domain lastName and firstName are not greater than allowed.
     *
     * @dataProvider validLengthNamesProvider
     * @param int $configFirstNameLength
     * @param int $configLastNameLength
     * @param string $firstName
     * @param string $lastName
     * @return void
     */
    public function testValidLengthReturnsTrue(
        int $configFirstNameLength,
        int $configLastNameLength,
        string $firstName,
        string $lastName
    ): void {
        $configMock = $this->getConfigMock($configFirstNameLength, $configLastNameLength);
        $nameLengthCondition = $this->getNameLengthCondition($configMock);
        $customerMock = $this->getCustomerMock($firstName, $lastName);

        $this->assertEquals(true, $nameLengthCondition->isAllowed($customerMock));
    }

    /**
     * NameLengthCondition::isAllowed should return false
     *
     * when domain lastName and firstName are greater than allowed.
     *
     * @dataProvider invalidLengthNamesProvider
     * @param int $configFirstNameLength
     * @param int $configLastNameLength
     * @param string $firstName
     * @param string $lastName
     * @return void
     */
    public function testInvalidLengthReturnsFalse(
        int $configFirstNameLength,
        int $configLastNameLength,
        string $firstName,
        string $lastName
    ): void {
        $configMock = $this->getConfigMock($configFirstNameLength, $configLastNameLength);
        $nameLengthCondition = $this->getNameLengthCondition($configMock);
        $customerMock = $this->getCustomerMock($firstName, $lastName);

        $this->assertEquals(false, $nameLengthCondition->isAllowed($customerMock));
    }

    /**
     * config firstname length|config lastname length|firstname|lastname
     *
     * @return array[]
     */
    public function invalidLengthNamesProvider(): array
    {
        return [
            [2, 2, 'john', 'doe'],
            [10, 2, 'john', 'doe'],
            [0, 2, 'john', 'doe'],
        ];
    }

    /**
     * config firstname length|config lastname length|firstname|lastname
     *
     * @return array[]
     */
    public function validLengthNamesProvider(): array
    {
        return [
            [20, 40, 'john', 'doe'],
            [4, 3, 'john', 'doe'],
            'unlimited firstname' => [0, 3, 'john', 'doe'],
            'unlimited lastname' => [4, 0, 'john', 'doe'],
        ];
    }

    /**
     * Get instance for testing
     *
     * @param ConfigInterface $config
     * @return NameLengthCondition
     */
    private function getNameLengthCondition(ConfigInterface $config): NameLengthCondition
    {
        /** @var NameLengthCondition $nameLengthCondition */
        $nameLengthCondition = (new ObjectManager($this))
            ->getObject(NameLengthCondition::class, ['config' => $config]);

        return $nameLengthCondition;
    }

    /**
     * Get config mock
     *
     * @param int $configFirstNameLength
     * @param int $configLastNameLength
     * @return ConfigInterface|MockObject
     */
    private function getConfigMock(int $configFirstNameLength, int $configLastNameLength)
    {
        $configMock = $this->getMockBuilder(ConfigInterface::class)
            ->getMock();
        $configMock->method('getMaxFirstNameLength')
            ->willReturn($configFirstNameLength);
        $configMock->method('getMaxLastNameLength')
            ->willReturn($configLastNameLength);

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
