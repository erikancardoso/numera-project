<?php

class NumerologiaDados {
	public static function obterAlfabeto() {
		return [
			'a' => 1, 'A' => 1, 'b' => 2, 'B' => 2, 'c' => 3, 'C' => 3, 'd' => 4, 'D' => 4,
			'e' => 5, 'E' => 5, 'f' => 8, 'F' => 8, 'g' => 3, 'G' => 3, 'h' => 5, 'H' => 5,
			'i' => 1, 'I' => 1, 'j' => 1, 'J' => 1, 'k' => 2, 'K' => 2, 'l' => 3, 'L' => 3,
			'm' => 4, 'M' => 4, 'n' => 5, 'N' => 5, 'o' => 7, 'O' => 7, 'p' => 8, 'P' => 8,
			'q' => 1, 'Q' => 1, 'r' => 2, 'R' => 2, 's' => 3, 'S' => 3, 't' => 4, 'T' => 4,
			'u' => 6, 'U' => 6, 'v' => 6, 'V' => 6, 'w' => 6, 'W' => 6, 'x' => 6, 'X' => 6,
			'y' => 1, 'Y' => 1, 'z' => 7, 'Z' => 7, 'ç' => 6, 'Ç' => 6
		];
	}

	public static function obterTabelaPiramides()
	{
		return [
			1 => ['a', 'A', 'i', 'I', 'j', 'J', 'q', 'Q', 'y', 'Y'],
			2 => ['b', 'B', 'k', 'K', 'r', 'R'],
			3 => ['c', 'C', 'g', 'G', 'l', 'L', 's', 'S'],
			4 => ['d', 'D', 'm', 'M', 't', 'T'],
			5 => ['e', 'E', 'h', 'H', 'n', 'N', 'x', 'X'],
			6 => ['u', 'U', 'v', 'V', 'w', 'W', 'ç', 'Ç'],
			7 => ['o', 'O', 'z', 'Z'],
			8 => ['f', 'F', 'p', 'P'],
			9 => [] // Posicionamento de letras adicionadas ou modificadas
		];
	}

	public static function obterVogais() {
		$alfabeto = self::obterAlfabeto();
		return array_filter($alfabeto, function($letra) {
			return in_array(strtolower($letra), ['a', 'e', 'i', 'o', 'u', 'y']);
		}, ARRAY_FILTER_USE_KEY);
	}

	public static function obterConsoantes() {
		$alfabeto = self::obterAlfabeto();
		return array_filter($alfabeto, function($letra) {
			return !in_array(strtolower($letra), ['a', 'e', 'i', 'o', 'u', 'y']);
		}, ARRAY_FILTER_USE_KEY);
	}

	public static function obterTabelaHarmoniaConjugal() {
		return [
			1 => [
				'vibra_com' => '9',
				'atrai' => '4 e 8',
				'e_oposto' => '6 e 7',
				'e_passivo_em_relação_a' => '2, 3 e 5'
			],
			2 => [
				'vibra_com' => '8',
				'atrai' => '7 e 9',
				'e_oposto' => '5',
				'e_passivo_em_relação_a' => '1, 3, 4 e 6'
			],
			3 => [
				'vibra_com' => '7',
				'atrai' => '5, 6 e 9',
				'e_oposto' => '4 e 8',
				'e_passivo_em_relação_a' => '1 e 2'
			],
			4 => [
				'vibra_com' => '6',
				'atrai' => '1 e 8',
				'e_oposto' => '3 e 5',
				'e_passivo_em_relação_a' => '2, 7 e 9'
			],
			5 => [
				'vibra_com' => '5',
				'atrai' => '3 e 9',
				'e_oposto' => '2 e 4; profundamente oposto a 6',
				'e_passivo_em_relação_a' => '1, 7 e 8'
			],
			6 => [
				'vibra_com' => '4',
				'atrai' => '3, 7 e 9',
				'e_oposto' => '1 e 8; profundamente oposto a 5',
				'e_passivo_em_relação_a' => '2'
			],
			7 => [
				'vibra_com' => '3',
				'atrai' => '2 e 6',
				'e_oposto' => '1 e 9',
				'e_passivo_em_relação_a' => '4, 5 e 8'
			],
			8 => [
				'vibra_com' => '2',
				'atrai' => '1 e 4',
				'e_oposto' => '3 e 6',
				'e_passivo_em_relação_a' => '5, 7 e 9'
			],
			9 => [
				'vibra_com' => '1',
				'atrai' => '2, 3, 5 e 6',
				'e_oposto' => '7',
				'e_passivo_em_relação_a' => '4 e 8'
			],
		];
	}

