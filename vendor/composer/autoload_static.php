<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitb7208717ea07a7c9743a5b0351489db5
{
    public static $files = array (
        'ce89ac35a6c330c55f4710717db9ff78' => __DIR__ . '/..' . '/kriswallsmith/assetic/src/functions.php',
    );

    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Symfony\\Component\\Process\\' => 26,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Symfony\\Component\\Process\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/process',
        ),
    );

    public static $prefixesPsr0 = array (
        'C' => 
        array (
            'ComponentInstaller' => 
            array (
                0 => __DIR__ . '/..' . '/robloach/component-installer/src',
            ),
        ),
        'A' => 
        array (
            'Assetic' => 
            array (
                0 => __DIR__ . '/..' . '/kriswallsmith/assetic/src',
            ),
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitb7208717ea07a7c9743a5b0351489db5::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitb7208717ea07a7c9743a5b0351489db5::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInitb7208717ea07a7c9743a5b0351489db5::$prefixesPsr0;
            $loader->classMap = ComposerStaticInitb7208717ea07a7c9743a5b0351489db5::$classMap;

        }, null, ClassLoader::class);
    }
}