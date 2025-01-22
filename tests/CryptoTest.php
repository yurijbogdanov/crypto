<?php

declare(strict_types=1);

namespace YB\Crypto\Tests;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use YB\Crypto\Crypto;
use YB\Crypto\Exception;

/**
 * @internal
 *
 * @covers \YB\Crypto\Crypto
 */
final class CryptoTest extends TestCase
{
    private const DEFAULT_SECRET = 'c29kaXVtX2NyeXB0b19hZWFkX3hjaGFjaGEyMHBvbHkxMzA1X2lldGYuM443WWLIVeqJWCv16zLIAliPnOwfk3z2YKgfi9TlxfQuItcES9FWz7qPvsSKeTiABVGkVFXfHFjD';

    public function testGenerateSecret(): void
    {
        $secret = Crypto::generateSecret();
        Assert::assertEquals(132, \strlen($secret));
    }

    /** @dataProvider provideEncryptCases */
    public function testEncrypt(string $secret, string $content, string $expected): void
    {
        Assert::assertEquals($expected, Crypto::encrypt($secret, $content));
    }

    /** @dataProvider provideDecryptCases */
    public function testDecrypt(string $secret, string $content, string $expected): void
    {
        Assert::assertEquals($expected, Crypto::decrypt($secret, $content));
    }

    /** @dataProvider provideEncryptFailedCases */
    public function testEncryptFailed(string $secret, string $content): void
    {
        $this->expectException(Exception\EncryptFailedException::class);
        Crypto::encrypt($secret, $content);
    }

    /** @dataProvider provideDecryptFailedCases */
    public function testDecryptFailed(string $secret, string $content): void
    {
        $this->expectException(Exception\DecryptFailedException::class);
        Crypto::decrypt($secret, $content);
    }

    /**
     * @return array<int, string>[]
     */
    public static function provideEncryptCases(): iterable
    {
        yield [
            self::DEFAULT_SECRET,
            'Lorem ipsum dolor sit amet',
            'fqVFisbX2Jarzt2l-69hZplsSW1HRc9UsBJbveqNPPz0z4bYQXpw6r33',
        ];

        yield [
            'c29kaXVtX2NyeXB0b19hZWFkX3hjaGFjaGEyMHBvbHkxMzA1X2lldGYuBbbv6jOYmspUT7vHiJ2XJOSZR792VWLf3hAPNIFVUskusAaStvBV_Im1mtp4EbNGX7oPILiS3fGz',
            '',
            '1IeeJoyJI2DJo3ui8YSy-g',
        ];

        yield [
            'c29kaXVtX2NyeXB0b19hZWFkX3hjaGFjaGEyMHBvbHkxMzA1X2lldGYu56SAnmRG-4_HFpApy-RWd0Ho6zLQiDBfDnPk0xKaaI4uCRbYL-sKZPesUabcfiIpgTb8-Et9iLQk',
            "Lorem \t\t ipsum 1_2-3=4 dolor !*&#@ sit \r\r amet\n\n",
            'pcoA5CQzzWVe-TRG-XByExcg_aY5V9a6UsH6kvCFCK6kbm0K2AdvnGC9xPNCr0UmjT1Km4Ov0nvKvNYvQEmEnA',
        ];
    }

    /**
     * @return array<int, string>[]
     */
    public static function provideDecryptCases(): iterable
    {
        yield [
            self::DEFAULT_SECRET,
            'fqVFisbX2Jarzt2l-69hZplsSW1HRc9UsBJbveqNPPz0z4bYQXpw6r33',
            'Lorem ipsum dolor sit amet',
        ];

        yield [
            'c29kaXVtX2NyeXB0b19hZWFkX3hjaGFjaGEyMHBvbHkxMzA1X2lldGYu9OlazGsXF30DSEXh4dnaWzWCdpiLKjJfGHypmdHBRj0uYXkhgw5pMYfew_K_8fNEwhbWoQkEkz0o',
            'iqjZFtqr-B_fDVSiaYtaxg',
            '',
        ];

        yield [
            'c29kaXVtX2NyeXB0b19hZWFkX3hjaGFjaGEyMHBvbHkxMzA1X2lldGYupG5OON38EFiG0bpb7pxGExVEs8NVcRvg-sFPU2gsRCAulZTi8AAgNxIVy2a4gPs0geXJFTElK3jp',
            'R8MOYc2ZqnLMJ8laNF8j7kXNgdkGd_U2IPbe-sP7rBqjy-swrePgpYqz61UdeTjUYRScOq98OA08BZ4QQiIx3w',
            "Lorem \t\t ipsum 1_2-3=4 dolor !*&#@ sit \r\r amet\n\n",
        ];
    }

    /**
     * @return array<int, string>[]
     */
    public static function provideEncryptFailedCases(): iterable
    {
        yield [
            '',
            '',
        ];

        yield [
            'incorrect secret',
            '',
        ];
    }

    /**
     * @return array<int, string>[]
     */
    public static function provideDecryptFailedCases(): iterable
    {
        yield [
            '',
            '',
        ];

        yield [
            'incorrect secret',
            '',
        ];

        yield [
            self::DEFAULT_SECRET,
            'incorrect content', // content should be encoded
        ];
    }
}
