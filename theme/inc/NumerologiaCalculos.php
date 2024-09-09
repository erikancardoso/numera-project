<?php

class NumerologiaCalculos {

    public static function somarAlgarismos($numero) {
        return array_sum(str_split($numero));
    }

    public static function reduzirNumeroSimples($numero) {
        while ($numero > 9) {
            $numero = self::somarAlgarismos($numero);
        }
        return $numero;
    }

    public static function reduzirNumeroMestre($numero) {
        while ($numero > 9 && !in_array($numero, [11, 22])) {
            $numero = self::somarAlgarismos($numero);
        }
        return $numero;
    }

    public static function reduzirTeosoficamente($numero)
    {
        while ($numero > 9 && $numero != 11 && $numero != 22) {
            $numero = array_sum(str_split($numero));
        }
        return $numero;
    }

    public static function calcularSomaLetras($nome, $tabela) {
        $soma = 0;
        foreach (str_split($nome) as $letra) {
            if (isset($tabela[$letra])) {
                $soma += $tabela[$letra];
            }
        }
        return self::reduzirNumeroMestre($soma);
    }

    public static function calcularAnoPessoal($dataNascimento)
    {
        $anoAtual = intval(date('Y'));
        $diaNascimento = (int)date('d', strtotime($dataNascimento));
        $mesNascimento = (int)date('m', strtotime($dataNascimento));

        // Reduzindo os valores para dígitos únicos
        $diaNascimento = self::reduzirNumeroSimples($diaNascimento);
        $mesNascimento = self::reduzirNumeroSimples($mesNascimento);

        // Verificando se o aniversário já passou neste ano
        $aniversarioEsteAno = new DateTime("$anoAtual-$mesNascimento-$diaNascimento");
        $hoje = new DateTime();

        // Se o aniversário ainda não passou, usamos o ano anterior
        $anoUso = $hoje < $aniversarioEsteAno ? $anoAtual : $anoAtual - 1;
        $anoUso = self::reduzirNumeroSimples($anoUso);

        // Calculando a soma e a redução final
        $soma = $diaNascimento + $mesNascimento + $anoUso;
        return self::reduzirNumeroSimples($soma);
    }

    public static function mesPessoalCalc($anoPessoal)
    {
        $mes = date('m');
        return $anoPessoal + intval($mes);
    }

    public static function calcularDiaPessoal($mesPessoal) {
        $hoje = intval(date('d'));
        return self::reduzirNumeroSimples($hoje + intval($mesPessoal));
    }

    public static function calcularNumeroDestino($dataNascimento) {

       $dia = self::reduzirNumeroSimples((int)date('d', strtotime($dataNascimento)));
       $mes = self::reduzirNumeroSimples((int)date('m', strtotime($dataNascimento)));
       $ano = self::reduzirNumeroSimples((int)date('Y', strtotime($dataNascimento)));

       $sem_reducao = $dia + $mes + $ano;

        return self::reduzirNumeroSimples($sem_reducao);
    }

    public static function calcularLicoesCarmicas($nome, $tabela) {

        $contagemNumeros = array_fill(1, 9, 0);

        foreach (str_split(strtolower($nome)) as $letra) {
            if (isset($tabela[$letra])) {
                $contagemNumeros[$tabela[$letra]]++;
            }
        }
        $licoes =  array_keys(array_filter($contagemNumeros, fn($count) => $count == 0));

        return !empty($licoes) ? implode(', ', $licoes) : 'Sem Lições Cármicas';

    }

