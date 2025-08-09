<!DOCTYPE html>
<html lang="pt-br">

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

<body>

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
                        <a class="nav-link active" aria-current="page" href="../">Home</a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Menu Matrizes
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="./">Cadastrar Matriz</a></li>
                            <li><a class="dropdown-item" href="#">Alterar Matriz</a></li>
                            <li><a class="dropdown-item" href="#">Excluir Matriz</a></li>
                            <li><a class="dropdown-item" href="#">Listar Matrizes</a></li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" id="botaoMultiplex" data-bs-toggle="modal" data-bs-target="#Multiplex"
                            href="#">Contar páginas Multiplex</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="botaoInsercao" href="#">Contar páginas Inserção</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="modal" data-bs-target="#BancoDoBrasil" href="#">
                            Gerar arquivo BB</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="my-5">
        <div class="text-bg-light p-3 border">
            <h3>Cadastrar Matriz</h1>
        </div>
        <div class="container my-5">
            <form>

                <div class="row g-3">
                    <div class="form-floating col-md-4">
                        <input type="text" class="form-control" id="matriz" name="matriz" placeholder="32222">
                        <label for="matriz">Digitar Matriz</label>
                    </div>

                    <div class="form-floating col-md-4">
                        <select class="form-select" id="tipoServico" name="tipoServico" aria-label="Digitar o Serviço Contratado">
                            <option value="" selected>Selecionar Serviço</option>
                            <option value="1">Registrado</option>
                            <option value="2">Registrado com AR Digital</option>
                        </select>
                        <label for="tipoServico">Tipo de serviço</label>
                    </div>

                    <div class="form-floating col-md-4">
                        <select class="form-select" id="tipoMatriz" name="tipoMatriz" aria-label="Selecionar Acabamento">
                            <option value="" selected>Selecionar Acabamento</option>
                            <option value="1">Multiplex</option>
                            <option value="2">Inserção</option>
                        </select>
                        <label for="tipoMatriz">Tipo de Acabamento</label>
                    </div>
                </div>

                <div class="row g-3 my-3">

                    <div class="form-floating col-md-4">
                        <select class="form-select" id="tipoArquivo" name="tipoArquivo" aria-label="Digitar o número da matriz">
                            <option value="" selected>Selecionar Arquivo</option>
                            <option value="1">TXT</option>
                            <option value="2">XML</option>
                        </select>
                        <label for="tipoArquivo">Tipo de arquivo</label>
                    </div>

                    <div class="form-floating col-md-4">
                        <select class="form-select" id="complementar" name="complementar" aria-label="Selecionar Arquivo Complementar">
                            <option value="" selected>Selecionar Complementar</option>
                            <option value="1">Um arquivo complementar</option>
                            <option value="2">Dois arquivos complementares</option>
                            <option value="3">Sem arquivo complementar</option>
                        </select>
                        <label for="complementar">Arquivo complementar por objeto</label>
                    </div>

                    <div class="form-floating col-md-4">
                        <select class="form-select" id="qtdPaginas" name="qtdPaginas" aria-label="Selecionar Quantidade de Páginas">
                            <option value="" selected>Selecionar Qtde Páginas</option>
                            <option value="1">Variável</option>
                            <option value="2">Duas páginas</option>
                            <option value="3">Três páginas</option>
                            <option value="4">Quatro páginas</option>
                            <option value="5">Cinco páginas</option>
                            <option value="6">Seis páginas</option>
                            <option value="7">Sete páginas</option>
                        </select>
                        <label for="qtdPaginas">Quanitdade de páginas</label>
                    </div>

                   <div id="liveAlertPlaceholder"></div>
                   

                    <button type="button" class="container btn btn-secondary col-md-3 my-5" id="liveAlertBtn">Cadastrar Matriz</button>

                </div>

            </form>

    </section>

    <!--Modal Multiplex-->
    <div class="modal fade" id="Multiplex" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" tabindex="-1" aria-labelledby="..." aria-hidden="true">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Arquivos em processamento</h1>
                    <!--<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>-->
                </div>
                <div class="modal-body">
                    <div class="d-flex align-items-center">
                        <strong role="status">Loading...</strong>
                        <div class="spinner-border ms-auto" aria-hidden="true"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <!--<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>-->
                </div>
            </div>
        </div>
    </div>
    <!--Final do Modal Multiplex-->

    <!--Modal BancoDoBrasil-->
    <div class="modal fade" id="BancoDoBrasil" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" tabindex="-1" aria-labelledby="..." aria-hidden="true">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <!--Final do Modal BancoDoBrasil-->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous">
    </script>
    <script src="./script/script.js" type="module"></script>
</body>

</html>