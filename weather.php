<?php
// Configuración de claves API
$apiKeys = [
    'openWeather' => 'b984d7e6f4fc40fc180728854481ffb1', // Tu clave actual
    'weatherAPI' => 'TU_CLAVE_WEATHERAPI', // Alternativa: https://www.weatherapi.com/
];

// Función mejorada para hacer solicitudes HTTP
function makeApiRequest($url, $timeout = 15) {
    // Verificar si cURL está disponible
    if (!function_exists('curl_init')) {
        return ['error' => 'cURL no está disponible en este servidor'];
    }
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Para servidores con problemas SSL
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; WeatherApp/1.0)');
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);
    
    if ($response === false) {
        return ['error' => 'Error cURL: ' . $curlError];
    }
    
    if ($httpCode >= 400) {
        return ['error' => 'Error HTTP: ' . $httpCode . ' - Respuesta: ' . substr($response, 0, 200)];
    }
    
    $data = json_decode($response, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        return ['error' => 'Error JSON: ' . json_last_error_msg() . ' - Respuesta: ' . substr($response, 0, 200)];
    }
    
    return $data;
}

// Función para obtener clima con OpenWeatherMap (API gratuita)
function getWeatherOpenWeather($city, $apiKey) {
    // Usar la API actual de OpenWeatherMap (Current Weather Data)
    $url = "https://api.openweathermap.org/data/2.5/weather?q=" . urlencode($city) . "&appid=" . $apiKey . "&units=metric&lang=es";
    
    $data = makeApiRequest($url);
    
    if (isset($data['error'])) {
        return $data;
    }
    
    // Verificar si la respuesta contiene datos válidos
    if (!isset($data['main']) || !isset($data['weather'])) {
        return ['error' => 'Respuesta inválida de OpenWeatherMap: ' . json_encode($data)];
    }
    
    return [
        'city' => $data['name'],
        'country' => $data['sys']['country'] ?? 'N/A',
        'temperature' => round($data['main']['temp']),
        'feels_like' => round($data['main']['feels_like']),
        'humidity' => $data['main']['humidity'],
        'pressure' => $data['main']['pressure'],
        'description' => ucfirst($data['weather'][0]['description']),
        'icon' => $data['weather'][0]['icon'],
        'wind_speed' => $data['wind']['speed'] ?? 0,
        'visibility' => isset($data['visibility']) ? ($data['visibility'] / 1000) : 'N/A'
    ];
}

// Función alternativa con WeatherAPI (más confiable)
function getWeatherAPI($city, $apiKey) {
    if ($apiKey === 'TU_CLAVE_WEATHERAPI') {
        return ['error' => 'Configura tu clave de WeatherAPI'];
    }
    
    $url = "https://api.weatherapi.com/v1/current.json?key=" . $apiKey . "&q=" . urlencode($city) . "&lang=es";
    
    $data = makeApiRequest($url);
    
    if (isset($data['error'])) {
        return $data;
    }
    
    if (!isset($data['current'])) {
        return ['error' => 'Respuesta inválida de WeatherAPI'];
    }
    
    return [
        'city' => $data['location']['name'],
        'country' => $data['location']['country'],
        'temperature' => round($data['current']['temp_c']),
        'feels_like' => round($data['current']['feelslike_c']),
        'humidity' => $data['current']['humidity'],
        'pressure' => $data['current']['pressure_mb'],
        'description' => $data['current']['condition']['text'],
        'icon' => $data['current']['condition']['icon'],
        'wind_speed' => $data['current']['wind_kph'] / 3.6, // Convertir a m/s
        'visibility' => $data['current']['vis_km']
    ];
}

