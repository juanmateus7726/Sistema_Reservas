<?php
/**
 * Script para aplicar la migración faltante del campo permitir_coworking
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

    // Verificar si ya existe el campo
    $query = "SHOW COLUMNS FROM salas LIKE 'permitir_coworking'";
    $stmt = $pdo->query($query);
    $exists = $stmt->fetch();

    if ($exists) {
        echo "ℹ️  El campo 'permitir_coworking' ya existe en la tabla 'salas'.\n";
        echo "   No se requiere ninguna acción.\n";
    } else {
        echo "🔧 Agregando campo 'permitir_coworking' a la tabla 'salas'...\n\n";

        $sql = "ALTER TABLE salas
                ADD COLUMN permitir_coworking TINYINT(1) NOT NULL DEFAULT 0
                COMMENT '0=Tradicional (una reserva), 1=Coworking (múltiples reservas)'
                AFTER capacidad_sala";

        $pdo->exec($sql);

        echo "✅ Campo 'permitir_coworking' agregado exitosamente!\n\n";

        // Verificar que se agregó correctamente
        $query = "SHOW COLUMNS FROM salas LIKE 'permitir_coworking'";
        $stmt = $pdo->query($query);
        $result = $stmt->fetch();

        if ($result) {
            echo "✅ Verificación exitosa:\n";
            echo "   Campo: " . $result['Field'] . "\n";
            echo "   Tipo: " . $result['Type'] . "\n";
            echo "   Default: " . $result['Default'] . "\n\n";
        }

        echo "🎉 ¡Migración completada! Ahora puedes crear reservas sin problemas.\n";
    }

    // Mostrar estructura actualizada
    echo "\n=== ESTRUCTURA ACTUALIZADA DE LA TABLA 'salas' ===\n\n";
    $query = "DESCRIBE salas";
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
    echo "❌ Error: " . $e->getMessage() . "\n";
}
