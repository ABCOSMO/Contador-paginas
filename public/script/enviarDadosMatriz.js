export async function enviarDadosMatriz() {
    const form = document.querySelector('form');
    const formData = new FormData(form);

    try {
        const response = await fetch('/cadastrar-nova-matriz', {
            method: 'POST',
            body: formData
        });

        if (!response.ok) {
            throw new Error('Erro na requisição: ' + response.status);
        }

        const data = await response.json();

        if (data.success) {
            alert(data.message);
            window.location.href = '/cadastrar-matriz'; // Redireciona para a página de cadastro de matriz
        } else {
            alert('Erro ao cadastrar a matriz: ' + data.message);
        }
    } catch (error) {
        console.error('Erro ao enviar os dados:', error);
        alert('Ocorreu um erro ao enviar os dados. Por favor, tente novamente.');
    }
}

