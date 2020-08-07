<?php

declare(strict_types=1);

namespace LS\CustomerGuard\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

/**
 * Module configuration
 */
class Config implements ConfigInterface
{
    private const GENERAL_CONFIG_PATH = 'ls_customer_guard/general/';
    private const BLOCKED_EMAIL_DOMAINS_PATH = self::GENERAL_CONFIG_PATH . 'blocked_email_domains';
    private const ALLOWED_EMAIL_DOMAINS_PATH = self::GENERAL_CONFIG_PATH . 'allowed_email_domains';
    private const MAX_FIRST_NAME_LENGTH_PATH = self::GENERAL_CONFIG_PATH . 'max_first_name_length';
    private const MAX_LAST_NAME_LENGTH_PATH = self::GENERAL_CONFIG_PATH . 'max_last_name_length';
    private const REGISTER_RESTRICTION_MESSAGE_PATH = self::GENERAL_CONFIG_PATH . 'register_restriction_message';
    private const BLOCKED_CUSTOMER_NAMES_PATH = self::GENERAL_CONFIG_PATH . 'blocked_customer_names';
    private const BLOCKED_IPS_PATH = self::GENERAL_CONFIG_PATH . 'blocked_ips';

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @inheritDoc
     */
    public function getBlockedEmailDomains(): array
    {
        $value = (string)$this->scopeConfig->getValue(
            self::BLOCKED_EMAIL_DOMAINS_PATH,
            ScopeInterface::SCOPE_STORE
        );

        return $this->safeExplode($value);
    }

    /**
     * @inheritDoc
     */
    public function getAllowedEmailDomains(): array
    {
        $value = (string)$this->scopeConfig->getValue(
            self::ALLOWED_EMAIL_DOMAINS_PATH,
            ScopeInterface::SCOPE_STORE
        );

        return $this->safeExplode($value);
    }

    /**
     * @inheritDoc
     */
    public function getMaxFirstNameLength(): ?int
    {
        $value = $this->scopeConfig->getValue(
            self::MAX_FIRST_NAME_LENGTH_PATH,
            ScopeInterface::SCOPE_STORE
        );

        return empty($value) ? (int)$value : null;
    }

    /**
     * @inheritDoc
     */
    public function getMaxLastNameLength(): ?int
    {
        $value = $this->scopeConfig->getValue(
            self::MAX_LAST_NAME_LENGTH_PATH,
            ScopeInterface::SCOPE_STORE
        );

        return empty($value) ? (int)$value : null;
    }

    /**
     * @inheritDoc
     */
    public function getRegisterRestrictionMessage(): string
    {
        return (string)$this->scopeConfig->getValue(
            self::REGISTER_RESTRICTION_MESSAGE_PATH,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @inheritDoc
     */
    public function getBlockedCustomerNames(): array
    {
        $value = (string)$this->scopeConfig->getValue(
            self::BLOCKED_CUSTOMER_NAMES_PATH,
            ScopeInterface::SCOPE_STORE
        );

        return $this->safeExplode($value);
    }

    /**
     * @inheritDoc
     */
    public function getBlockedIps(): array
    {
        $value = (string)$this->scopeConfig->getValue(
            self::BLOCKED_IPS_PATH,
            ScopeInterface::SCOPE_STORE
        );

        return $this->safeExplode($value);
    }

    /**
     * Strips whitespace from the exploded string elements.
     *
     * @param string $value
     * @param string $delimiter
     * @return array
     */
    private function safeExplode(string $value, string $delimiter = ','): array
    {
        $array = explode($delimiter, $value);
        $array = array_map(function (string $value) {
            return trim($value);
        }, $array);

        return $array;
    }
}
