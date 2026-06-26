<header style="background: linear-gradient(135deg, #f8fafc 0%, #edf2f7 100%); padding: 20px 30px; border-bottom: 1px solid #e2e8f0; font-family: 'Segoe UI', system-ui, sans-serif; display: flex; justify-content: space-between; align-items: center;">
    
    <h1 class="logo" style="margin: 0; font-size: 24px; font-weight: 700; color: #1a202c; letter-spacing: -0.5px;">
        <span style="color: #3182ce;"></span> Mi Proyecto <span style="font-weight: 400; color: #718096;">MVC</span>
    </h1>

    <?php if(!empty($_SESSION['login'])): ?>
        <div style="display: flex; align-items: center; gap: 10px; background: #ffffff; padding: 6px 14px; border-radius: 30px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
            <div style="width: 28px; height: 28px; background-color: #3182ce; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 13px;">
                <?= strtoupper(substr($_SESSION['nombre_usuario'] ?? 'U', 0, 1)); ?>
            </div>
            <span style="font-size: 14px; color: #4a5568; font-weight: 500;">
                Hola, <strong style="color: #2d3748;"><?= htmlspecialchars($_SESSION['nombre_usuario'] ?? 'Usuario'); ?></strong>
            </span>
        </div>
    <?php endif; ?>

</header>