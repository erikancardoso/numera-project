<?php
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

function create_mapas_cpt() {
	$labels = array(
		'name'                  => _x( 'Mapas', 'Post type general name', 'numera_theme' ),
		'singular_name'         => _x( 'Mapa', 'Post type singular name', 'numera_theme' ),
		'menu_name'             => _x( 'Mapas', 'Admin Menu text', 'numera_theme' ),
		'name_admin_bar'        => _x( 'Mapa', 'Add New on Toolbar', 'numera_theme' ),
		'add_new'               => __( 'Adicionar Novo', 'numera_theme' ),
		'add_new_item'          => __( 'Adicionar Novo Mapa', 'numera_theme' ),
		'new_item'              => __( 'Novo Mapa', 'numera_theme' ),
		'edit_item'             => __( 'Editar Mapa', 'numera_theme' ),
		'view_item'             => __( 'Ver Mapa', 'numera_theme' ),
		'all_items'             => __( 'Todos os Mapas', 'numera_theme' ),
		'search_items'          => __( 'Buscar Mapas', 'numera_theme' ),
		'parent_item_colon'     => __( 'Mapa Parente:', 'numera_theme' ),
		'not_found'             => __( 'Nenhum mapa encontrado.', 'numera_theme' ),
		'not_found_in_trash'    => __( 'Nenhum mapa encontrado na lixeira.', 'numera_theme' ),
		'featured_image'        => _x( 'Imagem Destacada', 'Overrides the “Featured Image” phrase for this post type', 'numera_theme' ),
		'set_featured_image'    => _x( 'Definir imagem destacada', 'Overrides the “Set featured image” phrase for this post type', 'numera_theme' ),
		'remove_featured_image' => _x( 'Remover imagem destacada', 'Overrides the “Remove featured image” phrase for this post type', 'numera_theme' ),
		'use_featured_image'    => _x( 'Usar como imagem destacada', 'Overrides the “Use as featured image” phrase for this post type', 'numera_theme' ),
		'archives'              => _x( 'Arquivos de Mapas', 'The post type archive label used in nav menus', 'numera_theme' ),
		'insert_into_item'      => _x( 'Inserir no mapa', 'Overrides the “Insert into post” phrase for this post type', 'numera_theme' ),
		'uploaded_to_this_item' => _x( 'Carregado para este mapa', 'Overrides the “Uploaded to this post” phrase for this post type', 'numera_theme' ),
		'filter_items_list'     => _x( 'Filtrar lista de mapas', 'Screen reader text for the filter links heading on the post type listing screen', 'numera_theme' ),
		'items_list_navigation' => _x( 'Navegação da lista de mapas', 'Screen reader text for the pagination heading on the post type listing screen', 'numera_theme' ),
		'items_list'            => _x( 'Lista de mapas', 'Screen reader text for the items list heading on the post type listing screen', 'numera_theme' ),
	);

	$args = array(
		'labels'             => $labels,
		'public'             => false,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'mapas' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title' ),
		'menu_icon'          => 'dashicons-location',
	);

	register_post_type( 'mapas', $args );
}
add_action( 'init', 'create_mapas_cpt' );

