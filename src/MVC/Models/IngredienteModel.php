<?php

namespace MVC\Models;

/**
 * Description of Ingrediente
 *
 * @author Guilherme
 */
class IngredienteModel {

    public function saveIngrediente(\MVC\Dos\IngredienteDo $ingredienteDo, \PDO $conn) {

        if (!$ingredienteDo->getNome()) {
            throw new \Exception("Um ou mais campos não foram enviados ou são inválidos", 400);
        }

        if (!$ingredienteDo->getObservacao()) {
            throw new \Exception("Um ou mais campos não foram enviados ou são inválidos", 400);
        }

        try {
            $nome = $ingredienteDo->getNome();
            $observacao = $ingredienteDo->getObservacao();
            $sql = "Insert into ingredientes (nome, observacao) values (:nome, :observacao)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":nome", $nome);
            $stmt->bindParam(":observacao", $observacao);
            $stmt->execute();
        } catch (\Exception $ex) {
            throw new \Exception("Erro ao Salvar ingrediente", 500);
        }
    }

    public function buscarIngredientes(\PDO $conn, $id = null) {
        if ($id == null) {

            $sql = "Select * from ingredientes";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
        } else {
            $sql = "Select * from ingredientes where id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        }
        try {

            $ingredientes = $stmt->fetchAll(\PDO::FETCH_OBJ);
        } catch (\Exception $ex) {
            throw new \Exception("Erro ao Buscar ingrediente", 500);
        }

        return $ingredientes;
    }

    public function editarIngrediente(\MVC\Dos\IngredienteDo $ingredienteDo, \PDO $conn) {
        try {

            $id = $ingredienteDo->getId();
            $nome = $ingredienteDo->getNome();
            $observacao = $ingredienteDo->getObservacao();

            $sql = "Select * from ingredientes where id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $ingrediente = $stmt->fetchAll(\PDO::FETCH_OBJ);

            if (!$ingrediente) {
                throw new \Exception("Ingrediente inexistente informe um ingrediente válido", 400);
            }

            $sql = "Update ingredientes set nome = :nome, observacao = :observacao where id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':observacao', $observacao);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        } catch (\Exception $ex) {
            throw new \Exception("Erro ao Atualizar ingrediente", 500);
        }
    }

    public function deletarIngrediente($id, \PDO $conn) {
        try {

            $sql = "Select * from ingredientes where id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $ingrediente = $stmt->fetchAll(\PDO::FETCH_OBJ);

            if (!$ingrediente) {
                throw new \Exception("Ingrediente inexistente informe um ingrediente válido", 400);
            }

            $sql = "Delete from ingredientes  where id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        } catch (\Exception $ex) {
            throw new \Exception("Erro ao Deletar ingrediente", 500);
        }
    }

}
