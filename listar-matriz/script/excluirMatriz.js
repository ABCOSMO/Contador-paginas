export async function excluirMatriz(excluir) {
    const matrizExlcuir = excluir; //document.querySelector('exluir');
    
    try {
        const response = await fetch('/FAP/src/Controller/ExcluirMatriz.php', {
            method: 'POST',
             headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ matriz: matrizExlcuir })
        });

        if (!response.ok) {
            throw new Error('Erro na requisição: ' + response.status);
        }

        const data = await response.json();

        if (data.success) {
            alert(data.message);
            window.location.href = '../listar-matriz/'; // Redireciona para a página de cadastro de matriz
        } else {
            alert('Erro ao cadastrar a matriz: ' + data.message);
        }
    } catch (error) {
        console.error('Erro ao solicitar a exclusão da matriz:', error);
        alert('Ocorreu um erro ao solicitar a exclusão da matriz. Por favor, tente novamente.');
    }
}

