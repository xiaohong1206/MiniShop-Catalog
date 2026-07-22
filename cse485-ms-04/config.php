<?php

declare(strict_types=1);

const DB_HOST = '127.0.0.1';
const DB_NAME = 'minishop_cse485';
const DB_USER = 'root';
const DB_PASS = ''; // XAMPP mặc định thường để trống
const DB_CHARSET = 'utf8mb4';

function db(): PDO
{
    static $pdo = null;

    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;

    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // ném Exception khi lỗi
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // trả về mảng kết hợp
        PDO::ATTR_EMULATE_PREPARES   => false,                  // dùng prepare thật của MySQL
    ];

    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
    return $pdo;
}