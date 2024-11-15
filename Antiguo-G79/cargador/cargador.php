<?php

$dbname = "grupo79";
$user = "grupo79";
$password = "grupo79";

$conn = pg_connect("host=localhost port=22 dbname=$dbname user=$user password=$password");
if (!$conn) {
    die("Connection failed: " . pg_last_error());
}


function ejecutar_query($conn, $sql) {
    $result = pg_query($conn, $sql);
    if ($result) {
        echo "Tabla creada correctamente\n";
    } else {
        echo "Error creando la tabla: " . pg_last_error($conn) . "\n";
    }
}


function crear_tabla_personas($conn) {
    $sql = "CREATE TABLE IF NOT EXISTS personas (
        id_persona SERIAL PRIMARY KEY,
        run VARCHAR(12) NOT NULL UNIQUE,
        DV CHAR(1) NOT NULL,
        nombre VARCHAR(100) NOT NULL,
        correo VARCHAR(100),
        telefonos VARCHAR(9)
    )";
    ejecutar_query($conn, $sql);
}

function crear_tabla_estudiantes($conn) {
    $sql = "CREATE TABLE IF NOT EXISTS estudiantes (
        id_estudiante SERIAL PRIMARY KEY,
        id_persona INT REFERENCES personas(id_persona),
        numero_estudiante VARCHAR(15) UNIQUE NOT NULL,
        cohorte VARCHAR(7),
        estado_bloqueo BOOLEAN DEFAULT FALSE,
        ultimo_logro VARCHAR(50),
        ultima_carga VARCHAR(7)
    )";
    ejecutar_query($conn, $sql);
}

function crear_tabla_trabajadores($conn) {
    $sql = "CREATE TABLE IF NOT EXISTS trabajadores (
        id_trabajador SERIAL PRIMARY KEY,
        id_persona INT REFERENCES personas(id_persona),
        contrato VARCHAR(20) CHECK (contrato IN ('FULL TIME', 'PART TIME', 'HONORARIO')),
        grado_academico VARCHAR(50) CHECK (grado_academico IN ('LICENCIATURA', 'MAGISTER', 'DOCTOR')),
        jerarquia VARCHAR(50)
    )";
    ejecutar_query($conn, $sql);
}

function crear_tabla_academicos($conn) {
    $sql = "CREATE TABLE IF NOT EXISTS academicos (
        id_academico SERIAL PRIMARY KEY,
        id_persona INT REFERENCES personas(id_persona),
        contrato VARCHAR(20) CHECK (contrato IN ('FULL TIME', 'PART TIME', 'HONORARIO')),
        grado_academico VARCHAR(50) CHECK (grado_academico IN ('LICENCIATURA', 'MAGISTER', 'DOCTOR')),
        jerarquia VARCHAR(50),
        cargo VARCHAR(50) NOT NULL
    )";
    ejecutar_query($conn, $sql);
}

function crear_tabla_administrativos($conn) {
    $sql = "CREATE TABLE IF NOT EXISTS administrativos (
        id_administrativo SERIAL PRIMARY KEY,
        id_persona INT REFERENCES personas(id_persona),
        contrato VARCHAR(20) CHECK (contrato IN ('FULL TIME', 'PART TIME', 'HONORARIO')),
        grado_academico VARCHAR(50) CHECK (grado_academico IN ('LICENCIATURA', 'MAGISTER', 'DOCTOR')),
        jerarquia VARCHAR(50),
        cargo VARCHAR(50) NOT NULL
    )";
    ejecutar_query($conn, $sql);
}

function crear_tabla_historial_academico($conn) {
    $sql = "CREATE TABLE IF NOT EXISTS historiales_academicos (
        id_historial SERIAL PRIMARY KEY,
        id_estudiante INT REFERENCES estudiantes(id_estudiante),
        id_curso INT REFERENCES cursos(id_curso),
        nota NUMERIC(3,1) CHECK (nota >= 1.0 AND nota <= 7.0),
        calificacion VARCHAR(2) CHECK (calificacion IN ('SO', 'MB', 'B', 'SU', 'I', 'M', 'MM', 'P', 'NP', 'EX', 'A', 'R')),
        descripcion TEXT
    )";
    ejecutar_query($conn, $sql);
}

function crear_tabla_oferta_academica($conn) {
    $sql = "CREATE TABLE IF NOT EXISTS oferta_academica (
        id_oferta SERIAL PRIMARY KEY,
        id_curso INT REFERENCES cursos(id_curso),
        id_estudiante INT REFERENCES estudiantes(id_estudiante),
        vacantes INT CHECK (vacantes > 0),
        sala VARCHAR(50),
        modulo_horario VARCHAR(50),
        periodo VARCHAR(7),
        seccion INT,
        nombre_profesor VARCHAR(100) DEFAULT 'POR DESIGNAR'
    )";
    ejecutar_query($conn, $sql);
}

function crear_tabla_cursos($conn) {
    $sql = "CREATE TABLE IF NOT EXISTS cursos (
        id_curso SERIAL PRIMARY KEY,
        sigla VARCHAR(10) UNIQUE NOT NULL,
        nombre VARCHAR(255),
        caracter VARCHAR(50),
        equivalencias VARCHAR(255),
        nivel VARCHAR(10),
        ciclo VARCHAR(10)
    )";
    ejecutar_query($conn, $sql);
}

function crear_tabla_prerrequisitos($conn) {
    $sql = "CREATE TABLE IF NOT EXISTS prerrequisitos (
        id_curso INT REFERENCES cursos(id_curso),
        ciclo VARCHAR(10),
        sigla VARCHAR(10),
        PRIMARY KEY (id_curso, ciclo, sigla)
    )";
    ejecutar_query($conn, $sql);
}

function crear_tabla_equivalencias($conn) {
    $sql = "CREATE TABLE IF NOT EXISTS equivalencias (
        id_curso INT REFERENCES cursos(id_curso),
        ciclo VARCHAR(10),
        sigla VARCHAR(10),
        PRIMARY KEY (id_curso, ciclo, sigla)
    )";
    ejecutar_query($conn, $sql);
}

function crear_tabla_planes_estudio($conn) {
    $sql = "CREATE TABLE IF NOT EXISTS planes_estudio (
        id_plan SERIAL PRIMARY KEY,
        codigo VARCHAR(10) UNIQUE NOT NULL,
        fecha_inicio DATE NOT NULL,
        cantidad_OFG INT,
        cantidad_OPT INT,
        cantidad_CTICSI INT
    )";
    ejecutar_query($conn, $sql);
}

function crear_tabla_cursos_minimos($conn) {
    $sql = "CREATE TABLE IF NOT EXISTS cursos_minimos (
        id_plan INT REFERENCES planes_estudio(id_plan),
        id_min SERIAL PRIMARY KEY,
        nombre VARCHAR(100),
        sigla VARCHAR(10),
        caracter VARCHAR(50),
        tipo VARCHAR(50)
    )";
    ejecutar_query($conn, $sql);
}

function crear_tabla_carrera($conn) {
    $sql = "CREATE TABLE IF NOT EXISTS carrera (
        id_plan INT REFERENCES planes_estudio(id_plan),
        id_persona INT REFERENCES estudiantes(id_persona),
        nombre VARCHAR(100)
    )";
    ejecutar_query($conn, $sql);
}



?>
