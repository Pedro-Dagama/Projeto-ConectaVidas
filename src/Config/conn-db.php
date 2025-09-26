<?php

$config = require __DIR__ . '/database.php';

try {
  $conn = "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}";
  $options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  ];
  $pdo = new PDO($conn, $config['username'], $config['password'], $options);
} catch (PDOException $e) {
  die("Falha na conexão com o banco de dados: " . $e->getMessage());
}
