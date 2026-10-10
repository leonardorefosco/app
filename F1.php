<?php
class Carro {
    protected $equipe;
    protected $potencia;
    protected $desgastePneu;
    
    public function __construct($e, $p, $d = 0){
        $this->setEquipe($e);
        $this->setPotencia($p);
        $this->setDesgastePneu($d); // Inicia com 0 se não for passado
    }

    public function getEquipe(){ return $this->equipe; }
    public function setEquipe($e){ $this->equipe = $e; }
    public function getPotencia(){ return $this->potencia; }
    public function setPotencia($p){ $this->potencia = $p; }
    public function getDesgastePneu(){ return $this->desgastePneu; }
    public function setDesgastePneu($p){ $this->desgastePneu = $p; }

    public function desgastarPneu(){
        if($this->getDesgastePneu() >= 80){
            echo " [Pitstop necessário!] ";
            $this->fazerPitStop();
        } else {
            $this->setDesgastePneu($this->getDesgastePneu() + 20);
        }
    }

    private function fazerPitStop(){
        $this->setDesgastePneu(0);
    }
}    

class Piloto {
    private $nome;
    private $habilidade;
    private $carro;
    private $tempoTotal; // Protegido do mundo externo

    public function __construct($no, $nu, Carro $car){
        $this->nome = $no;
        $this->habilidade = $nu;
        $this->carro = $car;
        $this->tempoTotal = 0; // Inicializado com 0 automaticamente
    }

    public function getNome() { return $this->nome; }
    public function getTempoTotal() { return $this->tempoTotal; }
    
    // Método para a Corrida conseguir injetar o tempo de forma segura
    public function adicionarTempo($tempo) {
        $this->tempoTotal += $tempo;
    }

    public function acelerar(){
        $tempoBase = rand(70000, 90000) / 1000; 

        $habilidade = $this->habilidade;
        $potencia = $this->carro->getPotencia(); 
        
        // Puxa o número inteiro do desgaste para a conta matemática
        $desgaste = $this->carro->getDesgastePneu(); 

        $tempoFinal = $tempoBase - ($habilidade * 0.5) - ($potencia / 20) + ($desgaste / 10);

        $this->carro->desgastarPneu();

        return $tempoFinal;
    }
}

class Corrida {
    private $grandePremio;
    private $grid = [];

    public function __construct($nome){
        $this->grandePremio = $nome;
    }

    public function adicionarPiloto(Piloto $piloto){
        $this->grid[] = $piloto;
    }

    public function darBandeirada(int $n){
        echo "\n=== BEM-VINDO AO {$this->grandePremio} ===\n\n";

        // Loop de Voltas
        for($i = 1; $i <= $n; $i++){
            echo "--- Volta $i ---\n";
            
            // Loop de Pilotos (Usando foreach como você havia perguntado antes)
            foreach($this->grid as $piloto) {
                $tempoVolta = $piloto->acelerar();
                $piloto->adicionarTempo($tempoVolta);
                
                echo $piloto->getNome() . " completou em " . number_format($tempoVolta, 3) . "s\n";
            }
            echo "\n";
        }

        $this->exibirResultado();
    }

    private function exibirResultado() {
        echo "=== RESULTADO FINAL ===\n";
        
        $vencedor = null;
        $menorTempo = 999999; // Um número alto qualquer para começar

        foreach($this->grid as $piloto) {
            $tempoDoPiloto = $piloto->getTempoTotal();
            echo $piloto->getNome() . " - Tempo Total: " . number_format($tempoDoPiloto, 3) . "s\n";

            // Lógica para descobrir quem fez em menos tempo
            if ($tempoDoPiloto < $menorTempo) {
                $menorTempo = $tempoDoPiloto;
                $vencedor = $piloto->getNome();
            }
        }

        echo "\n🏆 VENCEDOR: " . $vencedor . "!!!\n";
    }
}

// === TESTANDO O CÓDIGO ===
$carroRBR = new Carro("Red Bull Racing", 95);
$carroFerrari = new Carro("Ferrari", 92);

$max = new Piloto("Max Verstappen", 9, $carroRBR);
$charles = new Piloto("Charles Leclerc", 8, $carroFerrari);

$gp = new Corrida("GP de Interlagos");
$gp->adicionarPiloto($max);
$gp->adicionarPiloto($charles);

$gp->darBandeirada(5);
?>