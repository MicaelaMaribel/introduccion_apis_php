<?php
// Configuración de credenciales (La "llave" de acceso)
$apiKey = "Tu_Api_Key"; 

// PASO 1: ESCUCHAR AL USUARIO (PREPARAR EL ENVÍO)
// Recibimos lo que el usuario escribió y armamos el paquete JSON
$pregunta = isset($_POST['pregunta']) ? $_POST['pregunta'] : '';
$respuesta_ia = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($pregunta)) {

    $url = "https://api.groq.com/openai/v1/chat/completions";

    // Estructuramos los datos que la IA necesita recibir
    $data = [
        "model" => "llama-3.3-70b-versatile",
        "messages" => [
            ["role" => "user", "content" => $pregunta]
        ]
    ];

    // PASO 2: LLAMADA A LA API Y ENVÍO DE PETICIÓN
    // Usamos cURL para enviar el paquete con seguridad (API Key) y recibir la respuesta del servidor de Groq
    $ch = curl_init($url);

    // Configuramos los encabezados (Headers) para la autorización
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $apiKey
    ]);
    curl_setopt($ch, CURLOPT_POST, true); #viaje de ida y vuelta 
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

    // Se ejecuta la conexión y se recibe el paquete de datos
    $json_response = curl_exec($ch);

    // PASO 3: TRADUCCIÓN DE JSON A ARRAY PHP (PROCESAMIENTO)
    // Convertimos el paquete de la IA en algo que PHP entienda para extraer el mensaje final para el usuario
    if ($json_response === false) {
        $respuesta_ia = "Error de conexión: " . curl_error($ch);
    } else {
        // Traducimos el JSON a un Array asociativo de PHP
        $datos = json_decode($json_response, true);

        // Navegamos el array para encontrar el texto de la respuesta
        if (isset($datos['choices'][0]['message']['content'])) {
            $respuesta_ia = $datos['choices'][0]['message']['content'];
        } else {
            $respuesta_ia = "Respuesta de Groq: " . print_r($datos, true);
        }
    }

}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi primer Chatbot con IA</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #eef2f7; text-align: center; padding: 50px; }
        .chat-box { background: white; max-width: 600px; margin: auto; padding: 30px; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
        textarea { width: 100%; height: 100px; border-radius: 8px; border: 1px solid #ccc; padding: 10px; font-size: 16px; box-sizing: border-box; }
        button { background: #1a73e8; color: white; border: none; padding: 12px 25px; border-radius: 8px; cursor: pointer; margin-top: 10px; }
        .respuesta { background: #f1f3f4; padding: 20px; border-radius: 10px; margin-top: 20px; text-align: left; line-height: 1.6; }
    </style>
</head>
<body>

<div class="chat-box">
    <h2>Consultale a la Inteligencia Artificial</h2>

    <form method="POST">
        <textarea name="pregunta" placeholder="Escribí tu pregunta aquí..."><?= htmlspecialchars($pregunta) ?></textarea>
        <button type="submit">Enviar</button>
    </form>

    <?php if ($respuesta_ia): ?>
        <div class="respuesta">
            <strong>Respuesta:</strong><br>
            <?= nl2br(htmlspecialchars($respuesta_ia)) ?>
        </div>
    <?php endif; ?>
</div>

</body>
</html>