<?php
include '../config/ConectionBD.php';

// Obtener los datos JSON enviados por POST
$input = file_get_contents('php://input');
$data = json_decode($input, true);

// Extraer el ID de la pastilla del JSON
$pastillaID = $data['pastillaID'];

try {
    // Preparar la llamada al procedimiento almacenado
    $sql = "CALL obtenerDatosPastillaPorId(:pastillaID)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':pastillaID', $pastillaID, PDO::PARAM_INT);

    // Ejecutar la llamada
    if ($stmt->execute()) {
        $response = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $response[] = $row;
        }

        if (empty($response)) {
            $response = array("error" => "No se encontraron datos para la pastilla con ID: $pastillaID");
        }

        echo json_encode($response);
    } else {
        $response = array("error" => $stmt->errorInfo());
        echo json_encode($response);
    }

    // Cerrar el cursor
    $stmt->closeCursor();
} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}

// Cerrar conexión
$conn = null;
?>
