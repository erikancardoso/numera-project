<?php

/**
 * numera_theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package numera_theme
 */

// echo '<pre>';
// var_dump(get_post_type(60));
// echo '</pre>';
// die();

if (! defined('NUMERA_THEME_VERSION')) {
	/*
	 * Set the theme’s version number.
	 *
	 * This is used primarily for cache busting. If you use `npm run bundle`
	 * to create your production build, the value below will be replaced in the
	 * generated zip file with a timestamp, converted to base 36.
	 */
	define('NUMERA_THEME_VERSION', '0.1.0');
}

if (! defined('NUMERA_THEME_TYPOGRAPHY_CLASSES')) {
	/*
	 * Set Tailwind Typography classes for the front end, block editor and
	 * classic editor using the constant below.
	 *
	 * For the front end, these classes are added by the `numera_theme_content_class`
	 * function. You will see that function used everywhere an `entry-content`
	 * or `page-content` class has been added to a wrapper element.
	 *
	 * For the block editor, these classes are converted to a JavaScript array
	 * and then used by the `./javascript/block-editor.js` file, which adds
	 * them to the appropriate elements in the block editor (and adds them
	 * again when they’re removed.)
	 *
	 * For the classic editor (and anything using TinyMCE, like Advanced Custom
	 * Fields), these classes are added to TinyMCE’s body class when it
	 * initializes.
	 */
	define(
		'NUMERA_THEME_TYPOGRAPHY_CLASSES',
		'prose prose-neutral max-w-none prose-a:text-primary'
	);
}

