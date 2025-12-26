<?php
/**
 * Script para ver las reservas en la base de datos
 */

$host = 'localhost';
$database = 'sistema_reservas';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "=== VERIFICACIÓN DE RESERVAS ===\n\n";

    // Contar total de reservas
    $stmt = $pdo->query('SELECT COUNT(*) as total FROM reservas');
    $result = $stmt->fetch();
    echo "📊 Total de reservas en la BD: " . $result['total'] . "\n\n";

    // Ver últimas 10 reservas
    echo "=== ÚLTIMAS 10 RESERVAS ===\n\n";
    $stmt = $pdo->query('
        SELECT r.*, s.nombre_sala, u.nombre_usuario
        FROM reservas r
        LEFT JOIN salas s ON s.id_sala = r.id_sala
        LEFT JOIN usuarios u ON u.id_usuario = r.id_usuario
        ORDER BY r.id_reserva DESC
        LIMIT 10
    ');
    $reservas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($reservas)) {
        echo "⚠️  No hay reservas en la base de datos\n";
    } else {
        printf("%-5s %-20s %-20s %-12s %-10s %-10s %-10s\n",
            "ID", "Sala", "Usuario", "Fecha", "Inicio", "Fin", "Estado");
        echo str_repeat("-", 95) . "\n";

        foreach($reservas as $r) {
            printf("%-5s %-20s %-20s %-12s %-10s %-10s %-10s\n",
                $r['id_reserva'],
                substr($r['nombre_sala'] ?? 'N/A', 0, 20),
                substr($r['nombre_usuario'] ?? 'N/A', 0, 20),
                $r['fecha_reserva'],
                $r['hora_reserva_inicio'],
                $r['hora_reserva_fin'],
                $r['estado_reserva'] == 1 ? 'Activa' : 'Cancelada'
            );
        }
    }

    // Ver reservas de HOY
    echo "\n\n=== RESERVAS DE HOY (25/12/2025) ===\n\n";
    $stmt = $pdo->query("
        SELECT r.*, s.nombre_sala, u.nombre_usuario
        FROM reservas r
        LEFT JOIN salas s ON s.id_sala = r.id_sala
        LEFT JOIN usuarios u ON u.id_usuario = r.id_usuario
        WHERE r.fecha_reserva = '2025-12-25'
        ORDER BY r.hora_reserva_inicio
    ");
    $hoy = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($hoy)) {
        echo "⚠️  No hay reservas para hoy\n";
    } else {
        foreach($hoy as $r) {
            echo "  ✓ ID {$r['id_reserva']} - {$r['nombre_sala']} - {$r['hora_reserva_inicio']} a {$r['hora_reserva_fin']}\n";
        }
    }

} catch (PDOException $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