// Función de clima sin API (datos simulados para pruebas)
function getWeatherDemo($city) {
    $demoData = [
        'santo domingo' => [
            'city' => 'Santo Domingo',
            'country' => 'DO',
            'temperature' => 28,
            'feels_like' => 32,
            'humidity' => 75,
            'pressure' => 1013,
            'description' => 'Parcialmente nublado',
            'icon' => '02d',
            'wind_speed' => 3.5,
            'visibility' => 10
        ],
        'madrid' => [
            'city' => 'Madrid',
            'country' => 'ES',
            'temperature' => 15,
            'feels_like' => 12,
            'humidity' => 60,
            'pressure' => 1020,
            'description' => 'Soleado',
            'icon' => '01d',
            'wind_speed' => 2.1,
            'visibility' => 15
        ]
    ];
    
    $cityLower = strtolower($city);
    if (isset($demoData[$cityLower])) {
        return $demoData[$cityLower];
    }
    
    // Datos genéricos para cualquier ciudad
    return [
        'city' => ucfirst($city),
        'country' => 'XX',
        'temperature' => rand(15, 30),
        'feels_like' => rand(15, 35),
        'humidity' => rand(40, 80),
        'pressure' => rand(1000, 1030),
        'description' => 'Clima variable',
        'icon' => '03d',
        'wind_speed' => rand(1, 8),
        'visibility' => rand(5, 20)
    ];
}

// Procesar formulario
$weatherData = null;
$errorMessage = null;

if (isset($_POST['city']) && !empty(trim($_POST['city']))) {
    $city = trim($_POST['city']);
    
    // Intentar con OpenWeatherMap primero
    $weatherData = getWeatherOpenWeather($city, $apiKeys['openWeather']);
    
    // Si falla, intentar con WeatherAPI
    if (isset($weatherData['error']) && $apiKeys['weatherAPI'] !== 'TU_CLAVE_WEATHERAPI') {
        $weatherData = getWeatherAPI($city, $apiKeys['weatherAPI']);
    }
    
    // Si ambas fallan, usar datos demo
    if (isset($weatherData['error'])) {
        $errorMessage = $weatherData['error'];
        $weatherData = getWeatherDemo($city);
        $weatherData['demo'] = true;
    }
}

