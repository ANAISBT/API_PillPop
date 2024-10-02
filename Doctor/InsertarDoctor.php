<?php
include '../config/ConectionBD.php';

// Obtener los datos JSON del cuerpo de la solicitud
$input = file_get_contents('php://input');
$data = json_decode($input, true);

$nombreCompleto = $data['nombreCompleto'];
$sexo_id = $data['sexo_id'];
$especialidad_id = $data['especialidad_id'];
$dni = $data['dni'];
$correoElectronico = $data['correoElectronico'];
$contrasena = $data['contrasena'];

try {
    // Preparar y ejecutar la llamada al procedimiento almacenado
    $stmt = $conn->prepare("CALL InsertarUsuarioDoctor(:nombreCompleto, :sexo_id, :especialidad_id, :dni, :correoElectronico, :contrasena)");
    $stmt->bindParam(':nombreCompleto', $nombreCompleto, PDO::PARAM_STR);
    $stmt->bindParam(':sexo_id', $sexo_id, PDO::PARAM_INT);
    $stmt->bindParam(':especialidad_id', $especialidad_id, PDO::PARAM_INT);
    $stmt->bindParam(':dni', $dni, PDO::PARAM_STR);
    $stmt->bindParam(':correoElectronico', $correoElectronico, PDO::PARAM_STR);
    $stmt->bindParam(':contrasena', $contrasena, PDO::PARAM_STR);
    $stmt->execute();

    echo json_encode(["message" => "Nuevo registro insertado exitosamente"]);

    // Cerrar el cursor
    $stmt->closeCursor();
} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}

// Cerrar conexión
$conn = null;
?>
