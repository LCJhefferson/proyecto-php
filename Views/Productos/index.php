<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos - Filtros por Categoría</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        #filtros-container { margin-top: 15px; }
        .filtro-grupo { margin-bottom: 15px; }
        .filtro-grupo h4 { margin: 0 0 6px 0; font-size: 14px; text-transform: uppercase; color: #333; }
        .filtro-grupo label { display: block; font-size: 13px; margin-bottom: 3px; cursor: pointer; }
        #filtros-container p { color: #888; font-size: 13px; }
    </style>
</head>
<body>

<h2>Productos</h2>

<label for="categoria"><strong>Categoría:</strong></label>
<select id="categoria" onchange="cargarFiltros(this.value)">
    <option value="">-- Seleccione --</option>
    <?php if (!empty($data['categorias'])): ?>
        <?php foreach ($data['categorias'] as $cat): ?>
            <option value="<?= htmlspecialchars($cat['id']) ?>">
                <?= htmlspecialchars($cat['nombre']) ?>
            </option>
        <?php endforeach; ?>
    <?php endif; ?>
</select>

<div id="filtros-container">
    <p>Seleccione una categoría para ver los filtros.</p>
</div>

<script>
async function cargarFiltros(categoriaId) {
    const contenedor = document.getElementById('filtros-container');

    if (!categoriaId) {
        contenedor.innerHTML = '<p>Seleccione una categoría para ver los filtros.</p>';
        return;
    }

    contenedor.innerHTML = '<p>Cargando filtros...</p>';

    try {
        const response = await fetch(`<?= base_url() ?>Productos/apiGetFiltros/${categoriaId}`);

        if (!response.ok) {
            throw new Error(`Error HTTP: ${response.status}`);
        }

        const json = await response.json();

        if (!json.status || json.filtros.length === 0) {
            contenedor.innerHTML = '<p>No hay filtros disponibles para esta categoría.</p>';
            return;
        }

        let html = '';
        json.filtros.forEach(filtro => {
            html += `<div class="filtro-grupo">`;
            html += `<h4>${filtro.nombre}</h4>`;
            filtro.valores.forEach(valor => {
                const id = `filtro_${filtro.id}_${valor}`;
                html += `<label>
                    <input type="checkbox" id="${id}" name="filtro_${filtro.id}[]" value="${valor}">
                    ${valor}
                </label>`;
            });
            html += `</div>`;
        });

        contenedor.innerHTML = html;

    } catch (error) {
        contenedor.innerHTML = `<p style="color:red;">Error al cargar filtros: ${error.message}</p>`;
    }
}
</script>

</body>
</html>
