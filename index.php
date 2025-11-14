<?php
require_once 'Conexion.php';
$conexion = new Conexion();
$conn = $conexion->getConexion();

// Cargar países
$sqlPais = "SELECT id, nombre FROM pais ORDER BY nombre";
$listaPaises = $conn->query($sqlPais);

// Cargar áreas de interés (temas tecnológicos)
$sqlAreas = "SELECT id, descripcion FROM area_interes ORDER BY descripcion";
$listaAreas = $conn->query($sqlAreas);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario iTECH</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="container">
    <h1>Formulario de Inscripción - iTECH</h1>

    <?php if (isset($_GET['msg'])): ?>
        <div class="mensaje">
            <?php echo htmlspecialchars($_GET['msg']); ?>
        </div>
    <?php endif; ?>

    <form action="procesar.php" method="post">

        <div class="campo">
            <label for="nombre">Nombre *</label>
            <input type="text" id="nombre" name="nombre" required>
        </div>

        <div class="campo">
            <label for="apellido">Apellido *</label>
            <input type="text" id="apellido" name="apellido" required>
        </div>

        <div class="campo">
            <label for="edad">Edad *</label>
            <input type="number" id="edad" name="edad" min="1" max="120" required>
        </div>

        <div class="campo">
            <label>Sexo *</label>
            <div class="opciones">
                <label><input type="radio" name="sexo" value="Masculino" required> Masculino</label>
                <label><input type="radio" name="sexo" value="Femenino" required> Femenino</label>
                <label><input type="radio" name="sexo" value="Otro" required> Otro</label>
            </div>
        </div>

        <div class="campo">
            <label for="pais">País de residencia *</label>
            <select id="pais" name="pais_id" required>
                <option value="">Seleccione...</option>
                <?php if ($listaPaises && $listaPaises->num_rows > 0): ?>
                    <?php while ($row = $listaPaises->fetch_assoc()): ?>
                        <option value="<?php echo $row['id']; ?>">
                            <?php echo htmlspecialchars($row['nombre']); ?>
                        </option>
                    <?php endwhile; ?>
                <?php endif; ?>
            </select>
        </div>

        <div class="campo">
            <label for="nacionalidad">Nacionalidad *</label>
            <input type="text" id="nacionalidad" name="nacionalidad" required>
        </div>

        <div class="campo">
            <label>Tema tecnológico que le gustaría aprender *</label>
            <div class="opciones">
                <?php if ($listaAreas && $listaAreas->num_rows > 0): ?>
                    <?php while ($a = $listaAreas->fetch_assoc()): ?>
                        <label>
                            <input type="checkbox" name="temas[]" value="<?php echo $a['id']; ?>">
                            <?php echo htmlspecialchars($a['descripcion']); ?>
                        </label><br>
                    <?php endwhile; ?>
                <?php else: ?>
                    <!-- Plan B: si no tienes tabla area_interes, puedes ponerlos quemados -->
                    <label><input type="checkbox" name="temas_texto[]" value="Inteligencia Artificial"> Inteligencia Artificial</label><br>
                    <label><input type="checkbox" name="temas_texto[]" value="Ciberseguridad"> Ciberseguridad</label><br>
                    <label><input type="checkbox" name="temas_texto[]" value="Desarrollo Web"> Desarrollo Web</label><br>
                <?php endif; ?>
            </div>
        </div>

        <div class="campo">
            <label for="correo">Correo electrónico *</label>
            <input type="email" id="correo" name="correo" required>
        </div>

        <div class="campo">
            <label for="celular">Celular *</label>
            <input type="tel" id="celular" name="celular" required>
        </div>

        <div class="campo">
            <label for="observaciones">Observaciones o consulta sobre el evento</label>
            <textarea id="observaciones" name="observaciones" rows="4"></textarea>
        </div>

        <div class="campo">
            <label for="fecha">Fecha del formulario</label>
            <input type="date" id="fecha" name="fecha">
        </div>

        <div class="campo">
            <button type="submit">Enviar formulario</button>
            <a href="reporte.php" class="btn-secundario">Ver reporte</a>
        </div>
    </form>

    <footer>
        © 2025 iTECH. All rights reserved. | Contacto: info@itech.com
    </footer>
</div>

</body>
</html>
