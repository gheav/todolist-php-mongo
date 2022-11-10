<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/app/Helper.php';
$dotenv             = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$client             = new MongoDB\Client('mongodb://' . $_ENV['MDB_USER'] . ':' . $_ENV['MDB_PASS'] . '@' . $_ENV['MDB_HOST'] . '/' . $_ENV['MDB_INIT'] . '?retryWrites=true&w=majority');
$database           = $client->exercise;
$userCollection     = $database->users;
$todoCollection     = $database->todo;

echo "Fullname : ";
$fullname   = trim(fgets(STDIN));
echo "Email    : ";
$email      = trim(fgets(STDIN));

$user = $userCollection->findOne(['email' => $email]);
if (!$user) {
    $userCollection->insertOne([
        '_id'       => Helper::guidv4(),
        'fullname'  => $fullname,
        'email'     => $email,
        'source'    => 'todolist-php-mongo'
    ]);
}
echo PHP_EOL;
echo 'Welcome Back ' . $fullname;
