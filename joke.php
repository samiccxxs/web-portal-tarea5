<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chiste Aleatorio - Portal Web</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .joke-bg {
            background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 50%, #fecfef 100%);
            color: #333;
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }
        
        .joke-container {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 20px;
            padding: 30px;
            text-align: center;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
        }
        
        .navbar-brand {
            font-weight: bold;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #ff9a9e 0%, #fad0c4 100%);
            border: none;
            border-radius: 25px;
            padding: 10px 30px;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, #fad0c4 0%, #ff9a9e 100%);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 154, 158, 0.4);
        }
        
        .joke-emoji {
            font-size: 3em;
            margin-bottom: 20px;
            animation: bounce 2s infinite;
        }
        
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-20px);
            }
            60% {
                transform: translateY(-10px);
            }
        }
        
        .joke-text {
            font-size: 1.2em;
            line-height: 1.6;
            margin: 20px 0;
        }
        
        .setup-text {
            background: rgba(255, 255, 255, 0.1);
            padding: 15px;
            border-radius: 15px;
            margin: 15px 0;
            border-left: 5px solid #ffd700;
        }
        
        .punchline-text {
            background: rgba(255, 255, 255, 0.2);
            padding: 15px;
            border-radius: 15px;
            margin: 15px 0;
            border-left: 5px solid #ff6b6b;
            font-weight: bold;
        }
        
        .controls {
            margin-top: 30px;
        }
        
        .joke-counter {
            background: rgba(255, 255, 255, 0.1);
            padding: 10px 20px;
            border-radius: 20px;
            margin: 20px 0;
            font-size: 0.9em;
        }
        
        .category-badge {
            background: rgba(255, 255, 255, 0.2);
            padding: 5px 15px;
            border-radius: 15px;
            font-size: 0.8em;
            margin-bottom: 10px;
            display: inline-block;
        }
        
        .btn-secondary {
            background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
            border: none;
            border-radius: 25px;
            color: #333;
            font-weight: bold;
        }
        
        .btn-secondary:hover {
            background: linear-gradient(135deg, #fed6e3 0%, #a8edea 100%);
            color: #333;
        }
        
        .loading {
            opacity: 0.6;
            transform: scale(0.98);
            transition: all 0.3s ease;
        }
        
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .stats-container {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 20px;
            margin: 20px 0;
        }
        
        .disclaimer {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 10px;
            padding: 15px;
            margin-top: 30px;
            font-size: 0.9em;
            color: #856404;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Portal Web</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Acerca de</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Predicción de Género</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Predicción de Edad</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Universidades</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Clima</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Pokémon</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Noticias</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Conversión de Monedas</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Imágenes IA</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Datos de País</a></li>
                    <li class="nav-item"><a class="nav-link active" href="#">Chiste Aleatorio</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h1 class="text-center mb-4">😂 Generador de Chistes</h1>
                
                <div class="joke-container" id="jokeContainer">
                    <div class="joke-emoji" id="jokeEmoji">🤣</div>
                    
                    <div class="category-badge" id="categoryBadge">Chiste General</div>
                    
                    <div class="joke-text" id="jokeContent">
                        <div class="setup-text" id="setupText">
                            <strong>🎭 Pregunta:</strong><br>
                            ¡Haz clic en el botón para obtener un chiste divertido!
                        </div>
                    </div>
                    
                    <div class="joke-counter" id="jokeCounter">
                        🎯 Chistes mostrados: <span id="jokeCount">0</span>
                    </div>
                    
                    <div class="controls">
                        <button class="btn btn-primary btn-lg" id="getJokeBtn" onclick="getRandomJoke()">
                            🎲 ¡Nuevo Chiste!
                        </button>
                        <button class="btn btn-secondary ms-2" onclick="shareJoke()" id="shareBtn" style="display: none;">
                            📱 Compartir
                        </button>
                    </div>
                </div>
                
                <div class="stats-container mt-4">
                    <h6 class="text-center">📊 Estadísticas</h6>
                    <div class="row text-center">
                        <div class="col-4">
                            <div><strong id="totalJokes">25</strong></div>
                            <small>Chistes Disponibles</small>
                        </div>
                        <div class="col-4">
                            <div><strong id="favoriteCategory">General</strong></div>
                            <small>Categoría Popular</small>
                        </div>
                        <div class="col-4">
                            <div><strong id="currentStreak">0</strong></div>
                            <small>Racha Actual</small>
                        </div>
                    </div>
                </div>
                
                <div class="disclaimer">
                    <strong>ℹ️ Nota:</strong> Esta es una versión simulada con chistes predefinidos para entretenimiento. 
                    Los chistes son familiares y apropiados para todas las edades.
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Base de datos de chistes
        const jokes = [
            {
                setup: "¿Por qué los pájaros vuelan hacia el sur en invierno?",
                punchline: "Porque está muy lejos para ir caminando.",
                category: "Animales",
                emoji: "🐦"
            },
            {
                setup: "¿Qué le dice un taco a otro taco?",
                punchline: "¿Quieres ser mi pareja? ¡Hagamos una quesadilla!",
                category: "Comida",
                emoji: "🌮"
            },
            {
                setup: "¿Por qué los matemáticos confunden Halloween con Navidad?",
                punchline: "Porque Oct 31 = Dec 25 (31 en octal = 25 en decimal)",
                category: "Matemáticas",
                emoji: "🔢"
            },
            {
                setup: "¿Cómo se llama el campeón de buceo japonés?",
                punchline: "Tokofondo",
                category: "Juegos de Palabras",
                emoji: "🏊"
            },
            {
                setup: "¿Qué hace una abeja en el gimnasio?",
                punchline: "¡Zum-ba!",
                category: "Animales",
                emoji: "🐝"
            },
            {
                setup: "¿Por qué no puedes confiar en las escaleras?",
                punchline: "Porque siempre están tramando algo.",
                category: "General",
                emoji: "🪜"
            },
            {
                setup: "¿Cómo se despiden los químicos?",
                punchline: "¡Ácido un placer!",
                category: "Ciencia",
                emoji: "🧪"
            },
            {
                setup: "¿Qué le dice un jaguar a otro jaguar?",
                punchline: "¡Jaguar you doing?",
                category: "Animales",
                emoji: "🐆"
            },
            {
                setup: "¿Por qué las computadoras nunca tienen hambre?",
                punchline: "Porque siempre tienen bytes.",
                category: "Tecnología",
                emoji: "💻"
            },
            {
                setup: "¿Cómo se llama un pez que no tiene ojos?",
                punchline: "¡Pescado!",
                category: "Animales",
                emoji: "🐟"
            },
            {
                setup: "¿Qué hace un perro con un taladro?",
                punchline: "¡Taladrando!",
                category: "Animales",
                emoji: "🐕"
            },
            {
                setup: "¿Por qué el café fue a la policía?",
                punchline: "Porque lo molieron.",
                category: "Comida",
                emoji: "☕"
            },
            {
                setup: "¿Cómo organizan una fiesta en el espacio?",
                punchline: "¡Planetan todo!",
                category: "Espacio",
                emoji: "🚀"
            },
            {
                setup: "¿Qué le dice un semáforo a otro?",
                punchline: "¡No me mires que me pongo rojo!",
                category: "General",
                emoji: "🚦"
            },
            {
                setup: "¿Por qué no juegan al póker en la selva?",
                punchline: "Porque hay muchos guepardos (cheaters).",
                category: "Animales",
                emoji: "🐆"
            },
            {
                setup: "¿Cómo se dice 'zapato' en japonés?",
                punchline: "Zapato, porque los japoneses no tienen ñ.",
                category: "Juegos de Palabras",
                emoji: "👟"
            },
            {
                setup: "¿Qué hace un pato en una farmacia?",
                punchline: "¡Compra crema para sus patas!",
                category: "Animales",
                emoji: "🦆"
            },
            {
                setup: "¿Por qué los programadores prefieren el modo oscuro?",
                punchline: "Porque la luz atrae a los bugs.",
                category: "Tecnología",
                emoji: "💻"
            },
            {
                setup: "¿Cómo se llama el primo vegano de Bruce Lee?",
                punchline: "Broco Lee",
                category: "Juegos de Palabras",
                emoji: "🥦"
            },
            {
                setup: "¿Qué hace un gato cuando tiene problemas?",
                punchline: "¡Miau-lla por ayuda!",
                category: "Animales",
                emoji: "🐱"
            },
            {
                setup: "¿Por qué no se puede confiar en los átomos?",
                punchline: "Porque lo inventan todo.",
                category: "Ciencia",
                emoji: "⚛️"
            },
            {
                setup: "¿Cómo se llama un dinosaurio que choca su auto?",
                punchline: "¡Tiranosaurio Rex!",
                category: "Dinosaurios",
                emoji: "🦕"
            },
            {
                setup: "¿Qué hace una impresora en el supermercado?",
                punchline: "¡Imprime descuentos!",
                category: "Tecnología",
                emoji: "🖨️"
            },
            {
                setup: "¿Por qué los libros de matemáticas siempre están tristes?",
                punchline: "Porque están llenos de problemas.",
                category: "Matemáticas",
                emoji: "📚"
            },
            {
                setup: "¿Cómo se llama un boomerang que no regresa?",
                punchline: "¡Un palo!",
                category: "General",
                emoji: "🪃"
            }
        ];

        let jokeCount = 0;
        let currentStreak = 0;
        let currentJoke = null;

        // Función para obtener un chiste aleatorio
        function getRandomJoke() {
            const container = document.getElementById('jokeContainer');
            const btn = document.getElementById('getJokeBtn');
            
            // Efecto de carga
            container.classList.add('loading');
            btn.disabled = true;
            btn.innerHTML = '🎲 Cargando...';
            
            setTimeout(() => {
                // Seleccionar chiste aleatorio
                const randomIndex = Math.floor(Math.random() * jokes.length);
                currentJoke = jokes[randomIndex];
                
                // Actualizar contenido
                displayJoke(currentJoke);
                
                // Actualizar estadísticas
                jokeCount++;
                currentStreak++;
                updateStats();
                
                // Quitar efecto de carga
                container.classList.remove('loading');
                container.classList.add('fade-in');
                btn.disabled = false;
                btn.innerHTML = '🎲 ¡Otro Chiste!';
                
                // Mostrar botón de compartir
                document.getElementById('shareBtn').style.display = 'inline-block';
                
                setTimeout(() => {
                    container.classList.remove('fade-in');
                }, 500);
            }, 800);
        }

        // Función para mostrar el chiste
        function displayJoke(joke) {
            document.getElementById('jokeEmoji').textContent = joke.emoji;
            document.getElementById('categoryBadge').textContent = `Categoría: ${joke.category}`;
            
            document.getElementById('jokeContent').innerHTML = `
                <div class="setup-text">
                    <strong>🎭 Pregunta:</strong><br>
                    ${joke.setup}
                </div>
                <div class="punchline-text">
                    <strong>😂 Respuesta:</strong><br>
                    ${joke.punchline}
                </div>
            `;
        }

        // Función para actualizar estadísticas
        function updateStats() {
            document.getElementById('jokeCount').textContent = jokeCount;
            document.getElementById('currentStreak').textContent = currentStreak;
            
            // Calcular categoría más popular (simplificado)
            const categories = jokes.map(joke => joke.category);
            const categoryCount = {};
            categories.forEach(cat => categoryCount[cat] = (categoryCount[cat] || 0) + 1);
            const popularCategory = Object.keys(categoryCount).reduce((a, b) => 
                categoryCount[a] > categoryCount[b] ? a : b
            );
            document.getElementById('favoriteCategory').textContent = popularCategory;
        }

        // Función para compartir chiste
        function shareJoke() {
            if (!currentJoke) return;
            
            const text = `😂 ${currentJoke.setup}\n\n${currentJoke.punchline}\n\n¡Generado desde Portal Web!`;
            
            if (navigator.share) {
                navigator.share({
                    title: 'Chiste Divertido',
                    text: text
                });
            } else {
                // Fallback para navegadores que no soportan Web Share API
                navigator.clipboard.writeText(text).then(() => {
                    const btn = document.getElementById('shareBtn');
                    const originalText = btn.innerHTML;
                    btn.innerHTML = '✅ ¡Copiado!';
                    setTimeout(() => {
                        btn.innerHTML = originalText;
                    }, 2000);
                });
            }
        }

        // Permitir obtener chiste con Enter
        document.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                getRandomJoke();
            }
        });

        // Inicializar estadísticas
        document.addEventListener('DOMContentLoaded', function() {
            updateStats();
        });
    </script>
</body>
</html>