    public static function calcularCiclos($dataNascimento, $licoesCarmicas) {
        $dia= (int)date('d', strtotime($dataNascimento));
        $mes = (int)date('m', strtotime($dataNascimento));
        $ano = (int)date('Y', strtotime($dataNascimento));

        $primeiroCiclo = ($mes != 11) ? self::reduzirNumeroSimples($mes) : $mes;
        $numeroDestino = self::calcularNumeroDestino($dataNascimento);
        $anoInicioPrimeiroCiclo = $ano;
        $anoFimPrimeiroCiclo = $anoInicioPrimeiroCiclo + (37 - $numeroDestino);
        $dataInicioPrimeiroCiclo = "{$dia}-{$mes}-{$anoInicioPrimeiroCiclo}";
        $dataFimPrimeiroCiclo = "{$dia}-{$mes}-{$anoFimPrimeiroCiclo}";

        $segundoCiclo = ($dia != 11 && $dia != 22) ? self::reduzirNumeroSimples($dia) : $dia;
        $anoInicioSegundoCiclo = $anoFimPrimeiroCiclo;
        $anoFimSegundoCiclo = $anoInicioSegundoCiclo + 27;
        $dataInicioSegundoCiclo = "{$dia}-{$mes}-{$anoInicioSegundoCiclo}";
        $dataFimSegundoCiclo = "{$dia}-{$mes}-{$anoFimSegundoCiclo}";

        $terceiroCiclo = ($ano != 11 && $ano != 22) ? self::reduzirNumeroSimples($ano) : $ano;
        $anoInicioTerceiroCiclo = $anoFimSegundoCiclo;
        $dataInicioTerceiroCiclo = "{$dia}-{$mes}-{$anoInicioTerceiroCiclo}";

        $ciclos = [
            'ciclo_1' => [
                'numero' => $primeiroCiclo,
                'periodo' => "{$dataInicioPrimeiroCiclo} - {$dataFimPrimeiroCiclo}"
            ],
            'ciclo_2' => [
                'numero' => $segundoCiclo,
                'periodo' => "{$dataInicioSegundoCiclo} - {$dataFimSegundoCiclo}"
            ],
            'ciclo_3' => [
                'numero' => $terceiroCiclo,
                'periodo' => "{$dataInicioTerceiroCiclo} - Até o fim da vida"
            ]
        ];

        $alertas = [];
        foreach ($ciclos as $nomeCiclo => $ciclo) {
            if (in_array($ciclo['numero'], $licoesCarmicas)) {
                $alertas[] = "Alerta: O {$nomeCiclo} (numero: {$ciclo['numero']}) coincide com uma Lição Cármica. Este período pode ser conturbado.";
            }
        }

        return [
            'ciclos' => $ciclos,
            'alertas' => $alertas,
            'fim_primeiro_ciclo' => $dataFimPrimeiroCiclo
        ];
    }

	public static function coresFavoraveis($nomeCompleto, $alfabeto, $cores) {
		$numeroExpressao = NumerologiaCalculos::calcularNumeroExpressao($nomeCompleto, $alfabeto);

		return isset($cores[$numeroExpressao])
			? 'Cores favoráveis: ' . implode(', ', $cores[$numeroExpressao])
			: 'Nenhuma cor favorável encontrada para este número de Expressão';
	}

    public static function grauAscensao($nomeCompleto, $tabela) {
        $numeroImpressao = self::calcularNumeroImpressao($nomeCompleto, $tabela);
        $numeroMotivacao = self::calcularNumeroMotivacao($nomeCompleto, $tabela);

        if ($numeroMotivacao == $numeroImpressao) {
            return "Espírito Elevado";
        } elseif ($numeroMotivacao > $numeroImpressao) {
            return "Espírito Rebaixado";
        } else {
            return "Espírito em Ascensão";
        }
    }

	public static function numerosHarmonicos($dataNascimento, $numerosHarmonicosTabela)
	{
		// Extrair o dia da data de nascimento
		$dia = date('d', strtotime($dataNascimento));

		// Realizar a redução teosófica do dia
		$reduzido = array_sum(str_split($dia));
		while ($reduzido > 9) {
			$reduzido = array_sum(str_split($reduzido));
		}

		// Obter o conjunto de números harmônicos baseado no resultado reduzido
		$numerosResultantes = $numerosHarmonicosTabela[$reduzido];

		// Retornar o resultado
		return $numerosResultantes;
	}

    public static function obterDiasFavoraveis($dataNascimento, $tabelaNumerosFavoraveis, $meses) {
        $diaNascimento = (int)date('d', strtotime($dataNascimento));
        $mesNascimento = (int)date('m', strtotime($dataNascimento));

        $mesStr = $meses[$mesNascimento - 1];

        $numerosBasicos = $tabelaNumerosFavoraveis[$mesStr][$diaNascimento] ?? [];
        if (empty($numerosBasicos)) {
            return [];
        }

        $sequencia = $numerosBasicos;
        for ($i = 2; $i < 10; $i++) {
            $novoNumero = $sequencia[$i - 1] + ($i % 2 == 0 ? $numerosBasicos[1] : $numerosBasicos[0]);
            if ($novoNumero <= 31) {
                $sequencia[] = $novoNumero;
            } else {
                break;
            }
        }


        return !empty($sequencia) ? implode(', ', $sequencia) : '';

    }

    public static function calcularNumeroImpressao($nome, $consoantes) {
		return self::calcularSomaLetras($nome, $consoantes);
    }

    public static function calcularNumeroExpressao($nomeCompleto, $tabela) {
        return self::calcularSomaLetras($nomeCompleto, $tabela);
    }

