<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit73725bd37590da606766f88673ed68eb
{
    public static $files = array (
        'f71ae5372a45f32ad8e671f9a37e95f6' => __DIR__ . '/../..' . '/src/helper.php',
    );

    public static $prefixLengthsPsr4 = array (
        'R' => 
        array (
            'Richard\\AliyunApiGateway\\' => 25,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Richard\\AliyunApiGateway\\' => 
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
            $loader->prefixLengthsPsr4 = ComposerStaticInit73725bd37590da606766f88673ed68eb::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit73725bd37590da606766f88673ed68eb::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit73725bd37590da606766f88673ed68eb::$classMap;

        }, null, ClassLoader::class);
    }
}
