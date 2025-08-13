import { processarInsercao } from "./processarInsercao.js"; 
const botaoProcessarMultiplex = document.querySelector('button.btn-primary');
document.addEventListener('DOMContentLoaded', () => {
    botaoProcessarMultiplex.addEventListener('click', async (event) => {
        event.preventDefault(); // Evita o comportamento padrão do botão
        await processarInsercao();
    });
});