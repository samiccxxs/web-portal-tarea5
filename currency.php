<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conversión de Monedas - Portal Web</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .currency-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .navbar-brand {
            font-weight: bold;
        }
        
        .card {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: none;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%);
            transform: translateY(-1px);
        }
        
        .result-item {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            padding: 10px;
            margin: 5px 0;
            border-left: 4px solid #ffd700;
        }
        
        .disclaimer {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 5px;
            padding: 10px;
            margin-top: 20px;
            font-size: 0.9em;
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
                    <li class="nav-item"><a class="nav-link active" href="#">Conversión de Monedas</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Imágenes IA</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Datos de País</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Chiste Aleatorio</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="mb-4">🏦 Conversión de Monedas</h1>
        
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <form id="currencyForm" class="mb-4">
                            <div class="mb-3">
                                <label for="amount" class="form-label">💰 Ingresa una cantidad en USD:</label>
                                <input type="number" step="0.01" class="form-control" id="amount" name="amount" required placeholder="Ej: 100.00">
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-exchange-alt"></i> Convertir
                            </button>
                            <button type="button" class="btn btn-secondary ms-2" onclick="clearResults()">
                                Limpiar
                            </button>
                        </form>
                    </div>
                </div>

                <div id="results" style="display: none;">
                    <div class="card currency-bg mt-4">
                        <div class="card-body">
                            <h5 class="mb-3">📊 Resultados de la conversión:</h5>
                            <div id="resultContent"></div>
                        </div>
                    </div>
                </div>

                <div id="error" class="alert alert-danger mt-4" style="display: none;"></div>
            </div>
            
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">💱 Tasas de Cambio Actuales</h6>
                        <small class="text-muted">Base: 1 USD</small>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <span>🇩🇴 DOP:</span>
                            <strong>60.25</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>🇪🇺 EUR:</span>
                            <strong>0.92</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>🇬🇧 GBP:</span>
                            <strong>0.79</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="disclaimer">
            <strong>⚠️ Nota:</strong> Esta es una versión simulada con tasas de cambio fijas para propósitos de demostración. 
            Para conversiones reales, utiliza una API de tasas de cambio actualizadas.
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Tasas de cambio simuladas (fijas)
        const exchangeRates = {
            'DOP': 60.25,  // Peso Dominicano
            'EUR': 0.92,   // Euro
            'GBP': 0.79    // Libra Esterlina
        };

        // Función para convertir monedas
        function convertCurrency(amount) {
            if (!amount || amount <= 0) {
                return { error: 'Ingresa una cantidad válida mayor a 0' };
            }

            return {
                USD: parseFloat(amount),
                DOP: amount * exchangeRates.DOP,
                EUR: amount * exchangeRates.EUR,
                GBP: amount * exchangeRates.GBP
            };
        }

        // Función para formatear números con separadores de miles
        function formatNumber(num) {
            return new Intl.NumberFormat('es-DO', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }).format(num);
        }

        // Manejar el envío del formulario
        document.getElementById('currencyForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const amount = document.getElementById('amount').value;
            const result = convertCurrency(amount);
            
            const errorDiv = document.getElementById('error');
            const resultsDiv = document.getElementById('results');
            const resultContent = document.getElementById('resultContent');
            
            // Ocultar mensajes anteriores
            errorDiv.style.display = 'none';
            resultsDiv.style.display = 'none';
            
            if (result.error) {
                errorDiv.textContent = result.error;
                errorDiv.style.display = 'block';
            } else {
                resultContent.innerHTML = `
                    <div class="result-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <span>💵 <strong>USD (Dólares):</strong></span>
                            <span class="fs-5">${formatNumber(result.USD)}</span>
                        </div>
                    </div>
                    <div class="result-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <span>🇩🇴 <strong>DOP (Pesos Dominicanos):</strong></span>
                            <span class="fs-5">${formatNumber(result.DOP)}</span>
                        </div>
                    </div>
                    <div class="result-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <span>🇪🇺 <strong>EUR (Euros):</strong></span>
                            <span class="fs-5">${formatNumber(result.EUR)}</span>
                        </div>
                    </div>
                    <div class="result-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <span>🇬🇧 <strong>GBP (Libras):</strong></span>
                            <span class="fs-5">${formatNumber(result.GBP)}</span>
                        </div>
                    </div>
                `;
                resultsDiv.style.display = 'block';
                
                // Scroll suave hacia los resultados
                resultsDiv.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });

        // Función para limpiar resultados
        function clearResults() {
            document.getElementById('amount').value = '';
            document.getElementById('results').style.display = 'none';
            document.getElementById('error').style.display = 'none';
        }

        // Permitir conversión con Enter
        document.getElementById('amount').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                document.getElementById('currencyForm').dispatchEvent(new Event('submit'));
            }
        });

        // Agregar efectos visuales
        document.getElementById('amount').addEventListener('focus', function() {
            this.parentElement.classList.add('focused');
        });

        document.getElementById('amount').addEventListener('blur', function() {
            this.parentElement.classList.remove('focused');
        });
    </script>
</body>
</html>