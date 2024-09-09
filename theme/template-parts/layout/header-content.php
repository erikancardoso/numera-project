<?php
/**
 * Template part for displaying the header content
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package numera_theme
 */

?>

<header id="masthead" class="bg-white text-black p-4 shadow-md">
	<div class="container mx-auto flex justify-between items-center">
		<!-- Logo -->
		<div class="text-lg font-bold">
			<a href="<?php echo esc_url(home_url('/')); ?>">
				<img id="logo-superior" src="<?php echo get_template_directory_uri(); ?>/images/logo.png" alt="<?php bloginfo('name'); ?>" class="h-10">
			</a>
		</div>

		<!-- User Profile and Menu Toggle -->
		<div class="flex gap-[20px] items-center">
			<div class="relative group">
				<div class="flex items-center space-x-4 p-2">
					<img src="<?php echo get_avatar_url(get_current_user_id(), ['size' => '64']); ?>" alt="Foto de perfil" class="w-10 h-10 rounded-full cursor-pointer">
					<div>
						<h2 class="text-lg font-semibold">Olá, <?php echo wp_get_current_user()->display_name; ?>!</h2>
						<p class="text-gray-600">Seja bem-vindo(a)!</p>
					</div>
				</div>

				<!-- Dropdown Menu -->
				<div class="absolute right-0 mt-2 w-full bg-white border border-gray-200 rounded-lg shadow-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300 ease-in-out">
					<a href="<?php echo esc_url(home_url('/perfil')); ?>" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-t-lg">Meu Perfil</a>
					<a href="<?php echo wp_logout_url(home_url()); ?>" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-b-lg">Logout</a>
				</div>
			</div>
			<button id="menu-toggle" aria-controls="primary-menu" aria-expanded="false" class="focus:outline-none lg:hidden">
				<svg class="w-8 h-8 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
				</svg>
			</button>
		</div>
	</div>
</header>

<!-- Sidebar Menu (Fixo no Desktop, Off-Canvas no Mobile) -->
<div id="offcanvas-backdrop" class="fixed inset-0 bg-gray-900 bg-opacity-75 z-40 hidden lg:hidden"></div>
<div id="offcanvas-menu" class="fixed lg:relative inset-y-0 left-0 w-64 bg-white flex flex-col justify-between h-full shadow-lg transform -translate-x-full transition-transform duration-300 ease-in-out z-50">
	<div>
		<button id="close-menu" class="text-black p-4 focus:outline-none lg:hidden">
			<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
			</svg>
		</button>
		<div class="flex justify-center mt-4 mb-4">
			<a href="<?php echo esc_url(home_url('/')); ?>">
				<img class="w-40" src="<?php echo get_template_directory_uri() . '/images/logo.png' ?>" alt="">
			</a>
		</div>
		<div class="p-4">
			<button id="create-map-button" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none">
				Criar Mapa
			</button>
			<button id="create-placa-button" class="w-full bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700 focus:outline-none mt-4">
				Criar Placa e Telefone
			</button>
			<a href="<?php echo get_post_type_archive_link('mapas'); ?>" class="mt-4 w-full inline-block bg-blue-600 text-white py-2 px-4 rounded-md text-center hover:bg-blue-700 focus:outline-none">
				Ver Mapas
			</a>
		</div>
	</div>
	<div class="container mx-auto p-2">
		<div class="text-center bg-white rounded shadow-md text-2xl flex flex-col">
			<?php
			$numera_theme_blog_info = get_bloginfo( 'name' );
			if ( ! empty( $numera_theme_blog_info ) ) :
				?>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="font-bold text-xl link-footer"><?php bloginfo( 'name' ); ?><br></a>
			<?php
			endif;

			/* translators: 1: WordPress link, 2: WordPress. */
			printf(
				'<a class="text-sm link-kdevs p-2 text-gray-300" href="%1$s">Proudly powered by %2$s</a>',
				esc_url( __( 'https://wordpress.org/', 'numera_theme' ) ),
				'Kdevs'
			);
			?>
		</div>
		<style>
			.link-footer{
				color: #43265F;
			}
			.link-kdevs{
				color: #a8a8a8;
			}
		</style>
	</div>
</div>

<!-- Main Content Area -->
<div id="content" class="main-content">
	<!-- Seu conteúdo principal vai aqui -->
</div>

<!-- Popup Modal para Criar Mapa -->
<div id="create-map-modal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50 hidden">
	<div class="bg-white p-6 rounded-lg shadow-lg w-96 relative">
		<h2 class="text-2xl font-bold mb-4">Criar Novo Mapa</h2>
		<form id="create-map-form" method="post" class="space-y-4">
			<div>
				<label for="map-title" class="block text-sm font-medium text-gray-700">Título do Mapa</label>
				<input type="text" id="map-title" name="title" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
			</div>
			<div>
				<label class="block text-sm font-medium text-gray-700">Tipo de Mapa</label>
				<div class="mt-1 flex items-center">
					<input type="radio" name="type" value="mapa" checked class="mr-2">
					<span>Mapa</span>
				</div>
			</div>
			<div id="map-fields">
				<div>
					<label for="map-name" class="block text-sm font-medium text-gray-700">Nome Completo</label>
					<input type="text" id="map-name" name="name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
				</div>
				<div>
					<label for="map-dob" class="block text-sm font-medium text-gray-700">Data de Nascimento</label>
					<input type="date" id="map-dob" name="dob" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
				</div>
			</div>
			<div>
				<button type="submit" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none">Criar Mapa</button>
			</div>
		</form>
		<button id="close-map-modal" class="absolute top-0 right-0 m-4 text-black">
			<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
			</svg>
		</button>
	</div>
