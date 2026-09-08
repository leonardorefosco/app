<?php

class Prato{
    private $nome;
    private $preco;

    public function __construct($no, $pr){
        $this->nome = $no;
        $this->preco = $pr;
    }

    public function getNome(){
        return $this->nome;
    }
    public function setNome($no){
        $this->nome = $no;
    }

    public function getPreco(){
        return $this->preco;
    }
    public function setPreco($pr){
        $this->preco = $pr;
    }
    
}

class Pedido{
    private $itens = [];

    public function adicionarPrato(Prato $prato){
        if($prato->getPreco()>0){
            $this->itens[] = $prato;
            echo "Prato {$prato->getNome()} adicionado com sucesso.<br>";
        }
        else{
            throw new Exception("ERRO: Impossivel colocar {$prato->getNome()} no pedido!<br>");
        }
    }

    public function fecharPedido(){
        if(empty($this->itens)){
            throw new Exception("ERRO: Pedido vazio.");
        }

        $total = 0;

        foreach($this->itens as $item){
            $total += $item->getPreco();
        }
        return "Pedido fechado! Total a pagar é R$ $total.<br>";
    }

}


try{

    $meuPedido = new Pedido();

    $prato1 = new Prato("Lasanha", 25.00);
    $prato2 = new Prato("Sierra", 45.00);
    $prato3 = new Prato("Pizza", 100.00);

    $meuPedido->adicionarPrato($prato1);
    $meuPedido->adicionarPrato($prato2);

    echo $meuPedido->fecharPedido();

}catch(Exception $e){
    echo "Alerta do sistema " . $e->getMessage(). "\n"; 
}




?>