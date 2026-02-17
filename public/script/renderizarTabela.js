import { botaoExcluir } from "./botaoExcluir.js";
export function renderizarTabela(listaParaRenderizar) {
    const corpoLista = document.querySelector('.corpo-lista');
    const corpoDaTabela = corpoLista.querySelector('tbody');

    if (!corpoDaTabela) {
        console.error('Corpo da tabela não encontrado.');
        return;
    }

    corpoDaTabela.innerHTML = ''; // Limpa o conteúdo do corpo da tabela
    let id = 1;

    if (listaParaRenderizar.length > 0) {
        listaParaRenderizar.forEach(lista => {
            const linha = document.createElement("tr");

            const primeiraColuna = document.createElement("th");
            primeiraColuna.classList.add("text-center");
            primeiraColuna.setAttribute("scope", "row");
            primeiraColuna.setAttribute("id", `${lista.matriz}`);
            primeiraColuna.textContent = id;
            linha.appendChild(primeiraColuna);

            const matriz = document.createElement("td");
            matriz.classList.add("text-center");
            matriz.textContent = lista.matriz;
            linha.appendChild(matriz);

            const servico = document.createElement("td");
            servico.classList.add("text-center");
            servico.textContent = lista.idTipoServico;
            linha.appendChild(servico);

            const acabamento = document.createElement("td");
            acabamento.classList.add("text-center");
            acabamento.textContent = lista.idTipoMatriz;
            linha.appendChild(acabamento);

            const arquivo = document.createElement("td");
            arquivo.classList.add("text-center");
            arquivo.textContent = lista.idTipoArquivo;
            linha.appendChild(arquivo);

            const paginas = document.createElement("td");
            paginas.classList.add("text-center");
            paginas.textContent = lista.idQtdPaginas;
            linha.appendChild(paginas);

            const complementar = document.createElement("td");
            complementar.classList.add("text-center");
            complementar.textContent = lista.idComplementar;
            linha.appendChild(complementar);

            const tdExcluir = document.createElement("td");
            const btnAcaoExcluir = document.createElement("button");
            btnAcaoExcluir.classList.add("border-0", "bg-transparent")
            tdExcluir.classList.add("text-center", "excluir");
            const lixeira = document.createElement("i");
            lixeira.classList.add("bi", "bi-trash-fill");
            
            btnAcaoExcluir.appendChild(lixeira);
            tdExcluir.appendChild(btnAcaoExcluir);
            linha.appendChild(tdExcluir);

            corpoDaTabela.appendChild(linha);
            id++;
        });
    } else {
        const linhaVazia = document.createElement("tr");
        const celulaMensagem = document.createElement("td");
        celulaMensagem.setAttribute("colspan", "8");
        celulaMensagem.classList.add("text-center");
        celulaMensagem.textContent = "Nenhuma matriz encontrada.";
        linhaVazia.appendChild(celulaMensagem);
        corpoDaTabela.appendChild(linhaVazia);
    }

    botaoExcluir();
}