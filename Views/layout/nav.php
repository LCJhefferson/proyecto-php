<nav style="background-color: #2d3748; padding: 0 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); font-family: 'Segoe UI', system-ui, sans-serif;">
  <ul style="list-style: none; margin: 0; padding: 0; display: flex; align-items: center; height: 60px; gap: 15px;">
    
    <li style="margin-right: auto; color: #fff; font-weight: bold; font-size: 18px; letter-spacing: 0.5px;">
        🧪 Panel Laboratorio
    </li>

    <li>
        <a href="<?= base_url(); ?>Home" style="color: #cbd5e0; text-decoration: none; padding: 8px 16px; border-radius: 4px; font-size: 15px; font-weight: 500; transition: all 0.2s;" onmouseover="this.style.color='#fff'; this.style.backgroundColor='#4a5568'" onmouseout="this.style.color='#cbd5e0'; this.style.backgroundColor='transparent'">Inicio</a>
    </li>
    <li>
        <a href="<?= base_url(); ?>Users" style="color: #cbd5e0; text-decoration: none; padding: 8px 16px; border-radius: 4px; font-size: 15px; font-weight: 500; transition: all 0.2s;" onmouseover="this.style.color='#fff'; this.style.backgroundColor='#4a5568'" onmouseout="this.style.color='#cbd5e0'; this.style.backgroundColor='transparent'">Usuarios</a>
    </li>

    <!-- Productos -->
   <li>
    <a href="<?= base_url(); ?>Productos" style="color: #cbd5e0; text-decoration: none; padding: 8px 16px; border-radius: 4px; font-size: 15px; font-weight: 500; transition: all 0.2s;" onmouseover="this.style.color='#fff'; this.style.backgroundColor='#4a5568'" onmouseout="this.style.color='#cbd5e0'; this.style.backgroundColor='transparent'">Productos</a>
</li>

    <li style="margin-left: 10px; border-left: 1px solid #4a5568; padding-left: 15px;">
        <a href="<?= base_url(); ?>Login/logout" style="color: #fc8181; text-decoration: none; padding: 6px 12px; border: 1px solid #fc8181; border-radius: 4px; font-size: 14px; font-weight: 500; transition: all 0.2s;" onmouseover="this.style.color='#fff'; this.style.backgroundColor='#e53e3e'; this.style.borderColor='#e53e3e'" onmouseout="this.style.color='#fc8181'; this.style.backgroundColor='transparent'; this.style.borderColor='#fc8181'">Cerrar Sesión</a>
    </li>
  </ul>
</nav>