<?php

const USER = 'root';
const PASSWORD = '';
const HOST = 'localhost';
const DATABASE = 'product_security_challenge_db';

try {
    $connection = new PDO("mysql:host=" . HOST . ";dbname=" . DATABASE, USER, PASSWORD, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES => false
    ]);
} catch (PDOException $e) {
    exit("Error: " . $e->getMessage());
}