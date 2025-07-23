<?php

namespace AppleSignInTest\Integration;

use AppleSignIn\Http\Curl;
use AppleSignIn\PublicKeyFetcher;
use PHPUnit\Framework\TestCase;

/**
 * Class PublicKeyFetcherTest
 * @package AppleSignInTest\Integration
 */
class PublicKeyFetcherTest extends TestCase
{
    /** @var string */
    protected const KID = 'E6q83RB15n';

    /** @var PublicKeyFetcher */
    private $fetcher;

    public function setUp(): void
    {
        parent::setUp();

        $this->fetcher = new PublicKeyFetcher(new Curl());
    }

    public function testFetchRetrievesKeyWithWellKnownKid(): void
    {
        $result = $this->fetcher->fetch(self::KID);

        $this->assertArrayHasKey('publicKey', $result);
        $this->assertArrayHasKey('alg', $result);
    }

    public function testFetchThrowsExceptionWithInvalidKid(): void
    {
        $this->expectException(\AppleSignIn\Exception::class);
        $this->expectExceptionMessage('Invalid public key details');
        $this->fetcher->fetch('lol');
    }
}
