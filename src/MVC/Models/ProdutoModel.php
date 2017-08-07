<?php

namespace MVC\Models;

/**
 * Description of Produto
 *
 * @author Guilherme
 */
class ProdutoModel {

    public function saveProduto(\MVC\Dos\ProdutoDo $produtoDo, \PDO $conn) {

        if (!$produtoDo->getNome()) {
            throw new \Exception("Um ou mais campos não foram enviados ou são inválidos", 400);
        }

        if (!$produtoDo->getPreco()) {
            throw new \Exception("Um ou mais campos não foram enviados ou são inválidos", 400);
        }

        if (!$produtoDo->getIngredientes()) {
            throw new \Exception("Um ou mais campos não foram enviados ou são inválidos", 400);
        }

        try {
            $nome = $produtoDo->getNome();
            $preco = $produtoDo->getPreco();
            $ingredientes = $produtoDo->getIngredientes();

            $erroIngrediente = '';
            foreach ($ingredientes as $ingrediente) {

                $ingrediente = json_decode($ingrediente);

                $sql = "select * from ingredientes where id = :id";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(":id", $ingrediente->id);
                $stmt->execute();

                $ingredienteRetorno = $stmt->fetchAll(\PDO::FETCH_OBJ);

                if (!$ingredienteRetorno) {

                    $erroIngrediente .= " Ingrediente {$ingrediente->id} não existe - ";
                }
            }
            if ($erroIngrediente) {
                throw new \Exception($erroIngrediente, 400);
            }

            $sql = "Insert into produto (nome, preco) values (:nome, :preco)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":nome", $nome);
            $stmt->bindParam(":preco", $preco);
            $stmt->execute();
            $idprod = $conn->lastInsertId();

            //Caso envie um ingrediente que não exista o mesmo não seria inserido
            foreach ($ingredientes as $ingrediente) {
                $ingrediente = json_decode($ingrediente);

                $sql = "Insert into prodingrediente (idprod, idingrediente) values (:idprod, :idingrediente)";
                $stmt2 = $conn->prepare($sql);
                $stmt2->bindParam(":idprod", $idprod);
                $stmt2->bindParam(":idingrediente", $ingrediente->id);
                $stmt2->execute();
            }
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage(), 400);
        }
    }

    public function buscarProdutos(\PDO $conn, $id = null) {
        if ($id == null) {

            $sql = "Select prod.nome as nomeProd, prod.id as prodId, i.nome as nomeIngrediente, i.id as idIngrediente, prod.preco, i.observacao from produto as prod inner join prodingrediente as pi on prod.id = pi.idprod inner join ingredientes i on i.id = pi.idingrediente";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
        } else {
            $sql = "Select prod.nome as nomeProd, prod.id as prodId, i.nome as nomeIngrediente, i.id as idIngrediente, prod.preco, i.observacao from produto as prod inner join prodingrediente as pi on prod.id = pi.idprod inner join ingredientes i on i.id = pi.idingrediente where prod.id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        }
        try {
            $produtos = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (Exception $ex) {
            throw new Exception("Erro ao Buscar produto", 500);
        }

        return $produtos;
    }

    public function editarProduto(\MVC\Dos\ProdutoDo $produtoDo, \PDO $conn) {
        try {

            $id = $produtoDo->getId();
            $nome = $produtoDo->getNome();
            $preco = $produtoDo->getPreco();
            $ingredientes = $produtoDo->getIngredientes();

            $sql = "Select * from produto where id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $produto = $stmt->fetchAll(\PDO::FETCH_OBJ);

            if (!$produto) {
                throw new \Exception("Produto inexistente informe um produto válido", 400);
            }

            $erroIngrediente = '';
            foreach ($ingredientes as $ingrediente) {

                $ingrediente = json_decode($ingrediente);

                $sql = "select * from ingredientes where id = :id";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(":id", $ingrediente->id);
                $stmt->execute();

                $ingredienteRetorno = $stmt->fetchAll(\PDO::FETCH_OBJ);

                if (!$ingredienteRetorno) {

                    $erroIngrediente .= " Ingrediente {$ingrediente->id} não existe - ";
                }
            }

            if ($erroIngrediente) {
                throw new \Exception($erroIngrediente, 400);
            }


            $sql = "Delete from prodingrediente where idprod = :idprod";
            $stmt2 = $conn->prepare($sql);
            $stmt2->bindParam(":idprod", $id);
            $stmt2->execute();

            foreach ($ingredientes as $ingrediente) {
                $ingrediente = json_decode($ingrediente);

                $sql = "Insert into prodingrediente (idprod, idingrediente) values (:idprod, :idingrediente)";
                $stmt2 = $conn->prepare($sql);
                $stmt2->bindParam(":idprod", $id);
                $stmt2->bindParam(":idingrediente", $ingrediente->id);
                $stmt2->execute();
            }

            $sql = "Update produto set nome = :nome, preco = :preco where id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':preco', $preco);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        } catch (Exception $ex) {
            throw new \Exception("Erro ao Atualizar produto", 500);
        }
    }

    public function deletarProduto($id, \PDO $conn) {
        try {

            $sql = "Select * from produto where id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $produto = $stmt->fetch(\PDO::FETCH_COLUMN);

            if (!$produto) {
                throw new \Exception("Produto inexistente informe um produto válido", 400);
            }

            $sql = "Delete from prodingrediente  where idprod = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            $sql = "Delete from produto  where id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        } catch (Exception $ex) {
            throw new \Exception("Erro ao Deletar produto", 500);
        }
    }

}
