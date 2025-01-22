# PHP Crypto (encrypt/decrypt) Library

[![Latest Stable Version](https://img.shields.io/packagist/v/yurijbogdanov/crypto?style=flat)](https://packagist.org/packages/yurijbogdanov/crypto)
[![License](https://img.shields.io/packagist/l/yurijbogdanov/crypto?style=flat)](https://packagist.org/packages/yurijbogdanov/crypto)
[![Total Downloads](https://img.shields.io/packagist/dt/yurijbogdanov/crypto.svg?style=flat)](https://packagist.org/packages/yurijbogdanov/crypto)


## Installation
```terminal
composer require yurijbogdanov/crypto
```


## Usage
Generate new key:
```terminal
$key = Crypto::generateKey(); // Y0h7g44QW9IlUJ2vPeqXMZJIdKNsOYfgqZVtUvy7WbM
```

Generate new nonce:
```terminal
$nonce = Crypto::generateNonce(); // hnVfbOXXzJ6Zn5hlPHJxiQqSWLU9nJ7W
```

Encrypt (encrypted content is always unique due to built-in nonce):
```terminal
$key = 'Y0h7g44QW9IlUJ2vPeqXMZJIdKNsOYfgqZVtUvy7WbM';
$content = 'Lorem ipsum dolor sit amet';
$encryptedContent = Crypto::encrypt($key, $content); // Dq0zaZfxTQ0xzqiZfnPUBBNUi0mtSVLP9K6xBHdqtvRnJNQ6HCLYWVCZwmk1qALJOMdkKU56TfUWfdO_fqtmvDmO
```

Decrypt:
```terminal
$key = 'Y0h7g44QW9IlUJ2vPeqXMZJIdKNsOYfgqZVtUvy7WbM';
$content = 'Dq0zaZfxTQ0xzqiZfnPUBBNUi0mtSVLP9K6xBHdqtvRnJNQ6HCLYWVCZwmk1qALJOMdkKU56TfUWfdO_fqtmvDmO';
$decryptedContent = Crypto::decrypt($key, $content); // Lorem ipsum dolor sit amet
```

Encrypt with nonce:
```terminal
$key = 'Y0h7g44QW9IlUJ2vPeqXMZJIdKNsOYfgqZVtUvy7WbM';
$content = 'Lorem ipsum dolor sit amet';
$nonce = 'hnVfbOXXzJ6Zn5hlPHJxiQqSWLU9nJ7W';
$encryptedContent = Crypto::encryptWithNonce($key, $content, $nonce); // iTWjKcy8Qn2dCMp3Th_tyPhv__6VVR0t21fMF9qP1FYiite_3NOg-0yc
```

Decrypt with nonce:
```terminal
$key = 'Y0h7g44QW9IlUJ2vPeqXMZJIdKNsOYfgqZVtUvy7WbM';
$content = 'iTWjKcy8Qn2dCMp3Th_tyPhv__6VVR0t21fMF9qP1FYiite_3NOg-0yc';
$nonce = 'hnVfbOXXzJ6Zn5hlPHJxiQqSWLU9nJ7W';
$decryptedContent = Crypto::decryptWithNonce($key, $content, $nonce); // Lorem ipsum dolor sit amet
```


## Usage via Terminal
List of commands:
```terminal
bin/crypto
```

Generate new key:
```terminal
bin/crypto generate_key
# Output: Y0h7g44QW9IlUJ2vPeqXMZJIdKNsOYfgqZVtUvy7WbM
```

Generate new nonce:
```terminal
bin/crypto generate_nonce
# Output: hnVfbOXXzJ6Zn5hlPHJxiQqSWLU9nJ7W
```

Encrypt (encrypted content is always unique due to built-in nonce):
```terminal
bin/crypto encrypt [KEY] [CONTENT]
bin/crypto encrypt Y0h7g44QW9IlUJ2vPeqXMZJIdKNsOYfgqZVtUvy7WbM "Lorem ipsum dolor sit amet"
# Output: Dq0zaZfxTQ0xzqiZfnPUBBNUi0mtSVLP9K6xBHdqtvRnJNQ6HCLYWVCZwmk1qALJOMdkKU56TfUWfdO_fqtmvDmO
```

Decrypt:
```terminal
bin/crypto decrypt [KEY] [CONTENT]
bin/crypto decrypt Y0h7g44QW9IlUJ2vPeqXMZJIdKNsOYfgqZVtUvy7WbM Dq0zaZfxTQ0xzqiZfnPUBBNUi0mtSVLP9K6xBHdqtvRnJNQ6HCLYWVCZwmk1qALJOMdkKU56TfUWfdO_fqtmvDmO
# Output: Lorem ipsum dolor sit amet
```

Encrypt with nonce:
```terminal
bin/crypto encrypt_with_nonce [KEY] [CONTENT] [NONCE]
bin/crypto encrypt_with_nonce Y0h7g44QW9IlUJ2vPeqXMZJIdKNsOYfgqZVtUvy7WbM "Lorem ipsum dolor sit amet" hnVfbOXXzJ6Zn5hlPHJxiQqSWLU9nJ7W
# Output: iTWjKcy8Qn2dCMp3Th_tyPhv__6VVR0t21fMF9qP1FYiite_3NOg-0yc
```

Decrypt with nonce:
```terminal
bin/crypto decrypt_with_nonce [KEY] [CONTENT] [NONCE]
bin/crypto decrypt_with_nonce Y0h7g44QW9IlUJ2vPeqXMZJIdKNsOYfgqZVtUvy7WbM iTWjKcy8Qn2dCMp3Th_tyPhv__6VVR0t21fMF9qP1FYiite_3NOg-0yc hnVfbOXXzJ6Zn5hlPHJxiQqSWLU9nJ7W
# Output: Lorem ipsum dolor sit amet
```
