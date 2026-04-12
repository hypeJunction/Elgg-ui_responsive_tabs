<?php
/**
 * PHPUnit bootstrap for ui_responsive_tabs plugin tests.
 * Plugin must be installed at {elgg_root}/mod/ui_responsive_tabs/
 */

// tests/ -> mod/ui_responsive_tabs/ -> mod/ -> elgg_root/
$elggRoot = dirname(__DIR__, 3);

require_once $elggRoot . '/vendor/autoload.php';

// Load Elgg test classes (IntegrationTestCase, UnitTestCase, etc.)
$testClassesDir = $elggRoot . '/vendor/elgg/elgg/engine/tests/classes';
spl_autoload_register(function ($class) use ($testClassesDir) {
    $file = $testClassesDir . '/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

// Plugin autoloader (if composer deps are present)
$pluginRoot = dirname(__DIR__);
if (file_exists($pluginRoot . '/vendor/autoload.php')) {
    require_once $pluginRoot . '/vendor/autoload.php';
}

\Elgg\Application::loadCore();
