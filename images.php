<?php
require_once 'config.php';

function getImage($query) {
    global $apiKeys;
    if (empty($query)) {
        return ['error' => 'La palabra clave no puede estar vacía'];
    }
    $url = "https://api.unsplash.com/search/photos?query=" . urlencode($query) . "&client_id=" . $apiKeys['unsplash'] . "&per_page=1";
    return makeApiRequest($url);
}

$result = null;
if (isset($_POST['query']) && !empty(trim($_POST['query']))) {
    $result = getImage(trim($_POST['query']));
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Imágenes IA - Portal Web</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
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
                    <li class="nav-item"><a class="nav-link" href="universities.php">Universidades</a></li>
                    <li class="nav-item"><a class="nav-link" href="weather.php">Clima</a></li>
                    <li class="nav-item"><a class="nav-link" href="pokemon.php">Pokémon</a></li>
                    <li class="nav-item"><a class="nav-link" href="news.php">Noticias</a></li>
                    <li class="nav-item"><a class="nav-link" href="currency.php">Conversión de Monedas</a></li>
                    <li class="nav-item"><a class="nav-link active" href="images.php">Imágenes IA</a></li>
                    <li class="nav-item"><a class="nav-link" href="country.php">Datos de País</a></li>
                    <li class="nav-item"><a class="nav-link" href="joke.php">Chiste Aleatorio</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h1>Generador de Imágenes</h1>
        <form method="POST" class="mb-4">
            <div class="mb-3">
                <label for="query" class="form-label">Ingresa una palabra clave:</label>
                <input type="text" class="form-control" id="query" name="query" required>
            </div>
            <button type="submit" class="btn btn-primary">Buscar</button>
        </form>

        <?php if ($result): ?>
            <?php if (isset($result['error'])): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($result['error']); ?></div>
            <?php elseif (!empty($result['results'])): ?>
                <div class="card">
                    <img src="<?php echo $result['results'][0]['urls']['regular'] ?? 'https://via.placeholder.com/300'; ?>" class="card-img-top" alt="Imagen">
                    <div class="card-body">
                        <p>Imagen basada en: <?php echo htmlspecialchars($_POST['query']); ?></p>
                    </div>
                </div>
            <?php else: ?>
                <div class="alert alert-warning">No se encontraron imágenes para esa palabra clave.</div>
            <?php endif; ?>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>