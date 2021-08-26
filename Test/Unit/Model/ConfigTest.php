<?php
/**
 * Copyright © Lucid Modules. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace LucidModules\CustomerGuard\Test\Unit\Model;

use LucidModules\CustomerGuard\Model\Config;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use Magento\Store\Model\ScopeInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ConfigTest extends TestCase
{
    /**
     * @var Config
     */
    private $config;

    /**
     * @var MockObject
     */
    private $scopeConfigMock;

    /**
     * @inheritDoc
     */
    public function setUp(): void
    {
        $this->scopeConfigMock = $this->getMockBuilder(ScopeConfigInterface::class)->getMock();
        $this->config = (new ObjectManager($this))->getObject(
            Config::class,
            [
                'scopeConfig' => $this->scopeConfigMock,
            ]
        );
    }

    /**
     * Config returns empty array
     *
     * When Blocked Email Domains are not configured
     *
     * @return void
     */
    public function testGetBlockedEmailDomainsReturnsEmptyArrayWhenNotConfigured(): void
    {
        $this->scopeConfigMock->method('getValue')
            ->with(
                $this->getGeneralConfigPath('blocked_email_domains'),
                ScopeInterface::SCOPE_STORE
            )
            ->willReturn(null);

        $this->assertEquals([], $this->config->getBlockedEmailDomains());
    }

    /**
     * Config returns list of blocked domains
     *
     * When configured domains are split by comma
     *
     * @return void
     */
    public function testGetBlockedEmailDomainsReturnsArray(): void
    {
        $this->scopeConfigMock->method('getValue')
            ->with(
                $this->getGeneralConfigPath('blocked_email_domains'),
                ScopeInterface::SCOPE_STORE
            )
            ->willReturn('invalid.com, other.com');

        $this->assertEquals([
            'invalid.com',
            'other.com',
        ], $this->config->getBlockedEmailDomains());
    }

    /**
     * Config returns empty array
     *
     * When allowed Email Domains are not configured
     *
     * @return void
     */
    public function testGetAllowedEmailDomainsReturnsEmptyArrayWhenNotConfigured(): void
    {
        $this->scopeConfigMock->method('getValue')
            ->with(
                $this->getGeneralConfigPath('allowed_email_domains'),
                ScopeInterface::SCOPE_STORE
            )
            ->willReturn(null);

        $this->assertEquals([], $this->config->getAllowedEmailDomains());
    }

    /**
     * Config returns list of allowed domains
     *
     * When configured domains are split by comma
     *
     * @return void
     */
    public function testGetAllowedEmailDomainsReturnsArray(): void
    {
        $this->scopeConfigMock->method('getValue')
            ->with(
                $this->getGeneralConfigPath('allowed_email_domains'),
                ScopeInterface::SCOPE_STORE
            )
            ->willReturn('valid.com, other.com');

        $this->assertEquals([
            'valid.com',
            'other.com',
        ], $this->config->getAllowedEmailDomains());
    }

    /**
     * Config returns max first name length
     *
     * When configured
     *
     * @return void
     */
    public function testGetMaxFirstNameLengthReturnsLength(): void
    {
        $this->scopeConfigMock->method('getValue')
            ->with(
                $this->getGeneralConfigPath('max_first_name_length'),
                ScopeInterface::SCOPE_STORE
            )
            ->willReturn('33');

        $this->assertEquals(33, $this->config->getMaxFirstNameLength());
    }

    /**
     * Config returns max first name length equal to null
     *
     * When configured as zero length
     *
     * @return void
     */
    public function testGetMaxFirstNameLengthReturnsNullWhenIsZero(): void
    {
        $this->scopeConfigMock->method('getValue')
            ->with(
                $this->getGeneralConfigPath('max_first_name_length'),
                ScopeInterface::SCOPE_STORE
            )
            ->willReturn('0');

        $this->assertEquals(null, $this->config->getMaxFirstNameLength());
    }

    /**
     * Config returns max last name length
     *
     * When configured
     *
     * @return void
     */
    public function testGetMaxLastNameLengthReturnsLength(): void
    {
        $this->scopeConfigMock->method('getValue')
            ->with(
                $this->getGeneralConfigPath('max_last_name_length'),
                ScopeInterface::SCOPE_STORE
            )
            ->willReturn('33');

        $this->assertEquals(33, $this->config->getMaxLastNameLength());
    }

    /**
     * Config returns max last name length equal to null
     *
     * When configured as zero length
     *
     * @return void
     */
    public function testGetMaxLastNameLengthReturnsNullWhenIsZero(): void
    {
        $this->scopeConfigMock->method('getValue')
            ->with(
                $this->getGeneralConfigPath('max_last_name_length'),
                ScopeInterface::SCOPE_STORE
            )
            ->willReturn('0');

        $this->assertEquals(null, $this->config->getMaxLastNameLength());
    }

    /**
     * Config returns empty array
     *
     * When blocked Customer Names are not configured
     *
     * @return void
     */
    public function testGetBlockedCustomerNamesReturnsEmptyArrayWhenNotConfigured(): void
    {
        $this->scopeConfigMock->method('getValue')
            ->with(
                $this->getGeneralConfigPath('blocked_customer_names'),
                ScopeInterface::SCOPE_STORE
            )
            ->willReturn(null);

        $this->assertEquals([], $this->config->getBlockedCustomerNames());
    }

    /**
     * Config returns list of blocked Customer Names
     *
     * When configured Customer Names are split by comma
     *
     * @return void
     */
    public function testGetBlockedCustomerNamesReturnsArray(): void
    {
        $this->scopeConfigMock->method('getValue')
            ->with(
                $this->getGeneralConfigPath('blocked_customer_names'),
                ScopeInterface::SCOPE_STORE
            )
            ->willReturn('John, Doe');

        $this->assertEquals([
            'John',
            'Doe'
        ], $this->config->getBlockedCustomerNames());
    }

    /**
     * Config returns empty array
     *
     * When blocked IPs are not configured
     *
     * @return void
     */
    public function testGetBlockedIpsReturnsEmptyArrayWhenNotConfigured(): void
    {
        $this->scopeConfigMock->method('getValue')
            ->with(
                $this->getGeneralConfigPath('blocked_ips'),
                ScopeInterface::SCOPE_STORE
            )
            ->willReturn(null);

        $this->assertEquals([], $this->config->getBlockedIps());
    }

    /**
     * Config returns list of blocked IP addresses
     *
     * When configured IPs are split by comma
     *
     * @return void
     */
    public function testGetBlockedIpsReturnsArray(): void
    {
        $this->scopeConfigMock->method('getValue')
            ->with(
                $this->getGeneralConfigPath('blocked_ips'),
                ScopeInterface::SCOPE_STORE
            )
            ->willReturn('127.0.0.1, 192.168.1.1');

        $this->assertEquals([
            '127.0.0.1',
            '192.168.1.1'
        ], $this->config->getBlockedIps());
    }

    /**
     * Config returns false
     *
     * When debug mode is not configured
     *
     * @return void
     */
    public function testGetIsDebugReturnsFalse(): void
    {
        $this->scopeConfigMock->method('getValue')
            ->with($this->getGeneralConfigPath('is_debug'))
            ->willReturn(null);

        $this->assertEquals(false, $this->config->getIsDebug());
    }

    /**
     * Config returns true
     *
     * When debug mode is enabled
     *
     * @return void
     */
    public function testGetIsDebugReturnsTrue(): void
    {
        $this->scopeConfigMock->method('getValue')
            ->with($this->getGeneralConfigPath('is_debug'))
            ->willReturn(1);

        $this->assertEquals(true, $this->config->getIsDebug());
    }

    /**
     * Get general config path
     *
     * @param string $path
     * @return string
     */
    private function getGeneralConfigPath(string $path): string
    {
        return 'lucid_modules_customer_guard/general/' . $path;
    }
}
