<?php
include '../config/ConectionBD.php';

$data = json_decode(file_get_contents('php://input'), true);

$p_dni = $data['p_dni'];
$p_prescripcion_id = $data['p_prescripcion_id'];
$p_diagnostico = $data['p_diagnostico'];
$p_fecha = $data['p_fecha'];

$sql = "CALL editarPrescripcion(:dni, :prescripcion_id, :diagnostico, :fecha)";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':dni', $p_dni, PDO::PARAM_INT);
$stmt->bindParam(':prescripcion_id', $p_prescripcion_id, PDO::PARAM_INT);
$stmt->bindParam(':diagnostico', $p_diagnostico, PDO::PARAM_STR);
$stmt->bindParam(':fecha', $p_fecha, PDO::PARAM_STR);

if ($stmt->execute()) {
    do {
        if ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $response = array("prescripcion_id" => $result['p_prescripcion_id']);
        }
    } while ($stmt->nextRowset());

    echo json_encode($response);
} else {
    $response = array("error" => $stmt->errorInfo());
    echo json_encode($response);
}

$stmt->closeCursor();
$conn = null;
?>
