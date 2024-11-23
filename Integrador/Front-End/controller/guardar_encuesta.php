<?php
// Establece la conexión a la base de datos
$servername = "localhost";
$port = "3307"; // Usuario por defecto en XAMPP
$servername = "localhost";
$password = ""; // Contraseña por defecto en XAMPP
$dbname = "encuestas"; // Nombre de la base de datos

// Conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener los datos JSON enviados desde el cliente
$input_data = file_get_contents('php://input');
$data = json_decode($input_data, true);

// Verificar si se recibió la calificación
if (isset($data['rating']) && isset($data['comentarios'])) {
    $rating = $data['rating'];
    $comentarios = $data['comentarios'];

    // Consulta SQL para insertar los datos en la tabla
    $sql = "INSERT INTO respuestas (rating, comentarios) VALUES (?, ?)";

    // Preparar la declaración
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $rating, $comentarios); // 'i' para int, 's' para string

    // Ejecutar la declaración
    if ($stmt->execute()) {
        echo json_encode(['message' => 'Gracias por tu encuesta!']);
    } else {
        echo json_encode(['error' => 'Error al guardar los datos.']);
    }

    // Cerrar la declaración y la conexión
    $stmt->close();
} else {
    echo json_encode(['error' => 'Datos incompletos.']);
}

$conn->close();
?>
