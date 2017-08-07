<?php

namespace MVC\Controllers;

/**
 * Description of Cliente
 *
 * @author Guilherme
 */
class ClienteController {

    public function salvarCliente($dados, \PDO $conn) {
        $clienteDo = new \MVC\Dos\ClienteDo();
        $clienteDo->setNome($dados['nome']);
        $clienteDo->setEmail($dados['email']);


        try {
            $clienteModel = new \MVC\Models\ClienteModel();
            $clienteModel->saveCliente($clienteDo, $conn);
            $sucesso['message'] = "Operação completada com sucesso";
            $sucesso['code'] = 201;

            return $sucesso;
        } catch (\Exception $ex) {
            $erro['message'] = $ex->getMessage();
            $erro['code'] = $ex->getCode();
            return $erro;
        }
    }

    public function buscarClientes(\PDO $conn, $id = null) {

        try {
            $clienteModel = new \MVC\Models\ClienteModel();

            $sucesso["data"] = $clienteModel->buscarClientes($conn, $id);
            $sucesso['message'] = "Operação completada com sucesso";
            $sucesso['code'] = 200;

            return $sucesso;
        } catch (Exception $ex) {
            $erro['message'] = $ex->getMessage();
            $erro['code'] = $ex->getCode();
            $erro["data"] = null;
            return $erro;
        }
    }

    public function editarCliente(\PDO $conn, $dados) {
        $clienteDo = new \MVC\Dos\ClienteDo();

        $clienteDo->setEmail($dados['email']);
        $clienteDo->setNome($dados['nome']);
        $clienteDo->setId($dados['id']);

        try {
            $clienteModel = new \MVC\Models\ClienteModel();
            $clienteModel->editarCliente($clienteDo, $conn);
            $sucesso['message'] = "Operação completada com sucesso";
            $sucesso['code'] = 200;

            return $sucesso;
        } catch (\Exception $ex) {
            $erro['message'] = $ex->getMessage();
            $erro['code'] = $ex->getCode();
            return $erro;
        }
    }

    public function deletarCliente(\PDO $conn, $id) {
        try {
            $clienteModel = new \MVC\Models\ClienteModel();
            $clienteModel->deletarCliente($id, $conn);
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
