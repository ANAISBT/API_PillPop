<?php
include '../config/ConectionBD.php';

// Obtener los datos JSON enviados por POST
$input = file_get_contents('php://input');
$data = json_decode($input, true);

// Extraer el ID de la prescripción del JSON
$p_prescripcion_id = $data['p_prescripcion_id'];

try {
    // Preparar la llamada al procedimiento almacenado
    $sql = "CALL obtenerDatosPrescripcionPorId(:prescripcion_id)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':prescripcion_id', $p_prescripcion_id, PDO::PARAM_INT);

    // Ejecutar la llamada
    if ($stmt->execute()) {
        $response = array(
            "datos" => array(),
            "lista_pastillas" => array()
        );

        // Procesar todos los resultados
        $resultIndex = 0;
        do {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                if ($resultIndex == 0) {
                    $response["datos"][] = $row;
                } else {
                    $response["lista_pastillas"][] = $row;
                }
            }
            $resultIndex++;
        } while ($stmt->nextRowset());

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
