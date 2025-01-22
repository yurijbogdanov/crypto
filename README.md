# PHP Crypto (encrypt/decrypt) Library


[![Latest Stable Version](https://img.shields.io/packagist/v/yurijbogdanov/crypto?style=flat)](https://packagist.org/packages/yurijbogdanov/crypto)
[![License](https://img.shields.io/packagist/l/yurijbogdanov/crypto?style=flat)](https://packagist.org/packages/yurijbogdanov/crypto)
[![Total Downloads](https://img.shields.io/packagist/dt/yurijbogdanov/crypto.svg?style=flat)](https://packagist.org/packages/yurijbogdanov/crypto)


## Installation
```terminal
composer require yurijbogdanov/crypto
```


## Usage
Generate new secret:
```terminal
$secret = Crypto::generateSecret();
// Result: c29kaXVtX2NyeXB0b19hZWFkX3hjaGFjaGEyMHBvbHkxMzA1X2lldGYuM443WWLIVeqJWCv16zLIAliPnOwfk3z2YKgfi9TlxfQuItcES9FWz7qPvsSKeTiABVGkVFXfHFjD
```

Encrypt:
```terminal
$secret = 'c29kaXVtX2NyeXB0b19hZWFkX3hjaGFjaGEyMHBvbHkxMzA1X2lldGYuM443WWLIVeqJWCv16zLIAliPnOwfk3z2YKgfi9TlxfQuItcES9FWz7qPvsSKeTiABVGkVFXfHFjD';
$content = 'Lorem ipsum dolor sit amet';
$encryptedContent = Crypto::encrypt($secret, $content);
// Result: fqVFisbX2Jarzt2l-69hZplsSW1HRc9UsBJbveqNPPz0z4bYQXpw6r33
```

Decrypt:
```terminal
$secret = 'c29kaXVtX2NyeXB0b19hZWFkX3hjaGFjaGEyMHBvbHkxMzA1X2lldGYuM443WWLIVeqJWCv16zLIAliPnOwfk3z2YKgfi9TlxfQuItcES9FWz7qPvsSKeTiABVGkVFXfHFjD';
$content = 'fqVFisbX2Jarzt2l-69hZplsSW1HRc9UsBJbveqNPPz0z4bYQXpw6r33';
$decryptedContent = Crypto::decrypt($secret, $content);
// Result: Lorem ipsum dolor sit amet
```

Encrypt file:
```terminal
$secret = 'c29kaXVtX2NyeXB0b19hZWFkX3hjaGFjaGEyMHBvbHkxMzA1X2lldGYuM443WWLIVeqJWCv16zLIAliPnOwfk3z2YKgfi9TlxfQuItcES9FWz7qPvsSKeTiABVGkVFXfHFjD';
$filename = 'test.txt';
$encryptedFilename = Crypto::encryptFile($secret, $filename);
// Result: test.txt.encrypted.txt
```

Decrypt file:
```terminal
$secret = 'c29kaXVtX2NyeXB0b19hZWFkX3hjaGFjaGEyMHBvbHkxMzA1X2lldGYuM443WWLIVeqJWCv16zLIAliPnOwfk3z2YKgfi9TlxfQuItcES9FWz7qPvsSKeTiABVGkVFXfHFjD';
$filename = 'test.txt.encrypted.txt';
$decryptedFilename = Crypto::decryptFile($secret, $filename);
// Result: test.txt
```


## Usage via Terminal
List of commands:
```terminal
bin/crypto
```

Generate new secret:
```terminal
bin/crypto generate_secret
# Result: c29kaXVtX2NyeXB0b19hZWFkX3hjaGFjaGEyMHBvbHkxMzA1X2lldGYuM443WWLIVeqJWCv16zLIAliPnOwfk3z2YKgfi9TlxfQuItcES9FWz7qPvsSKeTiABVGkVFXfHFjD
```

Encrypt:
```terminal
bin/crypto encrypt [SECRET] [CONTENT]
bin/crypto encrypt c29kaXVtX2NyeXB0b19hZWFkX3hjaGFjaGEyMHBvbHkxMzA1X2lldGYuM443WWLIVeqJWCv16zLIAliPnOwfk3z2YKgfi9TlxfQuItcES9FWz7qPvsSKeTiABVGkVFXfHFjD "Lorem ipsum dolor sit amet"
# Result: fqVFisbX2Jarzt2l-69hZplsSW1HRc9UsBJbveqNPPz0z4bYQXpw6r33
```

Decrypt:
```terminal
bin/crypto decrypt [SECRET] [CONTENT]
bin/crypto decrypt c29kaXVtX2NyeXB0b19hZWFkX3hjaGFjaGEyMHBvbHkxMzA1X2lldGYuM443WWLIVeqJWCv16zLIAliPnOwfk3z2YKgfi9TlxfQuItcES9FWz7qPvsSKeTiABVGkVFXfHFjD fqVFisbX2Jarzt2l-69hZplsSW1HRc9UsBJbveqNPPz0z4bYQXpw6r33
# Result: Lorem ipsum dolor sit amet
```

Encrypt file:
```terminal
bin/crypto encrypt_file [SECRET] [FILENAME]
bin/crypto encrypt_file c29kaXVtX2NyeXB0b19hZWFkX3hjaGFjaGEyMHBvbHkxMzA1X2lldGYuM443WWLIVeqJWCv16zLIAliPnOwfk3z2YKgfi9TlxfQuItcES9FWz7qPvsSKeTiABVGkVFXfHFjD test.txt
# Result: test.txt.encrypted.txt
```

Decrypt file:
```terminal
bin/crypto decrypt_file [SECRET] [FILENAME]
bin/crypto decrypt_file c29kaXVtX2NyeXB0b19hZWFkX3hjaGFjaGEyMHBvbHkxMzA1X2lldGYuM443WWLIVeqJWCv16zLIAliPnOwfk3z2YKgfi9TlxfQuItcES9FWz7qPvsSKeTiABVGkVFXfHFjD test.txt.encrypted.txt
# Result: test.txt
```