	public static function obterCores() {
		return [
			1 => ['Todos os tons de amarelo', 'laranja', 'castanho', 'dourado', 'verde', 'creme', 'branco'],
			2 => ['Todos os tons de verde', 'creme', 'branco', 'cinza'],
			3 => ['violeta', 'vinho', 'púrpura', 'vermelho'],
			4 => ['azul', 'cinza', 'púrpura', 'ouro'],
			5 => ['Todos os tons claros', 'cinza', 'prateado'],
			6 => ['rosa', 'azul', 'verde'],
			7 => ['verde', 'amarelo', 'branco', 'cinza', 'azul-claro'],
			8 => ['púrpura', 'cinza', 'azul', 'preto', 'castanho'],
			9 => ['vermelho', 'rosa', 'coral', 'vinho'],
			11 => ['branco', 'violeta', 'cores claras'],
			22 => ['violeta', 'branco', 'cores claras']
		];
	}

	public static function obterNumerosHarmoncos() {
		return  [
			1 => [2, 4, 9],
			2 => [1, 2, 3, 4, 5, 6, 7, 8, 9],
			3 => [2, 3, 6, 8, 9],
			4 => [1, 2, 6, 7],
			5 => [2, 5, 6, 7, 9],
			6 => [2, 3, 4, 5, 6, 9],
			7 => [2, 4, 5, 7],
			8 => [2, 3, 9],
			9 => [1, 2, 3, 5, 6, 8, 9],
		];
	}