    public static function calcularNumeroMotivacao($nome, $vogais) {
        return self::calcularSomaLetras($nome, $vogais);
    }

    public static function calcularNumeroMissao($numeroDestino, $numeroExpressao) {
        $soma = $numeroDestino + $numeroExpressao;
        return self::reduzirNumeroMestre($soma);
    }

    public static function calculoDividasCarmicas($nomeCompleto, $dataNascimento, $tabela) {
        $diaNascimento = (int)date('d', strtotime($dataNascimento));
        $dividaCarmica = in_array($diaNascimento, [13, 14, 16, 19]) ? [$diaNascimento] : [];

        $numeroDestino = self::calcularNumeroDestino($dataNascimento);
        $numeroMotivacao = self::calcularSomaLetras(preg_replace('/[^aeiouAEIOUY]/', '', $nomeCompleto), $tabela);
        $numeroExpressao = self::calcularNumeroExpressao($nomeCompleto, $tabela);

        $mapaDividas = [
            4 => 13,
            5 => 14,
            7 => 16,
            1 => 19
        ];

        foreach ([$numeroDestino, $numeroMotivacao, $numeroExpressao] as $numero) {
            if (isset($mapaDividas[$numero])) {
                $dividaCarmica[] = $mapaDividas[$numero];
            }
        }

        $dividaCarmica = array_unique($dividaCarmica);
        sort($dividaCarmica);

        return !empty($dividaCarmica) ? implode(', ', $dividaCarmica) : 'Sem Dívida Cármica';
    }

    public static function calcularTendenciaOculta($nome, $tabela) {
        // Remover espaços e caracteres não alfabéticos
        $nome = preg_replace('/[^a-zA-Z]/', '', $nome);

        // Contagem de frequências dos números
        $frequencias = [];
        foreach (str_split($nome) as $letra) {
            if (isset($tabela[$letra])) {
                $numero = self::reduzirNumeroSimples($tabela[$letra]);
                if (isset($frequencias[$numero])) {
                    $frequencias[$numero]++;
                } else {
                    $frequencias[$numero] = 1;
                }
            }
        }

        // Identificar tendências ocultas
        $tendenciasOcultas = [];
        foreach ($frequencias as $numero => $contagem) {
            if ($contagem > 3) {
                $tendenciasOcultas[] = $numero;
            }
        }

        // Ordenar as tendências ocultas em ordem numérica
        sort($tendenciasOcultas);

        // Retornar tendências ocultas
        return !empty($tendenciasOcultas) ? implode(', ', $tendenciasOcultas) : '$tendenciasOcultas';

    }

    public static function calcularRespostaSubconsciente($nome, $tabela) {
        $nome = preg_replace('/[^a-zA-Z]/', '', $nome);
        $numeros = [];

        foreach (str_split($nome) as $letra) {
            if (isset($tabela[$letra])) {
                $numeros[] = $tabela[$letra];
            }
        }

        return count(array_unique($numeros));
    }

    public static function relacoesIntervalores($nomeCompleto, $tabela) {
        $primeiroNome = explode(' ', trim($nomeCompleto))[0];
        $primeiroNome = strtolower($primeiroNome);

        $numeros = [];
        foreach (str_split($primeiroNome) as $letra) {
            if (isset($tabela[$letra])) {
                $numeros[] = $tabela[$letra];
            }
        }

        $contagemNumeros = array_count_values($numeros);
        $grupos = array_filter($contagemNumeros, fn($contagem) => $contagem > 1);

        return count($grupos) === 1 ? array_key_first($grupos) : "Nenhuma relação intervalor";
    }

    public static function calcularNumeroPsiquico($dataNascimento) {
		$diaNascimento = (int)date('d', strtotime($dataNascimento));
        return self::reduzirNumeroSimples($diaNascimento);
    }

    public static function talentoOculto($motivacao, $numeroDeExpressao) {
        $talentoOculto = self::reduzirNumeroMestre($motivacao + $numeroDeExpressao);

        if (in_array($talentoOculto, [10, 11])) {
            return $talentoOculto;
        }

        return self::reduzirNumeroMestre($talentoOculto);
    }

