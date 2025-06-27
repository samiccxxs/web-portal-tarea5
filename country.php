<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Datos de País - Portal Web</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .country-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .navbar-brand {
            font-weight: bold;
        }
        
        .card {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: none;
            border-radius: 15px;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%);
            transform: translateY(-1px);
        }
        
        .flag-img {
            max-width: 120px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        
        .info-item {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            padding: 12px;
            margin: 8px 0;
            border-left: 4px solid #ffd700;
        }
        
        .country-name {
            font-size: 1.8em;
            font-weight: bold;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            margin-bottom: 15px;
        }
        
        .search-suggestions {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
            margin-top: 20px;
        }
        
        .suggestion-btn {
            margin: 3px;
            font-size: 0.9em;
        }
        
        .disclaimer {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 5px;
            padding: 10px;
            margin-top: 20px;
            font-size: 0.9em;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 15px;
        }
        
        .autocomplete-dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 1px solid #ddd;
            border-top: none;
            max-height: 200px;
            overflow-y: auto;
            z-index: 1000;
            display: none;
        }
        
        .autocomplete-item {
            padding: 10px;
            cursor: pointer;
            border-bottom: 1px solid #eee;
        }
        
        .autocomplete-item:hover {
            background-color: #f5f5f5;
        }
        
        .search-container {
            position: relative;
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
                    <li class="nav-item"><a class="nav-link active" href="#">Datos de País</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Chiste Aleatorio</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-8">
                <h1 class="mb-4">🌍 Datos de País</h1>
                
                <div class="card">
                    <div class="card-body">
                        <form id="countryForm" class="mb-4">
                            <div class="mb-3">
                                <label for="country" class="form-label">🔍 Ingresa el nombre del país:</label>
                                <div class="search-container">
                                    <input type="text" class="form-control" id="country" name="country" required 
                                           placeholder="Ej: República Dominicana, España, México..." autocomplete="off">
                                    <div id="autocompleteDropdown" class="autocomplete-dropdown"></div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> Buscar País
                            </button>
                            <button type="button" class="btn btn-secondary ms-2" onclick="clearResults()">
                                Limpiar
                            </button>
                        </form>
                    </div>
                </div>

                <div id="results" style="display: none;">
                    <div class="card country-bg mt-4">
                        <div class="card-body text-center">
                            <div id="resultContent"></div>
                        </div>
                    </div>
                </div>

                <div id="error" class="alert alert-danger mt-4" style="display: none;"></div>
            </div>
            
            <div class="col-lg-4">
                <div class="search-suggestions">
                    <h6 class="fw-bold">💡 Países populares:</h6>
                    <p class="text-muted small">Haz clic para buscar rápidamente</p>
                    <div id="popularCountries"></div>
                </div>
                
                <div class="disclaimer">
                    <strong>⚠️ Nota:</strong> Esta es una versión simulada con datos predefinidos para propósitos de demostración. 
                    Para información actualizada, utiliza una API de países en tiempo real.
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Base de datos simulada de países
        const countriesData = {
            'república dominicana': {
                name: 'República Dominicana',
                capital: 'Santo Domingo',
                population: 10847904,
                currency: 'DOP (Peso Dominicano)',
                flag: 'https://flagcdn.com/w320/do.png',
                region: 'América',
                subregion: 'El Caribe',
                languages: 'Español',
                area: 48671,
                timezone: 'UTC-4',
                callingCode: '+1-809, +1-829, +1-849'
            },
            'españa': {
                name: 'España',
                capital: 'Madrid',
                population: 47351567,
                currency: 'EUR (Euro)',
                flag: 'https://flagcdn.com/w320/es.png',
                region: 'Europa',
                subregion: 'Europa del Sur',
                languages: 'Español',
                area: 505992,
                timezone: 'UTC+1',
                callingCode: '+34'
            },
            'méxico': {
                name: 'México',
                capital: 'Ciudad de México',
                population: 128932753,
                currency: 'MXN (Peso Mexicano)',
                flag: 'https://flagcdn.com/w320/mx.png',
                region: 'América',
                subregion: 'América del Norte',
                languages: 'Español',
                area: 1964375,
                timezone: 'UTC-6 a UTC-8',
                callingCode: '+52'
            },
            'estados unidos': {
                name: 'Estados Unidos',
                capital: 'Washington D.C.',
                population: 329484123,
                currency: 'USD (Dólar Estadounidense)',
                flag: 'https://flagcdn.com/w320/us.png',
                region: 'América',
                subregion: 'América del Norte',
                languages: 'Inglés',
                area: 9833517,
                timezone: 'UTC-5 a UTC-10',
                callingCode: '+1'
            },
            'brasil': {
                name: 'Brasil',
                capital: 'Brasília',
                population: 212559409,
                currency: 'BRL (Real Brasileño)',
                flag: 'https://flagcdn.com/w320/br.png',
                region: 'América',
                subregion: 'América del Sur',
                languages: 'Portugués',
                area: 8515767,
                timezone: 'UTC-2 a UTC-5',
                callingCode: '+55'
            },
            'argentina': {
                name: 'Argentina',
                capital: 'Buenos Aires',
                population: 45376763,
                currency: 'ARS (Peso Argentino)',
                flag: 'https://flagcdn.com/w320/ar.png',
                region: 'América',
                subregion: 'América del Sur',
                languages: 'Español',
                area: 2780400,
                timezone: 'UTC-3',
                callingCode: '+54'
            },
            'colombia': {
                name: 'Colombia',
                capital: 'Bogotá',
                population: 50882884,
                currency: 'COP (Peso Colombiano)',
                flag: 'https://flagcdn.com/w320/co.png',
                region: 'América',
                subregion: 'América del Sur',
                languages: 'Español',
                area: 1141748,
                timezone: 'UTC-5',
                callingCode: '+57'
            },
            'francia': {
                name: 'Francia',
                capital: 'París',
                population: 67391582,
                currency: 'EUR (Euro)',
                flag: 'https://flagcdn.com/w320/fr.png',
                region: 'Europa',
                subregion: 'Europa Occidental',
                languages: 'Francés',
                area: 643801,
                timezone: 'UTC+1',
                callingCode: '+33'
            },
            'alemania': {
                name: 'Alemania',
                capital: 'Berlín',
                population: 83240525,
                currency: 'EUR (Euro)',
                flag: 'https://flagcdn.com/w320/de.png',
                region: 'Europa',
                subregion: 'Europa Occidental',
                languages: 'Alemán',
                area: 357114,
                timezone: 'UTC+1',
                callingCode: '+49'
            },
            'japón': {
                name: 'Japón',
                capital: 'Tokio',
                population: 125836021,
                currency: 'JPY (Yen Japonés)',
                flag: 'https://flagcdn.com/w320/jp.png',
                region: 'Asia',
                subregion: 'Asia Oriental',
                languages: 'Japonés',
                area: 377930,
                timezone: 'UTC+9',
                callingCode: '+81'
            }
        };

        // Lista de países populares para botones rápidos
        const popularCountries = [
            'República Dominicana', 'España', 'México', 'Estados Unidos', 
            'Brasil', 'Argentina', 'Colombia', 'Francia', 'Alemania', 'Japón'
        ];

        // Función para normalizar texto (eliminar acentos y convertir a minúsculas)
        function normalizeText(text) {
            return text.toLowerCase()
                .normalize('NFD')
                .replace(/[\u0300-\u036f]/g, '')
                .trim();
        }

        // Función para buscar país
        function searchCountry(countryName) {
            const normalizedName = normalizeText(countryName);
            
            if (!countryName || countryName.trim() === '') {
                return { error: 'El nombre del país no puede estar vacío' };
            }

            // Buscar por coincidencia exacta o parcial
            for (const [key, data] of Object.entries(countriesData)) {
                if (key.includes(normalizedName) || normalizedName.includes(key)) {
                    return data;
                }
            }

            return { error: `No se encontró información para "${countryName}". Intenta con otro país.` };
        }

        // Función para formatear números
        function formatNumber(num) {
            return new Intl.NumberFormat('es-DO').format(num);
        }

        // Función para mostrar resultados
        function displayResult(data) {
            const resultContent = document.getElementById('resultContent');
            
            resultContent.innerHTML = `
                <div class="country-name">${data.name}</div>
                <img src="${data.flag}" alt="Bandera de ${data.name}" class="flag-img mb-3">
                
                <div class="stats-grid">
                    <div class="info-item">
                        <strong>🏛️ Capital:</strong><br>
                        ${data.capital}
                    </div>
                    <div class="info-item">
                        <strong>👥 Población:</strong><br>
                        ${formatNumber(data.population)} habitantes
                    </div>
                    <div class="info-item">
                        <strong>💰 Moneda:</strong><br>
                        ${data.currency}
                    </div>
                    <div class="info-item">
                        <strong>🌍 Región:</strong><br>
                        ${data.region} - ${data.subregion}
                    </div>
                    <div class="info-item">
                        <strong>🗣️ Idioma:</strong><br>
                        ${data.languages}
                    </div>
                    <div class="info-item">
                        <strong>📏 Área:</strong><br>
                        ${formatNumber(data.area)} km²
                    </div>
                    <div class="info-item">
                        <strong>🕐 Zona Horaria:</strong><br>
                        ${data.timezone}
                    </div>
                    <div class="info-item">
                        <strong>📞 Código Telefónico:</strong><br>
                        ${data.callingCode}
                    </div>
                </div>
            `;
        }

        // Generar botones de países populares
        function generatePopularCountries() {
            const container = document.getElementById('popularCountries');
            container.innerHTML = popularCountries.map(country => 
                `<button class="btn btn-outline-primary btn-sm suggestion-btn" onclick="searchFromButton('${country}')">${country}</button>`
            ).join('');
        }

        // Buscar desde botón
        function searchFromButton(countryName) {
            document.getElementById('country').value = countryName;
            document.getElementById('countryForm').dispatchEvent(new Event('submit'));
        }

        // Autocompletado
        function setupAutocomplete() {
            const input = document.getElementById('country');
            const dropdown = document.getElementById('autocompleteDropdown');
            
            input.addEventListener('input', function() {
                const value = normalizeText(this.value);
                dropdown.innerHTML = '';
                
                if (value.length < 2) {
                    dropdown.style.display = 'none';
                    return;
                }
                
                const matches = Object.keys(countriesData)
                    .filter(country => country.includes(value))
                    .slice(0, 5);
                
                if (matches.length > 0) {
                    dropdown.innerHTML = matches.map(country => 
                        `<div class="autocomplete-item" onclick="selectCountry('${countriesData[country].name}')">${countriesData[country].name}</div>`
                    ).join('');
                    dropdown.style.display = 'block';
                } else {
                    dropdown.style.display = 'none';
                }
            });
            
            // Cerrar dropdown al hacer clic fuera
            document.addEventListener('click', function(e) {
                if (!input.contains(e.target) && !dropdown.contains(e.target)) {
                    dropdown.style.display = 'none';
                }
            });
        }

        // Seleccionar país del autocompletado
        function selectCountry(countryName) {
            document.getElementById('country').value = countryName;
            document.getElementById('autocompleteDropdown').style.display = 'none';
        }

        // Manejar envío del formulario
        document.getElementById('countryForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const countryName = document.getElementById('country').value;
            const result = searchCountry(countryName);
            
            const errorDiv = document.getElementById('error');
            const resultsDiv = document.getElementById('results');
            
            // Ocultar mensajes anteriores
            errorDiv.style.display = 'none';
            resultsDiv.style.display = 'none';
            
            if (result.error) {
                errorDiv.textContent = result.error;
                errorDiv.style.display = 'block';
            } else {
                displayResult(result);
                resultsDiv.style.display = 'block';
                resultsDiv.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });

        // Función para limpiar resultados
        function clearResults() {
            document.getElementById('country').value = '';
            document.getElementById('results').style.display = 'none';
            document.getElementById('error').style.display = 'none';
            document.getElementById('autocompleteDropdown').style.display = 'none';
        }

        // Inicializar
        document.addEventListener('DOMContentLoaded', function() {
            generatePopularCountries();
            setupAutocomplete();
        });
    </script>
</body>
</html>