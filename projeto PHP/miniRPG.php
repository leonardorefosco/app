<?php
// classe que herda do Exception 
class AcessoNegadoException extends Exception{
}

class Usuario{
    protected string $nome; // nome da pessoa que assinou
    protected string $plano; // plano escolhido (GRATUITO, PREMIUM)
    
    // usuário sempre inicia gerando esse construtor, que já viria validado do front
    public function __construct(string $no, string $pl){
        $this->setNome($no);
        $this->setPlano($pl);
    }

    // metodos get e set
    public function getNome(){
        return $this->nome;
    }

    public function setNome(string $nome){
        $this->nome = $nome;
    }

    public function getPlano(){
        return $this->plano;
    }

    public function setPlano(string $plano){
        $this->plano = $plano;
    }
}

// classe abstrata
abstract class Assistivel{
    public function darPlay(Usuario $user){
    }
}

abstract class Conteudo extends Assistivel{
    protected string $titulo;
    protected string $tipoAcesso; // gratuito ou premium
    protected int $vizualizacoes;

    public function __construct($no, $ac){
        $this->titulo = $no;
        $this->tipoAcesso = $ac;
        $this->vizualizacoes = 0;
    }

    public function mostrarVizu(){
        echo "{$this->titulo} tem {$this->vizualizacoes} vizualizacoes.";
    }

    abstract protected function exibirDetalhes();

    public function darPlay(Usuario $user){
        if($this->tipoAcesso === "PREMIUM" && $user->getPlano() === "GRATUITO"){
            throw new AcessoNegadoException("Acesso negado... Para acessar esse titulo, evolua seu plano para o Premium clicando no link abaixo.. linkabixo.com"); 
        }
        else{
            $this->vizualizacoes++;
            echo $this->exibirDetalhes() . "\n"; // Mostra os detalhes do filme/série

            if($user->getPlano() === "GRATUITO"){
                echo "[!] Exibindo anúncio em 15 segundos...\n";
            }
            else{
                echo "Começando filme...\n";
            }
        }
    }

    public function getTitulo(){
        return $this->titulo;
    }
    
    public function getTipoAcesso(){
        return $this->tipoAcesso;
    }
}

class Filme extends Conteudo{
    private $duracao;

    public function __construct($no, $ac, $du){
        parent::__construct($no, $ac);
        $this->duracao = $du;
    }
    
    protected function exibirDetalhes(){
        return "Filme {$this->getTitulo()} - tem duracao de {$this->duracao}";
    }
}

class Serie extends Conteudo{
    private $qtdTemporadas;

    public function __construct($no, $ac, $temp){
        parent::__construct($no, $ac);
        $this->qtdTemporadas = $temp;
    }

    protected function exibirDetalhes(){
        return "Série {$this->getTitulo()} - tem {$this->qtdTemporadas} temporadas";
    }
}

// --- ÁREA DE TESTES ---
$usuarioFree = new Usuario("João", "GRATUITO");
$usuarioPremium = new Usuario("Maria", "PREMIUM");

$filmeAberto = new Filme("Matrix", "GRATUITO", "136 min");
$serieFechada = new Serie("Breaking Bad", "PREMIUM", 5);

echo "--- TESTES DE ACESSO ---\n\n";

try {
    echo "Teste 1: Maria (Premium) assistindo Matrix (Gratuito)\n";
    $filmeAberto->darPlay($usuarioPremium); 
    echo "\n";

    echo "Teste 2: João (Free) assistindo Matrix (Gratuito)\n";
    $filmeAberto->darPlay($usuarioFree);
    echo "\n";

    echo "Teste 3: João (Free) tentando assistir Breaking Bad (Premium)\n";
    $serieFechada->darPlay($usuarioFree); 

} catch (AcessoNegadoException $e) {
    echo "\n[ERRO CAPTURADO] " . $e->getMessage() . "\n";
}

echo "\n--- ESTATÍSTICAS ---\n";
$filmeAberto->mostrarVizu();
echo "\n";
?>