    public static function momentosDecisivos($dataNascimento, $dataFimPrimeiroCiclo) {
		$dataFimPrimeiroCiclo = (int)date('Y', strtotime($dataFimPrimeiroCiclo));
        $diaNascimento = (int)date('d', strtotime($dataNascimento));
        $mesNascimento = (int)date('m', strtotime($dataNascimento));
        $anoNascimento = (int)date('Y', strtotime($dataNascimento));

        $diaReduzido = self::reduzirTeosoficamente($diaNascimento);
        $mesReduzido = self::reduzirTeosoficamente($mesNascimento);
        $anoReduzido = self::reduzirTeosoficamente($anoNascimento);

        $primeiroMomento = $diaReduzido + $mesReduzido;
        $segundoMomento = $diaReduzido + $anoReduzido;
        $terceiroMomento = $primeiroMomento + $segundoMomento;
        $quartoMomento = $mesReduzido + $anoReduzido;

        return [
            "primeiroMomento" => $primeiroMomento,
            "momentoInicial1" => $anoNascimento,
            "momentoFinal1" => $dataFimPrimeiroCiclo,

            "segundoMomento" => $segundoMomento,
            "momentoInicial2" => $dataFimPrimeiroCiclo,
            "momentoFinal2" => $dataFimPrimeiroCiclo + 9,

            "terceiroMomento" => $terceiroMomento,
            "momentoInicial3" => $dataFimPrimeiroCiclo + 9,
            "momentoFinal3" => $dataFimPrimeiroCiclo + 18,

            "quartoMomento" => $quartoMomento,
            "momentoInicial4" => $dataFimPrimeiroCiclo + 18,
            "momentoFinal4" => "até o fim da vida"
        ];
    }

    public static function calcularNumeroAmor($numero_destino, $numero_expressao, $tabelaNumeros)
    {

        $soma = $numero_destino + $numero_expressao;
        $numero_amor = self::reduzirNumeroSimples($soma);
        if (isset($tabelaNumeros[$numero_amor])) {
            return $tabelaNumeros[$numero_amor];
        }
        return $tabelaNumeros[$numero_amor];
    }

	public static function calcularArcanos($nomeCompleto, $dataNascimento, $alfabeto)
	{
		// Converter o nome completo em números usando a tabela
		$numeros = [];
		for ($i = 0; $i < strlen($nomeCompleto); $i++) {
			$letra = $nomeCompleto[$i];
			if (isset($alfabeto[$letra])) {
				$numeros[] = $alfabeto[$letra];
			}
		}

		$arcanos = [];
		for ($i = 0; $i < count($numeros) - 1; $i++) {
			$arcano = $numeros[$i] * 10 + $numeros[$i + 1];
			$arcanos[] = $arcano;
		}

		// Calcular a duração de cada Arcano
		$numArcanos = count($arcanos);
		$duracaoArcanoTotal = 90 / $numArcanos;
		$anosPorArcano = floor($duracaoArcanoTotal);

		// Extrair o número após o ponto decimal para usar como meses
		$mesesPorArcano = ($duracaoArcanoTotal - $anosPorArcano) * 10;
		$mesesPorArcano = (int)$mesesPorArcano; // Converte para inteiro para garantir que seja um valor inteiro

		// Definir a data inicial
		$inicioArcano = new DateTime($dataNascimento);

		$arcanoAtual = '';
		$dataAtual = new DateTime();

		for ($i = 0; $i < count($arcanos); $i++) {
			// Clonar a data de início para não modificar o objeto original
			$fimArcano = clone $inicioArcano;

			// Adicionar os anos e meses calculados
			$fimArcano->add(new DateInterval("P{$anosPorArcano}Y{$mesesPorArcano}M"));

			// Verificar se a data atual está no intervalo deste Arcano
			if ($dataAtual >= $inicioArcano && $dataAtual < $fimArcano) {
				$arcanoAtual = $arcanos[$i];
				break;
			}

			// Atualizar o início do próximo Arcano
			$inicioArcano = clone $fimArcano;
		}

		// Retornar o Arcano em que a pessoa está atualmente
		return [
			'arcanoAtual' => $arcanoAtual,
			'anosPorArcano' => $anosPorArcano,
			'mesesPorArcano' => $mesesPorArcano
		];
	}

