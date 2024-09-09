<?php
/* Template para exibir um único post do tipo "Placas" */

get_header(); ?>

	<div class="container mx-auto p-4">
		<?php
		if (have_posts()) :
			while (have_posts()) : the_post(); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<header class="mb-4">
						<h1 class="text-3xl font-bold"><?php the_title(); ?></h1>
					</header>

					<div class="entry-content">
						<p><strong>Data de Nascimento:</strong> <?php echo esc_html(get_post_meta(get_the_ID(), '_placas_data_nascimento', true)); ?></p>
						<p><strong>Seu Número:</strong> <?php echo esc_html(get_post_meta(get_the_ID(), '_placas_numero_telefone', true)); ?></p>
						<p><strong>Placa do Veículo:</strong> <?php echo esc_html(get_post_meta(get_the_ID(), '_placas_placa_veiculo', true)); ?></p>
					</div>

					<footer class="mt-6">
						<a href="<?php echo esc_url(home_url('/placas')); ?>" class="text-blue-600 hover:underline">Voltar para a listagem de Placas</a>
					</footer>
				</article>

			<?php endwhile;
		else : ?>
			<p>Nenhuma placa encontrada.</p>
		<?php endif; ?>
	</div>

<?php
get_footer();
