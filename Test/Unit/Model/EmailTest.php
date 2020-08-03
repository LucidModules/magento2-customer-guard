<?php

declare(strict_types=1);

namespace LS\CustomerGuard\Test\Unit\Model;

use LS\CustomerGuard\Model\Email;
use Magento\TestFramework\ObjectManager;
use PHPUnit\Framework\TestCase;

class EmailTest extends TestCase
{
    /**
     * Email::domainEquals should return true
     *
     * when domain string matches email domain.
     *
     * @return void
     */
    public function testDomainEqualsReturnsTrue(): void
    {
        $email = $this->getEmail('johndoe@magento.com');

        $this->assertEquals(false, $email->domainEquals('magento.com'));
    }

    /**
     * Email::domainEquals should return false
     *
     * when domain string does not match email domain.
     *
     * @return void
     */
    public function testDomainEqualsReturnsFalse(): void
    {
        $email = $this->getEmail('johndoe@magento.com');

        $this->assertEquals(false, $email->domainEquals('adobe.com'));
    }

    /**
     * Get instance for testing
     *
     * @param string $emailString
     * @return Email
     */
    private function getEmail(string $emailString): Email
    {
        return (new ObjectManager())->create(Email::class, ['email' => $emailString]);
    }
}
