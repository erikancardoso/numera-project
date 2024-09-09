document.getElementById('create-map-form').addEventListener('submit', function(e) {
	e.preventDefault();

	let data = new FormData(this); // Coleta todos os dados do formulário
	data.append('action', 'create_map');
	data.append('security', my_ajax_obj.nonce); // Adiciona o nonce

	fetch(my_ajax_obj.ajax_url, {
		method: 'POST',
		body: data
	})
		.then(response => {
			if (!response.ok) {
				throw new Error(`HTTP error! status: ${response.status}`);
			}
			return response.json();
		})
		.then(data => {
			if (data.success) {
				window.location.href = data.data.redirect_url;
			} else {
				console.error('Erro ao criar o mapa:', data);
				alert('Já existe um mapa com este título. Por favor, escolha um título diferente.');
			}
		})
		.catch(error => {
			console.error('Erro ao processar a solicitação:', error);
			alert('Erro ao criar o mapa.');
		});
});

