<?php

require_once 'NumerologiaDados.php'; // Certifique-se de ajustar o caminho conforme necessário
require_once 'NumerologiaCalculos.php'; // Certifique-se de ajustar o caminho conforme necessário

class Numerologia {
    private $alfabeto;
	private $vogais;
	private $consoantes;
	private $tabelaPiramides;
    private $cores;
	private $profissoes;
    private $tabelaNumerosFavoraveis;
	private $numerosHarmonicos;
    private $meses;

    public function __construct() {
        $this->alfabeto = NumerologiaDados::obterAlfabeto();
		$this -> vogais = NumerologiaDados::obterVogais();
		$this->consoantes = NumerologiaDados::obterConsoantes();
		$this->tabelaPiramides = NumerologiaDados::obterTabelaPiramides();
        $this->cores = NumerologiaDados::obterCores();
		$this->profissoes = NumerologiaDados::obterProfissoes();
        $this->tabelaNumerosFavoraveis = NumerologiaDados::obterTabelaNumerosFavoraveis();
        $this->meses = NumerologiaDados::obterMeses();
		$this->numerosHarmonicos = NumerologiaDados::obterNumerosHarmoncos();
    }

    public function calcularAnoPessoal($dataNascimento) {
        return NumerologiaCalculos::calcularAnoPessoal($dataNascimento);
    }

    public function mesPessoalCalc($dataNascimento)
    {
        $anoPessoal =  $this->calcularAnoPessoal($dataNascimento);
        return NumerologiaCalculos::mesPessoalCalc($anoPessoal);
    }

    public function calcularDiaPessoal($dataNascimento) {
        return NumerologiaCalculos::calcularDiaPessoal($dataNascimento);
    }

    public function calcularNumeroDestino($dataNascimento) {
        // Chama o método da classe NumerologiaCalculos
        return NumerologiaCalculos::calcularNumeroDestino($dataNascimento);
    }

    public function calcularLicoesCarmicas($nome) {
        return NumerologiaCalculos::calcularLicoesCarmicas($nome, $this->alfabeto);
    }

    public function numerosHarmonicos($dataNascimento) {
        return NumerologiaCalculos::numerosHarmonicos($dataNascimento, $this->numerosHarmonicos);
    }

    public function calcularCiclos($dataNascimento, $licoesCarmicas) {
        return NumerologiaCalculos::calcularCiclos($dataNascimento, $licoesCarmicas, $this->alfabeto);
    }

    public function obterDiasFavoraveis($dataNascimento) {
        return NumerologiaCalculos::obterDiasFavoraveis($dataNascimento, $this->tabelaNumerosFavoraveis, $this->meses);
    }

    public function grauAscensao($nome) {
        return NumerologiaCalculos::grauAscensao($nome, $this->alfabeto);
    }

    public function calcularNumeroImpressao($nome) {
        return NumerologiaCalculos::calcularNumeroImpressao($nome, $this->consoantes);
    }

    public function calcularNumeroExpressao($nome) {
        return NumerologiaCalculos::calcularNumeroExpressao($nome, $this->alfabeto);
    }

    public function calcularNumeroMotivacao($nome) {
        return NumerologiaCalculos::calcularNumeroMotivacao($nome, $this->vogais);
    }

    public function calcularNumeroMissao($numeroDestino, $numeroExpressao) {
        return NumerologiaCalculos::calcularNumeroMissao($numeroDestino, $numeroExpressao);
    }

    public function calcularTendenciaOculta($nome) {
        return NumerologiaCalculos::calcularTendenciaOculta($nome, $this->alfabeto);
    }

    public function calcularNumeroPsiquico($diaNascimento) {
        return NumerologiaCalculos::calcularNumeroPsiquico($diaNascimento);
    }

    public function talentoOculto($motivacao, $numeroDeExpressao) {
        return NumerologiaCalculos::talentoOculto($motivacao, $numeroDeExpressao);
    }

    public function momentosDecisivos($dataNascimento, $dataFimPrimeiroCiclo) {
        return NumerologiaCalculos::momentosDecisivos($dataNascimento, $dataFimPrimeiroCiclo);
    }

    public function coresFavoraveis($nomeCompleto) {
		return NumerologiaCalculos::coresFavoraveis($nomeCompleto, $this->alfabeto, $this->cores);

	}

    public function calculoDividasCarmicas($nomeCompleto, $dataNascimento) {
        return NumerologiaCalculos::calculoDividasCarmicas($nomeCompleto, $dataNascimento, $this->alfabeto);
    }

	public function calcularNumeroAmor($numero_destino, $numero_expressao)
	{
		return NumerologiaCalculos::calcularNumeroAmor($numero_destino, $numero_expressao, NumerologiaDados::obterTabelaHarmoniaConjugal());
	}

	public function relacoesIntervalores($nomeCompleto) {
        return NumerologiaCalculos::relacoesIntervalores($nomeCompleto, $this->alfabeto);
    }

	public function calcularArcanos($nomeCompleto, $dataNascimento)
	{
		return NumerologiaCalculos::calcularArcanos($nomeCompleto, $dataNascimento, $this->alfabeto);
	}

	public function calcularPiramdeDestino($nomeCompleto, $dataNascimento)
	{
		return NumerologiaCalculos::calcularPiramideDestino($nomeCompleto, $dataNascimento, $this->tabelaPiramides);
	}

	public function calcularPiramdePessoal($nomeCompleto, $dataNascimento)
	{
		return NumerologiaCalculos::calcularPiramidePessoal($nomeCompleto, $dataNascimento, $this->tabelaPiramides);
	}

	public function calcularPiramdeSocial($nomeCompleto, $dataNascimento)
	{
		return NumerologiaCalculos::calcularPiramideSocial($nomeCompleto, $dataNascimento, $this->tabelaPiramides);
	}

	public function calcularPiramdeVida($nomeCompleto)
	{
		return NumerologiaCalculos::calcularPiramideVida($nomeCompleto, $this->alfabeto);
	}

	public function calcularArcanoPiramideDestino($nomeCompleto, $dataNascimento)
	{
		return NumerologiaCalculos::calcularArcanoPiramideDestino($nomeCompleto, $dataNascimento, $this->tabelaPiramides);
	}

	public function calcularArcanoPiramidePessoal($nomeCompleto, $dataNascimento)
	{
		return NumerologiaCalculos::calcularArcanoPiramidePessoal($nomeCompleto, $dataNascimento, $this->tabelaPiramides);
	}

	public function calcularArcanoPiramideSocial($nomeCompleto, $dataNascimento)
	{
		return NumerologiaCalculos::calcularArcanoPiramideSocial($nomeCompleto, $dataNascimento, $this->tabelaPiramides);
	}

	public function carcularDesafios($dataNascimento)
	{
		return NumerologiaCalculos::calcularDesafios($dataNascimento);
	}

	public function calcularTesteVocacional($numeroDestino, $numeroMissao, $numeroExpressao, $dataNascimento)
	{
		return NumerologiaCalculos::calcularTesteVocacional($numeroDestino, $numeroMissao, $numeroExpressao, $dataNascimento, $this->profissoes);
	}

	public function calcularRespostaSubconsciente($nome) {
		return NumerologiaCalculos::calcularRespostaSubconsciente($nome, $this->alfabeto);
	}

}


