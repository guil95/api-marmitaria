<?php

namespace MVC\Controllers;

/**
 * Description of Produto
 *
 * @author Guilherme
 */
class ProdutoController {

    public function salvarProduto($dados, \PDO $conn) {
        $produtoDo = new \MVC\Dos\ProdutoDo();
        $produtoDo->setNome($dados['nome']);
        $produtoDo->setPreco($dados['preco']);
        $produtoDo->setIngredientes($dados['ingredientes']);


        try {
            $produtoModel = new \MVC\Models\ProdutoModel();
            $produtoModel->saveProduto($produtoDo, $conn);
            $sucesso['message'] = "Operação completada com sucesso";
            $sucesso['code'] = 201;

            return $sucesso;
        } catch (\Exception $ex) {

            $erro['message'] = $ex->getMessage();
            $erro['code'] = $ex->getCode();
            return $erro;
        }
    }

    public function buscarProdutos(\PDO $conn, $id = null) {

        try {
            $produtoModel = new \MVC\Models\ProdutoModel();

            $produtos = $produtoModel->buscarProdutos($conn, $id);

            $produtoretorno = array();

            foreach ($produtos as $key => $produto) {
                if (!isset($produtoretorno[$produto['prodId']])) {
                    $produtoretorno[$produto['prodId']] = array(
                        "id" => $produto['prodId'],
                        "nome" => $produto['nomeProd'],
                        "preco" => $produto['preco'],
                        "ingredientes" => array(
                            array(
                                "id" => $produto['idIngrediente'],
                                "nome" => $produto['nomeIngrediente'],
                                "observacao" => $produto['observacao'],
                            )
                        )
                    );
                } elseif (isset($produtoretorno[$produto['prodId']])) {
                    $produtoretorno[$produto['prodId']]['ingredientes'][] = array(
                        "id" => $produto['idIngrediente'],
                        "nome" => $produto['nomeIngrediente'],
                        "observacao" => $produto['observacao'],
                    );
                }
            }

            $produtosJson = array();

            foreach ($produtoretorno as $produto) {
                $produtosJson[] = $produto;
            }
            $sucesso['data'] = $produtosJson;
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

    public function editarProduto(\PDO $conn, $dados) {
        $produtoDo = new \MVC\Dos\ProdutoDo();

        $produtoDo->setPreco($dados['preco']);
        $produtoDo->setNome($dados['nome']);
        $produtoDo->setId($dados['id']);
        $produtoDo->setIngredientes($dados['ingredientes']);

        try {
            $produtoModel = new \MVC\Models\ProdutoModel();
            $produtoModel->editarProduto($produtoDo, $conn);
            $sucesso['message'] = "Operação completada com sucesso";
            $sucesso['code'] = 200;

            return $sucesso;
        } catch (\Exception $ex) {
            $erro['message'] = $ex->getMessage();
            $erro['code'] = $ex->getCode();
            return $erro;
        }
    }

    public function deletarProduto(\PDO $conn, $id) {

        try {
            $produtoModel = new \MVC\Models\ProdutoModel();
            $produtoModel->deletarProduto($id, $conn);
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
