<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';

$app = new \Slim\App;

$config = file_get_contents("../config.json");
$config = json_decode($config);


$app->post('/marmitaria/clientes', function (Request $request, Response $response) use ($config) {

    $erro = 0;
    try {
        $conn = \MVC\Banco\Banco::connectDb($config->usuario, $config->senha, $config->host, $config->db);
    } catch (Exception $ex) {
        die("<pre>" . __FILE__ . " - " . __LINE__ . "\n" . print_r($ex, true) . "</pre>");
    }

    $clienteController = new \MVC\Controllers\ClienteController();

    $dados = array(
        "nome" => $request->getParam("nome") != null ? $request->getParam("nome") : null,
        "email" => $request->getParam("email") != null ? $request->getParam("email") : null,
    );

    if ($dados["nome"] == null) {
        $erro = 1;
    }

    if ($dados["email"] == null) {
        $erro = 1;
    }

    if ($erro == 0) {
        $retorno = $clienteController->salvarCliente($dados, $conn);
        return $response->withJson($retorno['message'], $retorno['code']);
    } else {
        $data = 'Um ou mais campos não foram enviados ou são inválidos';
        return $response->withJson($data, 400);
    }

    return $response;
});

$app->get('/marmitaria/clientes', function (Request $request, Response $response) use ($config) {
    $conn = \MVC\Banco\Banco::connectDb($config->usuario, $config->senha, $config->host, $config->db);

    $clienteController = new \MVC\Controllers\ClienteController();
    $retorno = $clienteController->buscarClientes($conn);
    return $response->withJson(array(
                "message" => $retorno['message'],
                "data" => $retorno['data'] != null ? $retorno['data'] : "Sem clientes para listagem"), $retorno['code']);
});

$app->get('/marmitaria/clientes/{idCliente}', function (Request $request, Response $response) use ($config) {
    $conn = \MVC\Banco\Banco::connectDb($config->usuario, $config->senha, $config->host, $config->db);
    $id = $request->getAttribute('idCliente') != null ? $request->getAttribute('idCliente') : null;

    $clienteController = new \MVC\Controllers\ClienteController();
    $retorno = $clienteController->buscarClientes($conn, $id);

    return $response->withJson(array(
                "message" => $retorno['message'],
                "data" => $retorno['data'] != null ? $retorno['data'] : "Cliente não encontrado"), $retorno['code']);
});

$app->put('/marmitaria/clientes/{idCliente}', function (Request $request, Response $response) use ($config) {
    $conn = \MVC\Banco\Banco::connectDb($config->usuario, $config->senha, $config->host, $config->db);

    $erro = 0;

    $id = $request->getAttribute('idCliente') != null ? $request->getAttribute('idCliente') : null;
    $nome = $request->getParam('nome') != null ? $request->getParam('nome') : null;
    $email = $request->getParam('email') != null ? $request->getParam('email') : null;

    if ($id == null) {
        $erro = 1;
    }

    if ($nome == null) {
        $erro = 1;
    }

    if ($email == null) {
        $erro = 1;
    }

    if ($erro == 0) {
        $dados = array(
            "id" => $id,
            "nome" => $nome,
            "email" => $email,
        );

        $clienteController = new \MVC\Controllers\ClienteController();
        $retorno = $clienteController->editarCliente($conn, $dados);
    } else {
        $data = 'Um ou mais campos não foram enviados ou são inválidos';
        return $response->withJson($data, 400);
    }



    return $response->withJson($retorno['message'], $retorno['code']);
});

$app->delete('/marmitaria/clientes/{idCliente}', function (Request $request, Response $response) use ($config) {
    $conn = \MVC\Banco\Banco::connectDb($config->usuario, $config->senha, $config->host, $config->db);

    $erro = 0;

    $id = $request->getAttribute('idCliente') != null ? $request->getAttribute('idCliente') : null;

    if ($id == null) {
        $erro = 1;
    }
    if ($erro == 0) {

        $clienteController = new \MVC\Controllers\ClienteController();
        $retorno = $clienteController->deletarCliente($conn, $id);
    } else {
        $data = 'Um ou mais campos não foram enviados ou são inválidos';
        return $response->withJson($data, 400);
    }



    return $response->withJson($retorno['message'], $retorno['code']);
});


