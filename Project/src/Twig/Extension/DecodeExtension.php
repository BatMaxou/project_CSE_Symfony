<?php

namespace App\Twig\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
// use Twig\TwigFunction;

class DecodeExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/3.x/advanced.html#automatic-escaping
            new TwigFilter('html_entity_decode', 'html_entity_decode', ['is_safe' => ['html']]),
        ];
    }

    // public function getFunctions(): array
    // {
    //     return [
    //         new TwigFunction('function_name', [DecodeExtensionRuntime::class, 'doSomething']),
    //     ];
    // }
}
