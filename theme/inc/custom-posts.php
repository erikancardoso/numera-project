<?php
include_once __DIR__ . "/acf-post-types.php";

//CPT Mapas
function adicionar_permissoes_personalizadas_para_subscriber() {
	$role = get_role('subscriber');

	if ($role) {
		$role->add_cap('edit_mapas');
		$role->add_cap('publish_mapas');
		$role->add_cap('edit_published_mapas');
		$role->add_cap('delete_mapas');
		$role->add_cap('delete_published_mapas');

		$role->add_cap('edit_posts');
		$role->add_cap('edit_published_posts');
	}
}
add_action('init', 'adicionar_permissoes_personalizadas_para_subscriber');

function restringir_visualizacao_mapa($query) {
	if (!is_admin() && $query->is_main_query() && $query->get('post_type') === 'mapas') {
		if (!current_user_can('administrator')) {
			$query->set('author', get_current_user_id());
		}
	}
}
add_action('pre_get_posts', 'restringir_visualizacao_mapa');


// Restringir a visualização de Placas ao autor
function restringir_visualizacao_placas($query) {
	if (!is_admin() && $query->is_main_query() && $query->get('post_type') === 'placas') {
		if (!current_user_can('administrator')) {
			$query->set('author', get_current_user_id());
		}
	}
}
add_action('pre_get_posts', 'restringir_visualizacao_placas');
