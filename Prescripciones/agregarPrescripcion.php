<?php
include '../config/ConectionBD.php';

$data = json_decode(file_get_contents('php://input'), true);

$p_dni = $data['p_dni'];
$p_doctor_id = $data['p_doctor_id'];
$p_diagnostico = $data['p_diagnostico'];
$p_fecha = $data['p_fecha'];

$sql = "CALL agregarPrescripcion(:dni, :doctor_id, :diagnostico, :fecha)";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':dni', $p_dni, PDO::PARAM_INT);
$stmt->bindParam(':doctor_id', $p_doctor_id, PDO::PARAM_INT);
$stmt->bindParam(':diagnostico', $p_diagnostico, PDO::PARAM_STR);
$stmt->bindParam(':fecha', $p_fecha, PDO::PARAM_STR);

if ($stmt->execute()) {
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $response = array("prescripcion_id" => $result['p_prescripcion_id']);
    echo json_encode($response);
} else {
    $response = array("error" => $stmt->errorInfo());
    echo json_encode($response);
}

$stmt->closeCursor();
$conn = null;
?>
