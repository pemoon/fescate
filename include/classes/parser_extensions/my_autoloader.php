<?php declare(strict_types=1);

namespace PhpParser;

/**
 * @codeCoverageIgnore
 */
class Autoloader
{
    /** @var bool Whether the autoloader has been registered. */
    private static $registered = false;

    /**
     * Registers PhpParser\Autoloader as an SPL autoloader.
     *
     * @param bool $prepend Whether to prepend the autoloader instead of appending
     */
    public static function register(bool $prepend = false) {
        if (self::$registered === true) {
            return;
        }

        spl_autoload_register([__CLASS__, 'autoload'], true, $prepend);
        self::$registered = true;
    }

    /**
     * Handles autoloading of classes.
     *
     * @param string $class A class name.
     */
    public static function autoload(string $class) {
        if (0 === strpos($class, 'PhpParser\\')) {
            global $fescate_dirname;
            $fileName = $fescate_dirname.'/'.PHP_PARSER_DIRECTORY.'/lib/'.strtr($class,'\\','/').'.php';
            if (file_exists($fileName)) {
                require $fileName;
            }
        }
    }
}

Autoloader::register();