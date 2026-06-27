(function() {
    // Referencias exactas de Elementos del DOM para la sección de Productos
    const selectCategoria = document.getElementById('categoria');
    const contenedorFiltros = document.getElementById('filtros-container');
    const inputBuscador = document.getElementById('buscador');
    const tbodyProductos = document.getElementById('tbody-productos');

    // Escuchadores de eventos cuando el DOM esté listo
    document.addEventListener("DOMContentLoaded", () => {
        if (tbodyProductos) {
            buscarProductos(); // Carga el catálogo completo al inicio
        }
    });

    if (selectCategoria) {
        selectCategoria.addEventListener('change', (e) => {
            const categoriaId = e.target.value;
            cargarFiltrosDinamicos(categoriaId);
            buscarProductos(); // Refresca los productos en base a la categoría seleccionada
        });
    }

    if (inputBuscador) {
        // Aplicamos la optimización obligatoria DEBOUNCE de 400ms exigida en el laboratorio
        inputBuscador.addEventListener('input', debounce(() => {
            buscarProductos();
        }, 400));
    }

    if (contenedorFiltros) {
        // Event delegation para los checkboxes dinámicos
        contenedorFiltros.addEventListener('change', (e) => {
            if (e.target.type === 'checkbox') {
                buscarProductos();
            }
        });
    }

    // Carga los Checkboxes EAV dinámicamente
    async function cargarFiltrosDinamicos(categoriaId) {
        if (!contenedorFiltros) return;

        if (!categoriaId) {
            contenedorFiltros.innerHTML = '<p style="color:#888; font-size:13px; margin: 0; text-align: center; padding: 10px 0;">Seleccione una categoría para desplegar especificaciones.</p>';
            return;
        }

        contenedorFiltros.innerHTML = '<p style="font-size:13px; color:#2b6cb0; text-align: center; padding: 10px 0;">Cargando especificaciones...</p>';

        try {
            const urlBaseLimpia = BASE_URL.endsWith('/') ? BASE_URL : BASE_URL + '/';
            const response = await fetch(`${urlBaseLimpia}Productos/apiGetFiltros/${categoriaId}`);
            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
            
            const json = await response.json();
            contenedorFiltros.innerHTML = ''; // Limpiar estado de carga

            if (!json.status || !json.filtros || json.filtros.length === 0) {
                contenedorFiltros.innerHTML = '<p style="color:#e67e22; font-size:13px; text-align: center; padding: 10px 0;">No hay propiedades EAV para esta categoría.</p>';
                return;
            }

            // Construcción dinámica de Checkboxes iterando la metadata EAV
            json.filtros.forEach(filtro => {
                const grupoDiv = document.createElement('div');
                grupoDiv.style.marginBottom = "15px";
                grupoDiv.style.paddingBottom = "10px";
                grupoDiv.style.borderBottom = "1px dashed #e2e8f0";

                const titulo = document.createElement('h4');
                titulo.style.margin = "0 0 8px 0";
                titulo.style.fontSize = "12px";
                titulo.style.color = "#4a5568";
                titulo.style.textTransform = "uppercase";
                titulo.textContent = filtro.nombre || filtro.atributo || "Propiedad"; 
                grupoDiv.appendChild(titulo);

                // Mapeo adaptado con precisión a tu columna `valor`
                let valoresArray = [];
                if (Array.isArray(filtro.valores)) {
                    valoresArray = filtro.valores;
                } else if (filtro.valor) {
                    valoresArray = [filtro.valor];
                } else if (filtro.valores_texto) {
                    valoresArray = [filtro.valores_texto];
                } else {
                    valoresArray = ["No asignado"];
                }

                valoresArray.forEach(valor => {
                    const label = document.createElement('label');
                    label.style.display = "block";
                    label.style.fontSize = "13px";
                    label.style.color = "#2d3748";
                    label.style.cursor = "pointer";
                    label.style.marginBottom = "4px";
                    
                    const checkbox = document.createElement('input');
                    checkbox.type = 'checkbox';
                    checkbox.style.marginRight = "6px";
                    checkbox.name = `filtro_${filtro.id || 'eav'}[]`;
                    checkbox.value = valor;
                    
                    label.appendChild(checkbox);
                    label.appendChild(document.createTextNode(` ${valor}`));
                    grupoDiv.appendChild(label);
                });

                contenedorFiltros.appendChild(grupoDiv);
            });

        } catch (error) {
            console.error("Error cargando filtros:", error);
            contenedorFiltros.innerHTML = `<p style="color:red; font-size:13px; text-align: center; padding: 10px 0;">Error: ${error.message}</p>`;
        }
    }

    // Busca y renderiza los productos en la tabla por AJAX
    async function buscarProductos() {
        if (!tbodyProductos) return;

        const categoriaId = selectCategoria ? selectCategoria.value : '';
        const buscarTexto = inputBuscador ? inputBuscador.value : '';

        let queryParams = new URLSearchParams();
        if (categoriaId) queryParams.append('categoria_id', categoriaId);
        if (buscarTexto) queryParams.append('buscar', buscarTexto);

        // Recolectar checkboxes seleccionados
        const checkboxes = document.querySelectorAll('#filtros-container input[type="checkbox"]:checked');
        checkboxes.forEach(cb => {
            queryParams.append(cb.name, cb.value); // cb.name incluye los corchetes []
        });

        tbodyProductos.innerHTML = '<tr><td colspan="6" style="text-align:center; color:#2b6cb0; padding: 20px;">Buscando productos...</td></tr>';

        try {
            const urlBaseLimpia = BASE_URL.endsWith('/') ? BASE_URL : BASE_URL + '/';
            const url = `${urlBaseLimpia}Productos/apiGetProductos?${queryParams.toString()}`;
            const response = await fetch(url);
            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
            
            const json = await response.json();
            tbodyProductos.innerHTML = ''; 

            if (!json.status || !json.productos || json.productos.length === 0) {
                tbodyProductos.innerHTML = '<tr><td colspan="6" style="text-align:center; color:#888; padding: 20px;">No se encontraron productos correspondientes.</td></tr>';
                return;
            }

            // Construcción segura usando nodos del DOM contra vulnerabilidades XSS
            json.productos.forEach(prod => {
                const tr = document.createElement('tr');
                tr.style.borderBottom = "1px solid #edf2f7";

                const tdId = document.createElement('td');
                tdId.style.padding = "12px";
                tdId.textContent = prod.id;

                const tdNombre = document.createElement('td');
                tdNombre.style.padding = "12px";
                tdNombre.style.fontWeight = '500';
                tdNombre.textContent = prod.nombre;

                const tdCategoria = document.createElement('td');
                tdCategoria.style.padding = "12px";
                tdCategoria.innerHTML = `<span style="background: #e2e8f0; padding: 3px 8px; border-radius: 12px; font-size: 12px;">${prod.categoria || 'General'}</span>`;

                const tdDesc = document.createElement('td');
                tdDesc.style.padding = "12px";
                tdDesc.style.color = "#718096";
                tdDesc.textContent = prod.descripcion || 'Sin descripción';

                const tdPrecio = document.createElement('td');
                tdPrecio.style.padding = "12px";
                tdPrecio.style.fontWeight = "600";
                tdPrecio.style.color = "#2b6cb0";
                tdPrecio.textContent = `S/. ${parseFloat(prod.precio).toFixed(2)}`;

                const tdStock = document.createElement('td');
                tdStock.style.padding = "12px";
                const stockVal = parseInt(prod.stock) || 0;
                tdStock.innerHTML = `<span style="color: ${stockVal > 0 ? '#38a169' : '#e53e3e'}; font-weight: bold;">${stockVal} unids.</span>`;

                tr.appendChild(tdId);
                tr.appendChild(tdNombre);
                tr.appendChild(tdCategoria);
                tr.appendChild(tdDesc);
                tr.appendChild(tdPrecio);
                tr.appendChild(tdStock);

                tbodyProductos.appendChild(tr);
            });

        } catch (error) {
            console.error("Error recuperando productos:", error);
            tbodyProductos.innerHTML = `<tr><td colspan="6" style="text-align:center; color:red; padding: 20px;">Error al recuperar productos: ${error.message}</td></tr>`;
        }
    }

    // Función Debounce auxiliar para optimizar el rendimiento del buscador
    function debounce(func, delay) {
        let timeoutId;
        return (...args) => {
            if (timeoutId) clearTimeout(timeoutId);
            timeoutId = setTimeout(() => {
                func.apply(null, args);
            }, delay);
        };
    }
})();