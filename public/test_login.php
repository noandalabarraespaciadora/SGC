<?php
// Conectar a la base de datos y probar manualmente
require_once '../app/Config/Database.php';

$config = new \Config\Database();
$db = \Config\Database::connect();

// Ver usuarios en la base de datos
echo "<h2>Usuarios en la base de datos:</h2>";
$usuarios = $db->query("SELECT id, nombre, email, password, activo, LENGTH(password) as pass_length FROM usuarios")->getResultArray();

foreach ($usuarios as $usuario) {
    echo "ID: {$usuario['id']} | ";
    echo "Email: {$usuario['email']} | ";
    echo "Activo: {$usuario['activo']} | ";
    echo "Longitud Password: {$usuario['pass_length']} | ";
    echo "Password: {$usuario['password']}<br>";
}

// Probar hash de una contraseña
echo "<h2>Probar Hash:</h2>";
$test_password = "password";
$hashed = password_hash($test_password, PASSWORD_DEFAULT);
echo "Password original: {$test_password}<br>";
echo "Password hasheado: {$hashed}<br>";
echo "Longitud hash: " . strlen($hashed) . "<br>";

// Verificar contra un usuario específico
if (!empty($usuarios)) {
    $usuario = $usuarios[0];
    $verify = password_verify($test_password, $usuario['password']);
    echo "<h2>Verificación con primer usuario:</h2>";
    echo "Resultado verificación: " . ($verify ? 'TRUE' : 'FALSE') . "<br>";
}