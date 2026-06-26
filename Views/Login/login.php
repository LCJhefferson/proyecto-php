<div class="login-wrapper" style="max-width: 380px; margin: 80px auto; padding: 30px; background: #ffffff; border: 1px solid #e0e0e0; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.08); font-family: 'Segoe UI', Arial, sans-serif;">
    
    <h2 style="text-align: center; color: #2c3e50; margin-bottom: 25px; font-weight: 600;">Control de Acceso</h2>
    
    <?php if(!empty($data['error'])): ?>
        <div style="background-color: #f8d7da; color: #721c24; padding: 12px; margin-bottom: 20px; border-radius: 4px; text-align: center; font-size: 14px; border: 1px solid #f5c6cb;">
            <?= htmlspecialchars($data['error']); ?>
        </div>
    <?php endif; ?>

    <form action="<?= base_url(); ?>Login/login" method="post">
        <div style="margin-bottom: 18px;">
            <label for="correo" style="display: block; margin-bottom: 6px; color: #34495e; font-weight: 500; font-size: 14px;">Correo Electrónico:</label>
            <input type="email" id="correo" name="correo" required placeholder="ejemplo@correo.com" style="width: 100%; padding: 10px; box-sizing: border-box; border: 1px solid #cccccc; border-radius: 4px; font-size: 14px;">
        </div>

        <div style="margin-bottom: 25px;">
            <label for="clave" style="display: block; margin-bottom: 6px; color: #34495e; font-weight: 500; font-size: 14px;">Contraseña:</label>
            <input type="password" id="clave" name="clave" required placeholder="••••••••" style="width: 100%; padding: 10px; box-sizing: border-box; border: 1px solid #cccccc; border-radius: 4px; font-size: 14px;">
        </div>

        <input type="submit" value="Iniciar Sesión" style="width: 100%; padding: 12px; background-color: #3498db; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 15px; font-weight: bold; transition: background 0.2s;">
    </form>
</div>