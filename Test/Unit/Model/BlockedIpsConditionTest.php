<?php

declare(strict_types=1);

namespace LucidSolutions\CustomerGuard\Test\Unit\Model;

use LucidSolutions\CustomerGuard\Model\BlockedIpsCondition;
use LucidSolutions\CustomerGuard\Model\ConfigInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Framework\HTTP\PhpEnvironment\RemoteAddress;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class BlockedIpsConditionTest extends TestCase
{
    /**
     * BlockedIpsCondition::isAllowed should return true
     *
     * when IP addresses are not banned in config.
     *
     * @return void
     */
    public function testIpNotBannedReturnsTrue(): void
    {
        $bannedIps = ['127.0.0.1', '192.168.1.1'];
        $configMock = $this->getConfigMock($bannedIps);
        $remoteAddressMock = $this->getRemoteAddressMock('172.168.1.1');
        $blockedIpsCondition = $this->getBlockedIpsCondition($configMock, $remoteAddressMock);
        /** @var CustomerInterface|MockObject $customerMock */
        $customerMock = $this->getMockBuilder(CustomerInterface::class)->getMock();

        $this->assertEquals(true, $blockedIpsCondition->isAllowed($customerMock));
    }

    /**
     * BlockedIpsCondition::isAllowed should return false
     *
     * when IP addresses are not banned in config.

     * @return void
     */
    public function testInvalidLengthReturnsFalse(): void
    {
        $bannedIps = ['127.0.0.1', '192.168.1.1'];
        $configMock = $this->getConfigMock($bannedIps);
        $remoteAddressMock = $this->getRemoteAddressMock('192.168.1.1');
        $nameLengthCondition = $this->getBlockedIpsCondition($configMock, $remoteAddressMock);
        /** @var CustomerInterface|MockObject $customerMock */
        $customerMock = $this->getMockBuilder(CustomerInterface::class)->getMock();

        $this->assertEquals(false, $nameLengthCondition->isAllowed($customerMock));
    }

    /**
     * Get instance for testing
     *
     * @param ConfigInterface $config
     * @param RemoteAddress $remoteAddress
     * @return BlockedIpsCondition
     */
    private function getBlockedIpsCondition(ConfigInterface $config, RemoteAddress $remoteAddress): BlockedIpsCondition
    {
        /** @var BlockedIpsCondition $blockedIpsCondition */
        $blockedIpsCondition = (new ObjectManager($this))
            ->getObject(BlockedIpsCondition::class, [
                'config' => $config,
                'remoteAddress' => $remoteAddress
            ]);

        return $blockedIpsCondition;
    }

    /**
     * Get config mock
     *
     * @param string[] $blockedIps
     * @return ConfigInterface|MockObject
     */
    private function getConfigMock(array $blockedIps)
    {
        $configMock = $this->getMockBuilder(ConfigInterface::class)
            ->getMock();
        $configMock->method('getBlockedIps')
            ->willReturn($blockedIps);

        return $configMock;
    }

    /**
     * Get RemoteAddress mock
     *
     * @param string $ip
     * @return RemoteAddress|MockObject
     */
    private function getRemoteAddressMock(string $ip): RemoteAddress
    {
        $remoteAddressMock = $this->getMockBuilder(RemoteAddress::class)
            ->disableOriginalConstructor()
            ->getMock();
        $remoteAddressMock->method('getRemoteAddress')
            ->willReturn($ip);

        return $remoteAddressMock;
    }
}
