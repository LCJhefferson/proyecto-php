<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error 404 - Página no encontrada</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f7fafc;
            color: #2d3748;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
        }

        .error-container {
            text-align: center;
            max-width: 500px;
            width: 100%;
            background: #ffffff;
            padding: 40px 30px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        }

        .error-code {
            font-size: 96px;
            font-weight: 800;
            line-height: 1;
            color: #e53e3e;
            margin-bottom: 15px;
            letter-spacing: -2px;
        }

        .error-title {
            font-size: 22px;
            font-weight: 600;
            color: #1a202c;
            margin-bottom: 12px;
        }

        .error-message {
            font-size: 15px;
            color: #718096;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            background-color: #3182ce;
            color: #ffffff;
            text-decoration: none;
            padding: 12px 24px;
            font-size: 15px;
            font-weight: 500;
            border-radius: 8px;
            transition: all 0.2s ease;
            box-shadow: 0 4px 6px rgba(49, 130, 206, 0.2);
        }

        .btn-back:hover {
            background-color: #2b6cb0;
            transform: translateY(-1px);
            box-shadow: 0 6px 12px rgba(49, 130, 206, 0.3);
        }

        .btn-back:active {
            transform: translateY(0);
        }
    </style>
</head>
<body>

    <div class="error-container">
        <div class="error-code">404</div>
        
        <h2 class="error-title">Página no encontrada</h2>
        
        <p class="error-message">
            Lo sentimos, el enlace al que intentas acceder no existe, ha sido movido o cambió de dirección temporalmente.
        </p>
        
        <a href="javascript:history.go(-1)" class="btn-back">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            Regresar al listado
        </a>
    </div>

</body>
</html>