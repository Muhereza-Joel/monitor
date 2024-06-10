<?php
// Specify the path for the new .env file
$newEnvFilePath = __DIR__ . '/.env';

// Define the environment variables and their values
$envData = [
    'DB_HOST' => 'localhost',
    'DB_PORT' => '3306',
    'DB_DATABASE' => 'monitor_db',
    'DB_USERNAME' => 'root',
    'DB_PASSWORD' => '',
    'APP_NAME' => 'monitor',
    'APP_NAME_FULL' => '"M & E Monitor"',
    'APP_BASE_URL' => 'http://localhost',
    'SMTP_SERVER' => 'smtp.gmail.com',
    'APP_MAIL_CLIENT' => 'muherezajoel40@gmail.com',
    'APP_MAIL_KEY' => "'kmmt srcd nmuo nudn'",
    'APP_MAIL_SENDER' => 'moels.inc@gmail.com',
    'APP_MAIL_TITLE' => "'ODT M &E Monitor'"
];

// Generate the contents for the new .env file
$envContents = '';
foreach ($envData as $key => $value) {
    $envContents .= "$key=$value\n";
}

// Write the contents to the new .env file
file_put_contents($newEnvFilePath, $envContents);

echo "New .env file generated successfully.\n";
