document.addEventListener('click', () => {
	const aguardar = document.getElementById('aguardar');

	if(aguardar){
		aguardar.remove();
		console.log('tela escondida');
	}
	
});