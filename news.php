<?php
// Base de datos simulada de noticias por categorías
$newsDatabase = [
    'tecnologia' => [
        [
            'title' => 'Inteligencia Artificial revoluciona la industria médica',
            'excerpt' => 'Los nuevos sistemas de IA están ayudando a los médicos a diagnosticar enfermedades con una precisión del 95%, mejorando significativamente los tratamientos.',
            'author' => 'Dr. Ana Martínez',
            'date' => '2025-06-25',
            'category' => 'Tecnología',
            'image' => 'https://via.placeholder.com/300x200/4285f4/white?text=IA+Medica',
            'url' => '#'
        ],
        [
            'title' => 'Nuevos avances en computación cuántica',
            'excerpt' => 'Científicos logran crear el primer procesador cuántico estable a temperatura ambiente, abriendo nuevas posibilidades tecnológicas.',
            'author' => 'Ing. Carlos Rodríguez',
            'date' => '2025-06-24',
            'category' => 'Tecnología',
            'image' => 'https://via.placeholder.com/300x200/9c27b0/white?text=Quantum',
            'url' => '#'
        ],
        [
            'title' => 'Realidad Virtual transforma la educación',
            'excerpt' => 'Las aulas virtuales inmersivas están cambiando la forma en que los estudiantes aprenden, con resultados 40% más efectivos.',
            'author' => 'Prof. María González',
            'date' => '2025-06-23',
            'category' => 'Tecnología',
            'image' => 'https://via.placeholder.com/300x200/ff5722/white?text=VR+Educacion',
            'url' => '#'
        ]
    ],
    'ciencia' => [
        [
            'title' => 'Descubren nueva especie marina en las profundidades',
            'excerpt' => 'Biólogos marinos identifican una nueva especie de pulpo bioluminiscente en la fosa oceánica más profunda del Pacífico.',
            'author' => 'Dr. Elena Vargas',
            'date' => '2025-06-25',
            'category' => 'Ciencia',
            'image' => 'https://via.placeholder.com/300x200/009688/white?text=Oceano',
            'url' => '#'
        ],
        [
            'title' => 'Avance en medicina regenerativa',
            'excerpt' => 'Científicos logran regenerar tejido cardíaco usando células madre, ofreciendo esperanza para pacientes con problemas del corazón.',
            'author' => 'Dr. Roberto Silva',
            'date' => '2025-06-24',
            'category' => 'Ciencia',
            'image' => 'https://via.placeholder.com/300x200/e91e63/white?text=Medicina',
            'url' => '#'
        ],
        [
            'title' => 'Energía renovable alcanza nuevo récord',
            'excerpt' => 'Las plantas solares y eólicas generan el 70% de la energía mundial por primera vez en la historia, marcando un hito ambiental.',
            'author' => 'Ing. Laura Pérez',
            'date' => '2025-06-23',
            'category' => 'Ciencia',
            'image' => 'https://via.placeholder.com/300x200/4caf50/white?text=Energia+Verde',
            'url' => '#'
        ]
    ],
    'deportes' => [
        [
            'title' => 'Mundial de Fútbol 2026: Preparativos en marcha',
            'excerpt' => 'Los países organizadores intensifican los preparativos para el próximo Mundial, con nuevos estadios y tecnología innovadora.',
            'author' => 'Sports News',
            'date' => '2025-06-25',
            'category' => 'Deportes',
            'image' => 'https://via.placeholder.com/300x200/ff9800/white?text=Mundial+2026',
            'url' => '#'
        ],
        [
            'title' => 'Récord mundial en natación es superado',
            'excerpt' => 'La nadadora olímpica establece nuevo récord mundial en los 200 metros libres, batiendo una marca que se mantenía desde 2019.',
            'author' => 'Olympic News',
            'date' => '2025-06-24',
            'category' => 'Deportes',
            'image' => 'https://via.placeholder.com/300x200/2196f3/white?text=Natacion',
            'url' => '#'
        ],
        [
            'title' => 'Liga de Campeones: Finales emocionantes',
            'excerpt' => 'Los equipos clasificados para las finales prometen un espectáculo inolvidable con jugadas estratégicas y talento excepcional.',
            'author' => 'UEFA Sports',
            'date' => '2025-06-23',
            'category' => 'Deportes',
            'image' => 'https://via.placeholder.com/300x200/673ab7/white?text=Champions',
            'url' => '#'
        ]
    ],
    'economia' => [
        [
            'title' => 'Criptomonedas alcanzan nueva estabilidad',
            'excerpt' => 'El mercado de criptomonedas muestra signos de madurez con menor volatilidad y mayor adopción institucional.',
            'author' => 'Financial Times',
            'date' => '2025-06-25',
            'category' => 'Economía',
            'image' => 'https://via.placeholder.com/300x200/795548/white?text=Crypto',
            'url' => '#'
        ],
        [
            'title' => 'Startups tecnológicas reciben inversión récord',
            'excerpt' => 'Las empresas emergentes de tecnología atraen 50 mil millones en inversiones, impulsando la innovación global.',
            'author' => 'TechCrunch',
            'date' => '2025-06-24',
            'category' => 'Economía',
            'image' => 'https://via.placeholder.com/300x200/607d8b/white?text=Startups',
            'url' => '#'
        ],
        [
            'title' => 'Comercio electrónico crece exponencialmente',
            'excerpt' => 'Las ventas online superan las expectativas con un crecimiento del 35% anual, transformando el retail tradicional.',
            'author' => 'eCommerce Today',
            'date' => '2025-06-23',
            'category' => 'Economía',
            'image' => 'https://via.placeholder.com/300x200/3f51b5/white?text=eCommerce',
            'url' => '#'
        ]
    ]
];

