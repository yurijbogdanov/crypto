<?php

declare(strict_types=1);

namespace YB\Crypto;

use YB\Crypto\Exception\DecryptFailedException;
use YB\Crypto\Exception\DecryptWithNonceFailedException;
use YB\Crypto\Exception\EncryptFailedException;
use YB\Crypto\Exception\EncryptWithNonceFailedException;
use YB\Crypto\Exception\GenerateKeyFailedException;
use YB\Crypto\Exception\GenerateNonceFailedException;

interface CryptoInterface
{
    /**
     * @throws GenerateKeyFailedException
     */
    public static function generateKey(): string;

    /**
     * @throws EncryptFailedException
     */
    public static function encrypt(string $key, string $content): string;

    /**
     * @throws DecryptFailedException
     */
    public static function decrypt(string $key, string $content): string;

    /**
     * @throws EncryptWithNonceFailedException
     */
    public static function encryptWithNonce(string $key, string $content, string $nonce): string;

    /**
     * @throws DecryptWithNonceFailedException
     */
    public static function decryptWithNonce(string $key, string $content, string $nonce): string;

    /**
     * @throws GenerateNonceFailedException
     */
    public static function generateNonce(): string;
}
