<?php
class Lutador{
    #atributos
    private $nome;
    private $nacionalidade;
    private $idade;
    private $altura;
    private $peso;
    private $categorias;
    private $vitorias;
    private $derrotas;
    private $empates;
    #metodos especiais

    public function __construct($no, $na, $id, $al, $pe, $vi, $de, $em){
        $this->nome = $no;
        $this->nacionalidade = $na;
        $this->idade = $id;
        $this->altura = $al;
        $this->setPeso($pe);
        $this->vitorias = $vi;
        $this->derrotas = $de;
        $this->empates = $em;
    }

    public function getNome(){
        return $this->nome;
    }
    public function setNome($nome){
        $this->nome = $nome;
    }
    public function getNacionalidade(){
        return $this->nacionalidade;
    }
    public function setNacionalidade($pais){
        $this->nacionalidade = $pais;
    }
    public function getIdade(){
        return $this->idade;
    }
    public function setIdade($idade){
        $this->idade = $idade;
    }
    public function getAltura(){
        return $this->altura;
    }
    public function setAltura($altura){
        $this->altura = $altura;
    }
    public function getPeso(){
        return $this->peso;
    }
    public function setPeso($peso){
        $this->peso = $peso;
        $this->setCategorias($peso);
    }
    public function getCategorias(){
        return $this->categorias;
    }
    private function setCategorias($peso){
        if($peso<=52.5 && $peso>130){
            $this->categorias = "Invalido";
        }
        else if($peso<=70.3){
            $this->categorias = "Leve";
        }
        else if($peso<=83.9){
            $this->categorias = "Medio";
        }
        else if($peso<=120.9){
            $this->categorias = "Pesado";
        }
    }
    public function getVitorias(){
        return $this->vitorias;
    }
    public function setVitorias($qtd){
        $this->vitorias = $qtd;
    }
    public function getDerrotas(){
        return $this->derrotas;
    }
    public function setDerrotas($qtd){
        $this->derrotas = $qtd;
    }
    public function getEmpates(){
        return $this->empates;
    }
    public function setEmpates($qtd){
        $this->empates = $qtd;
    }

    public function status(){
        echo "<p>--------------------------------------------------</p>";
        echo "{$this->getNome()}, Vem direto de {$this->getNacionalidade()}, ";
        echo "<p> Pesa {$this->getPeso()}, da categoria {$this->getCategorias()}</p> ";
        echo "<p> Ja venceu {$this->getVitorias()} vezes, </p>";
        echo "<p> Ja perdeu {$this->getDerrotas()} vezes e </p>";
        echo " Empatou {$this->getEmpates()} vezes.";
    }
    public function apresentar(){
        echo "<p>--------------------------------------------------</p><br>";
        echo "CHEGOU A HORA!! O lutador {$this->getNome()}<br>";
        echo "<p>Veio direto de {$this->getNacionalidade()}</p><br>";
        echo "<p>Tem {$this->getIdade()} de Idade, e {$this->getPeso()} de peso.</p><br>";
        echo "{$this->getVitorias()}Vitorias, {$this->getEmpates()} Empates e {$this->getDerrotas()} Derrotas<br>";
    }
    public function ganharLuta(){
        $this->setVitorias($this->getVitorias() + 1);
    }
    public function perderLuta(){
        $this->setDerrotas($this->getDerrotas() + 1);
    }
    public function empatarLuta(){
        $this->setEmpates($this->getEmpates() + 1);
    }
}


class Luta{
    private $desafiado;
    private $desafiante;
    private $rounds;
    private $aprovada;

    public function marcarLuta(Lutador $l1, Lutador $l2){
        if($l1->getCategorias()===$l2->getCategorias() && $l1 != $l2){
            $this->aprovada = true;
            $this->desafiante = $l1;
            $this->desafiado = $l2;
            echo "Luta aprovada!!<br>";
            echo "{$this->desafiante->getNome()} x {$this->desafiado->getNome()}<br>";
        }
        else{
            $this->aprovada = false;
            $this->desafiante = NULL;
            $this->desafiado = NULL;
            echo "Luta nao marcada.<br>";
        }
    }
    public function lutar(){
        if($this->aprovada){
            $this->desafiado->apresentar();
            $this->desafiante->apresentar();
            $number = random_int(0, 2);
            switch($number){
                case 0 :
                    echo "Empate na luta!<br>";
                    $this->desafiante->empatarLuta();
                    $this->desafiado->empatarLuta();
                    break;
                case 1 : 
                    echo"{$this->desafiante->getNome()} venceu a luta!!<br>";
                    $this->desafiante->ganharLuta();
                    $this->desafiado->perderLuta();
                    break;
                case 2:
                    echo "{$this->desafiado->getNome()} ganhou a luta!!<br>";
                    $this->desafiante->perderLuta();
                    $this->desafiado->ganharLuta();
                    break;
            }

        }
        else{
            echo"<p>Luta Não pode acontecer.</p><br>";
        }
    }

    public function getDesafiado(){
        return $this->desafiado;
    }

    public function setDesafiado(Lutador $lutador){
        $this->desafiado = $lutador;
    }

    public function getDesafiante(){
        return $this->desafiante;
    }

    public function setDesafiante(Lutador $lutador){
        $this->desafiante = $lutador;
    }
}