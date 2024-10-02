<?php
include '../config/ConectionBD.php';

// Obtener los datos JSON enviados por Postman
$input = file_get_contents("php://input");
$data = json_decode($input, true);

$nombre = $data['nombre'];
$cantidad = $data['cantidad'];
$dosis = $data['dosis'];
$cantidad_sobrante = $data['cantidad_sobrante'];
$frecuencia_id = $data['frecuencia_id'];
$fecha_inicio = $data['fecha_inicio'];
$observaciones = $data['observaciones'];
$prescripcion_id = $data['prescripcion_id'];

try {
    // Preparar y ejecutar el procedimiento almacenado
    $stmt = $conn->prepare("CALL InsertarPastillas(:nombre, :cantidad, :dosis, :cantidad_sobrante, :frecuencia_id, :fecha_inicio, :observaciones, :prescripcion_id)");
    $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
    $stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
    $stmt->bindParam(':dosis', $dosis, PDO::PARAM_INT);
    $stmt->bindParam(':cantidad_sobrante', $cantidad_sobrante, PDO::PARAM_INT);
    $stmt->bindParam(':frecuencia_id', $frecuencia_id, PDO::PARAM_INT);
    $stmt->bindParam(':fecha_inicio', $fecha_inicio, PDO::PARAM_STR);
    $stmt->bindParam(':observaciones', $observaciones, PDO::PARAM_STR);
    $stmt->bindParam(':prescripcion_id', $prescripcion_id, PDO::PARAM_INT);
    $stmt->execute();

    echo json_encode(["mensaje" => "Pastilla insertada correctamente"]);

    // Cerrar el cursor
    $stmt->closeCursor();
} catch (PDOException $e) {
    echo json_encode(["error" => "Error al insertar la pastilla: " . $e->getMessage()]);
}

// Cerrar conexión
$conn = null;
?>
