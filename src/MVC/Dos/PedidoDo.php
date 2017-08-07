<?php

namespace MVC\Dos;

/**
 * Description of Pedido
 *
 * @author Guilherme
 */
class PedidoDo {

    private $id;
    private $data_pedido;
    private $idcliente;
    private $produtos;

    function getProdutos() {
        return $this->produtos;
    }

    function setProdutos($produtos) {
        $this->produtos = $produtos;
    }

    function getId() {
        return $this->id;
    }

    function getData_pedido() {
        return $this->data_pedido;
    }

    function getIdcliente() {
        return $this->idcliente;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setData_pedido($data_pedido) {
        $this->data_pedido = $data_pedido;
    }

    function setIdcliente($idcliente) {
        $this->idcliente = $idcliente;
    }

}
