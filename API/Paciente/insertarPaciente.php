<?php
include '../config/ConectionBD.php';

// Obtener los datos de la solicitud POST
$input = file_get_contents("php://input");
$data = json_decode($input, true);

$nombreCompleto = $data['nombreCompleto'];
$sexo_id = $data['sexo_id'];
$edad = $data['edad'];
$dni = $data['dni'];
$correoElectronico = $data['correoElectronico'];
$contrasena = $data['contrasena'];

try {
    // Preparar y ejecutar la llamada al procedimiento almacenado
    $stmt = $conn->prepare("CALL agregarPaciente(:nombreCompleto, :sexo_id, :edad, :dni, :correoElectronico, :contrasena)");
    $stmt->bindParam(':nombreCompleto', $nombreCompleto, PDO::PARAM_STR);
    $stmt->bindParam(':sexo_id', $sexo_id, PDO::PARAM_INT);
    $stmt->bindParam(':edad', $edad, PDO::PARAM_INT);
    $stmt->bindParam(':dni', $dni, PDO::PARAM_STR);
    $stmt->bindParam(':correoElectronico', $correoElectronico, PDO::PARAM_STR);
    $stmt->bindParam(':contrasena', $contrasena, PDO::PARAM_STR);
    $stmt->execute();

    echo json_encode(["message" => "Paciente agregado exitosamente."]);

    // Cerrar el cursor
    $stmt->closeCursor();
} catch (PDOException $e) {
    echo json_encode(["error" => "Error al agregar paciente: " . $e->getMessage()]);
}

// Cerrar conexión
$conn = null;
?>
