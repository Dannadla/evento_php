<?php
require_once 'Conexion.php';
$conexion = new Conexion();
$conn = $conexion->getConexion();

// JOIN con país
$sql = "SELECT i.*, p.nombre AS pais_nombre
        FROM inscriptor i
        LEFT JOIN pais p ON i.pais_id = p.id
        ORDER BY i.id DESC";

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Inscripciones</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="container">
    <h1>Reporte de Inscripciones - iTECH</h1>

    <?php if (isset($_GET['msg'])): ?>
        <div class="mensaje">
            <?php echo htmlspecialchars($_GET['msg']); ?>
        </div>
    <?php endif; ?>

    <a href="index.php" class="btn-secundario">Volver al formulario</a>

    <table class="tabla">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre completo</th>
                <th>Edad</th>
                <th>Sexo</th>
                <th>País</th>
                <th>Nacionalidad</th>
                <th>Correo</th>
                <th>Celular</th>
                <th>Fecha formulario</th>
                <th>Observaciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo htmlspecialchars($row['nombre'] . " " . $row['apellido']); ?></td>
                        <td><?php echo htmlspecialchars($row['edad']); ?></td>
                        <td><?php echo htmlspecialchars($row['sexo']); ?></td>
                        <td><?php echo htmlspecialchars($row['pais_nombre']); ?></td>
                        <td><?php echo htmlspecialchars($row['nacionalidad']); ?></td>
                        <td><?php echo htmlspecialchars($row['correo']); ?></td>
                        <td><?php echo htmlspecialchars($row['celular']); ?></td>
                        <td><?php echo htmlspecialchars($row['fecha_formulario']); ?></td>
                        <td><?php echo nl2br(htmlspecialchars($row['observaciones'])); ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="10">No hay registros aún.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>
