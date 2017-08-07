<?php

namespace MVC\Controllers;

/**
 * Description of Ingrediente
 *
 * @author Guilherme
 */
class IngredienteController {

    public function salvarIngrediente($dados, \PDO $conn) {
        $ingredienteDo = new \MVC\Dos\IngredienteDo();
        $ingredienteDo->setNome($dados['nome']);
        $ingredienteDo->setObservacao($dados['observacao']);


        try {
            $ingredienteModel = new \MVC\Models\IngredienteModel();
            $ingredienteModel->saveIngrediente($ingredienteDo, $conn);
            $sucesso['message'] = "Operação completada com sucesso";
            $sucesso['code'] = 201;

            return $sucesso;
        } catch (\Exception $ex) {
            $erro['message'] = $ex->getMessage();
            $erro['code'] = $ex->getCode();
            return $erro;
        }
    }

    public function buscarIngredientes(\PDO $conn, $id = null) {

        try {
            $ingredienteModel = new \MVC\Models\IngredienteModel();

            $sucesso["data"] = $ingredienteModel->buscarIngredientes($conn, $id);
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

    public function editarIngrediente(\PDO $conn, $dados) {
        $ingredienteDo = new \MVC\Dos\IngredienteDo();

        $ingredienteDo->setObservacao($dados['observacao']);
        $ingredienteDo->setNome($dados['nome']);
        $ingredienteDo->setId($dados['id']);

        try {
            $ingredienteModel = new \MVC\Models\IngredienteModel();
            $ingredienteModel->editarIngrediente($ingredienteDo, $conn);
            $sucesso['message'] = "Operação completada com sucesso";
            $sucesso['code'] = 200;

            return $sucesso;
        } catch (\Exception $ex) {
            $erro['message'] = $ex->getMessage();
            $erro['code'] = $ex->getCode();
            return $erro;
        }
    }

    public function deletarIngrediente(\PDO $conn, $id) {
        try {
            $ingredienteModel = new \MVC\Models\IngredienteModel();
            $ingredienteModel->deletarIngrediente($id, $conn);
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
