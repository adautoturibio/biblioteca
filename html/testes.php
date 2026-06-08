<?php
require_once "funcoes.php";

echo "<h2>INSERIR LEITOR!</h2>";
// inserirLeitor($conexao, "Adauto", "123", "08641712186", "62996867501", "2009-01-13", "admin");
echo "Leitor inserido!";

echo "<h2>LISTAR LEITOR!</h2>";
$leitor = listarLeitores($conexao);
while ($l = $leitor->fetch_assoc()) {
    print_r($l);
    echo "<br>";
}

echo "<h2>BUSCAR LEITOR!</h2>";
$leitor = buscarLeitor($conexao, 1);
print_r($leitor->fetch_assoc());
echo "<br>";

echo "<h2>BUSCAR LEITOR POR NOME!</h2>";
$leitores = buscarLeitorPorNome($conexao, "Adauto");
while ($leitor = $leitores ->fetch_assoc()){
    print_r($leitor);
    echo "<br>";
}

echo "<h2>ATUALIZAR LEITOR!</h2>";
atualizarLeitor($conexao, 1, "Joana", "123", "5555555555", 
"62991222222", "2001-01-02", "admin");
echo "Leitor atualizado";

echo "<h2>DELETAR LEITOR!</h2>";
deletarLeitor($conexao, 2);
echo "Leitor deletado";

?>