	public static function calcularPiramideDestino($nomeCompleto, $dataNascimento, $tabelaPiramde){
		$diaNascimento = (int)date('d', strtotime($dataNascimento));
		$mesNascimento = (int)date('m', strtotime($dataNascimento));

		// Reduzir o dia e o mês
		$diaReducao = array_sum(str_split($diaNascimento));
		if ($diaReducao >= 10) {
			$diaReducao = array_sum(str_split($diaReducao));
		}

		$mesReducao = array_sum(str_split($mesNascimento));
		if ($mesReducao >= 10) {
			$mesReducao = array_sum(str_split($mesReducao));
		}

		// Somar as reduções e reduzir novamente se necessário
		$reducaoFinal = $diaReducao + $mesReducao;
		if ($reducaoFinal > 9) {
			$reducaoFinal = array_sum(str_split($reducaoFinal));
		}

		$tabelaDeslocada = [];
		$tamanhoTabela = count($tabelaPiramde);

		foreach ($tabelaPiramde as $posicao => $letras) {
			$novaPosicao = ($posicao + $reducaoFinal - 1) % $tamanhoTabela + 1;
			$tabelaDeslocada[$novaPosicao] = $letras;
		}

		// Converter o nome completo em números usando a tabela deslocada
		$numeros = [];
		for ($i = 0; $i < strlen($nomeCompleto); $i++) {
			$letra = $nomeCompleto[$i];
			foreach ($tabelaDeslocada as $numero => $letras) {
				if (in_array($letra, $letras)) {
					$numeros[] = $numero;
					break;
				}
			}
		}

		// Construir a pirâmide
		$piramide = [];
		$piramide[] = $numeros;

		while (count($numeros) > 1) {
			$novaLinha = [];
			for ($i = 0; $i < count($numeros) - 1; $i++) {
				$soma = $numeros[$i] + $numeros[$i + 1];
				$novaLinha[] = $soma >= 10 ? $soma - 9 : $soma;
			}
			$piramide[] = $novaLinha;
			$numeros = $novaLinha;
		}

		return $piramide;
	}

	public static function calcularPiramidePessoal($nomeCompleto, $dataNascimento, $tabelaPiramide){

		$diaNascimento = (int)date('d', strtotime($dataNascimento));
		$diaReducao = array_sum(str_split($diaNascimento)); // Reduzir o dia
		if ($diaReducao >= 10) {
			$diaReducao = array_sum(str_split($diaReducao));
		}

		// Criar uma nova tabela deslocada de acordo com a redução do dia
		$tabelaDeslocada = [];
		$tamanhoTabela = count($tabelaPiramide);

		foreach ($tabelaPiramide as $posicao => $letras) {
			$novaPosicao = ($posicao + $diaReducao - 1) % $tamanhoTabela + 1;
			$tabelaDeslocada[$novaPosicao] = $letras;
		}

		// Converter o nome completo em números usando a tabela deslocada
		$numeros = [];
		for ($i = 0; $i < strlen($nomeCompleto); $i++) {
			$letra = $nomeCompleto[$i];
			foreach ($tabelaDeslocada as $numero => $letras) {
				if (in_array($letra, $letras)) {
					$numeros[] = $numero;
					break;
				}
			}
		}

		// Construir a pirâmide
		$piramide = [];
		$piramide[] = $numeros;

		while (count($numeros) > 1) {
			$novaLinha = [];
			for ($i = 0; $i < count($numeros) - 1; $i++) {
				$soma = $numeros[$i] + $numeros[$i + 1];
				$novaLinha[] = $soma >= 10 ? $soma - 9 : $soma;
			}
			$piramide[] = $novaLinha;
			$numeros = $novaLinha;
		}

		return $piramide;
	}

	public static function calcularPiramideSocial($nomeCompleto, $dataNascimento, $tabelaPiramides)
	{
		$mesNascimento = (int)date('m', strtotime($dataNascimento));
		$mesReducao = array_sum(str_split($mesNascimento)); // Reduzir o mês
		if ($mesReducao >= 10) {
			$mesReducao = array_sum(str_split($mesReducao));
		}

		$tabelaDeslocada = [];
		$tamanhoTabela = count($tabelaPiramides);

		foreach ($tabelaPiramides as $posicao => $letras) {
			$novaPosicao = ($posicao + $mesReducao - 1) % $tamanhoTabela + 1;
			$tabelaDeslocada[$novaPosicao] = $letras;
		}

		$numeros = [];
		for ($i = 0; $i < strlen($nomeCompleto); $i++) {
			$letra = $nomeCompleto[$i];
			foreach ($tabelaDeslocada as $numero => $letras) {
				if (in_array($letra, $letras)) {
					$numeros[] = $numero;
					break;
				}
			}
		}

		$piramide = [];
		$piramide[] = $numeros;

		while (count($numeros) > 1) {
			$novaLinha = [];
			for ($i = 0; $i < count($numeros) - 1; $i++) {
				$soma = $numeros[$i] + $numeros[$i + 1];
				$novaLinha[] = $soma >= 10 ? $soma - 9 : $soma;
			}
			$piramide[] = $novaLinha;
			$numeros = $novaLinha;
		}

		return $piramide;
	}

