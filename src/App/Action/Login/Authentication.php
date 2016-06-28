<?php

namespace App\Action\Login;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Authentication {

    private $tableGateway;

    public function __construct($tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null) {
        $data = $request->getParsedBody();

        $rowset = $this->tableGateway->select(['name' => $data['name'], 'password' => md5($data['password'])]);

        if(is_null($rowset->current())){
            return $response->withStatus(401);
        }

        $objJwt = new \stdClass();
        $objJwt->uid = 123456;
        $objJwt->exp = time() + (60*15);

        $token = \Firebase\JWT\JWT::encode($objJwt, 'webdev');

        return $response->withAddedHeader('authorization', $token)->withStatus(200);
    }

}
