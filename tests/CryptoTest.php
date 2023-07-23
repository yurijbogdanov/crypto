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
    /**
     * @throws Exception\GenerateKeyFailedException
     */
    public function testGenerateKey(): void
    {
        $key = Crypto::generateKey();
        Assert::assertEquals(43, \strlen($key));
    }

    /**
     * @throws Exception\GenerateNonceFailedException
     */
    public function testGenerateNonce(): void
    {
        $nonce = Crypto::generateNonce();
        Assert::assertEquals(32, \strlen($nonce));
    }

    /**
     * @throws Exception\CryptoExceptionInterface
     *
     * @dataProvider provideEncryptCases
     */
    public function testEncrypt(string $key, string $content): void
    {
        $encryptedContent = Crypto::encrypt($key, $content);
        Assert::assertNotEquals($content, $encryptedContent);

        $decryptedContent = Crypto::decrypt($key, $encryptedContent);
        Assert::assertEquals($content, $decryptedContent);
    }

    /**
     * @throws Exception\CryptoExceptionInterface
     *
     * @dataProvider provideDecryptCases
     */
    public function testDecrypt(string $key, string $content, string $expected): void
    {
        $decryptedContent = Crypto::decrypt($key, $content);
        Assert::assertEquals($expected, $decryptedContent);
    }

    /**
     * @throws Exception\CryptoExceptionInterface
     *
     * @dataProvider provideEncryptWithNonceCases
     */
    public function testEncryptWithNonce(string $key, string $content, string $nonce, string $expected): void
    {
        $encryptedContent = Crypto::encryptWithNonce($key, $content, $nonce);
        Assert::assertEquals($expected, $encryptedContent);
    }

    /**
     * @throws Exception\CryptoExceptionInterface
     *
     * @dataProvider provideDecryptWithNonceCases
     */
    public function testDecryptWithNonce(string $key, string $content, string $nonce, string $expected): void
    {
        $decryptedContent = Crypto::decryptWithNonce($key, $content, $nonce);
        Assert::assertEquals($expected, $decryptedContent);
    }

    public function testDecryptFailed(): void
    {
        $this->expectException(Exception\DecryptFailedException::class);
        Crypto::decrypt('vGN7xw8XbJYxCPhWZk8VG66sRYi6razakWmHvA395gs', '123');
    }

    public function testDecryptWithNonceFailed(): void
    {
        $this->expectException(Exception\DecryptWithNonceFailedException::class);
        Crypto::decryptWithNonce('zo1ziE3Mw-IJ552RgQSBn_Rzj7uRvoF8pv_AB-1QErA', '456', 'Hhmi_zJBlvEnEYOwmDHD5CIyVg_8HsRw');
    }

    public function testEncryptException(): void
    {
        $this->expectException(Exception\EncryptFailedException::class);
        Crypto::encrypt('', '');
    }

    public function testDecryptException(): void
    {
        $this->expectException(Exception\DecryptFailedException::class);
        Crypto::decrypt('', '');
    }

    public static function provideEncryptCases(): iterable
    {
        yield ['AAA8jibi_JGprM9QFmgE3xQ4DYPezmtSb7Hiflg2p08', ''];

        yield ['cmi6Iy38xuNMLcV-sVCkbW3zx6quYl4W4j1QWNGwM6c', "ProvideEncryptCases Lorem ipsum\n dolor sit amet,\n\n consectetur adipisici elit,\t\t sed eiusmod tempor incidunt ut\t\t labore et dolore magna aliqua.\n\n"];
    }

    /**
     * @throws Exception\CryptoExceptionInterface
     */
    public static function provideDecryptCases(): iterable
    {
        $key = '4yDNI2N4K2SWYqVOB8xj9JErPwkH1XVwfjH3wvezg8o';
        $content = '';

        yield [$key, Crypto::encrypt($key, $content), $content];

        $key = 'rEuhiHfqaveIO2bDVUw1EUqT1p6vbamzzIsxm2zq84A';
        $content = "ProvideDecryptCases Lorem ipsum\n dolor sit amet,\n\n consectetur adipisici elit,\t\t sed eiusmod tempor incidunt ut labore et\t\t dolore magna aliqua.\n\n";

        yield [$key, Crypto::encrypt($key, $content), $content];
    }

    public static function provideEncryptWithNonceCases(): iterable
    {
        yield [
            'cGVDT8Hs8C9kPHvDUCxVXSgu6GoRsNYocl5P4iHhVsw',
            '',
            'IZ1MEAD4zSUv2bqpcFYiXYBpO1kPDP7M',
            'RaAQed-cdEcVUEP71oKcRg',
        ];

        yield [
            'DWd3fZKT2ZM_N4gVA2CJyRTZ_jYefYVLuS48b5VjbCs',
            "ProvideEncryptWithNonceCases Lorem ipsum\n dolor sit amet,\n\n consectetur adipisici elit,\t\t sed eiusmod tempor incidunt ut\t\t labore et dolore magna aliqua.\n\n",
            'rjyhK-AQ3uwghlHVS-msLKC1UlQMgkSV',
            'waxM9k7soxGF-MmZC9KkwJTNzwgZ3y0fuAPcLWFDpPa1HATvpooCHPd6jLlAAQRRnpV4CcWQzLifmH4ulSIVBhfOPXmHO17HFIdHqIcAWjcHW4oGmkWLUx7TeXogoo6hut8SFt7hUbM9ubcvWFQrPwz9i3rFnTIXbyEbUfKTdsC_Kz4N1uHkyXu1xQjxJySqeHk7Vg0oC5JwXxt5WRkgY-2-8c8YM6k_JZ9b',
        ];
    }

    public static function provideDecryptWithNonceCases(): iterable
    {
        yield [
            'gyOBW1XHYeTO9R4iNMhXR5djPIVvBk0wTTtDdQwOwXA',
            'tCBMdVGxyionL8zakkiyIQ',
            'ouGOAfkHgvPD4wyK6D2GJJ4NlPVeMCXg',
            '',
        ];

        yield [
            'LDUSZB0Plgdyl1d8lUCr6Z4M9sH8Zn01G16iuU9KZ2w',
            'Z_BiSkdBaoFM33wnuSZDFFP1Les7KqwBJZelH2El5Y3LBkNCnQ_A_ozTd13d1nSevYj-JW4_yKIBolwI4ZOWR051PmvTIDOeqIGtYxP6sFvCYOFEVqsTCQraMOJLyc5SqPlsgG0AerWp82UtaUtr7894j0gi5jpcdyftg82tL0p152di2oz7CGrUT7iV7_Lxj9HFHaINK4BYRtpsM_aS2sbYzApCFTYBmBjd',
            'K5tqyEb3eE9jWKlf8KICLGTtW1vmAPHv',
            "ProvideDecryptWithNonceCases Lorem ipsum\n dolor sit amet,\n\n consectetur adipisici elit,\t\t sed eiusmod tempor incidunt ut\t\t labore et dolore magna aliqua.\n\n",
        ];
    }
}
