export async function processarMultiplex() {    

    try {
        const endPointDoController = '/FAP/src/Controller/MatrizMultiplex.php';
        const response = await fetch(endPointDoController);

        if (!response.ok) {
            throw new Error('Erro na requisição: ' + response.status);
        }

        const data = await response.json();

        if (data.success) {
            alert(data.message);
            window.location.href = '../contador-multiplex/'; // Redireciona para a página de cadastro de matriz
        } else {
            alert('Erro ao processar os arquivos: ' + data.message);
            window.location.href = '../contador-multiplex/';
        }
    } catch (error) {
        console.error('Erro ao enviar os arquivos:', error);
        alert('Ocorreu um erro ao enviar os arquivos. Por favor, tente novamente.');
        window.location.href = '../contador-multiplex/';
    }
}

