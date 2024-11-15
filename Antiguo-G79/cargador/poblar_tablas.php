<?php
require 'conexion.php';

function cargar_datos_cursos($conn, $csvFile) {
    if (($handle = fopen($csvFile, "r")) !== false) {
        fgetcsv($handle, 1000, ";");

        while (($data = fgetcsv($handle, 1000, ";")) !== false) {
            $sigla = $data[1];
            $nombre = $data[2];
            $nivel = (int)$data[3];

            $sql = "INSERT INTO cursos (sigla, nombre, nivel) VALUES ('$sigla', '$nombre', $nivel)";
            $result = pg_query($conn, $sql);

            if ($result) {
                echo "Curso insertado correctamente: $sigla - $nombre\n";
            } else {
                echo "Error al insertar curso: " . pg_last_error($conn) . "\n";
            }
        }
        fclose($handle);
    } else {
        echo "No se pudo abrir el archivo CSV de cursos.";
    }
}

function cargar_datos_estudiantes($conn, $csvFile) {
    if (($handle = fopen($csvFile, "r")) !== false) {
        fgetcsv($handle, 1000, ";");

        while (($data = fgetcsv($handle, 1000, ";")) !== false) {
            $numero_estudiante = (int)$data[3];  
            $cohorte = $data[2];                 
            $estado_bloqueo = $data[4];        
            $ultimo_logro = !empty($data[12]) ? $data[12] : 'NULL';
            $ultima_carga = !empty($data[13]) ? $data[13] : 'NULL';

            $sql = "INSERT INTO estudiantes (numero_estudiante, cohorte, estado_bloqueo, ultimo_logro, ultima_carga)
                    VALUES ($numero_estudiante, '$cohorte', '$estado_bloqueo', '$ultimo_logro', '$ultima_carga')";
            $result = pg_query($conn, $sql);

            if ($result) {
                echo "Estudiante insertado correctamente: $numero_estudiante\n";
            } else {
                echo "Error al insertar estudiante: " . pg_last_error($conn) . "\n";
            }
        }
        fclose($handle);
    } else {
        echo "No se pudo abrir el archivo CSV de estudiantes.";
    }
}



$csvFileCursos = '../data/asignaturas.csv';
$csvFileEstudiantes = '../data/estudiantes.csv';

cargar_datos_cursos($conn, $csvFileCursos);
cargar_datos_estudiantes($conn, $csvFileEstudiantes);

?>

