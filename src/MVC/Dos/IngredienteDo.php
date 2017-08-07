<?php

namespace MVC\Dos;

/**
 * Description of Ingrediente
 *
 * @author Guilherme
 */
class IngredienteDo {

    private $nome;
    private $observacao;
    private $id;

    function getId() {
        return $this->id;
    }

    function setId($id) {
        $this->id = $id;
    }

    function getNome() {
        return $this->nome;
    }

    function getObservacao() {
        return $this->observacao;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setObservacao($observacao) {
        $this->observacao = $observacao;
    }

}
