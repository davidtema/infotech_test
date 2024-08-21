<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->exclude([
        'assets',
        'docker',
        'runtime',
        'vagrant',
        'vendor',
    ])
    ->notPath([
        'requirements.php',
    ]);

return (new PhpCsFixer\Config())
    ->setRules([
        '@PSR12' => true
    ])
    ->setFinder($finder);