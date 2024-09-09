<?php
/* Template Name: Listagem de Mapas e Placas */

get_header(); ?>

<div class="container mx-auto p-4">
	<div class="flex justify-between items-center gap-4">
		<h1 class="text-2xl text-right font-bold">Listagem de Mapas e Placas</h1>
		<!-- Campo de busca -->
		<form id="search-map-form" method="get" action="<?php echo esc_url(home_url('/')); ?>" class="flex w-full justify-between items-center">
			<input type="hidden" name="post_type" value="mapas,placas">
			<input type="text" id="search-map" name="s" placeholder="Buscar Mapas e Placas..." class="px-6 py-4 border rounded-l-lg focus:outline-none w-full">
			<span class="dashicons dashicons-search absolute left-16"></span>
		</form>
	</div>

	<div id="mapas-list" class="bg-white shadow-md rounded-lg my-6">
		<table class="min-w-full bg-white">
			<thead>
			<tr>
				<th class="py-3 px-6 text-left text-sm font-medium text-gray-700 uppercase tracking-wider">Título</th>
				<th class="py-3 px-6 text-center text-sm font-medium text-gray-700 uppercase tracking-wider">Tipo</th>
				<th class="py-3 px-6 text-center text-sm font-medium text-gray-700 uppercase tracking-wider">Ações</th>
			</tr>
			</thead>
			<tbody id="mapas-table-body">
			<?php
			// Query para buscar tanto os mapas quanto as placas do usuário logado
			$current_user_id = get_current_user_id();
			$query = new WP_Query(array(
				'post_type' => array('mapas', 'placas'), // Incluindo os dois post types
				'author' => $current_user_id,
				'posts_per_page' => -1, // Exibe todos os posts
			));

			if ($query->have_posts()) :
				while ($query->have_posts()) : $query->the_post(); ?>
					<tr class="border-b">
						<td class="py-3 px-6 text-left"><?php the_title(); ?></td>
						<td class="py-3 px-6 text-center"><?php echo get_post_type() == 'mapas' ? 'Mapa' : 'Placa e Telefone'; ?></td>
						<td class="py-3 px-6 text-center">
							<div class="flex justify-center space-x-4">
								<!-- Botão Editar -->
								<a href="<?php the_permalink(); ?>" class="text-gray-600 hover:text-gray-800">
									<span class="dashicons dashicons-edit"></span>
								</a>

								<!-- Botão Baixar como Word (apenas para Mapas) -->
								<?php if (get_post_type() == 'mapas') : ?>
									<a href="<?php echo site_url('/download-word/?mapa_id=' . get_the_ID()); ?>" class="text-gray-600 hover:text-gray-800">
										<span class="dashicons dashicons-download"></span>
									</a>
								<?php endif; ?>

								<!-- Botão Baixar como PDF (apenas para Mapas) -->
								<?php if (get_post_type() == 'mapas') : ?>
									<a href="<?php echo site_url('/download-pdf/?mapa_id=' . get_the_ID()); ?>" class="text-gray-600 hover:text-gray-800">
										<span class="dashicons dashicons-media-document"></span>
									</a>
								<?php endif; ?>

								<!-- Botão Excluir -->
								<form method="post" action="" onsubmit="return confirm('Tem certeza que deseja excluir este item?');">
									<?php wp_nonce_field('delete_item_' . get_the_ID(), 'delete_item_nonce'); ?>
									<input type="hidden" name="item_id" value="<?php echo get_the_ID(); ?>">
									<button type="submit" name="delete_item" class="text-gray-600 hover:text-gray-800">
										<span class="dashicons dashicons-trash"></span>
									</button>
								</form>
							</div>
						</td>
					</tr>
				<?php endwhile;
			else : ?>
				<tr>
					<td class="py-3 px-6 text-center" colspan="3">Nenhum mapa ou placa encontrado.</td>
				</tr>
			<?php endif; ?>
			<?php wp_reset_postdata(); ?>
			</tbody>
		</table>
	</div>

	<div class="pagination mt-8">
		<?php
		// Paginação
		the_posts_pagination(array(
			'mid_size'  => 2,
			'prev_text' => __('&laquo; Anterior', 'numera_theme'),
			'next_text' => __('Próximo &raquo;', 'numera_theme'),
		));
		?>
	</div>
</div>

<?php
// Lógica para processar a exclusão de mapas ou placas
if (isset($_POST['delete_item'])) {
	$item_id = intval($_POST['item_id']);

	// Verifica o nonce para segurança
	if (wp_verify_nonce($_POST['delete_item_nonce'], 'delete_item_' . $item_id)) {
		// Exclui o post (mapa ou placa)
		wp_delete_post($item_id, true);

		// Redireciona para a página atual para atualizar a listagem
		wp_redirect(get_permalink());
		exit;
	} else {
		echo '<p class="error">Falha ao verificar a solicitação de exclusão. Tente novamente.</p>';
	}
}

get_footer();
?>

<script>
	document.addEventListener('DOMContentLoaded', function() {
		const searchInput = document.getElementById('search-map');
		const mapsList = document.getElementById('mapas-list');

		searchInput.addEventListener('input', function() {
			const searchTerm = searchInput.value;

			// Faz a requisição AJAX para buscar mapas e placas
			fetch('<?php echo admin_url('admin-ajax.php'); ?>?action=search_mapas&s=' + searchTerm)
				.then(response => response.text())
				.then(data => {
					mapsList.innerHTML = data;
				})
				.catch(error => console.error('Erro ao buscar mapas:', error));
		});
	});
</script>
