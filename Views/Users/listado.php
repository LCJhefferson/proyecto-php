<table>
    <thead>
        <tr>
            <td>id</td>
            <td>nombre</td>
            <td>email</td>  
        </tr>
    </thead>
    <tbody> 
        <?php foreach($data as $usuario): ?>
            <tr>
                <td><?php echo $usuario["id"]; ?></td>
                <td><?php echo $usuario["nombre"]; ?></td>
                <td><?php echo $usuario["email"]; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