</div>

<!-- Popup Modal para Criar Placa e Telefone -->
<div id="create-placa-modal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50 hidden">
	<div class="bg-white p-6 rounded-lg shadow-lg w-96 relative">
		<h2 class="text-2xl font-bold mb-4">Criar Nova Placa e Telefone</h2>
		<form id="create-placa-form" method="post" class="space-y-4">
			<div>
				<label for="placa-title" class="block text-sm font-medium text-gray-700">Título</label>
				<input type="text" id="placa-title" name="title" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
			</div>
			<div>
				<label for="placa-dob" class="block text-sm font-medium text-gray-700">Data de Nascimento</label>
				<input type="date" id="placa-dob" name="dob" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
			</div>
			<div>
				<label for="placa-numero" class="block text-sm font-medium text-gray-700">Seu Número</label>
				<input type="text" id="placa-numero" name="numero_telefone" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
			</div>
			<div>
				<label for="placa-veiculo" class="block text-sm font-medium text-gray-700">Placa do Veículo</label>
				<input type="text" id="placa-veiculo" name="placa_veiculo" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
			</div>
			<div>
				<button type="submit" class="w-full bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700 focus:outline-none">Criar Placa</button>
			</div>
		</form>
		<button id="close-placa-modal" class="absolute top-0 right-0 m-4 text-black">
			<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
			</svg>
		</button>
	</div>
</div>

<script>
	// JavaScript to toggle the off-canvas menu on mobile
	document.addEventListener('DOMContentLoaded', function () {
		if (window.innerWidth <= 1024) {
			document.getElementById('menu-toggle').addEventListener('click', function () {
				document.getElementById('offcanvas-backdrop').classList.remove('hidden');
				document.getElementById('offcanvas-menu').classList.remove('-translate-x-full');
			});

			document.getElementById('close-menu').addEventListener('click', function () {
				document.getElementById('offcanvas-menu').classList.add('-translate-x-full');
				document.getElementById('offcanvas-backdrop').classList.add('hidden');
			});

			document.getElementById('offcanvas-backdrop').addEventListener('click', function () {
				document.getElementById('offcanvas-menu').classList.add('-translate-x-full');
				document.getElementById('offcanvas-backdrop').classList.add('hidden');
			});
		}

		// JavaScript to handle the popup modal for creating maps
		document.getElementById('create-map-button').addEventListener('click', function () {
			document.getElementById('create-map-modal').classList.remove('hidden');
		});

		document.getElementById('close-map-modal').addEventListener('click', function () {
			document.getElementById('create-map-modal').classList.add('hidden');
		});

		// JavaScript to handle the popup modal for creating placa e telefone
		document.getElementById('create-placa-button').addEventListener('click', function () {
			document.getElementById('create-placa-modal').classList.remove('hidden');
		});

		document.getElementById('close-placa-modal').addEventListener('click', function () {
			document.getElementById('create-placa-modal').classList.add('hidden');
		});
	});
</script>

<style>
	/* CSS para mobile */
	@media (max-width: 1024px) {
		#offcanvas-menu {
			transform: -translate-x-full;
		}

		#offcanvas-backdrop {
			display: block;
		}
	}

	/* CSS para desktop */
	@media (min-width: 1025px) {
		#logo-superior {
			display: none;
		}

		#offcanvas-menu {
			transform: translateX(0);
			position: fixed;
			width: 16vw; /* Ajuste conforme necessário */
			left: 0;
			top: 0;
			bottom: 0;
			z-index: 50;
			background-color: #43265F;
			box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
		}

		/* Ajuste do masthead para seguir o tamanho do off-canvas */
		#masthead {
			position: fixed;
			width: 84vw;
			margin-left: 16vw; /* Mesma largura do off-canvas */
			padding-left: 1rem; /* Ajuste de padding conforme necessário */
			box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
			top: 0; /* Posiciona no topo */
			height: 90px; /* Defina a altura do masthead */
		}

		/* Ajuste do content para seguir o tamanho do off-canvas */
		#content, .main-content {
			margin-left: 16vw; /* Mesma largura do off-canvas */
			margin-top: 90px; /* Mesma altura do masthead */
		}

		#menu-toggle, #offcanvas-backdrop, #close-menu {
			display: none; /* Esconda o botão de toggle no desktop */
		}

		#colophon {
			position: fixed;
			width: 84vw; /* Alinhado com a largura do conteúdo */
			bottom: 0;
			left: 16vw; /* Mesma largura do off-canvas */
			background-color: #ededed; /* Cor de fundo do rodapé */
			box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);
			padding-left: 1rem;
			padding-right: 1rem;
			z-index: 50; /* Garanta que o rodapé esteja acima de outros elementos */
		}
	}
</style>
