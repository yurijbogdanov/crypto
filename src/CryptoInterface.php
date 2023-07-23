<?php

declare(strict_types=1);

namespace YB\Crypto;

interface CryptoInterface
{
    /**
     * @throws Exception\GenerateKeyFailedException
     */
    public static function generateKey(): string;

    /**
     * @throws Exception\EncryptFailedException
     */
    public static function encrypt(string $key, string $content): string;

    /**
     * @throws Exception\DecryptFailedException
     */
    public static function decrypt(string $key, string $content): string;

    /**
     * @throws Exception\EncryptWithNonceFailedException
     */
    public static function encryptWithNonce(string $key, string $content, string $nonce): string;

    /**
     * @throws Exception\DecryptWithNonceFailedException
     */
    public static function decryptWithNonce(string $key, string $content, string $nonce): string;

    /**
     * @throws Exception\GenerateNonceFailedException
     */
    public static function generateNonce(): string;
}
