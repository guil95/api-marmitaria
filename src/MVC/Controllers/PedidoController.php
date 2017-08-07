<?php

namespace MVC\Controllers;

/**
 * Description of Pedido
 *
 * @author Guilherme
 */
class PedidoController {

    public function salvarPedido($dados, \PDO $conn) {
        $pedidoDo = new \MVC\Dos\PedidoDo();
        $pedidoDo->setIdcliente($dados['idCliente']);
        $pedidoDo->setData_pedido(date('Y-m-d'));
        $pedidoDo->setProdutos($dados['produtos']);


        try {
            $pedidoModel = new \MVC\Models\PedidoModel();
            $pedidoModel->savePedido($pedidoDo, $conn);
            $sucesso['message'] = "Operação completada com sucesso";
            $sucesso['code'] = 201;

            return $sucesso;
        } catch (\Exception $ex) {

            $erro['message'] = $ex->getMessage();
            $erro['code'] = $ex->getCode();
            return $erro;
        }
    }

    public function buscarPedidos(\PDO $conn, $id = null) {

        try {
            $pedidoModel = new \MVC\Models\PedidoModel();

            $pedidos = $pedidoModel->buscarPedidos($conn, $id);

            $pedidoretorno = array();

            foreach ($pedidos as $key => $pedido) {
                if (!isset($pedidoretorno[$pedido['prodId']])) {
                    $pedidoretorno[$pedido['prodId']] = array(
                        "id" => $pedido['prodId'],
                        "nome" => $pedido['nomeProd'],
                        "preco" => $pedido['preco'],
                        "ingredientes" => array(
                            array(
                                "id" => $pedido['idIngrediente'],
                                "nome" => $pedido['nomeIngrediente'],
                                "observacao" => $pedido['observacao'],
                            )
                        )
                    );
                } elseif (isset($pedidoretorno[$pedido['prodId']])) {
                    $pedidoretorno[$pedido['prodId']]['ingredientes'][] = array(
                        "id" => $pedido['idIngrediente'],
                        "nome" => $pedido['nomeIngrediente'],
                        "observacao" => $pedido['observacao'],
                    );
                }
            }

            $pedidosJson = array();

            foreach ($pedidoretorno as $pedido) {
                $pedidosJson[] = $pedido;
            }
            $sucesso['data'] = $pedidosJson;
            $sucesso['message'] = "Operação completada com sucesso";
            $sucesso['code'] = 201;

            return $sucesso;
        } catch (Exception $ex) {
            $erro['message'] = $ex->getMessage();
            $erro['code'] = $ex->getCode();
            $erro["data"] = null;
            return $erro;
        }
    }

    public function editarPedido(\PDO $conn, $dados) {
        $pedidoDo = new \MVC\Dos\PedidoDo();

        $pedidoDo->setPreco($dados['preco']);
        $pedidoDo->setNome($dados['nome']);
        $pedidoDo->setId($dados['id']);
        $pedidoDo->setIngredientes($dados['ingredientes']);

        try {
            $pedidoModel = new \MVC\Models\PedidoModel();
            $pedidoModel->editarPedido($pedidoDo, $conn);
            $sucesso['message'] = "Operação completada com sucesso";
            $sucesso['code'] = 200;

            return $sucesso;
        } catch (\Exception $ex) {
            $erro['message'] = $ex->getMessage();
            $erro['code'] = $ex->getCode();
            return $erro;
        }
    }

    public function deletarPedido(\PDO $conn, $id) {

        try {
            $pedidoModel = new \MVC\Models\PedidoModel();
            $pedidoModel->deletarPedido($id, $conn);
            $sucesso['message'] = "Operação completada com sucesso";
            $sucesso['code'] = 200;

            return $sucesso;
        } catch (\Exception $ex) {
            $erro['message'] = $ex->getMessage();
            $erro['code'] = $ex->getCode();
            return $erro;
        }
    }

}
