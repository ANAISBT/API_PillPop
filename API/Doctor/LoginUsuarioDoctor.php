<?php
include '../config/ConectionBD.php';

// Obtener datos JSON desde el cuerpo de la solicitud
$input = file_get_contents("php://input");
$data = json_decode($input, true);

// Datos de login
$dni = $data['dni'];
$contrasena = $data['contrasena'];

try {
    // Preparar y ejecutar el procedimiento almacenado
    $stmt = $conn->prepare("CALL LoginUsuarioDoctor(:dni, :contrasena)");
    $stmt->bindParam(':dni', $dni, PDO::PARAM_INT);
    $stmt->bindParam(':contrasena', $contrasena, PDO::PARAM_STR);
    $stmt->execute();

    // Obtener resultados
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row['mensaje'] == 'Login exitoso') {
        echo json_encode([
            "mensaje" => "Bienvenido",
            "id" => $row['v_id']
        ]);
    } else {
        echo json_encode(["mensaje" => "Credenciales incorrectas"]);
    }

    // Cerrar el cursor
    $stmt->closeCursor();
} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}

// Cerrar conexión
$conn = null;
?>
