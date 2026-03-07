 <?php $this->layout('layout'); ?>

 <section class="h-100 d-flex align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 d-flex flex-column align-items-center">
                    <div class="card" style="width: 30rem;">
                        <div class="card-body">
                            <h5 class="card-title">Contar Páginas Inserção</h5>
                            <h6 class="card-subtitle mb-2 text-body-secondary">Conta apenas as págians dos arquivos
                                Inserção</h6>
                            <p class="card-text">Primeiro coloque os arquivos na pasta do ZIP do Inserção e depois
                                aperte o botão abaixo.</p>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary mt-3" id="botaoProcessarMultiplex"
                        data-bs-toggle="modal" data-bs-target="#Insercao">
                        Processar Arquivos Inserção
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!--Modal Inserção-->
    <div class=" modal fade" id="Insercao" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" tabindex="-1" aria-labelledby="..." aria-hidden="true">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Arquivos em processamento</h1>
                    <!--<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>-->
                </div>
                <div class="modal-body">
                    <div class="d-flex align-items-center">
                        <strong role="status">Aguarde...</strong>
                        <div class="spinner-border ms-auto" aria-hidden="true"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <!--<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>-->
                </div>
            </div>
        </div>
    </div>
    <!--Final do Modal Inserção-->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous">
    </script>
    <script src="./script/scriptInsercao.js" type="module"></script>