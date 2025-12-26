<?php
/**
 * Script de verificación de base de datos
 * Verifica si la tabla reservas tiene el campo 'asistencia'
 */

// Configuración de la base de datos
$host = 'localhost';
$database = 'sistema_reservas';
$username = 'root';
$password = '';

try {
    // Conectar a la base de datos
    $pdo = new PDO("mysql:host=$host;dbname=$database;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "✅ Conexión exitosa a la base de datos '$database'\n\n";

    // Verificar si existe el campo 'asistencia' en la tabla 'reservas'
    $query = "SHOW COLUMNS FROM reservas LIKE 'asistencia'";
    $stmt = $pdo->query($query);
    $result = $stmt->fetch();

    echo "=== VERIFICACIÓN DEL CAMPO 'asistencia' ===\n\n";

    if ($result) {
        echo "✅ El campo 'asistencia' YA EXISTE en la tabla 'reservas'\n";
        echo "   Tipo: " . $result['Type'] . "\n";
        echo "   Nulo: " . $result['Null'] . "\n";
        echo "   Default: " . ($result['Default'] ?? 'NULL') . "\n\n";
        echo "✅ Tu base de datos está actualizada.\n";
    } else {
        echo "❌ El campo 'asistencia' NO EXISTE en la tabla 'reservas'\n\n";
        echo "⚠️  ACCIÓN REQUERIDA:\n";
        echo "   Debes ejecutar el archivo 'database_migration.sql' en phpMyAdmin\n\n";
        echo "   Pasos:\n";
        echo "   1. Abre http://localhost/phpmyadmin\n";
        echo "   2. Selecciona la base de datos 'sistema_reservas'\n";
        echo "   3. Ve a la pestaña 'SQL'\n";
        echo "   4. Copia y pega el contenido de 'database_migration.sql'\n";
        echo "   5. Haz clic en 'Continuar'\n\n";
    }

    // Verificar si existe el campo 'permitir_coworking' en la tabla 'salas'
    echo "\n=== VERIFICACIÓN DEL CAMPO 'permitir_coworking' ===\n\n";

    $query = "SHOW COLUMNS FROM salas LIKE 'permitir_coworking'";
    $stmt = $pdo->query($query);
    $result = $stmt->fetch();

    if ($result) {
        echo "✅ El campo 'permitir_coworking' YA EXISTE en la tabla 'salas'\n\n";
    } else {
        echo "❌ El campo 'permitir_coworking' NO EXISTE en la tabla 'salas'\n";
        echo "⚠️  Necesitas ejecutar 'database_migration.sql'\n\n";
    }

    // Mostrar estructura completa de la tabla reservas
    echo "\n=== ESTRUCTURA ACTUAL DE LA TABLA 'reservas' ===\n\n";
    $query = "DESCRIBE reservas";
    $stmt = $pdo->query($query);
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);

    printf("%-25s %-20s %-10s %-10s\n", "Campo", "Tipo", "Nulo", "Default");
    echo str_repeat("-", 70) . "\n";

    foreach ($columns as $column) {
        printf("%-25s %-20s %-10s %-10s\n",
            $column['Field'],
            $column['Type'],
            $column['Null'],
            $column['Default'] ?? 'NULL'
        );
    }

} catch (PDOException $e) {
    echo "❌ Error de conexión: " . $e->getMessage() . "\n";
    echo "\n⚠️  Verifica que:\n";
    echo "   - XAMPP esté ejecutándose\n";
    echo "   - MySQL esté activo\n";
    echo "   - La base de datos 'sistema_reservas' exista\n";
}
