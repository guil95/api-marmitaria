<?php

namespace MVC\Models;

/**
 * Description of Cliente
 *
 * @author Guilherme
 */
class ClienteModel {

    public function saveCliente(\MVC\Dos\ClienteDo $clienteDo, \PDO $conn) {

        if (!$clienteDo->getNome()) {
            throw new \Exception("Um ou mais campos não foram enviados ou são inválidos", 400);
        }

        if (!$clienteDo->getEmail()) {
            throw new \Exception("Um ou mais campos não foram enviados ou são inválidos", 400);
        }

        try {
            $nome = $clienteDo->getNome();
            $email = $clienteDo->getEmail();
            $sql = "Insert into cliente (nome, email) values (:nome, :email)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":nome", $nome);
            $stmt->bindParam(":email", $email);
            $stmt->execute();
        } catch (\Exception $ex) {
            throw new \Exception("Erro ao Salvar cliente", 500);
        }
    }

    public function buscarClientes(\PDO $conn, $id = null) {
        if ($id == null) {

            $sql = "Select * from cliente";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
        } else {
            $sql = "Select * from cliente where id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        }
        try {

            $clientes = $stmt->fetchAll(\PDO::FETCH_OBJ);
        } catch (\Exception $ex) {
            throw new \Exception("Erro ao Buscar cliente", 500);
        }

        return $clientes;
    }

    public function editarCliente(\MVC\Dos\ClienteDo $clienteDo, \PDO $conn) {
        try {
            $id = $clienteDo->getId();
            $nome = $clienteDo->getNome();
            $email = $clienteDo->getEmail();

            $sql = "Select * from cliente where id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $cliente = $stmt->fetchAll(\PDO::FETCH_OBJ);

            if (!$cliente) {
                throw new \Exception("Cliente inexistente informe um cliente válido", 400);
            }

            $sql = "Update cliente set nome = :nome, email = :email where id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        } catch (\Exception $ex) {
            throw new \Exception("Erro ao Atualizar cliente", 500);
        }
    }

    public function deletarCliente($id, \PDO $conn) {
        try {

            $sql = "Select * from cliente where id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $cliente = $stmt->fetchAll(\PDO::FETCH_OBJ);

            if (!$cliente) {
                throw new \Exception("Cliente inexistente informe um cliente válido", 400);
            }

            $sql = "Delete from cliente  where id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        } catch (\Exception $ex) {
            throw new \Exception("Erro ao Deletar cliente", 500);
        }
    }

}
