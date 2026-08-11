<?php
/**
 * Test Runner — CLI-based test runner for JobHub test suite
 *
 * Usage: php tests/TestRunner.php
 */

// Load bootstrap (only once)
if (!defined('BASE_PATH')) {
    require_once __DIR__ . '/bootstrap.php';
}

// ANSI color codes
define('GREEN', "\033[32m");
define('RED', "\033[31m");
define('YELLOW', "\033[33m");
define('CYAN', "\033[36m");
define('RESET', "\033[0m");
define('BOLD', "\033[1m");

echo PHP_EOL;
echo BOLD . CYAN . "  ╔══════════════════════════════════════╗" . RESET . PHP_EOL;
echo BOLD . CYAN . "  ║       JobHub Test Suite Runner       ║" . RESET . PHP_EOL;
echo BOLD . CYAN . "  ╚══════════════════════════════════════╝" . RESET . PHP_EOL;
echo PHP_EOL;

// Discover test files
$testFiles = [];
$testDirs = [
    __DIR__ . '/Unit',
    __DIR__ . '/Feature',
];

foreach ($testDirs as $dir) {
    if (is_dir($dir)) {
        $files = glob($dir . '/*Test.php');
        foreach ($files as $file) {
            $testFiles[] = $file;
        }
    }
}

if (empty($testFiles)) {
    echo YELLOW . "  No test files found in:" . RESET . PHP_EOL;
    foreach ($testDirs as $dir) {
        echo "  - $dir" . PHP_EOL;
    }
    echo PHP_EOL;
    exit(0);
}

$totalPassed = 0;
$totalFailed = 0;
$totalAssertions = 0;

foreach ($testFiles as $file) {
    $relativePath = str_replace(__DIR__ . '/', '', $file);
    echo BOLD . "  📁 $relativePath" . RESET . PHP_EOL;

    require_once $file;

    // Get class name from filename
    $className = basename($file, '.php');
    if (!class_exists($className)) {
        echo RED . "  ⚠ Class '$className' not found in file" . RESET . PHP_EOL;
        continue;
    }

    // Get test methods
    $reflection = new ReflectionClass($className);
    $methods = $reflection->getMethods(ReflectionMethod::IS_PUBLIC);

    $classPassed = 0;
    $classFailed = 0;
    $methodCount = 0;

    foreach ($methods as $method) {
        if (strpos($method->name, 'test') === 0) {
            $methodCount++;
            // Create fresh instance for each test
            $testInstance = new $className();
            $testInstance->setUp();

            try {
                $method->invoke($testInstance);
                $result = $testInstance->summary();

                if (!empty($result['errors'])) {
                    $classFailed++;
                    $thisFailed = count($result['errors']);
                    $totalFailed += $thisFailed;
                    echo "    " . RED . "✗" . RESET . " {$method->name}:" . PHP_EOL;
                    foreach ($result['errors'] as $error) {
                        echo "      " . RED . "→" . RESET . " $error" . PHP_EOL;
                    }
                } else {
                    $classPassed++;
                    echo "    " . GREEN . "✓" . RESET . " {$method->name}" . PHP_EOL;
                }
                $totalAssertions += ($result['passed'] + $result['failed']);
            } catch (\Throwable $e) {
                $classFailed++;
                $totalFailed++;
                echo "    " . RED . "✗" . RESET . " {$method->name}: " . RED . $e->getMessage() . RESET . PHP_EOL;
            }
        }
    }

    $status = $classFailed === 0 ? GREEN : RED;
    echo "  " . $status . "→ {$classPassed} passed, {$classFailed} failed in {$methodCount} methods" . RESET . PHP_EOL;
    echo PHP_EOL;

    $totalPassed += $classPassed;
}

// Summary
echo BOLD . CYAN . "  ═══════════════════════════════════════" . RESET . PHP_EOL;
echo BOLD . "  Test Results:" . RESET . PHP_EOL;
echo "  Total test files: " . count($testFiles) . PHP_EOL;
echo "  Total assertions: {$totalAssertions}" . PHP_EOL;
echo "  " . GREEN . "Methods passed: {$totalPassed}" . RESET . PHP_EOL;
echo "  " . ($totalFailed > 0 ? RED : GREEN) . "Assertions failed: {$totalFailed}" . RESET . PHP_EOL;

if ($totalFailed > 0) {
    echo PHP_EOL . RED . BOLD . "  ❌ Some tests FAILED!" . RESET . PHP_EOL;
    exit(1);
} else {
    echo PHP_EOL . GREEN . BOLD . "  ✅ All tests PASSED!" . RESET . PHP_EOL;
    exit(0);
}

