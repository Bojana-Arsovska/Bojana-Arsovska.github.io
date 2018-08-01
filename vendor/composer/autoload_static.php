<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit9d23c7068e0f4c6d915f9e113428d18d
{
    public static $prefixesPsr0 = array (
        'S' => 
        array (
            'Speakap\\Tests' => 
            array (
                0 => __DIR__ . '/..' . '/speakap/sdk/php/tests',
            ),
            'Speakap' => 
            array (
                0 => __DIR__ . '/..' . '/speakap/sdk/php/src',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixesPsr0 = ComposerStaticInit9d23c7068e0f4c6d915f9e113428d18d::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}
