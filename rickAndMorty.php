<?php
// 1. Definimos qué personaje queremos buscar (por defecto el 1)
$id = isset($_POST['id']) ? $_POST['id'] : 1;

// 2. Llamada a la API (Sin keys, directo)
$url = "https://rickandmortyapi.com/api/character/".$id;
$respuesta = file_get_contents($url);

// 3. Convertimos el JSON en un array de PHP
$personajes = json_decode($respuesta, true);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Demo API Simple</title>
    <style>
        body { font-family: sans-serif; text-align: center; background: #222; color: white; }
        .card { background: #333; padding: 20px; border-radius: 10px; display: inline-block; margin-top: 20px; }
        img { border-radius: 50%; border: 3px solid #97ce4c; }
    </style>
</head>
<body>

    <h2>Busca un Personaje de Rick And Morty</h2>
    
    <form method="POST">
        <input type="number" name="id" value="<?= $id?>" min="1" max="826">
        <button type="submit">Consultar API</button>
    </form>

    <div class="card">
        <img src="<?= $personajes['image']?>" width="150">
        <h3>Nombre: <?= $personajes['name']?></h3>
        <p>Especie: <?= $personajes['species']?></p>
        <p>Estado: <?= $personajes['status']?></p>
    </div>

</body>
</html>
