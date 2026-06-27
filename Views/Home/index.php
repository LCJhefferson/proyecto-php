<?php
// 1. Configuración de la conexión a la Base de Datos (ajusta si tu contraseña o usuario cambian)
$host = 'localhost';
$db   = 'proyecto_php';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    
    // 2. Consulta SQL para contar productos por categoría de forma dinámica
    // Trae únicamente las categorías que tienen al menos un producto asociado
    $stmt = $pdo->query("
        SELECT c.nombre AS categoria, COUNT(p.id) AS total_productos 
        FROM productos p
        INNER JOIN categorias c ON p.categoria_id = c.id
        GROUP BY p.categoria_id
    ");
    
    $labels = [];
    $counts = [];
    
    foreach ($stmt as $row) {
        $labels[] = $row['categoria'];
        $counts[] = (int)$row['total_productos'];
    }
    
    // 3. Convertir a formato JSON listo para que JavaScript lo entienda
    $chart_labels_json = json_encode($labels);
    $chart_data_json = json_encode($counts);

} catch (\PDOException $e) {
    // Si falla la conexión, definimos arrays vacíos para que no se rompa el JS
    $chart_labels_json = json_encode([]);
    $chart_data_json = json_encode([]);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistema de Gestión</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f7fafc;
            color: #2d3748;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .navbar {
            background-color: #ffffff;
            padding: 15px 30px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #edf2f7;
        }
        .navbar-brand {
            font-size: 18px;
            font-weight: 700;
            color: #2b6cb0;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .container {
            max-width: 1100px;
            width: 100%;
            margin: 40px auto;
            padding: 0 20px;
            flex: 1;
        }
        .welcome-card {
            background: linear-gradient(135deg, #2b6cb0 0%, #4299e1 100%);
            color: #ffffff;
            padding: 40px;
            border-radius: 16px;
            margin-bottom: 30px;
            box-shadow: 0 10px 20px rgba(66, 153, 225, 0.15);
        }
        .welcome-card h1 { font-size: 28px; font-weight: 700; margin-bottom: 10px; }
        .welcome-card p { font-size: 16px; opacity: 0.9; line-height: 1.5; }
        .dashboard-layout { display: grid; grid-template-columns: 1fr; gap: 30px; }
        @media (min-width: 768px) { .dashboard-layout { grid-template-columns: 1fr 1fr; } }
        .grid-modules { display: flex; flex-direction: column; gap: 20px; }
        .card-module {
            background: #ffffff;
            padding: 25px;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            transition: all 0.2s ease;
            text-decoration: none;
            color: inherit;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 160px;
        }
        .card-module:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 20px rgba(0,0,0,0.04);
            border-color: #cbd5e0;
        }
        .module-icon {
            width: 45px;
            height: 45px;
            background-color: #ebf8ff;
            color: #3182ce;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
        }
        .card-module h3 { font-size: 18px; color: #1a202c; margin-bottom: 8px; }
        .card-module p { font-size: 14px; color: #718096; line-height: 1.5; margin-bottom: 15px; }
        .module-link { font-size: 14px; color: #3182ce; font-weight: 600; display: flex; align-items: center; gap: 5px; }
        .chart-container {
            background: #ffffff;
            padding: 30px;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.01);
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .chart-container h3 {
            font-size: 18px;
            color: #1a202c;
            margin-bottom: 20px;
            align-self: flex-start;
            border-left: 4px solid #3182ce;
            padding-left: 10px;
        }
        .chart-wrapper { position: relative; width: 100%; max-width: 320px; margin: auto; }
        .footer {
            text-align: center;
            padding: 20px;
            font-size: 13px;
            color: #a0aec0;
            border-top: 1px solid #edf2f7;
            background: #ffffff;
            margin-top: 40px;
        }
    </style>
</head>
<body>

    <nav class="navbar">
        <div class="navbar-brand">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
            <span>Sistema POS</span>
        </div>
        <span style="font-size: 13px; color: #718096;">Módulo Principal</span>
    </nav>

    <div class="container">
        <div class="welcome-card">
            <h1>¡Bienvenido al Panel de Control de la Aplicación!</h1>
            <p>Gestiona de manera unificada tus productos, mapea especificaciones dinámicas bajo la arquitectura EAV y filtra catálogos en tiempo real.</p>
        </div>

        <div class="dashboard-layout">
            <div class="grid-modules">
                <a href="Productos" class="card-module">
                    <div>
                        <div class="module-icon">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                        </div>
                        <h3>Gestión de Productos</h3>
                        <p>Accede al catálogo interactivo asíncrono para buscar productos, seleccionar categorías y filtrar características.</p>
                    </div>
                    <div class="module-link">Ir al catálogo &rarr;</div>
                </a>
            </div>

            <div class="chart-container">
                <h3>Productos por Categoría</h3>
                <div class="chart-wrapper">
                    <canvas id="categoryPieChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        &copy; 2026 - Sistema de Gestión Escala Laboratorio. Desarrollado en PHP.
    </footer>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const ctx = document.getElementById('categoryPieChart').getContext('2d');
            
            // 📊 Inyección automática y dinámica calculada en tiempo de ejecución por PHP
            const dataCategorias = {
                labels: <?php echo $chart_labels_json; ?>, 
                datasets: [{
                    data: <?php echo $chart_data_json; ?>,   
                    backgroundColor: [
                        '#3182ce', // Azul (Electrónica)
                        '#4299e1', // Celeste (Ropa)
                        '#ecc94b', // Amarillo (Teléfonos)
                        '#38a169', // Verde alternativo
                        '#e53e3e'  // Rojo alternativo
                    ],
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            };

            const config = {
                type: 'pie',
                data: dataCategorias,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: { font: { size: 12 }, padding: 15 }
                        }
                    }
                }
            };

            new Chart(ctx, config);
        });
    </script>
</body>
</html>