if (! function_exists('numera_theme_setup')) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function numera_theme_setup()
	{
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on numera_theme, use a find and replace
		 * to change 'numera_theme' to the name of your theme in all the template files.
		 */
		load_theme_textdomain('numera_theme', get_template_directory() . '/languages');

		// Add default posts and comments RSS feed links to head.
		add_theme_support('automatic-feed-links');

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support('title-tag');

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support('post-thumbnails');

		// This theme uses wp_nav_menu() in two locations.
		register_nav_menus(
			array(
				'menu-1' => __('Primary', 'numera_theme'),
				'menu-2' => __('Footer Menu', 'numera_theme'),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support('customize-selective-refresh-widgets');

		// Add support for editor styles.
		add_theme_support('editor-styles');

		// Enqueue editor styles.
		add_editor_style('style-editor.css');
		add_editor_style('style-editor-extra.css');

		// Add support for responsive embedded content.
		add_theme_support('responsive-embeds');

		// Remove support for block templates.
		remove_theme_support('block-templates');
	}
endif;
add_action('after_setup_theme', 'numera_theme_setup');

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function numera_theme_widgets_init()
{
	register_sidebar(
		array(
			'name'          => __('Footer', 'numera_theme'),
			'id'            => 'sidebar-1',
			'description'   => __('Add widgets here to appear in your footer.', 'numera_theme'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action('widgets_init', 'numera_theme_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function numera_theme_scripts()
{
	wp_enqueue_style('numera_theme-style', get_stylesheet_uri(), array(), NUMERA_THEME_VERSION);
	wp_enqueue_script('numera_theme-script', get_template_directory_uri() . '/js/script.min.js', array(), NUMERA_THEME_VERSION, true);

	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}
add_action('wp_enqueue_scripts', 'numera_theme_scripts');

/**
 * Enqueue the block editor script.
 */
function numera_theme_enqueue_block_editor_script()
{
	if (is_admin()) {
		wp_enqueue_script(
			'numera_theme-editor',
			get_template_directory_uri() . '/js/block-editor.min.js',
			array(
				'wp-blocks',
				'wp-edit-post',
			),
			NUMERA_THEME_VERSION,
			true
		);
		wp_add_inline_script('numera_theme-editor', "tailwindTypographyClasses = '" . esc_attr(NUMERA_THEME_TYPOGRAPHY_CLASSES) . "'.split(' ');", 'before');
	}
}
add_action('enqueue_block_assets', 'numera_theme_enqueue_block_editor_script');

/**
 * Add the Tailwind Typography classes to TinyMCE.
 *
 * @param array $settings TinyMCE settings.
 * @return array
 */
function numera_theme_tinymce_add_class($settings)
{
	$settings['body_class'] = NUMERA_THEME_TYPOGRAPHY_CLASSES;
	return $settings;
}
add_filter('tiny_mce_before_init', 'numera_theme_tinymce_add_class');

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

//--------------------------------------------------------------------------------------------------------------

function enqueue_dashicons()
{
	wp_enqueue_style('dashicons');
}
add_action('wp_enqueue_scripts', 'enqueue_dashicons');

function enqueue_scripts()
{
	wp_enqueue_script('my-custom-script', get_template_directory_uri() . '/js/custom-script.js', array('jquery'), null, true);

	// Localize script para passar o nonce ao JavaScript
	wp_localize_script('my-custom-script', 'my_ajax_obj', array(
		'ajax_url' => admin_url('admin-ajax.php'),
		'nonce'    => wp_create_nonce('create_map_nonce')
	));
}
add_action('wp_enqueue_scripts', 'enqueue_scripts');


require get_template_directory() . '/inc/Numerologia.php';

// Função para restringir o acesso a membros logados
function restrict_access_to_members()
{
	if (!is_user_logged_in() && !is_page('login')) {
		wp_redirect(site_url('/login/'));
		exit();
	}
}
add_action('template_redirect', 'restrict_access_to_members');

// Registro de posts customizados
require get_template_directory() . '/inc/custom-posts.php';

// Função para criar um novo mapa via AJAX
function create_map_ajax_handler()
{
	// Verifique o nonce
	if (!isset($_POST['security']) || !wp_verify_nonce($_POST['security'], 'create_map_nonce')) {
		wp_send_json_error('Verificação de segurança falhou, por favor tente novamente.');
		return;
	}

	// Verifique a permissão do usuário atual
	if (!current_user_can('edit_mapas')) {
		wp_send_json_error('Você não tem permissão para criar mapas.');
		return;
	}

	// Obtenha os dados do formulário
	$title = sanitize_text_field($_POST['title']);
	$name = sanitize_text_field($_POST['name']);
	$dob = sanitize_text_field($_POST['dob']);

	// Verifique se já existe um mapa com o mesmo título
	$existing_map = get_page_by_title($title, OBJECT, 'mapas');

	if ($existing_map) {
		wp_send_json_error('Já existe um mapa com este título. Por favor, escolha um título diferente.');
		return;
	}

	// Crie o post do tipo 'mapas'
	$map_id = wp_insert_post(array(
		'post_title' => $title,
		'post_type' => 'mapas',
		'post_status' => 'publish',
		'post_author' => get_current_user_id(),
	));

	if (is_wp_error($map_id) || $map_id === 0) {
		wp_send_json_error('Erro ao criar o mapa.');
	} else {
		// Adicione os metadados ao post criado
		update_post_meta($map_id, '_mapas_nome_completo', $name);
		update_post_meta($map_id, '_mapas_data_nascimento', $dob);

		wp_send_json_success(array(
			'redirect_url' => get_permalink($map_id),
		));
	}
}
add_action('wp_ajax_create_map', 'create_map_ajax_handler');

// Função para criar uma nova placa via AJAX
function create_placa_ajax_handler()
{
	// Verifique o nonce
	if (!isset($_POST['security']) || !wp_verify_nonce($_POST['security'], 'create_placa_nonce')) {
		wp_send_json_error('Verificação de segurança falhou, por favor tente novamente.');
		return;
	}

	// Verifique a permissão do usuário atual
	if (!current_user_can('edit_placas')) {
		wp_send_json_error('Você não tem permissão para criar placas.');
		return;
	}

	// Obtenha os dados do formulário
	$title = sanitize_text_field($_POST['title']);
	$dob = sanitize_text_field($_POST['dob']);
	$numero_telefone = sanitize_text_field($_POST['numero_telefone']);
	$placa_veiculo = sanitize_text_field($_POST['placa_veiculo']);

	// Verifique se já existe uma placa com o mesmo título
	$existing_placa = get_page_by_title($title, OBJECT, 'placas');

	if ($existing_placa) {
		wp_send_json_error('Já existe uma placa com este título. Por favor, escolha um título diferente.');
		return;
	}

	// Crie o post do tipo 'placas'
	$placa_id = wp_insert_post(array(
		'post_title' => $title,
		'post_type' => 'placas',
		'post_status' => 'publish',
		'post_author' => get_current_user_id(),
	));

	if (is_wp_error($placa_id) || $placa_id === 0) {
		wp_send_json_error('Erro ao criar a placa.');
	} else {
		// Adicione os metadados ao post criado
		update_post_meta($placa_id, '_placas_data_nascimento', $dob);
		update_post_meta($placa_id, '_placas_numero_telefone', $numero_telefone);
		update_post_meta($placa_id, '_placas_placa_veiculo', $placa_veiculo);

		wp_send_json_success(array(
			'redirect_url' => get_permalink($placa_id),
		));
	}
}
add_action('wp_ajax_create_placa', 'create_placa_ajax_handler');


// Função para baixar o conteúdo do mapa em formato Word
function download_word()
{
	if (isset($_GET['mapa_id'])) {
		$mapa_id = intval($_GET['mapa_id']);
		$mapa_title = get_the_title($mapa_id);
		$mapa_content = apply_filters('the_content', get_post_field('post_content', $mapa_id));

		// Detalhes de numerologia
		$nome_completo = get_post_meta($mapa_id, '_mapas_nome_completo', true);
		$data_nascimento = get_post_meta($mapa_id, '_mapas_data_nascimento', true);

		// Instancia a classe de numerologia
		$numerologia = new Numerologia();

		// Cálculos numerológicos
		$numero_destino = $numerologia->calcularNumeroDestino($data_nascimento);
		$numero_expressao = $numerologia->calcularNumeroExpressao($nome_completo);
		$numero_motivacao = $numerologia->calcularNumeroMotivacao($nome_completo);

		// Configurações do Word
		header("Content-type: application/vnd.ms-word");
		header("Content-Disposition: attachment;Filename={$mapa_title}.doc");

		echo "<html>";
		echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">";
		echo "<body>";
		echo "<h1>{$mapa_title}</h1>";
		echo "<h2>Detalhes Numerológicos</h2>";
		echo "<p><strong>Nome Completo:</strong> {$nome_completo}</p>";
		echo "<p><strong>Data de Nascimento:</strong> {$data_nascimento}</p>";
		echo "<p><strong>Número de Destino:</strong> {$numero_destino}</p>";
		echo "<p><strong>Número de Expressão:</strong> {$numero_expressao}</p>";
		echo "<p><strong>Número de Motivação:</strong> {$numero_motivacao}</p>";
		echo "<h2>Conteúdo</h2>";
		echo $mapa_content;
		echo "</body>";
		echo "</html>";
		exit;
	}
}
add_action('init', 'download_word');

// Função para baixar o conteúdo do mapa em formato PDF
use Dompdf\Dompdf;
use Dompdf\Options;

function download_pdf()
{
	if (isset($_GET['mapa_id'])) {
		$mapa_id = intval($_GET['mapa_id']);
		$mapa_content = apply_filters('the_content', get_post_field('post_content', $mapa_id));
		$mapa_title = get_the_title($mapa_id);

		// Configurações do Dompdf
		$options = new Options();
		$options->set('isHtml5ParserEnabled', true);
		$options->set('isRemoteEnabled', true);

		// Inicializa o Dompdf e carrega o HTML
		$dompdf = new Dompdf($options);
		$html = '<h1>' . $mapa_title . '</h1>' . $mapa_content;
		$dompdf->loadHtml($html);

		// Configura o tamanho do papel e a orientação
		$dompdf->setPaper('A4', 'portrait');

		// Renderiza o HTML como PDF
		$dompdf->render();

		// Envia o PDF gerado para o navegador (1 = download)
		$dompdf->stream('mapa.pdf', array("Attachment" => 1));
		exit;
	}
}
add_action('init', 'download_pdf');

// Função para bloquear o acesso ao admin para assinantes e redirecioná-los
function block_wp_admin_access()
{
	if (current_user_can('subscriber') && (is_admin() || strpos($_SERVER['PHP_SELF'], 'wp-login.php') !== false)) {
		wp_redirect(home_url());
		exit;
	}
}
add_action('init', 'block_wp_admin_access');

// Função para salvar os metadados dos mapas
function salvar_meta_mapas()
{
	check_ajax_referer('salvar_meta_mapas_nonce', 'security');

	$post_id = intval($_POST['post_id']);
	$nome_completo = sanitize_text_field($_POST['nome_completo']);
	$data_nascimento = sanitize_text_field($_POST['data_nascimento']);

	// Atualiza os campos personalizados
	update_post_meta($post_id, '_mapas_nome_completo', $nome_completo);
	update_post_meta($post_id, '_mapas_data_nascimento', $data_nascimento);

	wp_send_json_success(array('message' => 'Mapa salvo com sucesso!'));
}
add_action('wp_ajax_save_map_meta', 'salvar_meta_mapas');

function salvar_meta_placas()
{
	check_ajax_referer('salvar_meta_placas_nonce', 'security');

	$post_id = intval($_POST['post_id']);
	$data_nascimento = sanitize_text_field($_POST['data_nascimento']);
	$numero_telefone = sanitize_text_field($_POST['numero_telefone']);
	$placa_veiculo = sanitize_text_field($_POST['placa_veiculo']);

	// Atualiza os campos personalizados
	update_post_meta($post_id, '_placas_data_nascimento', $data_nascimento);
	update_post_meta($post_id, '_placas_numero_telefone', $numero_telefone);
	update_post_meta($post_id, '_placas_placa_veiculo', $placa_veiculo);

	wp_send_json_success(array('message' => 'Placa salva com sucesso!'));
}
add_action('wp_ajax_save_placa_meta', 'salvar_meta_placas');


// Função para remover a barra de administração para usuários não administradores
function remover_admin_bar_para_usuarios()
{
	if (!current_user_can('administrator') && !is_admin()) {
		show_admin_bar(false);
	}
}
add_action('after_setup_theme', 'remover_admin_bar_para_usuarios');

function search_mapas()
{
	// Verifica se o usuário está logado
	if (!is_user_logged_in()) {
		wp_send_json_error('Você precisa estar logado para ver seus mapas.');
		wp_die();
	}

	$current_user_id = get_current_user_id();
	$search_term = isset($_GET['s']) ? sanitize_text_field($_GET['s']) : '';

	// Query personalizada para buscar mapas criados pelo usuário logado
	$args = array(
		'post_type' => 'mapas',
		's' => $search_term,
		'author' => $current_user_id, // Filtra pelos mapas do usuário logado
	);

	$query = new WP_Query($args);

	if ($query->have_posts()) {
		echo '<table class="min-w-full bg-white shadow-md rounded-lg">';
		echo '<thead><tr><th class="py-3 px-6 text-left text-sm font-medium text-gray-700 uppercase tracking-wider">Título</th>';
		echo '<th class="py-3 px-6 text-center text-sm font-medium text-gray-700 uppercase tracking-wider">Ações</th></tr></thead>';
		echo '<tbody id="mapas-table-body">';
		while ($query->have_posts()) {
			$query->the_post();
			echo '<tr class="border-b">';
			echo '<td class="py-3 px-6 text-left">' . get_the_title() . '</td>';
			echo '<td class="py-3 px-6 text-center">
					<div class="flex justify-center space-x-4">
						<a href="' . esc_url(get_edit_post_link(get_the_ID())) . '" class="text-gray-600 hover:text-gray-800">
							<span class="dashicons dashicons-edit"></span>
						</a>
						<a href="' . esc_url(get_permalink(get_the_ID())) . '" class="text-gray-600 hover:text-gray-800">
							<span class="dashicons dashicons-download"></span>
						</a>
						<form method="post" action="" onsubmit="return confirm(\'Tem certeza que deseja excluir este mapa?\');" class="inline">
							' . wp_nonce_field('delete_mapa_' . get_the_ID(), 'delete_mapa_nonce', true, false) . '
							<input type="hidden" name="mapa_id" value="' . get_the_ID() . '">
							<button type="submit" name="delete_mapa" class="text-gray-600 hover:text-gray-800">
								<span class="dashicons dashicons-trash"></span>
							</button>
						</form>
					</div>
				</td>';
			echo '</tr>';
		}
		echo '</tbody></table>';
	} else {
		echo '<p>Nenhum mapa encontrado.</p>';
	}

	wp_die(); // Termina a execução do script
}
add_action('wp_ajax_search_mapas', 'search_mapas');
add_action('wp_ajax_nopriv_search_mapas', 'search_mapas');