	public static function calcularPiramideVida($nomeCompleto, $alfabeto)
	{

		// Converter o nome completo em números usando a tabela
		$numeros = [];
		for ($i = 0; $i < strlen($nomeCompleto); $i++) {
			$letra = $nomeCompleto[$i];
			if (isset($alfabeto[$letra])) {
				$numeros[] = $alfabeto[$letra];
			}
		}

		$piramide = [];
		$piramide[] = $numeros;

		while (count($numeros) > 1) {
			$novaLinha = [];
			for ($i = 0; $i < count($numeros) - 1; $i++) {
				$soma = $numeros[$i] + $numeros[$i + 1];
				$novaLinha[] = $soma >= 10 ? $soma - 9 : $soma;
			}
			$piramide[] = $novaLinha;
			$numeros = $novaLinha;
		}

		return $piramide;
	}

	public static function calcularArcanoPiramideDestino($nomeCompleto, $dataNascimento, $tabelaPiramde)
	{
		$diaNascimento = (int)date('d', strtotime($dataNascimento));
		$mesNascimento = (int)date('m', strtotime($dataNascimento));

		$diaReducao = array_sum(str_split($diaNascimento)) >= 10 ? array_sum(str_split($diaNascimento)) : '';
		$mesReducao = array_sum(str_split($mesNascimento)) >= 10 ? array_sum(str_split($mesNascimento)) : '';
		$reducaoFinal = $diaReducao + $mesReducao;
		$reducaoFinal = self::reduzirNumeroSimples($reducaoFinal);

		$tabelaDeslocada = [];
		$tamanhoTabela = count($tabelaPiramde);

		foreach ($tabelaPiramde as $posicao => $letras) {
			$novaPosicao = ($posicao + $reducaoFinal - 1) % $tamanhoTabela + 1;
			$tabelaDeslocada[$novaPosicao] = $letras;
		}

		$numeros = [];
		for ($i = 0; $i < strlen($nomeCompleto); $i++) {
			$letra = $nomeCompleto[$i];
			foreach ($tabelaDeslocada as $numero => $letras) {
				if (in_array($letra, $letras)) {
					$numeros[] = $numero;
					break;
				}
			}
		}

		// Gerar a sequência de Arcanos
		$arcanos = [];
		for ($i = 0; $i < count($numeros) - 1; $i++) {
			$arcano = $numeros[$i] * 10 + $numeros[$i + 1];
			$arcanos[] = $arcano;
		}

		// Calcular a duração de cada Arcano
		$numArcanos = count($arcanos);
		$duracaoArcanoTotal = 90 / $numArcanos;
		$anosPorArcano = floor($duracaoArcanoTotal);

		// Extrair o número após o ponto decimal para usar como meses
		$mesesPorArcano = ($duracaoArcanoTotal - $anosPorArcano) * 12;
		$mesesPorArcano = (int)$mesesPorArcano; // Converte para inteiro para garantir que seja um valor inteiro

		// Definir a data inicial
		$inicioArcano = new DateTime($dataNascimento);

		$arcanoAtual = '';
		$dataAtual = new DateTime();

		for ($i = 0; $i < count($arcanos); $i++) {
			// Clonar a data de início para não modificar o objeto original
			$fimArcano = clone $inicioArcano;

			// Adicionar os anos e meses calculados
			$fimArcano->add(new DateInterval("P{$anosPorArcano}Y{$mesesPorArcano}M"));

			// Verificar se a data atual está no intervalo deste Arcano
			if ($dataAtual >= $inicioArcano && $dataAtual < $fimArcano) {
				$arcanoAtual = $arcanos[$i];
				break;
			}

			// Atualizar o início do próximo Arcano
			$inicioArcano = clone $fimArcano;
		}

		// Retornar o Arcano em que a pessoa está atualmente
		return [
			'arcanoAtual' => $arcanoAtual,
			'anosPorArcano' => $anosPorArcano,
			'mesesPorArcano' => $mesesPorArcano
		];
	}

