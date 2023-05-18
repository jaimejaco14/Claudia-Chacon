<?php
// Obtener la solicitud HTTP y la ruta
$request_method = $_SERVER['REQUEST_METHOD'];
$request_uri = explode('/', $_SERVER['REQUEST_URI']);

// Configurar el encabezado de respuesta
header('Content-Type: application/json');
// Determinar qué función llamar en función del método de solicitud y la ruta
if ($request_method == 'GET' && count($request_uri) == 5 && $request_uri[4] == 'usuarios') {
    // Llamar a la función para obtener todos los usuarios
    $usuarios = obtener_usuarios();
    echo json_encode($usuarios);
} elseif ($request_method == 'GET' && count($request_uri) == 3 && $request_uri[1] == 'usuarios') {
    // Llamar a la función para obtener un usuario específico
    $id = intval($request_uri[2]);
    $usuario = obtener_usuario($id);
    echo json_encode($usuario);
} elseif ($request_method == 'POST' && count($request_uri) == 2 && $request_uri[1] == 'usuarios') {
    // Llamar a la función para crear un nuevo usuario
    $data = json_decode(file_get_contents('php://input'), true);
    $usuario = crear_usuario($data);
    echo json_encode($usuario);
} elseif ($request_method == 'PUT' && count($request_uri) == 3 && $request_uri[1] == 'usuarios') {
    // Llamar a la función para actualizar un usuario existente
    $id = intval($request_uri[2]);
    $data = json_decode(file_get_contents('php://input'), true);
    $usuario = actualizar_usuario($id, $data);
    echo json_encode($usuario);
} elseif ($request_method == 'DELETE' && count($request_uri) == 3 && $request_uri[1] == 'usuarios') {
    // Llamar a la función para eliminar un usuario existente
    $id = intval($request_uri[2]);
    eliminar_usuario($id);
    echo json_encode(['mensaje' => 'Usuario eliminado']);
} else {
    // Si la solicitud no es válida, devolver un error 404
    http_response_code(404);
    echo json_encode(['mensaje' => 'Recurso no encontrado']);
}

// Definir las funciones para manejar las solicitudes
function obtener_usuarios() {
    // Lógica para obtener todos los usuarios de la base de datos
    return [
        "pedro" => "1234",
        "juan" => "dfdf df",
    ];
}

function obtener_usuario($id) {
    // Lógica para obtener un usuario específico de la base de datos
    return [];
}

function crear_usuario($data) {
    // Lógica para crear un nuevo usuario en la base de datos
    return [];
}

function actualizar_usuario($id, $data) {
    // Lógica para actualizar un usuario existente en la base de datos
    return [];
}

function eliminar_usuario($id){

}