$app->post('/marmitaria/ingredientes', function (Request $request, Response $response) use ($config) {
    $erro = 0;
    try {
        $conn = \MVC\Banco\Banco::connectDb($config->usuario, $config->senha, $config->host, $config->db);
    } catch (Exception $ex) {
        die("<pre>" . __FILE__ . " - " . __LINE__ . "\n" . print_r($ex, true) . "</pre>");
    }

    $ingredienteController = new \MVC\Controllers\IngredienteController();

    $dados = array(
        "nome" => $request->getParam("nome") != null ? $request->getParam("nome") : null,
        "observacao" => $request->getParam("observacao") != null ? $request->getParam("observacao") : null,
    );

    if ($dados["nome"] == null) {
        $erro = 1;
    }

    if ($dados["observacao"] == null) {
        $erro = 1;
    }

    if ($erro == 0) {
        $retorno = $ingredienteController->salvarIngrediente($dados, $conn);
        return $response->withJson($retorno['message'], $retorno['code']);
    } else {
        $data = 'Um ou mais campos não foram enviados ou são inválidos';
        return $response->withJson($data, 400);
    }

    return $response;
});

$app->get('/marmitaria/ingredientes', function (Request $request, Response $response) use ($config) {
    $conn = \MVC\Banco\Banco::connectDb($config->usuario, $config->senha, $config->host, $config->db);

    $ingredienteController = new \MVC\Controllers\IngredienteController();
    $retorno = $ingredienteController->buscarIngredientes($conn);
    return $response->withJson(array(
                "message" => $retorno['message'],
                "data" => $retorno['data'] != null ? $retorno['data'] : "Sem ingredientes para listagem"), $retorno['code']);
});

$app->get('/marmitaria/ingredientes/{idIngrediente}', function (Request $request, Response $response) use ($config) {
    $conn = \MVC\Banco\Banco::connectDb($config->usuario, $config->senha, $config->host, $config->db);
    $id = $request->getAttribute('idIngrediente') != null ? $request->getAttribute('idIngrediente') : null;

    $ingredienteController = new \MVC\Controllers\IngredienteController();
    $retorno = $ingredienteController->buscarIngredientes($conn, $id);

    return $response->withJson(array(
                "message" => $retorno['message'],
                "data" => $retorno['data'] != null ? $retorno['data'] : "Ingrediente não encontrado"), $retorno['code']);
});

$app->put('/marmitaria/ingredientes/{idIngrediente}', function (Request $request, Response $response) use ($config) {
    $conn = \MVC\Banco\Banco::connectDb($config->usuario, $config->senha, $config->host, $config->db);

    $erro = 0;

    $id = $request->getAttribute('idIngrediente') != null ? $request->getAttribute('idIngrediente') : null;
    $nome = $request->getParam('nome') != null ? $request->getParam('nome') : null;
    $observacao = $request->getParam('observacao') != null ? $request->getParam('observacao') : null;

    if ($id == null) {
        $erro = 1;
    }

    if ($nome == null) {
        $erro = 1;
    }

    if ($observacao == null) {
        $erro = 1;
    }

    if ($erro == 0) {
        $dados = array(
            "id" => $id,
            "nome" => $nome,
            "observacao" => $observacao,
        );

        $ingredienteController = new \MVC\Controllers\IngredienteController();
        $retorno = $ingredienteController->editarIngrediente($conn, $dados);
    } else {
        $data = 'Um ou mais campos não foram enviados ou são inválidos';
        return $response->withJson($data, 400);
    }



    return $response->withJson($retorno['message'], $retorno['code']);
});

$app->delete('/marmitaria/ingredientes/{idIngrediente}', function (Request $request, Response $response) use ($config) {
    $conn = \MVC\Banco\Banco::connectDb($config->usuario, $config->senha, $config->host, $config->db);

    $erro = 0;

    $id = $request->getAttribute('idIngrediente') != null ? $request->getAttribute('idIngrediente') : null;

    if ($id == null) {
        $erro = 1;
    }
    if ($erro == 0) {

        $ingredienteController = new \MVC\Controllers\IngredienteController();
        $retorno = $ingredienteController->deletarIngrediente($conn, $id);
    } else {
        $data = 'Um ou mais campos não foram enviados ou são inválidos';
        return $response->withJson($data, 400);
    }



    return $response->withJson($retorno['message'], $retorno['code']);
});



$app->post('/marmitaria/produtos', function (Request $request, Response $response) use ($config) {
    $erro = 0;

    try {
        $conn = \MVC\Banco\Banco::connectDb($config->usuario, $config->senha, $config->host, $config->db);
    } catch (Exception $ex) {
        die("<pre>" . __FILE__ . " - " . __LINE__ . "\n" . print_r($ex, true) . "</pre>");
    }

    $produtoController = new \MVC\Controllers\ProdutoController();

    $dados = array(
        "nome" => $request->getParam("nome") != null ? $request->getParam("nome") : null,
        "preco" => $request->getParam("preco") != null ? $request->getParam("preco") : null,
        "ingredientes" => $request->getParam("ingredientes") != null ? $request->getParam("ingredientes") : null,
    );

    if ($dados["nome"] == null) {
        $erro = 1;
    }

    if ($dados["preco"] == null) {
        $erro = 1;
    }

    if ($dados["ingredientes"] == null) {
        $erro = 1;
    }

    if ($erro == 0) {
        $retorno = $produtoController->salvarProduto($dados, $conn);
        return $response->withJson($retorno['message'], $retorno['code']);
    } else {
        $data = 'Um ou mais campos não foram enviados ou são inválidos';
        return $response->withJson($data, 400);
    }

    return $response;
});

