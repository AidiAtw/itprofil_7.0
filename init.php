<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

try {
    $db = new PDO("sqlite:profile.db");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = "CREATE TABLE IF NOT EXISTS interests (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                name TEXT NOT NULL UNIQUE
              )";
    $db->exec($query);
    echo "Krok 1: Tabulka v pořádku.<br>";
    $db->exec("INSERT OR IGNORE INTO interests (name) VALUES ('Programování')");
    echo "Krok 2: Testovací data vložena.<br>";
    chmod("profile.db", 0666);

} catch (Exception $e) {
    echo "CHYBA: " . $e->getMessage();
}