function getNewsSimulated($category = 'tecnologia') {
    global $newsDatabase;
    
    $category = strtolower(trim($category));
    
    // Mapear categorías comunes
    $categoryMap = [
        'tech' => 'tecnologia',
        'technology' => 'tecnologia',
        'tecnologia' => 'tecnologia',
        'science' => 'ciencia',
        'ciencia' => 'ciencia',
        'sports' => 'deportes',
        'deporte' => 'deportes',
        'deportes' => 'deportes',
        'economy' => 'economia',
        'economia' => 'economia',
        'business' => 'economia'
    ];
    
    if (isset($categoryMap[$category])) {
        $category = $categoryMap[$category];
    }
    
    // Si la categoría existe, devolverla
    if (isset($newsDatabase[$category])) {
        return $newsDatabase[$category];
    }
    
    // Si no existe, devolver tecnología por defecto
    return $newsDatabase['tecnologia'];
}

$result = null;
$selectedCategory = 'tecnologia';

if (isset($_POST['category']) && !empty(trim($_POST['category']))) {
    $selectedCategory = trim($_POST['category']);
    $result = getNewsSimulated($selectedCategory);
} else {
    $result = getNewsSimulated('tecnologia');
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noticias - Portal Web</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .main-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            margin-top: 20px;
        }
        .news-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            overflow: hidden;
            height: 100%;
        }
        .news-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
        }
        .news-image {
            height: 200px;
            object-fit: cover;
            border-radius: 15px 15px 0 0;
        }
        .category-badge {
            position: absolute;
            top: 15px;
            left: 15px;
            z-index: 2;
            font-size: 0.8rem;
            padding: 5px 12px;
            border-radius: 20px;
        }
        .news-meta {
            color: #6c757d;
            font-size: 0.85rem;
        }
        .news-title {
            font-weight: 600;
            color: #2c3e50;
            line-height: 1.3;
        }
        .news-excerpt {
            color: #5a6c7d;
            line-height: 1.5;
        }
        .btn-read-more {
            background: linear-gradient(45deg, #667eea, #764ba2);
            border: none;
            border-radius: 25px;
            padding: 8px 20px;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }
        .btn-read-more:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        .category-selector {
            background: white;
            border: 2px solid #e9ecef;
            border-radius: 25px;
            padding: 12px 20px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        .category-selector:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        .search-btn {
            background: linear-gradient(45deg, #667eea, #764ba2);
            border: none;
            border-radius: 25px;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .search-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
        }
        .stats-card {
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            margin-bottom: 20px;
        }
        .breaking-news {
            background: linear-gradient(45deg, #ff6b6b, #ffa726);
            color: white;
            padding: 10px 20px;
            border-radius: 25px;
            margin-bottom: 20px;
            text-align: center;
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(255, 107, 107, 0.7); }
            70% { box-shadow: 0 0 0 10px rgba(255, 107, 107, 0); }
            100% { box-shadow: 0 0 0 0 rgba(255, 107, 107, 0); }
        }
    </style>
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
                    <li class="nav-item"><a class="nav-link active" href="news.php">Noticias</a></li>
                    <li class="nav-item"><a class="nav-link" href="currency.php">Conversión de Monedas</a></li>
                    <li class="nav-item"><a class="nav-link" href="images.php">Imágenes IA</a></li>
                    <li class="nav-item"><a class="nav-link" href="country.php">Datos de País</a></li>
                    <li class="nav-item"><a class="nav-link" href="joke.php">Chiste Aleatorio</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="main-container">
            <div class="text-center mb-4">
                <h1 class="display-4 text-primary">📰 Portal de Noticias</h1>
                <p class="lead">Mantente informado con las últimas noticias</p>
            </div>

            <!-- Breaking News Banner -->
            <div class="breaking-news">
                <i class="fas fa-bolt"></i> <strong>ÚLTIMA HORA:</strong> 
                Nueva tecnología de IA mejora diagnósticos médicos en un 95%
            </div>

            <!-- Stats Cards -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="stats-card">
                        <i class="fas fa-newspaper fa-2x mb-2"></i>
                        <h4><?php echo count($newsDatabase['tecnologia']) + count($newsDatabase['ciencia']) + count($newsDatabase['deportes']) + count($newsDatabase['economia']); ?></h4>
                        <small>Noticias Totales</small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card">
                        <i class="fas fa-clock fa-2x mb-2"></i>
                        <h4>24/7</h4>
                        <small>Actualización</small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card">
                        <i class="fas fa-users fa-2x mb-2"></i>
                        <h4>50K+</h4>
                        <small>Lectores Diarios</small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card">
                        <i class="fas fa-globe fa-2x mb-2"></i>
                        <h4>4</h4>
                        <small>Categorías</small>
                    </div>
                </div>
            </div>

            <!-- Category Selector -->
            <div class="row justify-content-center mb-4">
                <div class="col-md-8">
                    <form method="POST" class="d-flex gap-3 align-items-end">
                        <div class="flex-grow-1">
                            <label for="category" class="form-label h6">
                                <i class="fas fa-tags"></i> Selecciona una categoría:
                            </label>
                            <select class="form-select category-selector" id="category" name="category">
                                <option value="tecnologia" <?php echo $selectedCategory == 'tecnologia' ? 'selected' : ''; ?>>
                                    🖥️ Tecnología
                                </option>
                                <option value="ciencia" <?php echo $selectedCategory == 'ciencia' ? 'selected' : ''; ?>>
                                    🔬 Ciencia
                                </option>
                                <option value="deportes" <?php echo $selectedCategory == 'deportes' ? 'selected' : ''; ?>>
                                    ⚽ Deportes
                                </option>
                                <option value="economia" <?php echo $selectedCategory == 'economia' ? 'selected' : ''; ?>>
                                    💼 Economía
                                </option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary search-btn">
                            <i class="fas fa-search"></i> Buscar Noticias
                        </button>
                    </form>
                </div>
            </div>

            <?php if ($result): ?>
                <div class="mb-4">
                    <h3 class="text-center text-primary mb-4">
                        <i class="fas fa-star"></i> 
                        Últimas Noticias de <?php echo ucfirst($selectedCategory); ?>
                    </h3>
                    <div class="row">
                        <?php foreach ($result as $index => $news): ?>
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="card news-card">
                                    <div class="position-relative">
                                        <img src="<?php echo $news['image']; ?>" 
                                             class="card-img-top news-image" 
                                             alt="<?php echo htmlspecialchars($news['title']); ?>">
                                        <span class="badge category-badge bg-primary">
                                            <?php echo $news['category']; ?>
                                        </span>
                                    </div>
                                    <div class="card-body d-flex flex-column">
                                        <div class="news-meta mb-2">
                                            <i class="fas fa-user"></i> <?php echo $news['author']; ?> • 
                                            <i class="fas fa-calendar"></i> <?php echo date('d/m/Y', strtotime($news['date'])); ?>
                                        </div>
                                        <h5 class="card-title news-title mb-3">
                                            <?php echo htmlspecialchars($news['title']); ?>
                                        </h5>
                                        <p class="card-text news-excerpt flex-grow-1">
                                            <?php echo htmlspecialchars($news['excerpt']); ?>
                                        </p>
                                        <div class="d-flex justify-content-between align-items-center mt-3">
                                            <button class="btn btn-primary btn-read-more" onclick="readNews(<?php echo $index; ?>)">
                                                <i class="fas fa-book-open"></i> Leer más
                                            </button>
                                            <div class="text-muted small">
                                                <i class="fas fa-heart"></i> <?php echo rand(50, 500); ?> 
                                                <i class="fas fa-share ms-2"></i> <?php echo rand(10, 100); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Newsletter Subscription -->
                <div class="row mt-5">
                    <div class="col-md-8 mx-auto">
                        <div class="card" style="background: linear-gradient(45deg, #667eea, #764ba2); color: white;">
                            <div class="card-body text-center p-4">
                                <h4><i class="fas fa-envelope"></i> Suscríbete a nuestro boletín</h4>
                                <p>Recibe las noticias más importantes directamente en tu correo</p>
                                <div class="row justify-content-center">
                                    <div class="col-md-8">
                                        <div class="input-group">
                                            <input type="email" class="form-control" placeholder="tu@email.com">
                                            <button class="btn btn-light text-primary fw-bold">Suscribirse</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function readNews(index) {
            // Simular la lectura de la noticia completa
            const newsData = <?php echo json_encode($result); ?>;
            const news = newsData[index];
            
            const modal = `
                <div class="modal fade" id="newsModal" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header" style="background: linear-gradient(45deg, #667eea, #764ba2); color: white;">
                                <h5 class="modal-title">${news.title}</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <img src="${news.image}" class="img-fluid rounded mb-3" alt="${news.title}">
                                <div class="mb-3">
                                    <span class="badge bg-primary">${news.category}</span>
                                    <small class="text-muted ms-2">Por ${news.author} • ${news.date}</small>
                                </div>
                                <p class="lead">${news.excerpt}</p>
                                <p>Esta es una demostración de cómo se vería el artículo completo. En una implementación real, aquí se mostraría el contenido completo de la noticia obtenido de la fuente original.</p>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <button type="button" class="btn btn-primary">Compartir</button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            // Remover modal anterior si existe
            const existingModal = document.getElementById('newsModal');
            if (existingModal) {
                existingModal.remove();
            }
            
            // Agregar nuevo modal
            document.body.insertAdjacentHTML('beforeend', modal);
            
            // Mostrar modal
            const bootstrapModal = new bootstrap.Modal(document.getElementById('newsModal'));
            bootstrapModal.show();
        }

        // Animación de entrada para las cards
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.news-card');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(50px)';
                setTimeout(() => {
                    card.style.transition = 'all 0.6s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 200);
            });
        });
    </script>
</body>
</html>