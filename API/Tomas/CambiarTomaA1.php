<?php
include '../config/ConectionBD.php';

// Leer y decodificar el JSON de la solicitud POST
$input = file_get_contents('php://input');
$data = json_decode($input, true);

// Verificar si tomaID está definido en el JSON
if (isset($data['tomaID'])) {
    $tomaID = $data['tomaID'];
} else {
    die(json_encode(["error" => "tomaID no está definido en la solicitud JSON."]));
}

try {
    // Preparar la llamada al procedimiento almacenado
    $sql = "CALL CambiarTomaA1(:tomaID)";
    $stmt = $conn->prepare($sql);

    // Vincular el parámetro
    $stmt->bindParam(':tomaID', $tomaID, PDO::PARAM_INT);

    // Ejecutar el procedimiento almacenado
    if ($stmt->execute()) {
        echo json_encode(["mensaje" => "El valor de 'toma' ha sido actualizado a '1' exitosamente."]);
    } else {
        echo json_encode(["error" => "Error al ejecutar el procedimiento: " . implode(", ", $stmt->errorInfo())]);
    }

    // Cerrar el cursor
    $stmt->closeCursor();
} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}

// Cerrar conexión
$conn = null;
?>
