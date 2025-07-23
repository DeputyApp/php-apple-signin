<?php

namespace AppleSignInTest\Unit;

use AppleSignIn\Payload;
use PHPUnit\Framework\TestCase;

/**
 * Class PayloadTest
 * @package AppleSignInTest\Unit
 */
class PayloadTest extends TestCase
{
    /** @var \stdClass */
    private $jwtPayload;

    public function setUp(): void
    {
        parent::setUp();

        $this->jwtPayload = new \stdClass();
        $this->jwtPayload->iss = Payload::APPLE_TOKEN_ISSUER;
        $this->jwtPayload->sub = 'some-user-uuid-string';
        $this->jwtPayload->email = 'user@example.com';
        $this->jwtPayload->aud = 'com.example.apple';
    }

    public function testPayloadInstanciatedWithNullObject()
    {
        $this->expectException(\AppleSignIn\Exception::class);
        $this->expectExceptionMessage('Payload received null JWT.');

        $payload = new Payload(null);
    }

    public function testPayloadInstanciatedWithMissingEmailClaim()
    {
        $this->expectException(\AppleSignIn\Exception::class);
        $this->expectExceptionMessage('Payload received invalid JWT. Missing email claim.');

        unset($this->jwtPayload->email);
        $payload = new Payload($this->jwtPayload);
    }

    public function testPayloadInstanciatedWithMissingSubClaim()
    {
        $this->expectException(\AppleSignIn\Exception::class);
        $this->expectExceptionMessage('Payload received invalid JWT. Missing subject claim.');

        unset($this->jwtPayload->sub);
        $payload = new Payload($this->jwtPayload);
    }

    public function testPayloadInstanciatedWithMissingIssuerClaim()
    {
        $this->expectException(\AppleSignIn\Exception::class);
        $this->expectExceptionMessage('Payload received invalid JWT. Missing issuer claim.');

        unset($this->jwtPayload->iss);
        $payload = new Payload($this->jwtPayload);
    }

    public function testPayloadInstanciatedWithInvalidIssuerClaim()
    {
        $this->expectException(\AppleSignIn\Exception::class);
        $this->expectExceptionMessage('Payload received invalid JWT. Invalid issuer claim.');

        $this->jwtPayload->iss = 'invalid';
        $payload = new Payload($this->jwtPayload);
    }

    public function testGetUserUUIDReturnsSubClaim()
    {
        $payload = new Payload($this->jwtPayload);

        $this->assertEquals('some-user-uuid-string', $payload->getUserUUID());
    }

    public function testGetEmailReturnsEmailClaim()
    {
        $payload = new Payload($this->jwtPayload);

        $this->assertEquals('user@example.com', $payload->getEmail());
    }

    public function testGetAudienceReturnsAudClaim()
    {
        $payload = new Payload($this->jwtPayload);

        $this->assertEquals('com.example.apple', $payload->getAudience());
    }

    public function testVerifyAudienceReturnsTrueWithCorrectAudience()
    {
        $payload = new Payload($this->jwtPayload);

        $this->assertTrue($payload->verifyAudience('com.example.apple'));
    }

    public function testVerifyAudienceReturnsFalseWithIncorrectAudience()
    {
        $payload = new Payload($this->jwtPayload);

        $this->assertFalse($payload->verifyAudience('invalid'));
    }
}
