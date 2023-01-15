<?php
namespace App\Emails;

use CodeIgniter\Test\CIUnitTestCase;

final class SendEmailTest extends CIUnitTestCase
{
    private $email = null;

    public function __construct()
    {
        parent::__construct();

        // Removing the mockEmail from this test
        $k = array_keys($this->setUpMethods, 'mockEmail')[0];
        unset($this->setUpMethods[$k]);
    }

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        
        return;
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->email = service('email');
        $this->email->setFrom(env('email.from'), env('email.fromName'));
        $this->email->setTo(env('email.testRecipient'));

        return;
    }

    final public function testCanSendEmails()
    {
        $this->email->setSubject('Email Test');
        $this->email->setMessage('Testing that the email can be sent properly.');
        $result = $this->email->send();

        if (!$result) {
            d($this->email->printDebugger());
        }

        $this->assertTrue($result);
    }
}