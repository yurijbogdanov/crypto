<?php

declare(strict_types=1);

namespace YB\Crypto;

class Crypto
{
    private const ALGO_SODIUM_CRYPTO_AEAD_XCHACHA20POLY1305_IETF = 'sodium_crypto_aead_xchacha20poly1305_ietf';

    private const ENCRYPTED_FILE_EXTENSION = '.encrypted.txt';

    /**
     * @throws Exception\GenerateSecretFailedException
     */
    public static function generateSecret(): string
    {
        $algo = self::ALGO_SODIUM_CRYPTO_AEAD_XCHACHA20POLY1305_IETF;

        try {
            $key = sodium_crypto_aead_xchacha20poly1305_ietf_keygen();

            try {
                $nonce = random_bytes(SODIUM_CRYPTO_AEAD_XCHACHA20POLY1305_IETF_NPUBBYTES);
            } catch (\Throwable $e) {
                throw new Exception\GenerateNonceFailedException($e->getMessage(), 0, $e);
            }

            $secret = implode('.', [$algo, $key, $nonce]);

            return self::binToBase64($secret);
        } catch (\Throwable $e) {
            throw new Exception\GenerateSecretFailedException($e->getMessage(), 0, $e);
        }
    }

    /**
     * @throws Exception\EncryptFailedException
     */
    public static function encrypt(string $secret, string $content): string
    {
        try {
            $secret = self::base64ToBin($secret);

            [$algo, $key, $nonce] = array_pad(explode('.', $secret, 3), 3, '');

            $encryptedContent = match ($algo) {
                self::ALGO_SODIUM_CRYPTO_AEAD_XCHACHA20POLY1305_IETF => sodium_crypto_aead_xchacha20poly1305_ietf_encrypt($content, $nonce, $nonce, $key),
                default => throw new Exception\InvalidAlgorithmException(\sprintf('Unsupported algorithm: "%s"', $algo)),
            };

            return self::binToBase64($encryptedContent);
        } catch (\Throwable $e) {
            throw new Exception\EncryptFailedException($e->getMessage(), 0, $e);
        }
    }

    /**
     * @throws Exception\DecryptFailedException
     */
    public static function decrypt(string $secret, string $content): string
    {
        try {
            $secret = self::base64ToBin($secret);

            [$algo, $key, $nonce] = array_pad(explode('.', $secret, 3), 3, '');

            $content = self::base64ToBin($content);

            $decryptedContent = match ($algo) {
                self::ALGO_SODIUM_CRYPTO_AEAD_XCHACHA20POLY1305_IETF => sodium_crypto_aead_xchacha20poly1305_ietf_decrypt($content, $nonce, $nonce, $key),
                default => throw new Exception\InvalidAlgorithmException(\sprintf('Unsupported algorithm: "%s"', $algo)),
            };
            if (!\is_string($decryptedContent)) {
                throw new Exception\CryptoException('Cannot decrypt content');
            }

            return $decryptedContent;
        } catch (\Throwable $e) {
            throw new Exception\DecryptFailedException($e->getMessage(), 0, $e);
        }
    }

    /**
     * @throws Exception\EncryptFileFailedException
     */
    public static function encryptFile(string $secret, string $filename): string
    {
        try {
            if (false === $filePathname = realpath($filename)) {
                throw new Exception\EncryptFileFailedException('File does not exist: '.$filename);
            }

            if (false === $content = file_get_contents($filePathname)) {
                throw new Exception\EncryptFileFailedException('Cannot read file: '.$filePathname);
            }

            $encryptedFilePathname = $filePathname.self::ENCRYPTED_FILE_EXTENSION;
            if (false === file_put_contents($encryptedFilePathname, self::encrypt($secret, $content))) {
                throw new Exception\EncryptFileFailedException('Cannot save content into file: '.$encryptedFilePathname);
            }

            return $encryptedFilePathname;
        } catch (\Throwable $e) {
            throw new Exception\EncryptFileFailedException($e->getMessage(), 0, $e);
        }
    }

    /**
     * @throws Exception\DecryptFileFailedException
     */
    public static function decryptFile(string $secret, string $filename): string
    {
        try {
            if (false === $filePathname = realpath($filename)) {
                throw new Exception\DecryptFileFailedException('File does not exist: '.$filename);
            }

            if (false === $encryptedContent = file_get_contents($filePathname)) {
                throw new Exception\DecryptFileFailedException('Cannot read file: '.$filePathname);
            }

            $decryptedFilePathname = str_replace(self::ENCRYPTED_FILE_EXTENSION, '', $filePathname);

            if (false === file_put_contents($decryptedFilePathname, self::decrypt($secret, trim($encryptedContent)))) {
                throw new Exception\DecryptFileFailedException('Cannot save content into file: '.$decryptedFilePathname);
            }

            return $decryptedFilePathname;
        } catch (\Throwable $e) {
            throw new Exception\DecryptFileFailedException($e->getMessage(), 0, $e);
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
