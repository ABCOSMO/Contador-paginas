function apenasNumeros(matriz) {
    // Remove todos os caracteres não numéricos
    return matriz.replace(/\D/g, "");
}

export function preencherForm() {
    // Conferindo no input os dados lançados
    let inputMatriz = document.getElementById('matriz');
   
    inputMatriz.addEventListener('input', () => {
        inputMatriz.value = apenasNumeros(inputMatriz.value);
    });

    return inputMatriz.value;
}

export function validarFormularioMatriz() {
    const inputMatriz = document.getElementById('matriz');
    const inputArquivo = document.getElementById('tipoArquivo');
    const inputTipoMatriz = document.getElementById('tipoMatriz');
    const inputComplementar = document.getElementById('complementar');
    const inputQtdPaginas = document.getElementById('qtdPaginas');

    if (!inputMatriz.value || !inputArquivo.value || !inputTipoMatriz.value || !inputComplementar.value || !inputQtdPaginas.value) {
        alert('Por favor, preencha todos os campos obrigatórios.');
        return false;
    }

    return true;
}

