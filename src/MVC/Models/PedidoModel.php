<?php

namespace MVC\Models;

/**
 * Description of Pedido
 *
 * @author Guilherme
 */
class PedidoModel {

    public function savePedido(\MVC\Dos\PedidoDo $pedidoDo, \PDO $conn) {

        if (!$pedidoDo->getData_pedido()) {
            throw new \Exception("Um ou mais campos não foram enviados ou são inválidos", 400);
        }

        if (!$pedidoDo->getIdcliente()) {
            throw new \Exception("Um ou mais campos não foram enviados ou são inválidos", 400);
        }

        if (!$pedidoDo->getProdutos()) {
            throw new \Exception("Um ou mais campos não foram enviados ou são inválidos", 400);
        }

        try {
            $data = $pedidoDo->getData_pedido();
            $idcliente = $pedidoDo->getIdcliente();
            $produtos = $pedidoDo->getProdutos();

            $erroProdutos = '';
            foreach ($produtos as $produto) {

                $produto = json_decode($produto);

                $sql = "select * from produto where id = :id";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(":id", $produto->id);
                $stmt->execute();

                $produtoretorno = $stmt->fetchAll(\PDO::FETCH_OBJ);
                if (!$produtoretorno) {

                    $erroProdutos .= " Produto {$ingrediente->id} não existe - ";
                }
            }

            $errocliente = '';

            $sql = "select * from cliente where id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":id", $idcliente);
            $stmt->execute();
            $clienteRetorno = $stmt->fetchAll(\PDO::FETCH_OBJ);
            if (!$clienteRetorno) {
                $errocliente = "Cliente não existe";
            }

            if ($errocliente) {
                throw new \Exception($errocliente, 400);
            }

            if ($erroProdutos) {
                throw new \Exception($erroProdutos, 400);
            }

            $sql = "Insert into pedido (idcliente, data_pedido) values (:idcliente, :data_pedido)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":idcliente", $idcliente);
            $stmt->bindParam(":data_pedido", $data);
            $stmt->execute();
            $idpedido = $conn->lastInsertId();

            //Caso envie um ingrediente que não exista o mesmo não seria inserido
            foreach ($produtos as $produto) {
                $produto = json_decode($produto);

                $sql = "Insert into itempedido (qtditem, idprod, idpedido, preco_unitario, preco_total) values (:qtditem, :idprod, :idpedido, :preco_unitario, :preco_total)";
                $stmt2 = $conn->prepare($sql);
                $stmt2->bindParam(":idprod", $produto->id);
                $stmt2->bindParam(":qtditem", $produto->quantidade);
                $stmt2->bindParam(":idpedido", $idpedido);
                $stmt2->bindParam(":preco_unitario", $produto->preco_unitario);
                $stmt2->bindParam(":preco_total", $produto->preco_total);
                $stmt2->execute();
            }
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage(), 400);
        }
    }

}
