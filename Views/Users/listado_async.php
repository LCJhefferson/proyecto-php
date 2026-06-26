<?php ?>

<a href="<?= BASE_URL ?>/users/crear">Crear Usuario</a>
<table border="1" id="tblUsuarios">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
        </tr>
    </thead>
    <tbody id="tblUsuario_body">
        <!-- Todo el contenido de esta tabla se cargará de forma asíncrona -->
    </tbody>
</table>

<script src="<?= BASE_URL ?>/assets/js/listado_async.js"></script>
