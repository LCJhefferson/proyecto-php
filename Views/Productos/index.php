<?php // Vista de Productos adaptada para incrustarse en el Layout Principal ?>

<script>
    // Definimos la constante global de la URL Base de tu MVC para usarla en los archivos JS externos
    const BASE_URL = "<?= base_url(); ?>";
</script>

<div style="padding: 20px; font-family: 'Segoe UI', system-ui, sans-serif;">
    <h2 style="color: #2d3748; font-size: 24px; margin-bottom: 20px; font-weight: 600;">
        Gestión de Catálogo de Productos (EAV + AJAX)
    </h2>

    <div style="display: flex; gap: 20px; align-items: flex-start;">
        
        <div class="sidebar" style="width: 25%; background: white; padding: 20px; border-radius: 8px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
            <label for="categoria" style="display: block; margin-bottom: 8px; color: #4a5568; font-weight: 600; font-size: 14px;">Categoría:</label>
            <select id="categoria" style="width: 100%; padding: 10px; border: 1px solid #cbd5e0; border-radius: 5px; background: #fff; font-size: 14px; margin-bottom: 15px;">
                <option value="">-- Seleccione Categoría --</option>
                <?php if (!empty($data['categorias'])): ?>
                    <?php foreach ($data['categorias'] as $cat): ?>
                        <option value="<?= htmlspecialchars($cat['id']) ?>">
                            <?= htmlspecialchars($cat['nombre']) ?>
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>

            <div id="filtros-container">
                <p style="color:#a0aec0; font-size:13px; margin: 0; text-align: center; padding: 10px 0;">
                    Seleccione una categoría para desplegar especificaciones dinámicas (EAV).
                </p>
            </div>
        </div>

        <div class="main-content" style="width: 75%; background: white; padding: 20px; border-radius: 8px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
            <label for="buscador" style="display: block; margin-bottom: 8px; color: #4a5568; font-weight: 600; font-size: 14px;">Buscador en Tiempo Real:</label>
            <input type="text" id="buscador" placeholder="Escriba el nombre o descripción del producto..." style="width: 100%; padding: 10px; border: 1px solid #cbd5e0; border-radius: 5px; font-size: 14px; margin-bottom: 20px; box-sizing: border-box;">

            <table id="tabla-productos" style="width: 100%; border-collapse: collapse; text-align: left; font-size: 14px;">
                <thead>
                    <tr style="background-color: #f7fafc; border-bottom: 2px solid #edf2f7;">
                        <th style="padding: 12px; color: #4a5568;">ID</th>
                        <th style="padding: 12px; color: #4a5568;">Producto</th>
                        <th style="padding: 12px; color: #4a5568;">Categoría</th>
                        <th style="padding: 12px; color: #4a5568;">Descripción</th>
                        <th style="padding: 12px; color: #4a5568;">Precio</th>
                        <th style="padding: 12px; color: #4a5568;">Stock</th>
                    </tr>
                </thead>
                <tbody id="tbody-productos">
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 20px; color: #a0aec0;">Cargando catálogo...</td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</div>


<script src="<?= base_url(); ?>Assets/js/productos_async.js"></script>