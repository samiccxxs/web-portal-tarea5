<?php
// config.php debería tener esta función, pero la incluimos aquí por seguridad
if (!function_exists('makeApiRequest')) {
    function makeApiRequest($url, $timeout = 10) {
        if (!function_exists('curl_init')) {
            // Fallback a file_get_contents si cURL no está disponible
            $context = stream_context_create([
                'http' => [
                    'timeout' => $timeout,
                    'user_agent' => 'Mozilla/5.0 (compatible; GenderPredictor/1.0)'
                ]
            ]);
            $response = @file_get_contents($url, false, $context);
            if ($response === false) {
                return ['error' => 'Error al conectar con la API (file_get_contents)'];
            }
        } else {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; GenderPredictor/1.0)');
            
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlError = curl_error($ch);
            curl_close($ch);
            
            if ($response === false) {
                return ['error' => 'Error cURL: ' . $curlError];
            }
            
            if ($httpCode >= 400) {
                return ['error' => 'Error HTTP: ' . $httpCode];
            }
        }
        
        $data = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return ['error' => 'Error al procesar JSON: ' . json_last_error_msg()];
        }
        
        return $data;
    }
}

// Función para obtener género usando Genderize.io
function getGenderize($name) {
    if (empty($name)) {
        return ['error' => 'El nombre no puede estar vacío'];
    }
    
    $url = "https://api.genderize.io/?name=" . urlencode($name);
    $result = makeApiRequest($url);
    
    if (isset($result['error'])) {
        return $result;
    }
    
    // Verificar si la API devolvió un resultado válido
    if (!isset($result['gender']) || $result['gender'] === null) {
        return ['error' => 'No se pudo determinar el género para este nombre'];
    }
    
    return $result;
}

// Función alternativa con base de datos local de nombres
function getGenderLocal($name) {
    $genderData = [
        // Nombres masculinos comunes en español
        'male' => [
            'juan', 'pedro', 'luis', 'carlos', 'jose', 'miguel', 'david', 'daniel', 'alberto', 'ricardo',
            'fernando', 'rafael', 'jorge', 'antonio', 'manuel', 'francisco', 'alejandro', 'diego', 'pablo',
            'andres', 'mario', 'sergio', 'roberto', 'eduardo', 'javier', 'oscar', 'raul', 'enrique',
            'victor', 'gabriel', 'adrian', 'cristian', 'leonardo', 'santiago', 'martin', 'ivan', 'nicolas',
            'felipe', 'jesus', 'marco', 'angel', 'alex', 'jonathan', 'sebastian', 'rodrigo', 'ruben',
            'jaime', 'emilio', 'abraham', 'benjamin', 'samuel', 'elias', 'mateo', 'lucas', 'noah'
        ],
        // Nombres femeninos comunes en español  
        'female' => [
            'maria', 'ana', 'carmen', 'laura', 'patricia', 'sofia', 'elena', 'lucia', 'claudia', 'diana',
            'sandra', 'monica', 'carolina', 'andrea', 'valentina', 'camila', 'isabella', 'natalia', 'paula',
            'gabriela', 'alejandra', 'daniela', 'sara', 'veronica', 'silvia', 'teresa', 'rosa', 'julia',
            'martha', 'adriana', 'gloria', 'beatriz', 'raquel', 'pilar', 'cristina', 'marta', 'eva',
            'irene', 'lorena', 'rocio', 'mercedes', 'nuria', 'amparo', 'dolores', 'esperanza', 'francisca',
            'antonia', 'isabel', 'josefa', 'margarita', 'angeles', 'victoria', 'emma', 'mia', 'zoe'
        ]
    ];
    
    $nameLower = strtolower(trim($name));
    
    if (in_array($nameLower, $genderData['male'])) {
        return [
            'name' => ucfirst($nameLower),
            'gender' => 'male',
            'probability' => 0.85,
            'count' => 1000,
            'source' => 'local'
        ];
    }
    
    if (in_array($nameLower, $genderData['female'])) {
        return [
            'name' => ucfirst($nameLower),
            'gender' => 'female', 
            'probability' => 0.85,
            'count' => 1000,
            'source' => 'local'
        ];
    }
    
    return ['error' => 'Nombre no encontrado en la base de datos local'];
}

