// =========================================================================
// MÓDULO 1: GESTIÓN ASÍNCRONA DE USUARIOS (Código heredado del otro grupo)
// =========================================================================
const tblUsuarios_body = document.getElementById("tblUsuario_body");

document.addEventListener("DOMContentLoaded", () => {
    // Solo ejecuta si estamos en la vista que contiene la tabla de usuarios
    if (tblUsuarios_body) {
        cargarUsuarios();
    }
});

document.addEventListener("DOMContentLoaded", function() {
    cargarUsuarios();
});

function cargarUsuarios(busqueda = '') {
    // Apuntamos de forma exacta al método asíncrono del controlador
    const url = window.location.origin + "/proyecto-php/Users/cargarUsuariosAsync?buscar=" + encodeURIComponent(busqueda);
    
    fetch(url)
        .then(response => response.json())
        .then(data => {
            const tbody = document.getElementById("tblUsuario_body");
            tbody.innerHTML = ""; // Limpiamos la tabla
            
            if(data.length === 0) {
                tbody.innerHTML = `<tr><td colspan="3" style="text-align:center;">No se encontraron usuarios</td></tr>`;
                return;
            }

            data.forEach(usuario => {
                const row = document.createElement("tr");
                row.innerHTML = `
                    <td style="padding: 10px;">${usuario.id}</td>
                    <td style="padding: 10px;">${usuario.nombre || 'Sin Nombre'}</td>
                    <td style="padding: 10px;">${usuario.correo}</td>
                `;
                tbody.appendChild(row);
            });
        })
        .catch(error => console.error("Error cargando los usuarios asíncronos:", error));
}

const inputBuscadorUsuarios = document.getElementById('buscadorUsuarios');
if (inputBuscadorUsuarios) {
    inputBuscadorUsuarios.addEventListener('input', debounce(() => {
        cargarUsuarios(inputBuscadorUsuarios.value);
    }, 400));
}


// =========================================================================
// MÓDULO 2: LABORATORIO - EAV + AJAX + DEBOUNCE (Tu código para Productos)
// =========================================================================

// Referencias de Elementos del DOM para la sección de Productos
const selectCategoria = document.getElementById('categoria');
const contenedorFiltros = document.getElementById('filtros-container');
const inputBuscador = document.getElementById('buscador');
const tbodyProductos = document.getElementById('tbody-productos');

// Escuchadores de eventos condicionales para la interfaz de Productos
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
    // Aplicamos la optimización obligatoria DEBOUNCE de 400ms exigida en el PDF
    inputBuscador.addEventListener('input', debounce(() => {
        buscarProductos();
    }, 400));
}

async function cargarFiltrosDinamicos(categoriaId) {
    if (!contenedorFiltros) return;

    if (!categoriaId) {
        contenedorFiltros.innerHTML = '<p style="color:#888; font-size:13px;">Seleccione una categoría para desplegar especificaciones.</p>';
        return;
    }

    contenedorFiltros.innerHTML = '<p style="font-size:13px; color:#007bff;">Cargando especificaciones...</p>';

    try {
        const response = await fetch(`${BASE_URL}/Productos/apiGetFiltros/${categoriaId}`);
        if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
        
        const json = await response.json();
        contenedorFiltros.innerHTML = ''; // Limpiar estado de carga

        if (!json.status || json.filtros.length === 0) {
            contenedorFiltros.innerHTML = '<p style="color:#e67e22; font-size:13px;">No hay propiedades EAV para esta categoría.</p>';
            return;
        }

        // Construcción dinámica de Checkboxes iterando la metadata EAV
        json.filtros.forEach(filtro => {
            const grupoDiv = document.createElement('div');
            grupoDiv.className = 'filtro-grupo';

            const titulo = document.createElement('h4');
            titulo.textContent = filtro.nombre; // Uso seguro de textContent contra XSS
            grupoDiv.appendChild(titulo);

            filtro.valores.forEach(valor => {
                const label = document.createElement('label');
                
                const checkbox = document.createElement('input');
                checkbox.type = 'checkbox';
                checkbox.name = `filtro_${filtro.id}[]`;
                checkbox.value = valor;
                
                label.appendChild(checkbox);
                label.appendChild(document.createTextNode(` ${valor}`));
                grupoDiv.appendChild(label);
            });

            contenedorFiltros.appendChild(grupoDiv);
        });

    } catch (error) {
        contenedorFiltros.innerHTML = `<p style="color:red; font-size:13px;">Error: ${error.message}</p>`;
    }
}

async function buscarProductos() {
    if (!tbodyProductos) return;

    const categoriaId = selectCategoria ? selectCategoria.value : '';
    const buscarTexto = inputBuscador ? inputBuscador.value : '';

    tbodyProductos.innerHTML = '<tr><td colspan="6" style="text-align:center; color:#007bff;">Buscando productos...</td></tr>';

    try {
        const url = `${BASE_URL}/Productos/apiGetProductos?categoria_id=${categoriaId}&buscar=${encodeURIComponent(buscarTexto)}`;
        const response = await fetch(url);
        if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
        
        const json = await response.json();
        tbodyProductos.innerHTML = ''; // Limpiar filas

        if (!json.status || json.productos.length === 0) {
            tbodyProductos.innerHTML = '<tr><td colspan="6" style="text-align:center; color:#888;">No se encontraron productos correspondientes.</td></tr>';
            return;
        }

        // Construcción de la tabla fila por fila usando nodos del DOM para cumplir con textContent
        json.productos.forEach(prod => {
            const tr = document.createElement('tr');

            const tdId = document.createElement('td');
            tdId.textContent = prod.id;

            const tdNombre = document.createElement('td');
            tdNombre.textContent = prod.nombre;
            tdNombre.style.fontWeight = 'bold';

            const tdCategoria = document.createElement('td');
            tdCategoria.textContent = prod.categoria;

            const tdDesc = document.createElement('td');
            tdDesc.textContent = prod.descripcion;

            const tdPrecio = document.createElement('td');
            tdPrecio.textContent = `S/. ${parseFloat(prod.precio).toFixed(2)}`;

            const tdStock = document.createElement('td');
            tdStock.textContent = prod.stock;

            tr.appendChild(tdId);
            tr.appendChild(tdNombre);
            tr.appendChild(tdCategoria);
            tr.appendChild(tdDesc);
            tr.appendChild(tdPrecio);
            tr.appendChild(tdStock);

            tbodyProductos.appendChild(tr);
        });

    } catch (error) {
        tbodyProductos.innerHTML = `<tr><td colspan="6" style="text-align:center; color:red;">Error al recuperar productos: ${error.message}</td></tr>`;
    }
}

function debounce(func, delay) {
    let timeoutId;
    return (...args) => {
        if (timeoutId) clearTimeout(timeoutId);
        timeoutId = setTimeout(() => {
            func.apply(null, args);
        }, delay);
    };
}