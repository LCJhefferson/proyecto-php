<?php ?>

<div style="padding: 20px; font-family: sans-serif;">
    <a href="<?= base_url() ?>Users/crear" style="display: inline-block; margin-bottom: 15px; padding: 8px 15px; background: #2ecc71; color: white; text-decoration: none; border-radius: 4px; font-weight: bold;">Crear Usuario</a>
    
    <input type="text" id="buscadorUsuarios" placeholder="Buscar por nombre o correo..." style="width: 100%; padding: 10px; border: 1px solid #cbd5e0; border-radius: 5px; font-size: 14px; margin-bottom: 15px; box-sizing: border-box;">

    <table id="tblUsuarios" style="width: 100%; border-collapse: collapse; margin-top: 15px; font-family: sans-serif; box-shadow: 0 1px 3px rgba(0,0,0,0.1); border-radius: 6px; overflow: hidden;">
        <thead>
            <tr style="background-color: #f2f2f2;">
                <th style="padding: 10px;">ID</th>
                <th style="padding: 10px;">Nombre</th>
                <th style="padding: 10px;">Correo Electrónico</th>
            </tr>
        </thead>
        <tbody id="tblUsuario_body">
            </tbody>
    </table>
</div>

<script src="<?= base_url() ?>Assets/js/listado_async.js"></script>