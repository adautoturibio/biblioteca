<?php
    require_once "funcoes.php";

    if(isset($_POST['enviar'])){
        $resultado = uploadCapa($_FILES['capa']);

        if($resultado){
            echo "Upload realizado com sucesso.";
        } else{
            echo "Erro no upload.";
        }
    }
?>
<form method="POST" enctype="multipart/form-data">
    <input type="file" name="capa">
    <button type="submit" name="enviar">Enviar Imagem</button>
</form>