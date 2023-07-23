<?php

declare(strict_types=1);

return (new PhpCsFixer\Config())
    ->setRules([
        '@PHP82Migration' => true,
        '@Symfony' => true,
        '@Symfony:risky' => true,
        '@PhpCsFixer' => true,
        '@PhpCsFixer:risky' => true,
        '@PHPUnit100Migration:risky' => true,
        'array_syntax' => ['syntax' => 'short'],
        'strict_param' => true,
    ])
    ->setFinder(PhpCsFixer\Finder::create()->in(__DIR__))
    ->setCacheFile('.php-cs-fixer.cache')
;
