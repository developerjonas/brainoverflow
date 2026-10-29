<?php

// Database credentials come from the deployment environment, never source code.
$requiredSettings = ['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASSWORD'];
$databaseSettings = [];
foreach ($requiredSettings as $setting) {
    $value = getenv($setting);
    if ($value === false || $value === '') {
        throw new RuntimeException("Missing required database setting: {$setting}");
    }
    $databaseSettings[$setting] = $value;
}

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$conn = mysqli_connect(
    $databaseSettings['DB_HOST'],
    $databaseSettings['DB_USER'],
    $databaseSettings['DB_PASSWORD'],
    $databaseSettings['DB_NAME']
);
mysqli_set_charset($conn, 'utf8mb4');