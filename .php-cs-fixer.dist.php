<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->exclude([
        'var',
        'vendor',
    ])
    ->name('*.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);

return (new PhpCsFixer\Config())
    ->setRules([
        '@Symfony' => true,
        '@PER-CS2.0' => true,
        'new_with_braces' => [
            'anonymous_class' => false,
        ],
        'unary_operator_spaces' => true,
        'cast_spaces' => [
            'space' => 'none',
        ],
        'no_useless_else' => true,
        'no_useless_return' => true,
        'no_unused_imports' => true,
        'ordered_imports' => true,
        'trailing_comma_in_multiline' => true,
        'array_syntax' => ['syntax' => 'short'],
        'global_namespace_import' => true
    ])
    ->setFinder($finder)
    ->setRiskyAllowed(true)
    ->setUsingCache(true)
;