	public static function calcularArcanoPiramidePessoal($nomeCompleto, $dataNascimento, $tabelaPiramde)
	{
		$diaNascimento = (int)date('d', strtotime($dataNascimento));
		$mesNascimento = (int)date('m', strtotime($dataNascimento));

		$diaReducao = array_sum(str_split($diaNascimento)) >= 10 ? array_sum(str_split($diaNascimento)) : '';
		$mesReducao = array_sum(str_split($mesNascimento)) >= 10 ? array_sum(str_split($mesNascimento)) : '';
		$reducaoFinal = $diaReducao + $mesReducao;
		$reducaoFinal = self::reduzirNumeroSimples($reducaoFinal);

		$tabelaDeslocada = [];
		$tamanhoTabela = count($tabelaPiramde);

		foreach ($tabelaPiramde as $posicao => $letras) {
			$novaPosicao = ($posicao + $reducaoFinal - 1) % $tamanhoTabela + 1;
			$tabelaDeslocada[$novaPosicao] = $letras;
		}

		$numeros = [];
		for ($i = 0; $i < strlen($nomeCompleto); $i++) {
			$letra = $nomeCompleto[$i];
			foreach ($tabelaDeslocada as $numero => $letras) {
				if (in_array($letra, $letras)) {
					$numeros[] = $numero;
					break;
				}
			}
		}

		// Gerar a sequência de Arcanos
		$arcanos = [];
		for ($i = 0; $i < count($numeros) - 1; $i++) {
			$arcano = $numeros[$i] * 10 + $numeros[$i + 1];
			$arcanos[] = $arcano;
		}

		// Calcular a duração de cada Arcano
		$numArcanos = count($arcanos);
		$duracaoArcanoTotal = 90 / $numArcanos;
		$anosPorArcano = floor($duracaoArcanoTotal);

		// Extrair o número após o ponto decimal para usar como meses
		$mesesPorArcano = ($duracaoArcanoTotal - $anosPorArcano) * 12;
		$mesesPorArcano = (int)$mesesPorArcano; // Converte para inteiro para garantir que seja um valor inteiro

		// Definir a data inicial
		$inicioArcano = new DateTime($dataNascimento);

		$arcanoAtual = '';
		$dataAtual = new DateTime();

		for ($i = 0; $i < count($arcanos); $i++) {
			// Clonar a data de início para não modificar o objeto original
			$fimArcano = clone $inicioArcano;

			// Adicionar os anos e meses calculados
			$fimArcano->add(new DateInterval("P{$anosPorArcano}Y{$mesesPorArcano}M"));

			// Verificar se a data atual está no intervalo deste Arcano
			if ($dataAtual >= $inicioArcano && $dataAtual < $fimArcano) {
				$arcanoAtual = $arcanos[$i];
				break;
			}

			// Atualizar o início do próximo Arcano
			$inicioArcano = clone $fimArcano;
		}

		// Retornar o Arcano em que a pessoa está atualmente
		return [
			'arcanoAtual' => $arcanoAtual,
			'anosPorArcano' => $anosPorArcano,
			'mesesPorArcano' => $mesesPorArcano
		];
	}

	public static function calcularArcanoPiramideSocial($nomeCompleto, $dataNascimento, $tabelaPiramde)
	{
		$mesNascimento = (int)date('m', strtotime($dataNascimento));

		$mesReducao = array_sum(str_split($mesNascimento)) >= 10 ? array_sum(str_split($mesNascimento)) : '';

		$tabelaDeslocada = [];
		$tamanhoTabela = count($tabelaPiramde);

		foreach ($tabelaPiramde as $posicao => $letras) {
			$novaPosicao = ($posicao + $mesReducao - 1) % $tamanhoTabela + 1;
			$tabelaDeslocada[$novaPosicao] = $letras;
		}

		$numeros = [];
		for ($i = 0; $i < strlen($nomeCompleto); $i++) {
			$letra = $nomeCompleto[$i];
			foreach ($tabelaDeslocada as $numero => $letras) {
				if (in_array($letra, $letras)) {
					$numeros[] = $numero;
					break;
				}
			}
		}

		// Gerar a sequência de Arcanos
		$arcanos = [];
		for ($i = 0; $i < count($numeros) - 1; $i++) {
			$arcano = $numeros[$i] * 10 + $numeros[$i + 1];
			$arcanos[] = $arcano;
		}

		// Calcular a duração de cada Arcano
		$numArcanos = count($arcanos);
		$duracaoArcanoTotal = 90 / $numArcanos;
		$anosPorArcano = floor($duracaoArcanoTotal);

		// Extrair o número após o ponto decimal para usar como meses
		$mesesPorArcano = ($duracaoArcanoTotal - $anosPorArcano) * 12;
		$mesesPorArcano = (int)$mesesPorArcano; // Converte para inteiro para garantir que seja um valor inteiro

		// Definir a data inicial
		$inicioArcano = new DateTime($dataNascimento);

		$arcanoAtual = '';
		$dataAtual = new DateTime();

		for ($i = 0; $i < count($arcanos); $i++) {
			// Clonar a data de início para não modificar o objeto original
			$fimArcano = clone $inicioArcano;

			// Adicionar os anos e meses calculados
			$fimArcano->add(new DateInterval("P{$anosPorArcano}Y{$mesesPorArcano}M"));

			// Verificar se a data atual está no intervalo deste Arcano
			if ($dataAtual >= $inicioArcano && $dataAtual < $fimArcano) {
				$arcanoAtual = $arcanos[$i];
				break;
			}

			// Atualizar o início do próximo Arcano
			$inicioArcano = clone $fimArcano;
		}

		// Retornar o Arcano em que a pessoa está atualmente
		return [
			'arcanoAtual' => $arcanoAtual,
			'anosPorArcano' => $anosPorArcano,
			'mesesPorArcano' => $mesesPorArcano
		];
	}