	public static function obterTabelaNumerosFavoraveis() {
		return [
			"janeiro" => [
				1 => [1, 5], 2 => [1, 6], 3 => [3, 6], 4 => [1, 5], 5 => [5, 6], 6 => [5, 6], 7 => [1, 7],
				8 => [1, 3], 9 => [6, 9], 10 => [1, 5], 11 => [1, 6], 12 => [6, 9], 13 => [1, 5], 14 => [5, 6],
				15 => [5, 6], 16 => [1, 5], 17 => [1, 3], 18 => [5, 6], 19 => [1, 5], 20 => [1, 6], 21 => [3, 6],
				22 => [1, 5], 23 => [5, 6], 24 => [5, 6], 25 => [1, 5], 26 => [2, 3], 27 => [6, 9], 28 => [2, 7],
				29 => [5, 7], 30 => [2, 3], 31 => [2, 7]
			],
			"fevereiro" => [
				1 => [2, 7], 2 => [2, 7], 3 => [3, 6], 4 => [2, 7], 5 => [5, 6], 6 => [3, 6], 7 => [2, 7],
				8 => [2, 3], 9 => [3, 6], 10 => [2, 7], 11 => [5, 7], 12 => [5, 6], 13 => [2, 7], 14 => [5, 6],
				15 => [3, 6], 16 => [2, 5], 17 => [2, 3], 18 => [3, 6], 19 => [2, 7], 20 => [2, 7], 21 => [3, 6],
				22 => [2, 7], 23 => [5, 6], 24 => [5, 6], 25 => [2, 7], 26 => [2, 3], 27 => [6, 9], 28 => [2, 7], 29 => [6, 7]
			],
			"marco" => [
				1 => [1, 7], 2 => [2, 7], 3 => [3, 6], 4 => [1, 7], 5 => [5, 7], 6 => [3, 6], 7 => [2, 7],
				8 => [3, 6], 9 => [6, 9], 10 => [1, 7], 11 => [1, 7], 12 => [6, 7], 13 => [1, 5], 14 => [5, 7],
				15 => [3, 6], 16 => [1, 2], 17 => [3, 6], 18 => [3, 6], 19 => [1, 7], 20 => [2, 7], 21 => [3, 6],
				22 => [1, 7], 23 => [6, 7], 24 => [3, 6], 25 => [2, 7], 26 => [1, 3], 27 => [1, 9], 28 => [5, 9],
				29 => [1, 7], 30 => [3, 9], 31 => [1, 7]
			],
			"abril" => [
				1 => [1, 7], 2 => [1, 7], 3 => [3, 9], 4 => [1, 7], 5 => [5, 7], 6 => [3, 6], 7 => [5, 7],
				8 => [1, 3], 9 => [3, 9], 10 => [1, 7], 11 => [1, 7], 12 => [1, 9], 13 => [1, 7], 14 => [5, 7],
				15 => [3, 6], 16 => [1, 2], 17 => [1, 3], 18 => [1, 3], 19 => [1, 7], 20 => [2, 7], 21 => [1, 3],
				22 => [1, 7], 23 => [5, 7], 24 => [3, 5], 25 => [5, 7], 26 => [2, 3], 27 => [3, 6], 28 => [2, 7],
				29 => [1, 7], 30 => [3, 6]
			],
			"maio" => [
				1 => [1, 2], 2 => [2, 7], 3 => [3, 6], 4 => [1, 7], 5 => [5, 6], 6 => [5, 6], 7 => [2, 7],
				8 => [2, 5], 9 => [5, 9], 10 => [1, 5], 11 => [1, 7], 12 => [2, 6], 13 => [1, 7], 14 => [5, 6],
				15 => [5, 6], 16 => [2, 5], 17 => [2, 3], 18 => [5, 6], 19 => [1, 2], 20 => [2, 7], 21 => [3, 6],
				22 => [1, 7], 23 => [5, 6], 24 => [5, 6], 25 => [2, 7], 26 => [2, 5], 27 => [5, 9], 28 => [2, 7],
				29 => [5, 7], 30 => [5, 6], 31 => [1, 5]
			],
			"junho" => [
				1 => [1, 5], 2 => [2, 7], 3 => [5, 6], 4 => [1, 5], 5 => [5, 6], 6 => [5, 6], 7 => [2, 7],
				8 => [3, 5], 9 => [5, 9], 10 => [1, 5], 11 => [5, 7], 12 => [5, 6], 13 => [1, 5], 14 => [5, 6],
				15 => [5, 6], 16 => [2, 5], 17 => [2, 5], 18 => [5, 6], 19 => [1, 5], 20 => [2, 7], 21 => [5, 6],
				22 => [1, 5], 23 => [5, 6], 24 => [5, 6], 25 => [2, 7], 26 => [2, 5], 27 => [5, 6], 28 => [2, 7],
				29 => [1, 7], 30 => [2, 3]
			],
			"julho" => [
				1 => [1, 2], 2 => [2, 7], 3 => [2, 3], 4 => [1, 7], 5 => [5, 7], 6 => [2, 6], 7 => [2, 7],
				8 => [2, 3], 9 => [2, 3], 10 => [1, 2], 11 => [1, 7], 12 => [2, 6], 13 => [1, 2], 14 => [5, 7],
				15 => [6, 7], 16 => [1, 2], 17 => [2, 3], 18 => [2, 3], 19 => [1, 2], 20 => [2, 7], 21 => [3, 6],
				22 => [1, 2], 23 => [5, 7], 24 => [6, 7], 25 => [2, 7], 26 => [2, 3], 27 => [1, 9], 28 => [2, 7],
				29 => [1, 7], 30 => [3, 6], 31 => [1, 7]
			],
			"agosto" => [
				1 => [1, 7], 2 => [1, 7], 3 => [3, 6], 4 => [1, 7], 5 => [5, 6], 6 => [3, 6], 7 => [2, 7],
				8 => [2, 3], 9 => [3, 6], 10 => [1, 7], 11 => [1, 7], 12 => [2, 7], 13 => [1, 7], 14 => [5, 6],
				15 => [1, 6], 16 => [1, 2], 17 => [3, 6], 18 => [3, 6], 19 => [1, 7], 20 => [2, 7], 21 => [3, 6],
				22 => [1, 7], 23 => [5, 7], 24 => [3, 6], 25 => [2, 7], 26 => [2, 3], 27 => [1, 9], 28 => [5, 9],
				29 => [1, 7], 30 => [3, 6], 31 => [1, 5]
			],
			"setembro" => [
				1 => [1, 5], 2 => [1, 6], 3 => [1, 6], 4 => [1, 7], 5 => [5, 6], 6 => [3, 6], 7 => [2, 7],
				8 => [3, 6], 9 => [5, 9], 10 => [1, 5], 11 => [5, 7], 12 => [5, 6], 13 => [1, 5], 14 => [5, 6],
				15 => [3, 6], 16 => [1, 5], 17 => [2, 3], 18 => [5, 6], 19 => [1, 5], 20 => [1, 7], 21 => [3, 6],
				22 => [1, 7], 23 => [5, 6], 24 => [5, 6], 25 => [2, 7], 26 => [2, 3], 27 => [6, 9], 28 => [2, 7],
				29 => [5, 7], 30 => [3, 6]
			],
			"outubro" => [
				1 => [1, 5], 2 => [1, 6], 3 => [1, 6], 4 => [1, 7], 5 => [5, 7], 6 => [3, 6], 7 => [2, 7],
				8 => [2, 3], 9 => [5, 9], 10 => [1, 5], 11 => [5, 7], 12 => [5, 6], 13 => [1, 5], 14 => [5, 6],
				15 => [3, 6], 16 => [1, 5], 17 => [2, 3], 18 => [3, 6], 19 => [1, 5], 20 => [1, 6], 21 => [3, 6],
				22 => [1, 7], 23 => [5, 7], 24 => [3, 6], 25 => [2, 7], 26 => [2, 3], 27 => [6, 9], 28 => [2, 7],
				29 => [5, 7], 30 => [3, 6], 31 => [1, 7]
			],
			"novembro" => [
				1 => [1, 7], 2 => [1, 7], 3 => [1, 6], 4 => [1, 7], 5 => [5, 6], 6 => [3, 6], 7 => [2, 7],
				8 => [3, 6], 9 => [5, 9], 10 => [1, 5], 11 => [5, 7], 12 => [5, 6], 13 => [1, 5], 14 => [5, 6],
				15 => [3, 6], 16 => [1, 5], 17 => [2, 3], 18 => [3, 6], 19 => [1, 5], 20 => [1, 6], 21 => [3, 6],
				22 => [1, 7], 23 => [5, 7], 24 => [3, 6], 25 => [2, 7], 26 => [2, 3], 27 => [6, 9], 28 => [2, 7],
				29 => [5, 7], 30 => [3, 6]
			],
			"dezembro" => [
				1 => [1, 5], 2 => [1, 6], 3 => [1, 6], 4 => [1, 7], 5 => [5, 7], 6 => [3, 6], 7 => [2, 7],
				8 => [2, 3], 9 => [5, 9], 10 => [1, 5], 11 => [5, 7], 12 => [5, 6], 13 => [1, 5], 14 => [5, 6],
				15 => [3, 6], 16 => [1, 5], 17 => [2, 3], 18 => [3, 6], 19 => [1, 5], 20 => [1, 6], 21 => [3, 6],
				22 => [1, 7], 23 => [5, 7], 24 => [3, 6], 25 => [2, 7], 26 => [2, 3], 27 => [6, 9], 28 => [2, 7],
				29 => [5, 7], 30 => [3, 6], 31 => [1, 3]
			]
			//verificar se tabela esta correta de agosto a dezembro
		];
	}

