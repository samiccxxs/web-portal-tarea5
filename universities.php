<?php
// Función para obtener datos de la API de universidades
function getUniversities($country) {
    $url = "http://universities.hipolabs.com/search?country=" . urlencode($country);
    $response = @file_get_contents($url);
    if ($response === false) {
        return ['error' => 'Error al conectar con la API'];
    }
    return json_decode($response, true);
}

$result = null;
if (isset($_POST['country']) && !empty($_POST['country'])) {
    $result = getUniversities($_POST['country']);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Universidades - Portal Web</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
    <!-- Barra de navegación -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Portal Web</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="about.php">Acerca de</a></li>
                    <li class="nav-item"><a class="nav-link" href="gender.php">Predicción de Género</a></li>
                    <li class="nav-item"><a class="nav-link" href="age.php">Predicción de Edad</a></li>
                    <li class="nav-item"><a class="nav-link active" href="universities.php">Universidades</a></li>
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

    <!-- Contenido de la página -->
    <div class="container mt-5">
        <h1>Universidades por País</h1>
        <form method="POST" class="mb-4">
            <div class="mb-3">
                <label for="country" class="form-label">Ingresa un país (en inglés):</label>
                <input type="text" class="form-control" id="country" name="country" required>
            </div>
            <button type="submit" class="btn btn-primary">Buscar</button>
        </form>

        <?php if ($result): ?>
            <?php if (isset($result['error'])): ?>
                <div class="alert alert-danger">Error: <?php echo $result['error']; ?></div>
            <?php elseif (!empty($result)): ?>
                <h3>Universidades encontradas:</h3>
                <ul class="list-group">
                    <?php foreach ($result as $university): ?>
                        <li class="list-group-item">
                            <strong><?php echo htmlspecialchars($university['name']); ?></strong><br>
                            Dominio: <?php echo htmlspecialchars($university['domains'][0] ?? 'N/A'); ?><br>
                            <a href="<?php echo htmlspecialchars($university['web_pages'][0] ?? '#'); ?>" target="_blank">Sitio web</a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <div class="alert alert-warning">No se encontraron universidades para ese país.</div>
            <?php endif; ?>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>