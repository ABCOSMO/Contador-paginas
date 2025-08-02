import { preencherForm, validarFormularioMatriz } from "./preencherForm.js";
import { enviarDadosMatriz } from "./enviarDadosMatriz.js"; 

preencherForm();
document.addEventListener('DOMContentLoaded', () => {
    const btnCadastrar = document.querySelector('button.btn-secondary');
    btnCadastrar.addEventListener('click', async () => {
        if (validarFormularioMatriz()) {
            await enviarDadosMatriz();
        }
    });
});

