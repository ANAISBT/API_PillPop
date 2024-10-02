<?php
include '../config/ConectionBD.php';

// Obtener los datos de la solicitud POST
$input = file_get_contents("php://input");
$data = json_decode($input, true);

$doctorID = $data['doctorID'];
$fechaHoy = $data['fechaHoy'];

try {
    // Preparar y ejecutar la llamada al procedimiento almacenado
    $stmt = $conn->prepare("CALL ObtenerPrescripcionesPorDoctorYFecha(:doctorID, :fechaHoy)");
    $stmt->bindParam(':doctorID', $doctorID, PDO::PARAM_INT);
    $stmt->bindParam(':fechaHoy', $fechaHoy, PDO::PARAM_STR);
    $stmt->execute();

    // Obtener los resultados
    $response = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $response[] = $row;
    }

    if (empty($response)) {
        $response["message"] = "No se encontraron resultados.";
    }

    // Cerrar el cursor
    $stmt->closeCursor();
} catch (PDOException $e) {
    $response = ["error" => $e->getMessage()];
}

// Cerrar conexión
$conn = null;

// Devolver la respuesta en formato JSON
echo json_encode($response);
?>
