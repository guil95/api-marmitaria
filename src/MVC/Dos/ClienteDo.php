<?php

namespace MVC\Dos;

/**
 * Description of Cliente
 *
 * @author Guilherme
 */
class ClienteDo {

    private $nome;
    private $email;
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

    function getEmail() {
        return $this->email;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setEmail($email) {
        $this->email = $email;
    }

}