function mapas_add_meta_boxes() {
	add_meta_box(
		'mapas_details',
		__( 'Detalhes do Mapa', 'numera_theme' ),
		'mapas_render_meta_box_content',
		'mapas',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'mapas_add_meta_boxes' );

function mapas_render_meta_box_content( $post ) {
	wp_nonce_field( 'mapas_save_meta_box_data', 'mapas_meta_box_nonce' );

	$nome_completo = get_post_meta( $post->ID, '_mapas_nome_completo', true );
	$data_nascimento = get_post_meta( $post->ID, '_mapas_data_nascimento', true );

	echo '<label for="mapas_nome_completo">';
	_e( 'Nome Completo', 'numera_theme' );
	echo '</label> ';
	echo '<input type="text" id="mapas_nome_completo" name="mapas_nome_completo" value="' . esc_attr( $nome_completo ) . '" class="widefat" />';

	echo '<br><br>';

	echo '<label for="mapas_data_nascimento">';
	_e( 'Data de Nascimento', 'numera_theme' );
	echo '</label> ';
	echo '<input type="date" id="mapas_data_nascimento" name="mapas_data_nascimento" value="' . esc_attr( $data_nascimento ) . '" class="widefat" />';
}

function mapas_save_meta_box_data($post_id) {
	// Verifica se é uma revisão para evitar múltiplas gravações
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return;
	}

	// Verifica o tipo de post para garantir que estamos salvando um 'mapa'
	if (isset($_POST['post_type']) && 'mapas' === $_POST['post_type']) {

		// Verifica se o usuário tem permissão para editar o post
		if (!current_user_can('edit_post', $post_id)) {
			return;
		}

		// Verifica o nonce para garantir que a requisição é segura
		if (!isset($_POST['mapas_nonce']) || !wp_verify_nonce($_POST['mapas_nonce'], 'mapas_save_meta_box_data')) {
			return;
		}

		// Salvando o nome completo
		if (isset($_POST['name'])) {
			$nome_completo = sanitize_text_field($_POST['name']);
			update_post_meta($post_id, '_mapas_nome_completo', $nome_completo);
		}

		// Salvando a data de nascimento
		if (isset($_POST['dob'])) {
			$data_nascimento = sanitize_text_field($_POST['dob']);
			update_post_meta($post_id, '_mapas_data_nascimento', $data_nascimento);
		}

		// Se precisar salvar outros campos, você pode adicionar aqui da mesma forma
	}
}
add_action('save_post', 'mapas_save_meta_box_data');

function restringir_visualizacao_mapa($query) {
	if (!is_admin() && $query->is_main_query() && $query->get('post_type') === 'mapas') {
		if (!current_user_can('administrator')) {
			$query->set('author', get_current_user_id());
		}
	}
}
add_action('pre_get_posts', 'restringir_visualizacao_mapa');

function save_map_meta() {
	if (!isset($_POST['post_id'])) {
		error_log('ID do post não especificado.');
		wp_send_json_error('ID do post não especificado.');
	}

	$post_id = intval($_POST['post_id']);

	if (!current_user_can('edit_mapas', $post_id)) {
		error_log('Usuário não tem permissão para editar o post.');
		wp_send_json_error('Você não tem permissão para editar este post.');
	}

	$nome_completo = isset($_POST['nome_completo']) ? sanitize_text_field($_POST['nome_completo']) : '';
	$data_nascimento = isset($_POST['data_nascimento']) ? sanitize_text_field($_POST['data_nascimento']) : '';

	if (empty($nome_completo) || empty($data_nascimento)) {
		error_log('Dados inválidos recebidos.');
		wp_send_json_error('Dados inválidos.');
	}

	update_post_meta($post_id, '_mapas_nome_completo', $nome_completo);
	update_post_meta($post_id, '_mapas_data_nascimento', $data_nascimento);

	error_log('Metafields atualizados com sucesso.');
	wp_send_json_success('Metafields atualizados com sucesso.');
}
add_action('wp_ajax_save_map_meta', 'save_map_meta');

//CPT editar Placas
function adicionar_permissoes_personalizadas_para_placa() {
	$role = get_role('subscriber');

	if ($role) {
		$role->add_cap('edit_placas');
		$role->add_cap('publish_placas');
		$role->add_cap('edit_published_placas');
		$role->add_cap('delete_placas');
		$role->add_cap('delete_published_placas');
	}
}
add_action('init', 'adicionar_permissoes_personalizadas_para_placa');

// Criar o Custom Post Type 'Placa do veículo e telefone'
function create_placa_veiculo_cpt() {
	$labels = array(
		'name'                  => _x( 'Placas e Telefones', 'Post type general name', 'numera_theme' ),
		'singular_name'         => _x( 'Placa e Telefone', 'Post type singular name', 'numera_theme' ),
		'menu_name'             => _x( 'Placas e Telefones', 'Admin Menu text', 'numera_theme' ),
		'name_admin_bar'        => _x( 'Placa e Telefone', 'Add New on Toolbar', 'numera_theme' ),
		'add_new'               => __( 'Adicionar Novo', 'numera_theme' ),
		'add_new_item'          => __( 'Adicionar Nova Placa e Telefone', 'numera_theme' ),
		'new_item'              => __( 'Nova Placa e Telefone', 'numera_theme' ),
		'edit_item'             => __( 'Editar Placa e Telefone', 'numera_theme' ),
		'view_item'             => __( 'Ver Placa e Telefone', 'numera_theme' ),
		'all_items'             => __( 'Todas as Placas e Telefones', 'numera_theme' ),
		'search_items'          => __( 'Buscar Placas e Telefones', 'numera_theme' ),
		'not_found'             => __( 'Nenhuma placa encontrada.', 'numera_theme' ),
		'not_found_in_trash'    => __( 'Nenhuma placa encontrada na lixeira.', 'numera_theme' ),
	);

	$args = array(
		'labels'             => $labels,
		'public'             => false,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'placas' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title' ),
		'menu_icon'          => 'dashicons-car',
	);

	register_post_type( 'placas', $args );
}
add_action( 'init', 'create_placa_veiculo_cpt' );

