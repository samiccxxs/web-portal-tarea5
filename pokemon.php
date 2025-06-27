<?php
// Base de datos simulada de Pokémon
$pokemonDB = [
    'pikachu' => [
        'name' => 'Pikachu',
        'id' => 25,
        'base_experience' => 112,
        'abilities' => [
            ['ability' => ['name' => 'static']],
            ['ability' => ['name' => 'lightning-rod']]
        ],
        'sprites' => ['front_default' => 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/25.png'],
        'types' => [['type' => ['name' => 'electric']]],
        'height' => 4,
        'weight' => 60
    ],
    'charizard' => [
        'name' => 'Charizard',
        'id' => 6,
        'base_experience' => 267,
        'abilities' => [
            ['ability' => ['name' => 'blaze']],
            ['ability' => ['name' => 'solar-power']]
        ],
        'sprites' => ['front_default' => 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/6.png'],
        'types' => [['type' => ['name' => 'fire']], ['type' => ['name' => 'flying']]],
        'height' => 17,
        'weight' => 905
    ],
    'blastoise' => [
        'name' => 'Blastoise',
        'id' => 9,
        'base_experience' => 239,
        'abilities' => [
            ['ability' => ['name' => 'torrent']],
            ['ability' => ['name' => 'rain-dish']]
        ],
        'sprites' => ['front_default' => 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/9.png'],
        'types' => [['type' => ['name' => 'water']]],
        'height' => 16,
        'weight' => 855
    ],
    'venusaur' => [
        'name' => 'Venusaur',
        'id' => 3,
        'base_experience' => 263,
        'abilities' => [
            ['ability' => ['name' => 'overgrow']],
            ['ability' => ['name' => 'chlorophyll']]
        ],
        'sprites' => ['front_default' => 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/3.png'],
        'types' => [['type' => ['name' => 'grass']], ['type' => ['name' => 'poison']]],
        'height' => 20,
        'weight' => 1000
    ],
    'mewtwo' => [
        'name' => 'Mewtwo',
        'id' => 150,
        'base_experience' => 340,
        'abilities' => [
            ['ability' => ['name' => 'pressure']],
            ['ability' => ['name' => 'unnerve']]
        ],
        'sprites' => ['front_default' => 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/150.png'],
        'types' => [['type' => ['name' => 'psychic']]],
        'height' => 20,
        'weight' => 1220
    ]
];

function getPokemon($name) {
    global $pokemonDB;
    
    if (empty($name)) {
        return ['error' => 'El nombre del Pokémon no puede estar vacío'];
    }
    
    $name = strtolower(trim($name));
    
    if (isset($pokemonDB[$name])) {
        return $pokemonDB[$name];
    } else {
        return ['error' => 'Pokémon no encontrado. Prueba con: ' . implode(', ', array_keys($pokemonDB))];
    }
}

$result = null;
if (isset($_POST['pokemon']) && !empty(trim($_POST['pokemon']))) {
    $result = getPokemon(trim($_POST['pokemon']));
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokémon Demo - Sin API</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .pokemon-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.3);
        }
        .pokemon-image {
            background: rgba(255,255,255,0.1);
            border-radius: 10px;
            padding: 20px;
            display: inline-block;
        }
        .type-badge {
            display: inline-block;
            padding: 5px 10px;
            margin: 2px;
            border-radius: 20px;
            font-size: 0.8em;
            font-weight: bold;
        }
        .type-electric { background-color: #f4d03f; color: #000; }
        .type-fire { background-color: #e74c3c; color: #fff; }
        .type-water { background-color: #3498db; color: #fff; }
        .type-grass { background-color: #2ecc71; color: #fff; }
        .type-poison { background-color: #9b59b6; color: #fff; }
        .type-flying { background-color: #85c1e9; color: #000; }
        .type-psychic { background-color: #ff6b9d; color: #fff; }
    </style>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="text-center mb-4">
            <h1 class="display-4">🔍 Pokédex Demo</h1>
            <p class="lead">Busca información de Pokémon (datos simulados)</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-6">
                <form method="POST" class="mb-4">
                    <div class="input-group">
                        <input type="text" class="form-control form-control-lg" id="pokemon" name="pokemon" 
                               placeholder="Ej: pikachu, charizard, blastoise..." required>
                        <button type="submit" class="btn btn-primary btn-lg">🔍 Buscar</button>
                    </div>
                    <small class="text-muted">Disponibles: pikachu, charizard, blastoise, venusaur, mewtwo</small>
                </form>
            </div>
        </div>

        <?php if ($result): ?>
            <?php if (isset($result['error'])): ?>
                <div class="alert alert-warning text-center">
                    <h5>⚠️ <?php echo htmlspecialchars($result['error']); ?></h5>
                </div>
            <?php elseif (isset($result['name'])): ?>
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card pokemon-card">
                            <div class="card-body text-center">
                                <h2 class="card-title text-uppercase"><?php echo htmlspecialchars($result['name']); ?></h2>
                                <p class="text-muted">#<?php echo $result['id']; ?></p>
                                
                                <div class="pokemon-image mb-3">
                                    <img src="<?php echo $result['sprites']['front_default']; ?>" 
                                         alt="<?php echo htmlspecialchars($result['name']); ?>" 
                                         class="img-fluid" style="max-width: 200px;">
                                </div>
                                
                                <div class="row text-start">
                                    <div class="col-md-6">
                                        <h5>📊 Estadísticas</h5>
                                        <p><strong>Experiencia Base:</strong> <?php echo $result['base_experience']; ?></p>
                                        <p><strong>Altura:</strong> <?php echo $result['height']/10; ?> m</p>
                                        <p><strong>Peso:</strong> <?php echo $result['weight']/10; ?> kg</p>
                                    </div>
                                    <div class="col-md-6">
                                        <h5>⚡ Habilidades</h5>
                                        <ul class="list-unstyled">
                                            <?php foreach($result['abilities'] as $ability): ?>
                                                <li>• <?php echo ucfirst(str_replace('-', ' ', $ability['ability']['name'])); ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                        
                                        <h5>🏷️ Tipos</h5>
                                        <?php foreach($result['types'] as $type): ?>
                                            <span class="type-badge type-<?php echo $type['type']['name']; ?>">
                                                <?php echo ucfirst($type['type']['name']); ?>
                                            </span>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>