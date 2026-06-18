<?php
    require_once 'conexao.php';
    function verificarLogin(){
        return isset($_SESSION['usuario']);
    }
    function verificarAdmin(){
        return (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'admin');
    }
    function logout(){
        session_destroy();
    }
    function login($conexao, $cpf, $senha){
        $sql = "SELECT * FROM leitores where cpf = ? and senha = ?";

        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("ss", $cpf, $senha);
        $stmt->execute();
        $resultado = $stmt->get_result();
        //OBJETO->ATRIBUTO/AÇÃO QUE ESSE OBJETO FAZ
        
        if ($resultado->num_rows > 0){
            $usuario = $resultado->fecth_assoc();

            $_SESSION['usuario'] = $usuario['nome'];
            $_SESSION['id'] = $usuario['id'];
            $_SESSION['tipo'] = $usuario['tipo'];

            return true;
        }

        return false;
    }


    function inserirLeitor($conexao, $nome, $senha, $cpf, $telefone, $nascimento, $tipo){
        $sql = "INSERT INTO leitores (nome, senha, cpf, telefone, nascimento, tipo)
            VALUES (?,?,?,?,?,?)";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("ssssss", $nome, $senha, $cpf, $telefone, $nascimento, $tipo);
        return $stmt->execute();

    }

    function listarleitores($conexao){
        return $conexao->query("SELECT * FROM leitores");
    }

    function buscarLeitores($conexao, $id){
        $sql = "SELECT * FROM leitores WHERE id = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result();
    }

    function buscarLeitoresPorNome($conexao, $nome){
        $sql = "SELECT * FROM leitores WHERE nome LIKE ?";
        $stmt = $conexao->prepare($sql);
        $nomeBusca = "%".$nome."%";
        $stmt->bind_param("s", $nomeBusca);
        $stmt->execute();
        return $stmt->get_result();
    }

    function atualizarLeitor($conexao, $id, $nome, $senha, $cpf, $telefone, $nascimento, $tipo){
        $sql = "UPDATE leitores SET nome = ?, senha = ?, cpf = ?, telefone = ?, nascimento = ?, tipo = ? WHERE id = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("ssssssi", $nome, $senha, $cpf, $telefone, $nascimento, $tipo, $id);
        return $stmt->execute();
    }

    function deletarLeitor($conexao, $id){
        $sql = "DELETE FROM leitores WHERE id = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    //CRUD EDITORA

    function inserirEditora($conexao, $nome, $pais){
        $sql = "INSERT INTO editoras (nome, pais)
            VALUES (?,?)";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("ss", $nome, $pais);
        return $stmt->execute();
    }

    function listarEditoras($conexao){
        return $conexao->query("SELECT * FROM editoras");
    }

    function buscarEditoras($conexao, $id){
        $sql = "SELECT * FROM editoras WHERE id = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result();
    }

    function buscarEditorasPorNome($conexao, $nome){
        $sql = "SELECT * FROM editoras WHERE nome LIKE ?";
        $stmt = $conexao->prepare($sql);
        $nomeBusca = "%".$nome."%";
        $stmt->bind_param("s", $nomeBusca);
        $stmt->execute();
        return $stmt->get_result();
    }

    function atualizarEditora($conexao, $id, $nome, $pais){
        $sql = "UPDATE editoras SET nome = ?, pais = ? WHERE id = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("ssi", $nome, $pais, $id);
        return $stmt->execute();
    }

    function deletarEditora($conexao, $id){
        $sql = "DELETE FROM editoras WHERE id = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    function uploadCapa ($arquivo){
        $diretorio = 'uploads/capas/';
        $extensao = strtolower(pathinfo($arquivo['name'], PATHINFO_EXTENSION));
        $permitidas = ['jpg', 'jpeg', 'png'];

        if(!in_array($extensao, $permitidas)){ 
            return false;
        }

        if($arquivo['size']> 1024 * 1024 * 2){ // permite até 2MB
            return false;
        }

        $nomeArquivo = uniqid() . "_" . $arquivo['name'];
        $caminho = $diretorio . $nomeArquivo; // uploads/capas/13516516has5_arvore.png

        if (move_uploaded_file($arquivo['tmp_name'], $caminho)){
            return $caminho;
        }

        return false;
    }





?>
