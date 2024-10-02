<?php
include '../config/ConectionBD.php';

$data = json_decode(file_get_contents('php://input'), true);

$p_prescripcion_id = $data['p_prescripcion_id'];

$sql = "CALL eliminarPrescripcion(:prescripcion_id)";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':prescripcion_id', $p_prescripcion_id, PDO::PARAM_INT);

if ($stmt->execute()) {
    $response = array("message" => "Prescripción eliminada exitosamente.");
    echo json_encode($response);
} else {
    $response = array("error" => $stmt->errorInfo());
    echo json_encode($response);
}

$stmt->closeCursor();
$conn = null;
?>
