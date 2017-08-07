<?php

namespace MVC\Dos;

/**
 * Description of Produto
 *
 * @author Guilherme
 */
class ProdutoDo {

    private $nome;
    private $preco;
    private $id;
    private $ingredientes;

    function getIngredientes() {
        return $this->ingredientes;
    }

    function setIngredientes($ingredientes) {
        $this->ingredientes = $ingredientes;
    }

    function getId() {
        return $this->id;
    }

    function setId($id) {
        $this->id = $id;
    }

    function getNome() {
        return $this->nome;
    }

    function getPreco() {
        return $this->preco;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setPreco($preco) {
        $this->preco = $preco;
    }

}
