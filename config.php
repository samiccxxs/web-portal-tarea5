<?php
// Configuración de claves API
$apiKeys = [
    'openWeather' => 'b984d7e6f4fc40fc180728854481ffb1', // Obtén en https://openweathermap.org/
    'exchangeRate' => '4ee6b1be7bf3bf6c95711de1', // Obtén en https://www.exchangerate-api.com/
    'unsplash' => 'TU_CLAVE_API_UNSPLASH' // Obtén en https://unsplash.com/developers
];

// Función para hacer solicitudes HTTP con cURL
function makeApiRequest($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // Asegura soporte HTTPS
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);

    if ($response === false || $httpCode >= 400) {
        return ['error' => 'Error al conectar con la API: ' . ($error ?: 'Código HTTP ' . $httpCode)];
    }

    $data = json_decode($response, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        return ['error' => 'Error al procesar la respuesta de la API'];
    }

    return $data;
}
?>