// Adicionar Meta Boxes
function placas_add_meta_boxes() {
	add_meta_box(
		'placas_details',
		__( 'Detalhes da Placa e Telefone', 'numera_theme' ),
		'placas_render_meta_box_content',
		'placas',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'placas_add_meta_boxes' );

// Renderizar o conteúdo do Meta Box
function placas_render_meta_box_content( $post ) {
	wp_nonce_field( 'placas_save_meta_box_data', 'placas_meta_box_nonce' );

	$data_nascimento = get_post_meta( $post->ID, '_placas_data_nascimento', true );
	$numero_telefone = get_post_meta( $post->ID, '_placas_numero_telefone', true );
	$placa_veiculo   = get_post_meta( $post->ID, '_placas_placa_veiculo', true );

	echo '<label for="placas_data_nascimento">';
	_e( 'Data de Nascimento', 'numera_theme' );
	echo '</label> ';
	echo '<input type="date" id="placas_data_nascimento" name="placas_data_nascimento" value="' . esc_attr( $data_nascimento ) . '" class="widefat" />';

	echo '<br><br>';

	echo '<label for="placas_numero_telefone">';
	_e( 'Seu Número', 'numera_theme' );
	echo '</label> ';
	echo '<input type="text" id="placas_numero_telefone" name="placas_numero_telefone" value="' . esc_attr( $numero_telefone ) . '" class="widefat" />';

	echo '<br><br>';

	echo '<label for="placas_placa_veiculo">';
	_e( 'Placa do Veículo', 'numera_theme' );
	echo '</label> ';
	echo '<input type="text" id="placas_placa_veiculo" name="placas_placa_veiculo" value="' . esc_attr( $placa_veiculo ) . '" class="widefat" />';
}

// Função para salvar os dados do Meta Box
function placas_save_meta_box_data($post_id) {
	// Verifica se é uma revisão para evitar múltiplas gravações
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return;
	}

	// Verifica o tipo de post para garantir que estamos salvando uma 'placa'
	if (isset($_POST['post_type']) && 'placas' === $_POST['post_type']) {

		// Verifica se o usuário tem permissão para editar o post
		if (!current_user_can('edit_post', $post_id)) {
			return;
		}

		// Verifica o nonce para garantir que a requisição é segura
		if (!isset($_POST['placas_meta_box_nonce']) || !wp_verify_nonce($_POST['placas_meta_box_nonce'], 'placas_save_meta_box_data')) {
			return;
		}

		// Salvando os campos
		if (isset($_POST['placas_data_nascimento'])) {
			$data_nascimento = sanitize_text_field($_POST['placas_data_nascimento']);
			update_post_meta($post_id, '_placas_data_nascimento', $data_nascimento);
		}

		if (isset($_POST['placas_numero_telefone'])) {
			$numero_telefone = sanitize_text_field($_POST['placas_numero_telefone']);
			update_post_meta($post_id, '_placas_numero_telefone', $numero_telefone);
		}

		if (isset($_POST['placas_placa_veiculo'])) {
			$placa_veiculo = sanitize_text_field($_POST['placas_placa_veiculo']);
			update_post_meta($post_id, '_placas_placa_veiculo', $placa_veiculo);
		}
	}
}
add_action('save_post', 'placas_save_meta_box_data');

// Restringir a visualização de Placas ao autor
function restringir_visualizacao_placas($query) {
	if (!is_admin() && $query->is_main_query() && $query->get('post_type') === 'placas') {
		if (!current_user_can('administrator')) {
			$query->set('author', get_current_user_id());
		}
	}
}
add_action('pre_get_posts', 'restringir_visualizacao_placas');


//{
//	name: 'name',
//
//}
