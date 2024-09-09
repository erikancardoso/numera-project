<?php
/**
 * The template for displaying single Mapas posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package numera_theme
 */

get_header(); ?>

	<div class="container mx-auto p-4 max-w-[1400px]">
		<?php
		while (have_posts()) :
			the_post();

			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				$nome_completo_post = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';
				$data_nascimento_post = isset($_POST['dob']) ? sanitize_text_field($_POST['dob']) : '';

				// Se os valores foram enviados via POST, substitua os valores padrão
				$nome_completo = !empty($nome_completo_post) ? $nome_completo_post : get_post_meta(get_the_ID(), '_mapas_nome_completo', true);
				$data_nascimento = !empty($data_nascimento_post) ? $data_nascimento_post : get_post_meta(get_the_ID(), '_mapas_data_nascimento', true);
			} else {
				// Se não houver POST, continue com os valores padrão dos campos personalizados
				$nome_completo = get_post_meta(get_the_ID(), '_mapas_nome_completo', true);
				$data_nascimento = get_post_meta(get_the_ID(), '_mapas_data_nascimento', true);
			}

// Dados

			$vogais = NumerologiaDados::obterVogais();
			$consoantes = NumerologiaDados::obterConsoantes();
			$alfabeto = NumerologiaDados::obterAlfabeto();
			$tabelaPiramides = NumerologiaDados::obterTabelaPiramides();

