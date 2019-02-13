<!-- CONNECTION TO DATABASE -->
<?php
    if (!defined('DB_HOST')) define('DB_HOST', 'localhost');
    if (!defined('DB_PORT')) define('DB_PORT', '8888');
    if (!defined('DB_NAME')) define('DB_NAME', 'test');
    if (!defined('DB_USER')) define('DB_USER', 'root');
    if (!defined('DB_PASS')) define('DB_PASS', 'root');
    
    try
    {
        $pdo = new PDO(
            'mysql:dbname='.DB_NAME.';host='.DB_HOST.';port='.DB_PORT,
            DB_USER,
            DB_PASS
        );
    
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    }
    catch (PDOException $e)
    {
        die('cannot connect');
    }