$app->get('/marmitaria/produtos', function (Request $request, Response $response) use ($config) {
    $conn = \MVC\Banco\Banco::connectDb($config->usuario, $config->senha, $config->host, $config->db);

    $produtoController = new \MVC\Controllers\ProdutoController();
    $retorno = $produtoController->buscarProdutos($conn);

    return $response->withJson(array(
                "message" => $retorno['message'],
                "data" => $retorno['data'] != null ? $retorno['data'] : "Sem produtos para listagem"), $retorno['code']);
});

$app->get('/marmitaria/produtos/{idProduto}', function (Request $request, Response $response) use ($config) {
    $conn = \MVC\Banco\Banco::connectDb($config->usuario, $config->senha, $config->host, $config->db);
    $id = $request->getAttribute('idProduto') != null ? $request->getAttribute('idProduto') : null;

    $produtoController = new \MVC\Controllers\ProdutoController();
    $retorno = $produtoController->buscarProdutos($conn, $id);

    return $response->withJson(array(
                "message" => $retorno['message'],
                "data" => $retorno['data'] != null ? $retorno['data'] : "Produto não encontrado"), $retorno['code']);
});

$app->put('/marmitaria/produtos/{idProduto}', function (Request $request, Response $response) use ($config) {
    $conn = \MVC\Banco\Banco::connectDb($config->usuario, $config->senha, $config->host, $config->db);

    $erro = 0;

    $id = $request->getAttribute('idProduto') != null ? $request->getAttribute('idProduto') : null;
    $nome = $request->getParam('nome') != null ? $request->getParam('nome') : null;
    $preco = $request->getParam('preco') != null ? $request->getParam('preco') : null;
    $ingredientes = $request->getParam('ingredientes') != null ? $request->getParam('ingredientes') : null;

    if ($id == null) {
        $erro = 1;
    }

    if ($nome == null) {
        $erro = 1;
    }

    if ($ingredientes == null) {
        $erro = 1;
    }

    if ($preco == null) {
        $erro = 1;
    }

    if ($erro == 0) {
        $dados = array(
            "id" => $id,
            "nome" => $nome,
            "preco" => $preco,
            "ingredientes" => $ingredientes,
        );

        $produtoController = new \MVC\Controllers\ProdutoController();
        $retorno = $produtoController->editarProduto($conn, $dados);
    } else {
        $data = 'Um ou mais campos não foram enviados ou são inválidos';
        return $response->withJson($data, 400);
    }



    return $response->withJson($retorno['message'], $retorno['code']);
});

$app->delete('/marmitaria/produtos/{idProduto}', function (Request $request, Response $response) use ($config) {
    $conn = \MVC\Banco\Banco::connectDb($config->usuario, $config->senha, $config->host, $config->db);

    $erro = 0;

    $id = $request->getAttribute('idProduto') != null ? $request->getAttribute('idProduto') : null;

    if ($id == null) {
        $erro = 1;
    }


    if ($erro == 0) {

        $produtoController = new \MVC\Controllers\ProdutoController();
        $retorno = $produtoController->deletarProduto($conn, $id);
    } else {
        $data = 'Um ou mais campos não foram enviados ou são inválidos';
        return $response->withJson($data, 400);
    }



    return $response->withJson($retorno['message'], $retorno['code']);
});

$app->post('/marmitaria/pedidos', function (Request $request, Response $response) use ($config) {
    $erro = 0;

    try {
        $conn = \MVC\Banco\Banco::connectDb($config->usuario, $config->senha, $config->host, $config->db);
    } catch (Exception $ex) {
        die("<pre>" . __FILE__ . " - " . __LINE__ . "\n" . print_r($ex, true) . "</pre>");
    }

    $pedidoController = new \MVC\Controllers\PedidoController();

    $dados = array(
        "idCliente" => $request->getParam("idCliente") != null ? $request->getParam("idCliente") : null,
        "produtos" => $request->getParam("produtos") != null ? $request->getParam("produtos") : null,
    );

    if ($dados["idCliente"] == null) {
        $erro = 1;
    }

    if ($dados["produtos"] == null) {
        $erro = 1;
    }

    if ($erro == 0) {

        $retorno = $pedidoController->salvarPedido($dados, $conn);
        return $response->withJson($retorno['message'], $retorno['code']);
    } else {
        $data = 'Um ou mais campos não foram enviados ou são inválidos';
        return $response->withJson($data, 400);
    }

    return $response;
});


$app->run();