// Calcula os valores baseados nos dados de entrada
			$letras_nome = str_split($nome_completo);
			$numerologia = new Numerologia();

			$numero_destino = $numerologia->calcularNumeroDestino($data_nascimento);  // Baseado na data de nascimento
			$numero_expressao = $numerologia->calcularNumeroExpressao($nome_completo);  // Baseado no nome completo
			$numero_motivacao = $numerologia->calcularNumeroMotivacao($nome_completo);  // Baseado no nome completo
			$numero_impressao = $numerologia->calcularNumeroImpressao($nome_completo);  // Baseado no nome completo
			$numero_psiquico = $numerologia->calcularNumeroPsiquico($data_nascimento);  // Baseado na data de nascimento

			$numero_missao = $numerologia->calcularNumeroMissao($numero_destino, $numero_expressao);  // Depende de destino e expressão

			$licoes_carmicas = explode(', ', $numerologia->calcularLicoesCarmicas($nome_completo));  // Baseado no nome completo
			$dividas_carmicas = explode(', ', $numerologia->calculoDividasCarmicas($nome_completo, $data_nascimento));  // Baseado em ambos
			$tendencias_ocultas = explode(', ', $numerologia->calcularTendenciaOculta($nome_completo));  // Baseado no nome completo

			$harmonia_conjugal = $numerologia->calcularNumeroAmor($numero_destino, $numero_expressao);  // Depende de destino e expressão
			$vibra_com = $harmonia_conjugal['vibra_com'];
			$atrai = $harmonia_conjugal['atrai'];
			$e_oposto = $harmonia_conjugal['e_oposto'];
			$e_passivo_em_relacao_a = $harmonia_conjugal['e_passivo_em_relação_a'];

			$ano_pessoal = $numerologia->calcularAnoPessoal($numero_destino);  // Depende do número de destino
			$mes_pessoal = $numerologia->mesPessoalCalc($data_nascimento);  // Baseado na data de nascimento
			$dia_pessoal = $numerologia->calcularDiaPessoal($data_nascimento);  // Baseado na data de nascimento

			$grau_ascensao = $numerologia->grauAscensao($nome_completo);  // Baseado no nome completo
			$talento_oculto = $numerologia->talentoOculto($numero_motivacao, $numero_expressao);  // Depende de motivação e expressão

			$cores = $numerologia->coresFavoraveis($nome_completo);  // Baseado no nome completo
			$arcanos = $numerologia->calcularArcanos($nome_completo, $data_nascimento);

			?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header class="entry-header mb-4">
					<h1 class="entry-title text-2xl font-bold"><?php the_title(); ?></h1>
				</header>

				<div class="entry-content">
					<form id="edit-map-form">
						<div class="mb-4">
							<label for="edit-nome-completo" class="block text-sm font-medium text-gray-700">Nome Completo</label>
							<input type="text" id="edit-nome-completo" name="edit-nome-completo" value="<?php echo esc_attr($nome_completo); ?>" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
						</div>

						<div class="mb-4">
							<label for="edit-data-nascimento" class="block text-sm font-medium text-gray-700">Data de Nascimento</label>
							<input type="date" id="edit-data-nascimento" name="edit-data-nascimento" value="<?php echo esc_attr($data_nascimento); ?>" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
						</div>

						<button type="submit" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none">Salvar Alterações</button>
					</form>

					<!-- Tabs Layout -->
					<div class="mb-4 border-b border-gray-200">
						<ul class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500">
							<li class="mr-2">
								<button data-tab="tab1" class="inline-block p-4 rounded-t-lg border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300">Analise de Mot/Imp/Exp</button>
							</li>
							<li class="mr-2">
								<button data-tab="tab2" class="inline-block p-4 rounded-t-lg border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300">Geral</button>
							</li>
							<li class="mr-2">
								<button data-tab="tab3" class="inline-block p-4 rounded-t-lg border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300">Energias / Fases da vida</button>
							</li>
							<li class="mr-2">
								<button data-tab="tab4" class="inline-block p-4 rounded-t-lg border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300">Arcanos</button>
							</li>
							<li class="mr-2">
								<button data-tab="tab5" class="inline-block p-4 rounded-t-lg border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300">Pirâmides</button>
							</li>
							<li class="mr-2">
								<button data-tab="tab6" class="inline-block p-4 rounded-t-lg border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300">Vocacional</button>
							</li>
						</ul>
					</div>

					<div id="tabs-content">
						<!-- Tab 1 Content -->
						<div data-tab-content="tab1" class="p-4">
							<div class="mb-4">
								<h2 class="text-xl font-semibold p-4 text-center">Análise de Assinatura:</h2>
								<div class="text-center space-y-2" id="numerologia-results">
									<!-- Exibir números de consoantes (expressões) abaixo das letras -->
									<div class="flex justify-center flex-wrap space-x-2 mt-2" id="consoantes-result">
										<?php foreach ($letras_nome as $letra): ?>
											<div class="flex flex-col items-center max-w-[30px]">
												<div class="item bg-impressao text-gray-700">
													<?php echo isset($consoantes[$letra]) ? $consoantes[$letra] : ''; ?>
												</div>
											</div>
										<?php endforeach; ?>
									</div>

									<!-- Exibir letras do nome completo no meio -->
									<div class="flex justify-center flex-wrap space-x-2 mt-2" id="letras-result">
										<?php foreach ($letras_nome as $letra): ?>
											<div class="flex flex-col items-center max-w-[30px]">
												<div class="item text-gray-900 font-semibold">
													<?php echo esc_html($letra); ?>
												</div>
											</div>
										<?php endforeach; ?>
									</div>
									<!-- Exibir números de vogais (motivações) acima das letras -->
									<div class="flex justify-center flex-wrap space-x-2" id="vogais-result">
										<?php foreach ($letras_nome as $letra): ?>
											<div class="flex flex-col items-center max-w-[30px]">
												<div class="item bg-motivacao text-gray-700">
													<?php echo isset($vogais[$letra]) ? $vogais[$letra] : ''; ?>
												</div>
											</div>
										<?php endforeach; ?>
									</div>

									<!-- Exibir números de vogais (motivações) acima das letras -->
									<div class="flex justify-center flex-wrap space-x-2" id="all-vl-result">
										<?php foreach ($letras_nome as $letra): ?>
											<div class="flex flex-col items-center max-w-[30px]">
												<div class="item bg-expressao text-gray-700">
													<?php echo isset($alfabeto[$letra]) ? $alfabeto[$letra] : ''; ?>
												</div>
											</div>
										<?php endforeach; ?>
									</div>
								</div>
							</div>

							<div class="bg-white p-6 rounded-lg shadow-md mb-8">
								<h3 class="text-xl font-semibold mb-4">Resultados dos Cálculos</h3>
								<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
									<!-- Resultado de Motivação -->
									<div class="border border-[#9dd4b0] rounded-lg p-4">
										<div class="flex items-center justify-between">
											<span id="resultado-motivacao" class="border border-[#bc9fc9] rounded-full px-2 py-1 mr-2"><?= $numero_motivacao ?></span>
											<span class="text-lg">Motivação</span>
										</div>
										<a href="#" class="text-blue-500 mt-2 block text-end">Ver detalhes</a>
									</div>

									<!-- Resultado de Impressão -->
									<div class="border border-[#9dd4b0] rounded-lg p-4">
										<div class="flex items-center justify-between">
											<span id="resultado-impressao" class="border border-[#bc9fc9] rounded-full px-2 py-1 mr-2"><?= $numero_impressao ?></span>
											<span class="text-lg">Impressão</span>
										</div>
										<a href="#" class="text-blue-500 mt-2 block text-end">Ver detalhes</a>
									</div>

									<!-- Resultado de Expressão -->
									<div class="border border-[#9dd4b0] rounded-lg p-4">
										<div class="flex items-center justify-between">
											<span id="resultado-expressao" class="border border-[#bc9fc9] rounded-full px-2 py-1 mr-2"><?= $numero_expressao ?></span>
											<span class="text-lg">Expressão</span>
										</div>
										<a href="#" class="text-blue-500 mt-2 block text-end">Ver detalhes</a>
									</div>

									<!-- Resultado de Arcano -->
									<div class="border border-[#9dd4b0] rounded-lg p-4">
										<div class="flex items-center justify-between">
											<span id="resultado-arcano" class="border border-[#bc9fc9] rounded-full px-2 py-1 mr-2"><?= $arcanos['arcanoAtual'] ?></span>
											<span class="text-lg">Arcano</span>
										</div>
										<a href="#" class="text-blue-500 mt-2 block text-end">Ver detalhes</a>
									</div>
								</div>
							</div>
						</div>
						<script>
							document.getElementById('edit-nome-completo').addEventListener('input', function() {
								const name = this.value;

								// Funções que retornam números com base nas letras
								function getVogais(letra) {
									const vogais = <?php echo json_encode($vogais); ?>;
									return vogais[letra.toUpperCase()] || '';
								}

								function getConsoantes(letra) {
									const consoantes = <?php echo json_encode($consoantes); ?>;
									return consoantes[letra.toUpperCase()] || '';
								}

								// Atualiza vogais
								const vogaisContainer = document.getElementById('vogais-result');
								vogaisContainer.innerHTML = '';
								for (let i = 0; i < name.length; i++) {
									const vogal = getVogais(name[i]);
									vogaisContainer.innerHTML += `<div class="flex flex-col items-center max-w-[30px]"><div class="item text-gray-700">${vogal}</div></div>`;
								}

								// Atualiza letras
								const letrasContainer = document.getElementById('letras-result');
								letrasContainer.innerHTML = '';
								for (let i = 0; i < name.length; i++) {
									letrasContainer.innerHTML += `<div class="flex flex-col items-center max-w-[30px]"><div class="item text-gray-900 font-semibold">${name[i]}</div></div>`;
								}

								// Atualiza consoantes
								const consoantesContainer = document.getElementById('consoantes-result');
								consoantesContainer.innerHTML = '';
								for (let i = 0; i < name.length; i++) {
									const consoante = getConsoantes(name[i]);
									consoantesContainer.innerHTML += `<div class="flex flex-col items-center max-w-[30px]"><div class="item text-gray-700">${consoante}</div></div>`;
								}

								// Aqui você pode atualizar os resultados de motivação, impressão e expressão com base no nome
								document.getElementById('resultado-motivacao').textContent = calculateMotivacao(name);
								document.getElementById('resultado-impressao').textContent = calculateImpressao(name);
								document.getElementById('resultado-expressao').textContent = calculateExpressao(name);
								document.getElementById('resultado-arcano').textContent = calculateArcano(name);
							});

							// Funções de cálculo para motivação, impressão e expressão (apenas exemplos)
							function calculateMotivacao(name) {
								return name.length % 9; // Exemplo: Retorna o número baseado no tamanho do nome
							}

							function calculateImpressao(name) {
								return name.length % 8; // Exemplo: Cálculo simples
							}

							function calculateExpressao(name) {
								return name.length % 7; // Exemplo: Cálculo simples
							}

							function calculateArcano(name) {
								return name.length; // Exemplo: Cálculo simples
							}

						</script>
						<!-- Tab 2 Content -->
						<div data-tab-content="tab2" class="p-4 hidden">
							<div class="space-y-4">
								<div class="grid grid-cols-1 md:grid-cols-2 gap-8">
									<!-- Bloco Pessoal -->
									<div class="bg-white border border-[#f2b37d] rounded-lg p-4">
										<div class="flex items-center mb-4">
											<h2 class="text-xl font-semibold">Pessoal</h2>
										</div>
										<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
											<!-- Missão -->
											<div class="border border-[#9dd4b0] rounded-lg p-4">
												<div class="flex items-center">
													<span id="resultado-missao" class="border border-[#bc9fc9] rounded-full px-2 py-1 mr-2"><?= $numero_missao ?></span>
													<h3 class="font-semibold">Missão</h3>
												</div>
												<a href="#" class="text-blue-500 mt-2 block text-end">Ver detalhes</a>
											</div>
											<!-- Destino -->
											<div class="border border-[#9dd4b0] rounded-lg p-4">
												<div class="flex items-center">
													<span id="resultado-destino" class="border border-[#bc9fc9] rounded-full px-2 py-1 mr-2"><?= $numero_destino ?></span>
													<h3 class="font-semibold">Destino</h3>
												</div>
												<a href="#" class="text-blue-500 mt-2 block text-end">Ver detalhes</a>
											</div>
											<!-- Ano Pessoal -->
											<div class="border border-[#9dd4b0] rounded-lg p-4">
												<div class="flex items-center">
													<span id="resultado-ano-pessoal" class="border border-[#bc9fc9] rounded-full px-2 py-1 mr-2"><?= $ano_pessoal ?></span>
													<h3 class="font-semibold">Ano Pessoal</h3>
												</div>
												<a href="#" class="text-blue-500 mt-2 block text-end">Ver detalhes</a>
											</div>
											<!-- Mês Pessoal -->
											<div class="border border-[#9dd4b0] rounded-lg p-4">
												<div class="flex items-center">
													<span id="resultado-mes-pessoal" class="border border-[#bc9fc9] rounded-full px-2 py-1 mr-2"><?= $mes_pessoal ?></span>
													<h3 class="font-semibold">Mês Pessoal</h3>
												</div>
												<a href="#" class="text-blue-500 mt-2 block text-end">Ver detalhes</a>
											</div>
											<!-- Dia Pessoal -->
											<div class="border border-[#9dd4b0] rounded-lg p-4">
												<div class="flex items-center">
													<span id="resultado-dia-pessoal" class="border border-[#bc9fc9] rounded-full px-2 py-1 mr-2"><?= $dia_pessoal ?></span>
													<h3 class="font-semibold">Dia Pessoal</h3>
												</div>
												<a href="#" class="text-blue-500 mt-2 block text-end">Ver detalhes</a>
											</div>
											<!-- Anjo -->
											<div class="border border-[#9dd4b0] rounded-lg p-4">
												<div class="flex items-center">
													<span id="resultado-dia-pessoal" class="border border-[#bc9fc9] rounded-full px-2 py-1 mr-2">Em breve</span>
													<h3 class="font-semibold">Anjo</h3>
												</div>
												<a href="#" class="text-blue-500 mt-2 block text-end">Ver detalhes</a>
											</div>
										</div>
									</div>

									<!-- Bloco Carmas -->
									<div class="bg-white border border-[#f2b37d] rounded-lg p-4">
										<div class="flex items-center mb-4">
											<h2 class="text-xl font-semibold">Carmas</h2>
										</div>
										<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
											<!-- Lições Cármicas -->
											<div class="border border-[#9dd4b0] rounded-lg p-4">
												<div class="flex items-center">
													<?php foreach ($licoes_carmicas as $licao): ?>
														<span id="resultado-licoes-carmicas" class="border border-[#bc9fc9] rounded-full px-2 py-1 mr-2"><?= $licao ?></span>
													<?php endforeach; ?>
													<h3 class="font-semibold">Lições Cármicas</h3>
												</div>
												<a href="#" class="text-blue-500 mt-2 block text-end">Ver detalhes</a>
											</div>
											<!-- Dívidas Cármicas -->
											<div class="border border-[#9dd4b0] rounded-lg p-4">
												<div class="flex items-center">
													<?php foreach ($dividas_carmicas as $divida): ?>
														<span id="resultado-dividas-carmicas" class="border border-[#bc9fc9] rounded-full px-2 py-1 mr-2"><?= $divida ?></span>
													<?php endforeach; ?>
													<h3 class="font-semibold">Dívidas Cármicas</h3>
												</div>
												<a href="#" class="text-blue-500 mt-2 block text-end">Ver detalhes</a>
											</div>
											<!-- Tendências Ocultas -->
											<div class="border border-[#9dd4b0] rounded-lg p-4">
												<div class="flex items-center">
													<?php foreach ($tendencias_ocultas as $tendencia): ?>
														<span id="resultado-tendencias-ocultas" class="border border-[#bc9fc9] rounded-full px-2 py-1 mr-2"><?= $tendencia ?></span>
													<?php endforeach; ?>
													<h3 class="font-semibold">Tendências Ocultas</h3>
												</div>
												<a href="#" class="text-blue-500 mt-2 block text-end">Ver detalhes</a>
											</div>

										</div>
									</div>

									<!-- Bloco Desafios -->
									<div class="bg-white border border-[#f2b37d] rounded-lg p-4">
										<div class="flex items-center mb-4">
											<h2 class="text-xl font-semibold">Desafios</h2>
										</div>
										<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
											<!-- Primeiro Desafio -->
											<div class="border border-[#9dd4b0] rounded-lg p-4">
												<div class="flex items-center">
													<span class="border border-[#bc9fc9] rounded-full px-2 py-1 mr-2">1</span>
													<h3 class="font-semibold">Primeiro Desafio</h3>
												</div>
												<a href="#" class="text-blue-500 mt-2 block text-end">Ver detalhes</a>
											</div>
											<!-- Segundo Desafio -->
											<div class="border border-[#9dd4b0] rounded-lg p-4">
												<div class="flex items-center">
													<span class="border border-[#bc9fc9] rounded-full px-2 py-1 mr-2">2</span>
													<h3 class="font-semibold">Segundo Desafio</h3>
												</div>
												<a href="#" class="text-blue-500 mt-2 block text-end">Ver detalhes</a>
											</div>
											<!-- Desafio Principal -->
											<div class="border border-[#9dd4b0] rounded-lg p-4">
												<div class="flex items-center">
													<span class="border border-[#bc9fc9] rounded-full px-2 py-1 mr-2">3</span>
													<h3 class="font-semibold">Desafio Principal</h3>
												</div>
												<a href="#" class="text-blue-500 mt-2 block text-end">Ver detalhes</a>
											</div>
										</div>
									</div>

									<!-- Bloco Harmonia Conjugal -->
									<div class="bg-white border border-[#f2b37d] rounded-lg p-4">
										<div class="flex items-center mb-4">
											<h2 class="text-xl font-semibold">Harmonia Conjugal</h2>
										</div>
										<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
											<!-- Vibra Com -->
											<div class="border border-[#9dd4b0] rounded-lg p-4">
												<div class="flex items-center">
													<span class="border border-[#bc9fc9] rounded-full px-2 py-1 mr-2"><?= $vibra_com ?></span>
													<h3 class="font-semibold">Vibra Com</h3>
												</div>
												<a href="#" class="text-blue-500 mt-2 block text-end">Ver detalhes</a>
											</div>
											<!-- Atrai -->
											<div class="border border-[#9dd4b0] rounded-lg p-4">
												<div class="flex items-center">
													<span class="border border-[#bc9fc9] rounded-full px-2 py-1 mr-2"><?= $atrai ?></span>
													<h3 class="font-semibold">Atrai</h3>
												</div>
												<a href="#" class="text-blue-500 mt-2 block text-end">Ver detalhes</a>
											</div>
											<!-- É Oposto -->
											<div class="border border-[#9dd4b0] rounded-lg p-4">
												<div class="flex items-center">
													<span class="border border-[#bc9fc9] rounded-full px-2 py-1 mr-2"><?= $e_oposto ?></span>
													<h3 class="font-semibold">É Oposto</h3>
												</div>
												<a href="#" class="text-blue-500 mt-2 block text-end">Ver detalhes</a>
											</div>
										</div>
									</div>

									<!-- Bloco Grau Ascenção -->
									<div class="bg-white border border-[#f2b37d] rounded-lg p-4">
										<div class="flex items-center mb-4">
											<h2 class="text-xl font-semibold">Grau Ascenção</h2>
										</div>
										<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
											<!-- Espírito em Ascenção -->
											<div class="border border-[#9dd4b0] rounded-lg p-4">
												<div class="flex items-center">
													<h3 class="font-semibold"><?= $grau_ascensao ?></h3>
												</div>
												<a href="#" class="text-blue-500 mt-2 block text-end">Ver detalhes</a>
											</div>
											<!-- Talento Oculto -->
											<div class="border border-[#9dd4b0] rounded-lg p-4">
												<div class="flex items-center">
													<span class="border border-[#bc9fc9] rounded-full px-2 py-1 mr-2"><?= $talento_oculto ?></span>
													<h3 class="font-semibold">Talento Oculto</h3>
												</div>
												<a href="#" class="text-blue-500 mt-2 block text-end">Ver detalhes</a>
											</div>
											<!-- Número Psíquico -->
											<div class="border border-[#9dd4b0] rounded-lg p-4">
												<div class="flex items-center">
													<span class="border border-[#bc9fc9] rounded-full px-2 py-1 mr-2"><?= $numero_psiquico ?></span>
													<h3 class="font-semibold">Número Psíquico</h3>
												</div>
												<a href="#" class="text-blue-500 mt-2 block text-end">Ver detalhes</a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<!-- Tab 3 Content -->
						<div data-tab-content="tab3" class="p-4 hidden">
							<div class="space-y-4">
								<h2 class="text-xl font-semibold">Energias</h2>
								<div class="grid grid-cols-1 md:grid-cols-2 gap-8">
									<!-- Bloco Cores -->
									<div class="bg-white border border-[#f2b37d] rounded-lg p-2">
										<div class="flex flex-col gap-4 mb-2">
											<h2 class="text-xl font-semibold">Cores</h2>
											<div>
												<span id="resultado-cores" class="border border-[#bc9fc9] rounded-full px-2 py-1 mr-2"><?= $cores ?></span>
												<a href="#" class="text-blue-500 mt-2 block text-end">Ver detalhes</a>
											</div>
										</div>
									</div>
									<!-- Bloco Dias Harmonicos -->
									<div class="bg-white border border-[#f2b37d] rounded-lg p-2">
										<div class="flex flex-col gap-4 mb-2">
											<h2 class="text-xl font-semibold">Dias Harmônicos</h2>
											<div>
												<?php foreach ($dias_favoraveis as $dia): ?>
													<span id="resultado-dias-harmonicos" class="border border-[#bc9fc9] rounded-full px-2 py-1 mr-2"><?= $dia ?></span>
												<?php endforeach; ?>
												<a href="#" class="text-blue-500 mt-2 block text-end"></a>
											</div>
										</div>
									</div>
									<!-- Bloco Numeros Harmônicos -->
									<div class="bg-white border border-[#f2b37d] rounded-lg p-2">
										<div class="flex flex-col gap-4 mb-2">
											<h2 class="text-xl font-semibold">Numeros Harmônicos</h2>
											<div>
												<?php foreach ($numeros_harmonicos as $num): ?>
													<span id="resultado-numeros-harmonicos" class="border border-[#bc9fc9] rounded-full px-2 py-1 mr-2"><?= $num ?></span>
												<?php endforeach; ?>
												<a href="#" class="text-blue-500 mt-2 block text-end">Ver detalhes</a>
											</div>
										</div>
									</div>
									<!-- Bloco Cores -->
									<div class="bg-white border border-[#f2b37d] rounded-lg p-2">
										<div class="flex flex-col gap-4 mb-2">
											<h2 class="text-xl font-semibold">Momentos Decisivos</h2>
											<div>
												<div class="flex">
													<span class="border border-[#bc9fc9] rounded-full px-2 py-1 mr-2"><?= $momentos_decisivos['primeiroMomento'] ?></span>
													<span><?= $momentos_decisivos['momentoInicial1'] . ' até ' . $momentos_decisivos['momentoFinal1'] ?></span>
												</div>
												<div class="flex">
													<span class="border border-[#bc9fc9] rounded-full px-2 py-1 mr-2"><?= $momentos_decisivos['segundoMomento'] ?></span>
													<span><?= $momentos_decisivos['momentoInicial2'] . ' até ' . $momentos_decisivos['momentoFinal2'] ?></span>
												</div>
												<div class="flex">
													<span class="border border-[#bc9fc9] rounded-full px-2 py-1 mr-2"><?= $momentos_decisivos['terceiroMomento'] ?></span>
													<span><?= $momentos_decisivos['momentoInicial3'] . ' até ' . $momentos_decisivos['momentoFinal3'] ?></span>
												</div>
												<div class="flex">
													<span class="border border-[#bc9fc9] rounded-full px-2 py-1 mr-2"><?= $momentos_decisivos['quartoMomento'] ?></span>
													<span><?= $momentos_decisivos['momentoInicial4'] . ' ' . $momentos_decisivos['momentoFinal4'] ?></span>
												</div>
												<a href="#" class="text-blue-500 mt-2 block text-end">Ver detalhes</a>
											</div>
										</div>
									</div>
									<!-- Bloco Cores -->
									<div class="bg-white border border-[#f2b37d] rounded-lg p-2">
										<div class="flex flex-col mb-2">
											<h2 class="text-xl font-semibold">Ciclos da Vida</h2>
											<div>
												<?php
												if (!empty($ciclos)) {
													// Exibir ciclos
													foreach ($ciclos['ciclos'] as $nome_ciclo => $dados_ciclo) {
														echo "<p>Número: {$dados_ciclo['numero']}, Período: {$dados_ciclo['periodo']}</p>";
													}

													// Exibir alertas, se houver
													if (!empty($ciclos['alertas'])) {
														foreach ($ciclos['alertas'] as $alerta) {
															echo "<p>{$alerta}</p>";
														}
													}
												} else {
													echo "<p>Nenhum ciclo encontrado.</p>";
												}
												?>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<!-- Tab 4 Content -->
						<div data-tab-content="tab4" class="p-4 hidden">
							<div class="space-y-4">
								<h2 class="text-xl font-semibold">Energias</h2>
								<div class="grid grid-cols-1 md:grid-cols-2 gap-8">
									<!-- Bloco Cores -->
									<div class="bg-white border border-[#f2b37d] rounded-lg p-2">
										<div class="flex flex-col gap-4 mb-2">
											<h2 class="text-xl font-semibold">Cores</h2>
											<div>
												<span id="resultado-cores" class="border border-[#bc9fc9] rounded-full px-2 py-1 mr-2"><?= $cores ?></span>
												<a href="#" class="text-blue-500 mt-2 block text-end">Ver detalhes</a>
											</div>
										</div>
									</div>
									<!-- Bloco Dias Harmonicos -->
									<div class="bg-white border border-[#f2b37d] rounded-lg p-2">
										<div class="flex flex-col gap-4 mb-2">
											<h2 class="text-xl font-semibold">Dias Harmônicos</h2>
											<div>
												<?php foreach ($dias_favoraveis as $dia): ?>
													<span id="resultado-dias-harmonicos" class="border border-[#bc9fc9] rounded-full px-2 py-1 mr-2"><?= $dia ?></span>
												<?php endforeach; ?>
												<a href="#" class="text-blue-500 mt-2 block text-end"></a>
											</div>
										</div>
									</div>
									<!-- Bloco Numeros Harmônicos -->
									<div class="bg-white border border-[#f2b37d] rounded-lg p-2">
										<div class="flex flex-col gap-4 mb-2">
											<h2 class="text-xl font-semibold">Numeros Harmônicos</h2>
											<div>
												<?php foreach ($numeros_harmonicos as $num): ?>
													<span id="resultado-numeros-harmonicos" class="border border-[#bc9fc9] rounded-full px-2 py-1 mr-2"><?= $num ?></span>
												<?php endforeach; ?>
												<a href="#" class="text-blue-500 mt-2 block text-end">Ver detalhes</a>
											</div>
										</div>
									</div>
									<!-- Bloco Cores -->
									<div class="bg-white border border-[#f2b37d] rounded-lg p-2">
										<div class="flex flex-col gap-4 mb-2">
											<h2 class="text-xl font-semibold">Momentos Decisivos</h2>
											<div>
												<div class="flex">
													<span class="border border-[#bc9fc9] rounded-full px-2 py-1 mr-2"><?= $momentos_decisivos['primeiroMomento'] ?></span>
													<span><?= $momentos_decisivos['momentoInicial1'] . ' até ' . $momentos_decisivos['momentoFinal1'] ?></span>
												</div>
												<div class="flex">
													<span class="border border-[#bc9fc9] rounded-full px-2 py-1 mr-2"><?= $momentos_decisivos['segundoMomento'] ?></span>
													<span><?= $momentos_decisivos['momentoInicial2'] . ' até ' . $momentos_decisivos['momentoFinal2'] ?></span>
												</div>
												<div class="flex">
													<span class="border border-[#bc9fc9] rounded-full px-2 py-1 mr-2"><?= $momentos_decisivos['terceiroMomento'] ?></span>
													<span><?= $momentos_decisivos['momentoInicial3'] . ' até ' . $momentos_decisivos['momentoFinal3'] ?></span>
												</div>
												<div class="flex">
													<span class="border border-[#bc9fc9] rounded-full px-2 py-1 mr-2"><?= $momentos_decisivos['quartoMomento'] ?></span>
													<span><?= $momentos_decisivos['momentoInicial4'] . ' ' . $momentos_decisivos['momentoFinal4'] ?></span>
												</div>
												<a href="#" class="text-blue-500 mt-2 block text-end">Ver detalhes</a>
											</div>
										</div>
									</div>
									<!-- Bloco Cores -->
									<div class="bg-white border border-[#f2b37d] rounded-lg p-2">
										<div class="flex flex-col mb-2">
											<h2 class="text-xl font-semibold">Ciclos da Vida</h2>
											<div>
												<?php
												if (!empty($ciclos)) {
													// Exibir ciclos
													foreach ($ciclos['ciclos'] as $nome_ciclo => $dados_ciclo) {
														echo "<p>Número: {$dados_ciclo['numero']}, Período: {$dados_ciclo['periodo']}</p>";
													}

													// Exibir alertas, se houver
													if (!empty($ciclos['alertas'])) {
														foreach ($ciclos['alertas'] as $alerta) {
															echo "<p>{$alerta}</p>";
														}
													}
												} else {
													echo "<p>Nenhum ciclo encontrado.</p>";
												}
												?>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<!-- Tab 5 Content -->
						<div data-tab-content="tab5" class="p-4 hidden">
							<div class="tab-menu">
								<button class="tab-link" onclick="openPiramide(event, 'piramideVida')">Vida</button>
								<button class="tab-link" onclick="openPiramide(event, 'piramideTalento')">Pessoal</button>
								<button class="tab-link" onclick="openPiramide(event, 'piramideAscensao')">Social</button>
								<button class="tab-link" onclick="openPiramide(event, 'piramideOculta')">Destino</button>
							</div>

							<div id="piramideVida" class="piramide-container" style="display: block;">
								<?php foreach ($piramideVida as $linha): ?>
									<div class="linha">
										<?php foreach ($linha as $letra): ?>
											<span class="num-piramide">
												<?= htmlspecialchars($letra, ENT_QUOTES, 'UTF-8') ?>
											</span>
										<?php endforeach; ?>
									</div>
								<?php endforeach; ?>
							</div>

							<div id="piramideTalento" class="piramide-container" style="display: none;">
								<?php foreach ($piramidePessoal as $linha): ?>
									<div class="linha">
										<?php foreach ($linha as $letra): ?>
											<span class="num-piramide">
												<?= htmlspecialchars($letra, ENT_QUOTES, 'UTF-8') ?>
											</span>
										<?php endforeach; ?>
									</div>
								<?php endforeach; ?>
							</div>

							<div id="piramideAscensao" class="piramide-container" style="display: none;">
								<?php foreach ($piramideSocial as $linha): ?>
									<div class="linha">
										<?php foreach ($linha as $letra): ?>
											<span class="num-piramide">
												<?= htmlspecialchars($letra, ENT_QUOTES, 'UTF-8') ?>
											</span>
										<?php endforeach; ?>
									</div>
								<?php endforeach; ?>
							</div>

							<div id="piramideOculta" class="piramide-container" style="display: none;">
								<?php foreach ($piramideDestino as $linha): ?>
									<div class="linha">
										<?php foreach ($linha as $letra): ?>
											<span class="num-piramide">
												<?= htmlspecialchars($letra, ENT_QUOTES, 'UTF-8') ?>
											</span>
										<?php endforeach; ?>
									</div>
								<?php endforeach; ?>
							</div>
						</div>

						<style>
							.tab-menu {
								text-align: center;
								margin-bottom: 10px;
							}

							.tab-link {
								background-color: #f1f1f1;
								border: none;
								padding: 10px;
								cursor: pointer;
								margin-right: 5px;
							}

							.tab-link.active {
								background-color: #ddd;
							}

							.piramide-container {
								display: flex;
								flex-direction: column;
								align-items: center;
							}

							.linha {
								display: flex;
								justify-content: center;
								margin-bottom: 0px;
							}

							.num-piramide {
								padding-right: 5px;
								padding-left: 5px;
								font-size: 12px;
								text-align: center;
							}
						</style>

						<script>
							function openPiramide(evt, piramideName) {
								// Ocultar todas as pirâmides
								var i, piramideContainer, tabLinks;
								piramideContainer = document.getElementsByClassName("piramide-container");
								for (i = 0; i < piramideContainer.length; i++) {
									piramideContainer[i].style.display = "none";
								}

								// Remover classe "active" de todos os botões
								tabLinks = document.getElementsByClassName("tab-link");
								for (i = 0; i < tabLinks.length; i++) {
									tabLinks[i].className = tabLinks[i].className.replace(" active", "");
								}

								// Mostrar a pirâmide selecionada
								document.getElementById(piramideName).style.display = "block";

								// Adicionar a classe "active" ao botão clicado
								evt.currentTarget.className += " active";
							}
						</script>


						<!-- Tab 3 Content -->
						<div data-tab-content="tab6" class="p-4 hidden">
							<div class="space-y-4">
								<h2 class="text-xl font-semibold">Energias</h2>
								<div class="grid grid-cols-1 md:grid-cols-2 gap-8">
									<!-- Bloco Cores -->
									<div class="bg-white border border-[#f2b37d] rounded-lg p-2">
										<div class="flex flex-col gap-4 mb-2">
											<h2 class="text-xl font-semibold">Cores</h2>
											<div>
												<span id="resultado-cores" class="border border-[#bc9fc9] rounded-full px-2 py-1 mr-2"><?= $cores ?></span>
												<a href="#" class="text-blue-500 mt-2 block text-end">Ver detalhes</a>
											</div>
										</div>
									</div>
									<!-- Bloco Dias Harmonicos -->
									<div class="bg-white border border-[#f2b37d] rounded-lg p-2">
										<div class="flex flex-col gap-4 mb-2">
											<h2 class="text-xl font-semibold">Dias Harmônicos</h2>
											<div>
												<?php foreach ($dias_favoraveis as $dia): ?>
													<span id="resultado-dias-harmonicos" class="border border-[#bc9fc9] rounded-full px-2 py-1 mr-2"><?= $dia ?></span>
												<?php endforeach; ?>
												<a href="#" class="text-blue-500 mt-2 block text-end"></a>
											</div>
										</div>
									</div>
									<!-- Bloco Numeros Harmônicos -->
									<div class="bg-white border border-[#f2b37d] rounded-lg p-2">
										<div class="flex flex-col gap-4 mb-2">
											<h2 class="text-xl font-semibold">Numeros Harmônicos</h2>
											<div>
												<?php foreach ($numeros_harmonicos as $num): ?>
													<span id="resultado-numeros-harmonicos" class="border border-[#bc9fc9] rounded-full px-2 py-1 mr-2"><?= $num ?></span>
												<?php endforeach; ?>
												<a href="#" class="text-blue-500 mt-2 block text-end">Ver detalhes</a>
											</div>
										</div>
									</div>
									<!-- Bloco Cores -->
									<div class="bg-white border border-[#f2b37d] rounded-lg p-2">
										<div class="flex flex-col gap-4 mb-2">
											<h2 class="text-xl font-semibold">Momentos Decisivos</h2>
											<div>
												<div class="flex">
													<span class="border border-[#bc9fc9] rounded-full px-2 py-1 mr-2"><?= $momentos_decisivos['primeiroMomento'] ?></span>
													<span><?= $momentos_decisivos['momentoInicial1'] . ' até ' . $momentos_decisivos['momentoFinal1'] ?></span>
												</div>
												<div class="flex">
													<span class="border border-[#bc9fc9] rounded-full px-2 py-1 mr-2"><?= $momentos_decisivos['segundoMomento'] ?></span>
													<span><?= $momentos_decisivos['momentoInicial2'] . ' até ' . $momentos_decisivos['momentoFinal2'] ?></span>
												</div>
												<div class="flex">
													<span class="border border-[#bc9fc9] rounded-full px-2 py-1 mr-2"><?= $momentos_decisivos['terceiroMomento'] ?></span>
													<span><?= $momentos_decisivos['momentoInicial3'] . ' até ' . $momentos_decisivos['momentoFinal3'] ?></span>
												</div>
												<div class="flex">
													<span class="border border-[#bc9fc9] rounded-full px-2 py-1 mr-2"><?= $momentos_decisivos['quartoMomento'] ?></span>
													<span><?= $momentos_decisivos['momentoInicial4'] . ' ' . $momentos_decisivos['momentoFinal4'] ?></span>
												</div>
												<a href="#" class="text-blue-500 mt-2 block text-end">Ver detalhes</a>
											</div>
										</div>
									</div>
									<!-- Bloco Cores -->
									<div class="bg-white border border-[#f2b37d] rounded-lg p-2">
										<div class="flex flex-col mb-2">
											<h2 class="text-xl font-semibold">Ciclos da Vida</h2>
											<div>
												<?php
												if (!empty($ciclos)) {
													// Exibir ciclos
													foreach ($ciclos['ciclos'] as $nome_ciclo => $dados_ciclo) {
														echo "<p>Número: {$dados_ciclo['numero']}, Período: {$dados_ciclo['periodo']}</p>";
													}

													// Exibir alertas, se houver
													if (!empty($ciclos['alertas'])) {
														foreach ($ciclos['alertas'] as $alerta) {
															echo "<p>{$alerta}</p>";
														}
													}
												} else {
													echo "<p>Nenhum ciclo encontrado.</p>";
												}
												?>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

					</div>
				</div>

				<footer class="entry-footer mt-8">
					<?php
					if (has_post_thumbnail()) {
						the_post_thumbnail('large', ['class' => 'w-full h-auto mt-4']);
					}
					?>
				</footer>
			</article>

		<?php endwhile; ?>
	</div>

	<script>
		document.addEventListener('DOMContentLoaded', function () {
			// Script para as abas
			const tabs = document.querySelectorAll('[data-tab]');
			const tabContents = document.querySelectorAll('[data-tab-content]');

			tabs.forEach(tab => {
				tab.addEventListener('click', function () {
					const target = this.getAttribute('data-tab');

					// Remove 'active' classes de todas as tabs
					tabs.forEach(t => t.classList.remove('border-b-2', 'border-blue-500', 'text-blue-500'));
					// Esconde todos os conteúdos de tabs
					tabContents.forEach(tc => tc.classList.add('hidden'));

					// Adiciona 'active' na tab clicada
					this.classList.add('border-b-2', 'border-blue-500', 'text-blue-500');
					// Mostra o conteúdo correspondente
					document.querySelector(`[data-tab-content="${target}"]`).classList.remove('hidden');
				});
			});

			// Script para salvar o formulário via AJAX
			document.getElementById('edit-map-form').addEventListener('submit', function(e) {
				e.preventDefault();

				// Coleta os dados do formulário
				const nomeCompleto = document.getElementById('edit-nome-completo').value;
				const dataNascimento = document.getElementById('edit-data-nascimento').value;
				const postId = <?php echo get_the_ID(); ?>;

				// Log para depuração
				console.log('Nome Completo:', nomeCompleto);
				console.log('Data de Nascimento:', dataNascimento);
				console.log('Post ID:', postId);

				// Envia os dados via AJAX para salvar
				fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
					method: 'POST',
					headers: {
						'Content-Type': 'application/x-www-form-urlencoded',
					},
					body: new URLSearchParams({
						'action': 'save_map_meta',
						'post_id': postId,
						'nome_completo': nomeCompleto,
						'data_nascimento': dataNascimento,
					})
				})
					.then(response => response.json())
					.then(data => {
						if (data.success) {
							alert('Alterações salvas com sucesso!');
							atualizarResultados(nomeCompleto, dataNascimento);
						} else {
							alert('Erro ao salvar as alterações 01.');
						}
					})
					.catch(error => {
						console.error('Erro:', error);
						alert('Erro ao salvar as alterações 02.');
					});
			});

			// Função para recalcular e atualizar os resultados
			function atualizarResultados(nomeCompleto, dataNascimento) {
				// Aqui você pode fazer uma nova chamada AJAX para recalcular os resultados
				// e atualizar o DOM com os novos valores.
				// Exemplo (isso seria substituído pela lógica de recalcular no PHP e atualizar o front):
				document.getElementById('resultado-motivacao').textContent = 'Novo valor motivação';
				document.getElementById('resultado-impressao').textContent = 'Novo valor impressão';
				document.getElementById('resultado-expressao').textContent = 'Novo valor expressão';
				document.getElementById('resultado-arcano').textContent = 'Novo valor arcano';
				// Outros campos podem ser atualizados da mesma maneira.
			}
		});
	</script>

	<style>
		.bg-impressao{
			background: #FF8080!important;
		}
		.bg-motivacao{
			background: #8080FF!important;
		}
		.bg-expressao{
			background: #80FFFF!important;
		}
		.item {
			background: #e2e8f0;
			min-width: 20px;
			min-height: 100%;
			display: flex;
			align-items: center;
			justify-content: center;
			font-size: 14px;
			text-align: center;
			line-height: 1.5; /* Adiciona uma linha base consistente para alinhamento */
			border-radius: 25%;
			box-shadow: 0px 0px 3px dimgray;
		}
	</style>

<?php
get_footer();
