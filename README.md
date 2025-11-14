📝 Parcial PHP – Formulario de Inscripción iTECH
👩‍💻 Estudiante

Danna Dawkins – 8-1010-1542

📌 Descripción del Parcial

Este parcial consiste en el desarrollo de un formulario en PHP para el registro de participantes de un evento iTECH.
El sistema incluye:

Formulario web con todos los campos solicitados

Validaciones del lado del servidor

Conexión a MySQL mediante clase

Conversión de nombre y apellido a mayúscula inicial

Inserción de datos en la base

Reporte con los registros almacenados

Uso de CSS para diseño

Uso de tabla intermedia para los temas tecnológicos

📁 Archivos Entregados
index.php        → Formulario principal
procesar.php     → Guarda los datos en la base
reporte.php      → Tabla de inscripciones
Conexion.php     → Clase de conexión
styles.css       → Estilos del formulario y reporte
README.md        → Documento requerido

🗄️ Base de Datos

Nombre de la BD: evcento_itech

Tablas creadas:

Tabla	Descripción
pais	Países disponibles
area_interes	Temas tecnológicos
inscriptor	Datos principales del formulario
inscriptor_area	Relación entre participante y áreas
⚙️ Instalación y Ejecución

1️⃣ Colocar la carpeta en XAMPP
C:\xampp\htdocs\evento_php\

2️⃣ Activar servicios

Apache ✔️

MySQL ✔️

3️⃣ Crear base de datos

Ingresar a:

http://localhost/phpmyadmin


Crear BD:

evcento_itech


Importar o ejecutar el script SQL proporcionado.

4️⃣ Ingresar al formulario

👉 http://localhost/evento_php/index.php

5️⃣ Ver reporte

👉 http://localhost/evento_php/reporte.php
