<?php

use App\Core\Application;
use App\Core\Container\ContainerException;
use App\Core\Database\Sqlite\Connection;

require __DIR__.'/../vendor/autoload.php';

try {
    $app = new Application(dirname(__DIR__));
} catch (ContainerException $e) {
    echo "Error: " . $e->getMessage() . PHP_EOL;
}

try {
    // Specify the SQLite database file
    $pdo = Connection::getInstance();
    // Set error mode to exception
    $pdo->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $migrations_path = __DIR__ . '/migrations';
    // Read and execute SQL files
    $sqlFiles = array_diff(scandir(__DIR__ . '/migrations'), ['.', '..']);
    foreach ($sqlFiles as $file) {
        // Read the SQL file
        $sql = file_get_contents($migrations_path . '/' .$file);

        echo "Executing $file..." . PHP_EOL;
        // Execute the SQL queries
        $pdo->exec($sql);
        echo "Executed $file successfully." . PHP_EOL;
    }

    echo "Database setup complete." . PHP_EOL;

    if(isset($argv[1]) && str_replace('--','', $argv[1]) == 'seed'){
        $seed_path = __DIR__ . '/seed';
        echo "Seeding database..." . PHP_EOL;
        // Read and execute seed files
        $sqlFiles = array_diff(scandir(__DIR__ . '/seed'), ['.', '..']);
        foreach ($sqlFiles as $file) {
            // Read the SQL file
            $sql = file_get_contents($seed_path . '/' .$file);

            // Execute the SQL queries
            $pdo->exec($sql);
            echo "Executed $file successfully." . PHP_EOL;
        }
        echo "Seeding database complete." . PHP_EOL;
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . PHP_EOL;
    exit(1);
}