<?php
header("Content-Type: application/json");

// Obtenemos el método de la solicitud
$request_method = $_SERVER["REQUEST_METHOD"];
// Dividimos la URI de la solicitud
$request_uri = explode('/', trim($_SERVER['REQUEST_URI'], '/'));

// Verificamos que al menos haya 2 partes en el URI (recurso y acción)
if (count($request_uri) < 2) {
    header("HTTP/1.0 400 Bad Request");
    echo json_encode(["message" => "Solicitud inválida"]);
    exit();
}

// Extraemos el recurso y la acción
$resource = $request_uri[1];  // Ej. 'Doctor', 'Paciente', 'Pastillas', 'Prescripciones', 'Tomas'
$action = $request_uri[2] ?? null;  // Ej. 'insertarDoctor', 'obtenerDatosPastillaPorId', etc.

// Mapeo de recursos a directorios
$resource_map = [
    'Doctor' => 'Doctor',
    'Paciente' => 'Paciente',
    'Pastillas' => 'Pastillas',
    'Prescripciones' => 'Prescripciones',
    'Tomas' => 'Tomas',
];

// Validamos si el recurso es válido
if (!array_key_exists($resource, $resource_map)) {
    header("HTTP/1.0 404 Not Found");
    echo json_encode(["message" => "Recurso no encontrado"]);
    exit();
}

// Validamos si se ha proporcionado una acción
if ($action === null) {
    header("HTTP/1.0 400 Bad Request");
    echo json_encode(["message" => "Acción no válida"]);
    exit();
}

// Ruta al archivo correspondiente
$file_path = __DIR__ . '/' . $resource_map[$resource] . '/' . $action . '.php';

// Verificamos si el archivo existe
if (file_exists($file_path)) {
    include $file_path;
} else {
    header("HTTP/1.0 404 Not Found");
    echo json_encode(["message" => "Archivo no encontrado"]);
    exit();
}
?>
