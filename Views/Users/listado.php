<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Correo Electrónico</th>  
        </tr>
    </thead>
    <tbody> 
        <?php 
        // Validamos si la información viene directamente en $data o dentro de $data['usuarios']
        $usuarios = isset($data['usuarios']) ? $data['usuarios'] : $data;

        if (!empty($usuarios) && is_array($usuarios)): 
            foreach($usuarios as $usuario): ?>
                <tr>
                    <td><?= htmlspecialchars($usuario["id"]); ?></td>
                    <td><?= htmlspecialchars($usuario["nombre"]); ?></td>
                    <td><?= htmlspecialchars($usuario["correo"]); ?></td> 
                </tr>
            <?php 
            endforeach; 
        else: 
        ?>
            <tr>
                <td colspan="3" style="text-align: center; color: #888;">No se encontraron usuarios en la base de datos.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>