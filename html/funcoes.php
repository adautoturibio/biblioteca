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
        $sql = "SELECT * FROM leitores WHERE cpf=? AND senha=?";

        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("ss", $cpf, $senha);
        $stmt->execute();

        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0){
            $usuario = $resultado->fetch_assoc();
            $_SESSION['usuario'] = $usuario['nome'];
            $_SESSION['id'] = $usuario['id'];
            $_SESSION['tipo'] = $usuario['tipo'];

            return true;
        }

        return false;
    }


//CRUD PARA LEITORES 
    function inserirLeitor($conexao, $nome, $senha, $cpf, $telefone, $nascimento, $tipo){
        $sql = "INSERT INTO leitores (nome, senha, cpf, telefone, nascimento, tipo) VALUES (?,?,?,?,?,?)";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("ssssss", $nome, $senha, $cpf, $telefone, $nascimento, $tipo);
        return $stmt->execute();
    }

    function listarLeitores($conexao){
        return $conexao->query("SELECT * FROM leitores");
    }
    function buscarLeitor($conexao, $id){
        $sql = "SELECT * FROM leitores WHERE id=?";

        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        return $stmt->get_result();

    }

    function buscarLeitorPorNome($conexao, $nome){

        $sql = "SELECT * FROM leitores WHERE nome LIKE ?";
        $stmt = $conexao->prepare($sql);
        $stmt = $conexao->prepare($sql);

        $nomeBusca = "%".$nome."%";
        $stmt->bind_param("s", $nomeBusca);
        $stmt->execute();

        return $stmt->get_result();
    }
    
    function atualizarLeitor($conexao, $id, $nome, $senha, $cpf, $telefone, $nascimento, $tipo){
        $sql = "UPDATE leitores
            set nome=?, senha=?, cpf=?, telefone=?, nascimento=?, tipo=?
            where id=?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("ssssssi", $nome, $senha, $cpf, $telefone, $nascimento, $tipo, $id);

        return $stmt->execute();
    }
    
    function deletarLeitor($conexao, $id){
        $sql = "DELETE FROM leitores WHERE id=?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }

    function inserirEditora($conexao, $id, $nome, $pais){
        $sql = "INSERT INTO editoras (id, nome, pais) VALUES (?, ?, ?)";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("iss", $id, $nome, $pais);

        return $stmt->execute();
    }

    function listarEditoras ($conexao){
        return $conexao->query("SELECT * FROM editoras");
    }

    function buscarEditora ($conexao, $id){
        $sql = "SELECT * FROM editoras WHERE id=?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        return $stmt->get_result();
    }

    function atualizarEditora ($conexao, $id, $nome, $pais){
        $sql = "UPDATE editoras SET nome=?, pais=? WHERE id=?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("ssi", $nome, $pais, $id);

        return $stmt->execute();
    }
     function detelarEditora ($conexao, $id){
        $sql = "DELETE * FROM editoras WHERE id=?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("i", $id);

        return $stmt->execute();
     }
?>