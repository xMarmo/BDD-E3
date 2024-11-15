<?php 
session_start();

if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'user') {
    header("Location: index.php"); 
    exit(); 
}

include('templates/header.html'); 
?>

<body>
  <div class="user">
  <h1 class="title">Bananer</h1>
  <form class="form" action="consultas/...php" method="post">
    <input class="form-input" type="number" required placeholder="Ingresa un número" name="cantidad" min="1" max="157"> 
    <br>
    <input class="form-button" type="submit" value="Buscar">
  </form>
  <br>
  <br>

  <p class="prompt">Consulta 2</p>
  <form class="form" action="consultas/....php" method="post">
    <input class="form-input" type="text" required placeholder="Ingresa un nombre" name="artista"> 
    <br>
    <input class="form-button" type="submit" value="Buscar">
  </form>
  <br>
  <br>
  <form method="POST" action="consultas/logout.php">
    <button type="submit" class="form-button">Volver a Iniciar Sesión</button>
  </form>
  </div>
</body>
</html>