	public static function obterMeses() {
		return [
			"janeiro",
			"fevereiro",
			"março",
			"abril",
			"maio",
			"junho",
			"julho",
			"agosto",
			"setembro",
			"outubro",
			"novembro",
			"dezembro"
		];
	}

	public static function obterProfissoes() {
		return [
			1 => ["empreendedor", "gestor", "executivo", "diretor", "presidente", "CEO", "gerente", "coordenador", "arquiteto", "advogado", "redator", "chefe de departamento", "publicitário", "inventor", "escritor", "líder comercial", "programador", "militar", "conferencista", "promotor", "inspetor", "analista", "embaixador", "editor", "produtor de filmes", "produtor teatral", "fazendeiro", "piloto", "ilustrador", "político", "geógrafo", "médico", "designer"],
			2 => ["professor", "estudante", "pesquisador", "secretário", "político", "diplomata", "psicólogo", "contador", "estatístico", "poeta", "médico", "músico", "cantor", "dançarino", "consultor", "bibliotecário", "administrador", "mecânico", "legislador", "pastor", "cobrador", "escriturário", "colunista", "agente de turismo", "biógrafo", "compositor", "paisagista", "produtor", "astrônomo", "garçom", "arquiteto", "ministro", "publicitário", "medium", "escultor"],
			3 => ["estilista", "esteticista", "modelo", "pregador", "músico", "ator", "administrador", "jornalista", "artista", "publicitário", "escritor", "decorador", "designer", "paisagista", "aviador", "crítico literário", "executivo", "influencer", "maquiador", "cabeleireiro", "promotor de eventos", "farmacêutico", "cartunista", "eletricista", "professor", "artesão", "filósofo", "promotor", "fotógrafo", "linguista", "químico", "médico", "assistente social", "advogado", "juiz", "sacerdote", "atleta", "humorista", "costureiro", "conferencista"],
			4 => ["corretor de imóveis", "eletricista", "mecânico", "relojoeiro", "caixa", "comerciante", "mineiro", "garçom", "fazendeiro", "pedreiro", "perito", "encanador", "instrutor", "operário", "revisor", "construtor", "arquiteto", "artesão", "arqueólogo", "engenheiro", "contador", "economista", "executivo", "militar", "marceneiro", "policial", "bombeiro", "dentista", "químico", "empreiteiro", "investidor"],
			5 => ["vendedor", "artista", "promotor de eventos", "político", "servidor público", "detetive", "advogado", "repórter", "publicitário", "orador", "ator", "comissário de bordo", "agente de viagens", "policial", "aviador", "relações públicas", "líder civil", "investigador", "jornalista", "viajante", "investidor", "guia turístico", "professor de idiomas", "intérprete", "esportista", "gerente logística", "comprador", "agrimensor", "marinheiro", "inventor", "promotor", "diretor teatral", "colunista", "conferencista", "editor", "psicólogo", "escritor", "fotógrafo", "geógrafo", "político", "consultor"],
			6 => ["diplomata", "ministro", "médico", "psicólogo", "advogado da família", "enfermeiro", "nutricionista", "dentista", "poeta", "músico", "ator", "artista", "escritor", "estilista", "desenhista", "designer de interiores", "consultor", "instrutor", "professor", "terapeuta", "administrador hospitalar", "diretor de escola", "camareiro", "executivo de produtos domésticos", "costureiro", "corretor de imóveis", "jardineiro", "paisagista", "pecuarista", "serviços domésticos", "agricultor", "lojista", "comerciante", "perfumista", "servidor público", "recepcionista", "economista", "floricultor", "tutor", "decorador"],
			7 => ["cientista", "químico", "biológico", "físico", "artesão", "pesquisador", "analista", "político", "sacerdote", "líder religioso", "astrólogo", "numerólogo", "filósofo", "teólogo", "matemático", "advogado", "juiz", "reitor", "professor", "detetive", "cirurgião", "radialista", "escritor", "editor", "cientista de dados", "engenheiro eletrônico", "técnico de Informática", "bibliotecário", "banqueiro", "contador", "psicanalista", "psicólogo", "desenhista", "arquiteto", "auditor", "superintendente", "ocultista", "dentista", "arqueólogo", "historiador", "astrônomo", "engenheiro", "pregador", "musicista"],
			8 => ["consultor", "corretor de imóveis", "banqueiro", "gerente de lojas", "executivo gráfica", "executivo editora", "executivo jornal", "presidente de empresa", "empreendedor", "executivo", "investidor", "comprador", "vendedor", "político", "filantropo", "treinador de esportes", "servidor público", "administrador", "juiz", "promotor", "analista comercial", "supervisor", "farmacêutico", "militar", "contador", "químico", "caixa", "estatístico", "engenheiro", "analista bancário", "investigador", "conselheiro financeiro", "advogado empresarial", "supervisor", "produtor"],
			9 => ["artista", "ator", "escultor", "professor", "músico", "diplomata", "policial", "médico", "líder religioso", "diretor de ongs", "assistente social", "advogado", "juiz", "bombeiro", "político", "filantropo", "cirurgião", "dentista", "nutricionista", "enfermeiro", "psicólogo", "comissário de bordo", "agente de viagens", "humorista", "horticultor", "paisagista", "recepcionista", "cientista", "conferencista", "repórter", "eletricista", "engenheiro", "astrônomo", "ocultista", "desenhista", "conselheiro", "apresentador", "compositor", "publicitário", "mágico", "pesquisador", "promotor", "aviador", "vendedor de arte", "pregador", "ilustrador", "químico"],
			11 => ["líder religioso", "filántropo", "sacerdote", "astrólogo", "numerólogo", "filósofo", "fotógrafo", "escritor", "poeta", "psicanalista", "psicólogo", "ministro", "crítico comentarista", "inventor", "ator", "medium", "aviador", "cientista", "artista", "esotérico", "terapeuta", "jornalista", "apresentador", "publicitário", "radialista", "colecionador", "pregador", "orador", "diplomata", "político", "pesquisador", "místico", "artista"],
			22 => ["vendedor", "artista", "promotor de eventos", "político", "servidor público", "detetive", "advogado", "repórter", "publicitário", "orador", "ator", "comissário de bordo", "agente de viagens", "policial", "aviador", "relações públicas", "líder civil", "investigador", "jornalista", "viajante", "investidor", "guia turístico", "professor de idiomas", "intérprete", "esportista", "gerente logística", "comprador", "agrimensor", "marinheiro", "inventor", "promotor", "diretor teatral", "colunista", "conferencista", "editor", "psicólogo", "escritor", "fotógrafo", "geógrafo", "político", "consultor"],
		];
	}
}
