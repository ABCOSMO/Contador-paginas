/**
 * Filtra a lista de matrizes com base no valor de busca.
 * @param {Array} listaCompleta - A lista completa de matrizes.
 * @param {string} termoBusca - O termo a ser usado para a busca.
 * @returns {Array} Um novo array contendo apenas os itens que correspondem à busca.
 */
export function buscarMatriz(listaCompleta, termoBusca) {
    if (!termoBusca || termoBusca.trim() === '') {
        return listaCompleta;
    }

    const termo = termoBusca.trim();

    return listaCompleta.filter(matriz => {
        // Converte o número da matriz para string antes de usar 'includes'
        return String(matriz.matriz).includes(termo);
    });
}