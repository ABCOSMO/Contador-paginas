import { excluirMatriz } from "./excluirMatriz.js";
export function botaoExcluir() {
      const botoesExcluir = document.querySelectorAll('.bi-trash-fill'); // Seleciona todos os ícones de lixeira

    botoesExcluir.forEach(botao => {
        botao.addEventListener('click', (event) => {
            // Encontra o 'id' da matriz a partir da célula pai do botão (ou de um atributo data-id)
            // No seu código, o ID está na 'th'
            const linha = event.target.closest('tr');
            const idExcluir = linha.querySelector('th').getAttribute('id');
            
            // Pergunta de confirmação com a mensagem correta
            if (confirm(`Tem certeza que deseja excluir a matriz ${idExcluir}?`)) {
                // Chama a função de exclusão com o ID
                excluirMatriz(idExcluir);
            }
        });
    });
}