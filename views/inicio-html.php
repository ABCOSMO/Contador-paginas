<?php $pastaCliente = 'barbeariabroklin'; ?>

<!DOCTYPE html>
<html lang="pt-br" class="h-100">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <title>FAP-CDIP</title>
</head>

<body class="d-flex flex-column h-100">

    <nav class="navbar navbar-expand-lg bg-body-tertiary" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Ferramente de Apoio à Produção</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/<?php $pastaCliente; ?>/">Home</a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Menu Matrizes
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/<?php echo $pastaCliente; ?>/cadastrar-matriz">Cadastrar Matriz</a></li>
                            <li><a class="dropdown-item" href="/<?php echo $pastaCliente; ?>/listar-matriz">Listar Matrizes</a></li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" id="botaoMultiplex" href="/<?php echo $pastaCliente; ?>/contador-multiplex">Contar páginas Multiplex</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="botaoInsercao" href="./contador-insercao/">Contar páginas Inserção</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