// Función para obtener el ícono del clima
function getWeatherIcon($iconCode) {
    if (strpos($iconCode, 'http') === 0) {
        return $iconCode; // WeatherAPI devuelve URL completa
    }
    return "https://openweathermap.org/img/wn/{$iconCode}@2x.png";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clima - Portal Web</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .weather-card {
            background: linear-gradient(135deg, #74b9ff 0%, #0984e3 100%);
            color: white;
            border-radius: 15px;
            padding: 2rem;
            margin: 1rem 0;
        }
        .weather-icon {
            width: 100px;
            height: 100px;
        }
        .temp-display {
            font-size: 3rem;
            font-weight: bold;
        }
        .weather-detail {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            padding: 1rem;
            margin: 0.5rem 0;
        }
        .demo-badge {
            background: #ffeaa7;
            color: #2d3436;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }
        .error-details {
            font-size: 0.9rem;
            margin-top: 1rem;
        }
    </style>
</head>
<body>
    <!-- Barra de navegación -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Portal Web</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="about.php">Acerca de</a></li>
                    <li class="nav-item"><a class="nav-link" href="gender.php">Predicción de Género</a></li>
                    <li class="nav-item"><a class="nav-link" href="age.php">Predicción de Edad</a></li>
                    <li class="nav-item"><a class="nav-link" href="universities.php">Universidades</a></li>
                    <li class="nav-item"><a class="nav-link active" href="weather.php">Clima</a></li>
                    <li class="nav-item"><a class="nav-link" href="pokemon.php">Pokémon</a></li>
                    <li class="nav-item"><a class="nav-link" href="news.php">Noticias</a></li>
                    <li class="nav-item"><a class="nav-link" href="currency.php">Conversión de Monedas</a></li>
                    <li class="nav-item"><a class="nav-link" href="images.php">Imágenes IA</a></li>
                    <li class="nav-item"><a class="nav-link" href="country.php">Datos de País</a></li>
                    <li class="nav-item"><a class="nav-link" href="joke.php">Chiste Aleatorio</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenido principal -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1 class="text-center mb-4"><i class="fas fa-cloud-sun"></i> Consultar Clima</h1>
                
                <!-- Información sobre APIs -->
                <div class="alert alert-info">
                    <h6><i class="fas fa-info-circle"></i> APIs Disponibles:</h6>
                    <ul class="mb-0">
                        <li><strong>OpenWeatherMap:</strong> 1,000 consultas gratis/día</li>
                        <li><strong>WeatherAPI:</strong> 1,000,000 consultas gratis/mes</li>
                        <li><strong>Modo Demo:</strong> Datos simulados si fallan las APIs</li>
                    </ul>
                </div>
                
                <!-- Formulario -->
                <form method="POST" class="mb-4">
                    <div class="input-group">
                        <input type="text" 
                               class="form-control form-control-lg" 
                               name="city" 
                               placeholder="Ingresa el nombre de una ciudad..." 
                               value="<?php echo htmlspecialchars($_POST['city'] ?? ''); ?>"
                               required>
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-search"></i> Buscar
                        </button>
                    </div>
                </form>

                <!-- Mensaje de error -->
                <?php if ($errorMessage): ?>
                    <div class="alert alert-warning">
                        <strong><i class="fas fa-exclamation-triangle"></i> Problema con la API:</strong>
                        <div class="error-details"><?php echo htmlspecialchars($errorMessage); ?></div>
                        <small class="mt-2 d-block">Se están mostrando datos de demostración.</small>
                    </div>
                <?php endif; ?>

                <!-- Resultados del clima -->
                <?php if ($weatherData): ?>
                    <div class="weather-card">
                        <?php if (isset($weatherData['demo'])): ?>
                            <div class="demo-badge text-center">
                                <i class="fas fa-flask"></i> Datos de Demostración
                            </div>
                        <?php endif; ?>
                        
                        <div class="row align-items-center">
                            <div class="col-md-6 text-center">
                                <img src="<?php echo getWeatherIcon($weatherData['icon']); ?>" 
                                     alt="Ícono del clima" 
                                     class="weather-icon mb-3"
                                     onerror="this.src='https://via.placeholder.com/100x100/74b9ff/ffffff?text=🌤️'">
                                <div class="temp-display"><?php echo $weatherData['temperature']; ?>°C</div>
                                <div class="h5"><?php echo htmlspecialchars($weatherData['description']); ?></div>
                            </div>
                            
                            <div class="col-md-6">
                                <h3><i class="fas fa-map-marker-alt"></i> 
                                    <?php echo htmlspecialchars($weatherData['city']); ?>, 
                                    <?php echo htmlspecialchars($weatherData['country']); ?>
                                </h3>
                                
                                <div class="weather-detail">
                                    <i class="fas fa-thermometer-half"></i>
                                    <strong>Sensación térmica:</strong> <?php echo $weatherData['feels_like']; ?>°C
                                </div>
                                
                                <div class="weather-detail">
                                    <i class="fas fa-tint"></i>
                                    <strong>Humedad:</strong> <?php echo $weatherData['humidity']; ?>%
                                </div>
                                
                                <div class="weather-detail">
                                    <i class="fas fa-compress-arrows-alt"></i>
                                    <strong>Presión:</strong> <?php echo $weatherData['pressure']; ?> hPa
                                </div>
                                
                                <div class="weather-detail">
                                    <i class="fas fa-wind"></i>
                                    <strong>Viento:</strong> <?php echo round($weatherData['wind_speed'], 1); ?> m/s
                                </div>
                                
                                <div class="weather-detail">
                                    <i class="fas fa-eye"></i>
                                    <strong>Visibilidad:</strong> <?php echo $weatherData['visibility']; ?> km
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Sugerencias de ciudades -->
                <div class="mt-4">
                    <h5>Ciudades sugeridas:</h5>
                    <div class="row">
                        <?php 
                        $cities = ['Santo Domingo', 'Madrid', 'Buenos Aires', 'México DF', 'Lima', 'Bogotá'];
                        foreach ($cities as $city): 
                        ?>
                            <div class="col-md-4 col-sm-6 mb-2">
                                <form method="POST" style="display: inline;">
                                    <input type="hidden" name="city" value="<?php echo $city; ?>">
                                    <button type="submit" class="btn btn-outline-primary btn-sm w-100">
                                        <?php echo $city; ?>
                                    </button>
                                </form>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>