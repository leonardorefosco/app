<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lutas</title>
</head>
<body>
    <?php
    require_once "lutas.php";

    $lutador = [];

    $lutador[0] = new Lutador("Carlos Prates", "Brasil", 30, 1.87, 77.5, 22, 7, 0);
    $lutador[1] = new Lutador("Ilia Topuria", "Espanha", 28, 1.73, 71, 17, 1, 0);
    $lutador[2] = new Lutador("Charles do Bronx", "Brasil", 35, 1.85, 74, 23, 8, 1);
    $lutador[3] = new Lutador("Ian Garry", "Irlanda", 28, 1.91, 77, 17, 2, 0);
    $lutador[4] = new Lutador("Michal Morales", "Equador", 25, 1.88, 80, 19, 0, 0);
    $lutador[5] = new Lutador("Poatan", "Brasil", 37, 1.85, 90, 20, 4, 0);

    $UFC335 = new Luta();
    $UFC335->marcarLuta($lutador[1], $lutador[2]);
    $UFC335->lutar();
    $lutador[1]->status();
    ?>
</body>
</html>