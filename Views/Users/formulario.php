<div class="form-wrapper" style="max-width: 450px; margin: 40px auto; padding: 30px; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); font-family: 'Segoe UI', system-ui, sans-serif;">
    
    <h2 style="margin-top: 0; margin-bottom: 20px; color: #1a202c; font-size: 24px; font-weight: 600; border-bottom: 2px solid #edf2f7; padding-bottom: 10px;">Crear Nuevo Usuario</h2>
    
    <form action="<?= base_url(); ?>Users/guardar" method="post">
        <div style="margin-bottom: 18px;">
            <label for="nombre" style="display: block; margin-bottom: 6px; color: #4a5568; font-weight: 500; font-size: 14px;">Nombre Completo:</label>
            <input type="text" id="nombre" name="nombre" placeholder="Ej. Juan Pérez" style="width: 100%; padding: 10px; box-sizing: border-box; border: 1px solid #cbd5e0; border-radius: 5px; font-size: 14px; transition: border-color 0.2s;" onfocus="this.style.borderColor='#3182ce'" onblur="this.style.borderColor='#cbd5e0'">
        </div>

        <div style="margin-bottom: 18px;">
            <label for="correo" style="display: block; margin-bottom: 6px; color: #4a5568; font-weight: 500; font-size: 14px;">Correo Electrónico:</label>
            <input type="email" id="correo" name="correo" required placeholder="correo@ejemplo.com" style="width: 100%; padding: 10px; box-sizing: border-box; border: 1px solid #cbd5e0; border-radius: 5px; font-size: 14px; transition: border-color 0.2s;" onfocus="this.style.borderColor='#3182ce'" onblur="this.style.borderColor='#cbd5e0'">
        </div>

        <div style="margin-bottom: 25px;">
            <label for="password" style="display: block; margin-bottom: 6px; color: #4a5568; font-weight: 500; font-size: 14px;">Contraseña:</label>
            <input type="password" id="password" name="password" required placeholder="••••••••" style="width: 100%; padding: 10px; box-sizing: border-box; border: 1px solid #cbd5e0; border-radius: 5px; font-size: 14px; transition: border-color 0.2s;" onfocus="this.style.borderColor='#3182ce'" onblur="this.style.borderColor='#cbd5e0'">
        </div>

        <div style="display: flex; gap: 10px; justify-content: flex-end;">
            <a href="<?= base_url(); ?>Users" style="padding: 10px 15px; background: #e2e8f0; color: #4a5568; text-decoration: none; border-radius: 5px; font-size: 14px; font-weight: 500; transition: background 0.2s;" onmouseover="this.style.background='#cbd5e0'" onmouseout="this.style.background='#e2e8f0'">Cancelar</a>
            <input type="submit" value="Registrar Usuario" style="padding: 10px 20px; background-color: #3182ce; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 14px; font-weight: 600; transition: background 0.2s;" onmouseover="this.style.backgroundColor='#2b6cb0'" onmouseout="this.style.backgroundColor='#3182ce'">
        </div>
    </form>
</div>