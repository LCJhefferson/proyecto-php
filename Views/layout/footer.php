<footer style="background-color: #1a202c; border-top: 3px solid #2b6cb0; padding: 40px 20px 20px 20px; font-family: 'Segoe UI', system-ui, sans-serif; color: #a0aec0; margin-top: auto; width: 100%;">    
    <div style="max-width: 1100px; margin: 0 auto; display: flex; flex-wrap: wrap; justify-content: space-between; gap: 30px; padding-bottom: 25px; border-bottom: 1px solid #2d3748;">
        
        <div style="flex: 1; min-width: 250px;">
            <h4 style="color: #ffffff; margin: 0 0 12px 0; font-size: 16px; font-weight: 600; display: flex; align-items: center; gap: 8px;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#4299e1" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                Mi Proyecto MVC
            </h4>
            <p style="font-size: 13px; line-height: 1.6; color: #718096; margin: 0;">
                Sistema de gestión comercial y catálogo dinámico asíncrono .
            </p>
        </div>

        <div style="min-width: 150px;">
            <h5 style="color: #ebf8ff; margin: 0 0 12px 0; font-size: 14px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Módulos</h5>
            <ul style="list-style: none; padding: 0; margin: 0; font-size: 13px;">
                <li style="margin-bottom: 8px;"><a href="Home" style="color: #a0aec0; text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='#4299e1'" onmouseout="this.style.color='#a0aec0'">Dashboard Principal</a></li>
                <li><a href="Productos" style="color: #a0aec0; text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='#4299e1'" onmouseout="this.style.color='#a0aec0'">Catálogo de Productos</a></li>
            </ul>
        </div>

        
    </div>

    <div style="max-width: 1100px; margin: 0 auto; padding-top: 20px; display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; font-size: 13px; color: #718096;">
        <p style="margin: 0;">
            &copy; <?= date("Y") ?> <span style="color: #cbd5e0; font-weight: 500;">Mi Proyecto MVC</span>. Todos los derechos reservados.
        </p>
        <p style="margin: 0; font-size: 12px;">
            Desarrollado para Reporte de Laboratorio
        </p>
    </div>
</footer>