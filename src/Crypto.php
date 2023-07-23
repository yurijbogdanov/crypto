<?php

declare(strict_types=1);

namespace YB\Crypto;

final class Crypto implements CryptoInterface
{
    public static function generateKey(): string
    {
        try {
            $key = sodium_crypto_aead_xchacha20poly1305_ietf_keygen();

            return self::binToBase64($key);
        } catch (\Throwable $e) {
            throw new Exception\GenerateKeyFailedException($e->getMessage(), 0, $e);
        }
    }

    public static function generateNonce(): string
    {
        try {
            $nonce = random_bytes(SODIUM_CRYPTO_AEAD_XCHACHA20POLY1305_IETF_NPUBBYTES);

            return self::binToBase64($nonce);
        } catch (\Throwable $e) {
            throw new Exception\GenerateNonceFailedException($e->getMessage(), 0, $e);
        }
    }

    public static function encrypt(string $key, string $content): string
    {
        try {
            $key = self::base64ToBin($key);
            $nonce = self::base64ToBin(self::generateNonce());

            $encryptedContent = sodium_crypto_aead_xchacha20poly1305_ietf_encrypt($content, $nonce, $nonce, $key);

            return self::binToBase64($nonce.$encryptedContent);
        } catch (\Throwable $e) {
            throw new Exception\EncryptFailedException($e->getMessage(), 0, $e);
        }
    }

    public static function decrypt(string $key, string $content): string
    {
        try {
            $key = self::base64ToBin($key);
            $content = self::base64ToBin($content);
            $nonce = mb_substr($content, 0, SODIUM_CRYPTO_AEAD_XCHACHA20POLY1305_IETF_NPUBBYTES, '8bit');
            $encryptedContent = mb_substr($content, SODIUM_CRYPTO_AEAD_XCHACHA20POLY1305_IETF_NPUBBYTES, null, '8bit');

            $decryptedContent = sodium_crypto_aead_xchacha20poly1305_ietf_decrypt($encryptedContent, $nonce, $nonce, $key);
            if (!\is_string($decryptedContent)) {
                throw new Exception\EmptyDecryptedContentException('Cannot decrypt content');
            }

            return $decryptedContent;
        } catch (\Throwable $e) {
            throw new Exception\DecryptFailedException($e->getMessage(), 0, $e);
        }
    }

    public static function encryptWithNonce(string $key, string $content, string $nonce): string
    {
        try {
            $key = self::base64ToBin($key);
            $nonce = self::base64ToBin($nonce);

            $encryptedContent = sodium_crypto_aead_xchacha20poly1305_ietf_encrypt($content, $nonce, $nonce, $key);

            return self::binToBase64($encryptedContent);
        } catch (\Throwable $e) {
            throw new Exception\EncryptWithNonceFailedException($e->getMessage(), 0, $e);
        }
    }

    public static function decryptWithNonce(string $key, string $content, string $nonce): string
    {
        try {
            $key = self::base64ToBin($key);
            $content = self::base64ToBin($content);
            $nonce = self::base64ToBin($nonce);

            $decryptedContent = sodium_crypto_aead_xchacha20poly1305_ietf_decrypt($content, $nonce, $nonce, $key);
            if (!\is_string($decryptedContent)) {
                throw new Exception\EmptyDecryptedContentException('Cannot decrypt content');
            }

            return $decryptedContent;
        } catch (\Throwable $e) {
            throw new Exception\DecryptWithNonceFailedException($e->getMessage(), 0, $e);
        }
    }

    /**
     * @throws Exception\BinToBase64FailedException
     */
    private static function binToBase64(string $data): string
    {
        try {
            return sodium_bin2base64($data, SODIUM_BASE64_VARIANT_URLSAFE_NO_PADDING);
        } catch (\Throwable $e) {
            throw new Exception\BinToBase64FailedException($e->getMessage(), 0, $e);
        }
    }

    /**
     * @throws Exception\Base64ToBinFailedException
     */
    private static function base64ToBin(string $data): string
    {
        try {
            return sodium_base642bin($data, SODIUM_BASE64_VARIANT_URLSAFE_NO_PADDING);
        } catch (\Throwable $e) {
            throw new Exception\Base64ToBinFailedException($e->getMessage(), 0, $e);
        }
    }
}