	public static function calcularDesafios($dataNascimento){
		$diaNascimento = NumerologiaCalculos::reduzirNumeroMestre((int)date('d', strtotime($dataNascimento)));
		$mesNascimento = NumerologiaCalculos::reduzirNumeroMestre((int)date('m', strtotime($dataNascimento)));
		$anoNascimento = NumerologiaCalculos::reduzirNumeroMestre((int)date('Y', strtotime($dataNascimento)));

		$primeiroDesafio = abs($mesNascimento - $diaNascimento);
		$segundoDesafio = abs($anoNascimento - $diaNascimento);
		$terceiroDesafio = abs($segundoDesafio - $primeiroDesafio);

		// Reduzir os desafios para valores de 1 a 9 (ou 0)
		$primeiroDesafio = $primeiroDesafio % 9 ?: 9;
		$segundoDesafio = $segundoDesafio % 9 ?: 9;
		$terceiroDesafio = $terceiroDesafio % 9 ?: 9;

		// Caso algum desafio seja "11" ou "22", reduzir para "2" e "4" respectivamente
		$primeiroDesafio = ($primeiroDesafio == 11) ? 2 : (($primeiroDesafio == 22) ? 4 : $primeiroDesafio);
		$segundoDesafio = ($segundoDesafio == 11) ? 2 : (($segundoDesafio == 22) ? 4 : $segundoDesafio);
		$terceiroDesafio = ($terceiroDesafio == 11) ? 2 : (($terceiroDesafio == 22) ? 4 : $terceiroDesafio);

		return [
			'primeiroDesafio' => $primeiroDesafio,
			'segundoDesafio' => $segundoDesafio,
			'terceiroDesafio' => $terceiroDesafio
		];

	}

	public static function calcularTesteVocacional($numeroDestino, $numeroMissao, $numeroExpressao, $dataNascimento, $listaProfissoes) {

		$diaNascimento = (int)date('d', strtotime($dataNascimento));

		$numeros = [
			'Destino' => $numeroDestino,
			'Missão' => $numeroMissao,
			'Expressão' => $numeroExpressao,
			'Dia de Nascimento' => $diaNascimento
		];

		// Armazena todas as profissões encontradas com suas fontes
		$todasProfissoes = [];

		// Mapeia profissões com suas fontes
		foreach ($numeros as $fonte => $numero) {
			if (isset($listaProfissoes[$numero])) {
				echo "Profissões para o número $numero ($fonte):\n";
				foreach ($listaProfissoes[$numero] as $profissao) {
					echo "- $profissao\n";
					$todasProfissoes[] = ['profissao' => $profissao, 'fonte' => $fonte];
				}
			} else {
				echo "Não há profissões mapeadas para o número $numero ($fonte).\n";
			}
			echo "\n";
		}

		// Conta a ocorrência de cada profissão com suas fontes
		$ocorrencias = [];

		// Agrupa as profissões por nome e mantém um registro das fontes
		foreach ($todasProfissoes as $entrada) {
			$profissao = $entrada['profissao'];
			$fonte = $entrada['fonte'];
			if (!isset($ocorrencias[$profissao])) {
				$ocorrencias[$profissao] = ['contagem' => 0, 'fontes' => []];
			}
			$ocorrencias[$profissao]['contagem']++;
			$ocorrencias[$profissao]['fontes'][] = $fonte;
		}

		// Exibe as profissões que aparecem mais de uma vez e suas origens
		echo "Profissões em comum e suas frequências:\n";
		foreach ($ocorrencias as $profissao => $dados) {
			if ($dados['contagem'] > 1) {
				$fontesUnicas = array_unique($dados['fontes']);
				echo "- $profissao: {$dados['contagem']} vezes, em: " . implode(', ', $fontesUnicas) . "\n";
			}
		}

	}

}
