<?php
// 1. Definimos qué personaje queremos buscar (por defecto el 1)

// 2. Llamada a la API (Sin keys, directo)

// 3. Convertimos el JSON en un array de PHP
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
        <input type="number" name="id" value="" min="1" max="826">
        <button type="submit">Consultar API</button>
    </form>

    <div class="card">
        <img src="" width="150">
        <h3>Nombre: </h3>
        <p>Especie: </p>
        <p>Estado: </p>
    </div>

</body>
</html>
