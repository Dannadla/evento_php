<?php
require_once 'Conexion.php';
$conexion = new Conexion();
$conn = $conexion->getConexion();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php");
    exit;
}

// 1. Recibir datos
$nombre        = trim($_POST['nombre'] ?? '');
$apellido      = trim($_POST['apellido'] ?? '');
$edad          = trim($_POST['edad'] ?? '');
$sexo          = $_POST['sexo'] ?? '';
$pais_id       = $_POST['pais_id'] ?? '';
$nacionalidad  = trim($_POST['nacionalidad'] ?? '');
$correo        = trim($_POST['correo'] ?? '');
$celular       = trim($_POST['celular'] ?? '');
$observaciones = trim($_POST['observaciones'] ?? '');
$fechaInput    = $_POST['fecha'] ?? '';

// Si el usuario no pone fecha, toma la de hoy
$fecha_formulario = $fechaInput !== '' ? $fechaInput : date('Y-m-d');

// Temas seleccionados (tabla intermedia o texto)
$temas_ids     = $_POST['temas'] ?? [];
$temas_texto   = $_POST['temas_texto'] ?? []; // por si usaste el plan B de texto

$errores = [];

// 2. Validaciones básicas
if ($nombre === '') {
    $errores[] = "El nombre es obligatorio.";
}
if ($apellido === '') {
    $errores[] = "El apellido es obligatorio.";
}
if ($edad === '' || !is_numeric($edad) || $edad <= 0 || $edad > 120) {
    $errores[] = "La edad no es válida.";
}
if ($sexo === '') {
    $errores[] = "Debe seleccionar el sexo.";
}
if ($pais_id === '') {
    $errores[] = "Debe seleccionar el país de residencia.";
}
if ($nacionalidad === '') {
    $errores[] = "La nacionalidad es obligatoria.";
}
if ($correo === '' || !filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    $errores[] = "El correo no es válido.";
}
if ($celular === '' || strlen(preg_replace('/\D/', '', $celular)) < 7) {
    $errores[] = "El celular no es válido.";
}
if (empty($temas_ids) && empty($temas_texto)) {
    $errores[] = "Debe seleccionar al menos un tema tecnológico.";
}

// 3. Si hay errores, los mostramos y salimos
if (count($errores) > 0) {
    echo "<h2>Se encontraron los siguientes errores:</h2>";
    echo "<ul>";
    foreach ($errores as $e) {
        echo "<li>" . htmlspecialchars($e) . "</li>";
    }
    echo "</ul>";
    echo '<p><a href="index.php">Volver al formulario</a></p>';
    exit;
}

// 4. Formato de Nombre y Apellido (primera letra mayúscula)
$nombre   = ucwords(mb_strtolower($nombre, 'UTF-8'));
$apellido = ucwords(mb_strtolower($apellido, 'UTF-8'));
$nacionalidad = ucwords(mb_strtolower($nacionalidad, 'UTF-8'));

// 5. Insertar en tabla inscriptor
// Asegúrate de que tu tabla tenga estas columnas:
// id (AI), nombre, apellido, edad, sexo, pais_id, nacionalidad, correo, celular,
// fecha_formulario, observaciones, temas (opcional)

$sql = "INSERT INTO inscriptor 
        (nombre, apellido, edad, sexo, pais_id, nacionalidad, correo, celular, fecha_formulario, observaciones)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Error al preparar la consulta: " . $conn->error);
}

$stmt->bind_param(
    "ssisssssss",
    $nombre,
    $apellido,
    $edad,
    $sexo,
    $pais_id,
    $nacionalidad,
    $correo,
    $celular,
    $fecha_formulario,
    $observaciones
);

if ($stmt->execute()) {

    // Obtener id del inscriptor insertado
    $inscriptor_id = $stmt->insert_id;

    // Si estás usando tabla intermedia inscriptor_area para las áreas de interés:
    if (!empty($temas_ids)) {
        $sqlArea = "INSERT INTO inscriptor_area (inscriptor_id, area_id) VALUES (?, ?)";
        $stmtArea = $conn->prepare($sqlArea);

        foreach ($temas_ids as $area_id) {
            $area_id = (int)$area_id;
            $stmtArea->bind_param("ii", $inscriptor_id, $area_id);
            $stmtArea->execute();
        }
        $stmtArea->close();
    }

    // Si estás usando solo texto para los temas (plan B)
    if (!empty($temas_texto)) {
        $temasStr = implode(', ', $temas_texto);
        // Necesitas tener un campo 'temas' en la tabla inscriptor para esto
        $sqlUpdateTemas = "UPDATE inscriptor SET temas = ? WHERE id = ?";
        $stmtTemas = $conn->prepare($sqlUpdateTemas);
        $stmtTemas->bind_param("si", $temasStr, $inscriptor_id);
        $stmtTemas->execute();
        $stmtTemas->close();
    }

    $stmt->close();
    header("Location: reporte.php?msg=Registro+guardado+correctamente");
    exit;

} else {
    echo "Error al guardar los datos: " . $stmt->error;
    echo '<p><a href="index.php">Volver al formulario</a></p>';
}
?>