// Función híbrida que intenta múltiples métodos
function getGender($name) {
    if (empty(trim($name))) {
        return ['error' => 'El nombre no puede estar vacío'];
    }
    
    $name = trim($name);
    
    // Intentar primero con Genderize.io
    $result = getGenderize($name);
    
    // Si falla, usar base de datos local
    if (isset($result['error'])) {
        $localResult = getGenderLocal($name);
        
        if (!isset($localResult['error'])) {
            return $localResult;
        }
        
        // Si ambos fallan, devolver el error de Genderize con información adicional
        return [
            'error' => $result['error'] . ' | También intentamos con base local: ' . $localResult['error']
        ];
    }
    
    return $result;
}

$result = null;
$errorDetails = null;

if (isset($_POST['name']) && !empty(trim($_POST['name']))) {
    $result = getGender(trim($_POST['name']));
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Predicción de Género - Portal Web</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .gender-card {
            border-radius: 15px;
            padding: 2rem;
            margin: 1rem 0;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .male-card {
            background: linear-gradient(135deg, #74b9ff 0%, #0984e3 100%);
            color: white;
        }
        .female-card {
            background: linear-gradient(135deg, #fd79a8 0%, #e84393 100%);
            color: white;
        }
        .probability-bar {
            height: 20px;
            border-radius: 10px;
            background: rgba(255,255,255,0.3);
            overflow: hidden;
            margin: 1rem 0;
        }
        .probability-fill {
            height: 100%;
            background: rgba(255,255,255,0.8);
            border-radius: 10px;
            transition: width 0.5s ease;
        }
        .name-suggestions {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-top: 1rem;
        }
        .name-btn {
            padding: 0.25rem 0.75rem;
            border-radius: 15px;
            border: none;
            background: #f8f9fa;
            color: #495057;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .name-btn:hover {
            background: #007bff;
            color: white;
        }
        .source-badge {
            background: rgba(255,255,255,0.2);
            padding: 0.25rem 0.75rem;
            border-radius: 15px;
            font-size: 0.8rem;
            margin-top: 1rem;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-globe"></i> Portal Web
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="about.php">Acerca de</a></li>
                    <li class="nav-item"><a class="nav-link active" href="gender.php">Predicción de Género</a></li>
                    <li class="nav-item"><a class="nav-link" href="age.php">Predicción de Edad</a></li>
                    <li class="nav-item"><a class="nav-link" href="universities.php">Universidades</a></li>
                    <li class="nav-item"><a class="nav-link" href="weather.php">Clima</a></li>
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

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1 class="text-center mb-4">
                    <i class="fas fa-user-friends"></i> Predicción de Género
                </h1>
                
                <!-- Información sobre el servicio -->
                <div class="alert alert-info">
                    <h6><i class="fas fa-info-circle"></i> ¿Cómo funciona?</h6>
                    <p class="mb-2">Utilizamos múltiples fuentes para predecir el género más probable de un nombre:</p>
                    <ul class="mb-0">
                        <li><strong>Genderize.io:</strong> Base de datos global con millones de nombres</li>
                        <li><strong>Base local:</strong> Nombres comunes en español como respaldo</li>
                        <li><strong>Precisión:</strong> Típicamente 85-95% según la popularidad del nombre</li>
                    </ul>
                </div>

                <!-- Formulario -->
                <form method="POST" class="mb-4">
                    <div class="input-group input-group-lg">
                        <span class="input-group-text">
                            <i class="fas fa-user"></i>
                        </span>
                        <input type="text" 
                               class="form-control" 
                               name="name" 
                               placeholder="Ingresa un nombre (ej: María, Juan, Ana...)"
                               value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>"
                               required>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Predecir
                        </button>
                    </div>
                </form>

                <!-- Resultados -->
                <?php if ($result): ?>
                    <?php if (isset($result['error'])): ?>
                        <div class="alert alert-warning">
                            <h6><i class="fas fa-exclamation-triangle"></i> No se pudo determinar el género</h6>
                            <p><?php echo htmlspecialchars($result['error']); ?></p>
                            <small>
                                <strong>Sugerencia:</strong> Intenta con nombres más comunes o verifica la ortografía.
                            </small>
                        </div>
                    <?php elseif (isset($result['gender']) && $result['gender']): ?>
                        <div class="gender-card <?php echo $result['gender'] == 'male' ? 'male-card' : 'female-card'; ?>">
                            <div class="text-center mb-4">
                                <h3>
                                    <?php if ($result['gender'] == 'male'): ?>
                                        <i class="fas fa-mars"></i> Masculino
                                    <?php else: ?>
                                        <i class="fas fa-venus"></i> Femenino
                                    <?php endif; ?>
                                </h3>
                                <h4>"<?php echo htmlspecialchars($result['name']); ?>"</h4>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <h6><i class="fas fa-percentage"></i> Probabilidad</h6>
                                    <div class="probability-bar">
                                        <div class="probability-fill" 
                                             style="width: <?php echo ($result['probability'] * 100); ?>%"></div>
                                    </div>
                                    <div class="text-center">
                                        <strong><?php echo round($result['probability'] * 100, 1); ?>%</strong>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <?php if (isset($result['count'])): ?>
                                        <h6><i class="fas fa-database"></i> Muestras analizadas</h6>
                                        <p class="h5"><?php echo number_format($result['count']); ?></p>
                                    <?php endif; ?>
                                    
                                    <?php if (isset($result['source'])): ?>
                                        <div class="source-badge">
                                            <i class="fas fa-tag"></i>
                                            Fuente: <?php echo $result['source'] == 'local' ? 'Base Local' : 'Genderize.io'; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>

                <!-- Sugerencias de nombres -->
                <div class="mt-4">
                    <h5><i class="fas fa-lightbulb"></i> Nombres de ejemplo:</h5>
                    <div class="name-suggestions">
                        <?php 
                        $sampleNames = [
                            'María', 'Juan', 'Ana', 'Carlos', 'Sofía', 'Luis', 'Carmen', 'Pedro',
                            'Laura', 'Miguel', 'Patricia', 'David', 'Elena', 'José', 'Claudia', 'Daniel'
                        ];
                        foreach ($sampleNames as $sampleName): 
                        ?>
                            <button type="button" class="name-btn" onclick="testName('<?php echo $sampleName; ?>')">
                                <?php echo $sampleName; ?>
                            </button>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Estadísticas adicionales -->
                <div class="mt-4">
                    <div class="alert alert-light">
                        <h6><i class="fas fa-chart-bar"></i> Datos interesantes:</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <small>
                                    • Los nombres más comunes tienen mayor precisión<br>
                                    • La base de datos incluye variaciones culturales<br>
                                    • Algunos nombres son unisex y pueden ser ambiguos
                                </small>
                            </div>
                            <div class="col-md-6">
                                <small>
                                    • Funciona mejor con nombres de pila simples<br>
                                    • Compatible con nombres en múltiples idiomas<br>
                                    • Los resultados son estadísticamente probables
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function testName(name) {
            document.querySelector('input[name="name"]').value = name;
            document.querySelector('form').submit();
        }
        
        // Efecto de animación para la barra de probabilidad
        document.addEventListener('DOMContentLoaded', function() {
            const probabilityFill = document.querySelector('.probability-fill');
            if (probabilityFill) {
                const width = probabilityFill.style.width;
                probabilityFill.style.width = '0%';
                setTimeout(() => {
                    probabilityFill.style.width = width;
                }, 100);
            }
        });
    </script>
</body>
</html>