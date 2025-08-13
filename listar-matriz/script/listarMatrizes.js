import { buscarMatriz } from "./buscarMatrizes.js";
import { renderizarTabela } from "./renderizarTabela.js";

// Variável para armazenar a lista completa de matrizes
let matrizesCompletas = [];

export async function listarMatrizes() {
    const corpoLista = document.querySelector('.corpo-lista');
    corpoLista.innerHTML = ""; // Limpa a div para reconstruir

    try {
        const response = await fetch('/FAP/src/Controller/ListarMatriz.php');

        if (!response.ok) {
            throw new Error('Erro na requisição: ' + response.status);
        }

        const dados = await response.json();
        matrizesCompletas = dados.data; // Atribui a lista de dados à variável global

        // Cria e adiciona o campo de busca
        const inputDiv = document.createElement("div");
        inputDiv.classList.add("input-group", "mb-3");

        const inputSpan = document.createElement("span");
        inputSpan.classList.add("input-group-text");
        inputSpan.setAttribute("id", "basic-addon1");
        inputSpan.textContent = "Buscar Matriz";
        inputDiv.appendChild(inputSpan);
        
        const inputBuscar = document.createElement("input");
        inputBuscar.setAttribute("type", "text");
        inputBuscar.classList.add("form-control");
        inputBuscar.setAttribute("placeholder", "Digitar número da matriz");
        inputBuscar.setAttribute("aria-label", "Buscar Matriz");
        inputBuscar.setAttribute("aria-describedby", "basic-addon1");
        inputDiv.appendChild(inputBuscar);

        // Adiciona a div de busca ao DOM antes da tabela
        corpoLista.appendChild(inputDiv);

        // Adiciona um ouvinte de evento para a busca
        inputBuscar.addEventListener('input', (evento) => {
            const termoDeBusca = evento.target.value;
            const resultadosFiltrados = buscarMatriz(matrizesCompletas, termoDeBusca);
            renderizarTabela(resultadosFiltrados); // Renderiza a tabela com os resultados
        });
        
        // Cria a estrutura da tabela
        const tabela = document.createElement("table");
        tabela.classList.add("table", "table-striped");
        
        const cabecalhoDaTabela = document.createElement("thead");
        const linhaDoCabecalho = document.createElement("tr");
        const titulos = ["#", "Matriz", "Serviço", "Acabamento", "Arquivo", "Qtde Páginas", "Arq. Complementar", "Excluir Matriz"];

        titulos.forEach(titulo => {
            const colunaDoCabecalho = document.createElement("th");
            colunaDoCabecalho.classList.add("text-center");
            colunaDoCabecalho.setAttribute("scope", "col");
            colunaDoCabecalho.textContent = titulo;
            linhaDoCabecalho.appendChild(colunaDoCabecalho);
        });

        cabecalhoDaTabela.appendChild(linhaDoCabecalho);
        tabela.appendChild(cabecalhoDaTabela);

        // Cria o corpo da tabela e o anexa, mas não o preenche ainda
        const corpoDaTabela = document.createElement("tbody");
        tabela.appendChild(corpoDaTabela);

        corpoLista.appendChild(tabela);

        // Chama a função de renderização inicial com a lista completa
        renderizarTabela(matrizesCompletas);

    } catch (error) {
        console.error('Erro ao enviar os dados:', error);
        alert('Ocorreu um erro ao enviar os dados. Por favor, tente novamente.');
    }
}