<?php

declare(strict_types=1);

namespace LS\CustomerGuard\Test\Unit\Model;

use LS\CustomerGuard\Model\Email;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
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

        $this->assertEquals(true, $email->domainEquals('magento.com'));
    }

    /**
     * Email::domainEquals should return false
     *
     * when domain string does not match email domain.
     *
     * @dataProvider falseDomainDataProvider
     * @param string $email
     * @param string $domain
     * @return void
     */
    public function testDomainEqualsReturnsFalse(string $email, string $domain): void
    {
        $email = $this->getEmail($email);

        $this->assertEquals(false, $email->domainEquals($domain));
    }

    /**
     * Retrieve test data for falsy domain match
     *
     * @return array
     */
    public function falseDomainDataProvider(): array
    {
        return [
            'invalid domain' => ['johndoe@magento.com', 'adobe.com'],
            'empty domain' => ['johndoe@', 'adobe.com'],
            'invalid email - no domain' => ['johndoe', 'adobe.com'],
            'invalid email - no username' => ['adobe.com', 'adobe.com'],
        ];
    }

    /**
     * Get instance for testing
     *
     * @param string $emailString
     * @return Email
     */
    private function getEmail(string $emailString): Email
    {
        /** @var Email $email */
        $email = (new ObjectManager($this))->getObject(Email::class, ['email' => $emailString]);

        return $email;
    }
}
