<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitb9aad89396034ced18cc3652826c0f79
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitb9aad89396034ced18cc3652826c0f79::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitb9aad89396034ced18cc3652826c0f79::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitb9aad89396034ced18cc3652826c0f79::$classMap;

        }, null, ClassLoader::class);
    }
}