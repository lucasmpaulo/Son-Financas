<?php

use Psr\Http\Message\ServerRequestInterface;

$app
    ->get(
        '/statements', function (ServerRequestInterface $request) use ($app) {
            $view = $app->service('view.renderer');
            $repository = $app->service('statement.repository');
            $auth = $app->service('auth');
            $data = $request->getQueryParams();

            // Verificar se a data inicial existe
            $dateStart = $data['date_start'] ?? (new \DateTime())->modify('-1 month');
            // Verifica se é uma instância do php, se não for converte o formato da data
            $dateStart = $dateStart instanceof \DateTime ? $dateStart ->format('Y-m-d') 
            : \DateTime::createFromFormat('d/m/Y', $dateStart)->format('Y-m-d');  

            // Verificar se a data final existe
            $dateEnd = $data['date_end'] ?? new \DateTime();
            // Verifica se é uma instância do php, se não for converte o formato da data
            $dateEnd = $dateEnd instanceof \DateTime ? $dateEnd ->format('Y-m-d') 
            : \DateTime::createFromFormat('d/m/Y', $dateEnd)->format('Y-m-d');

            $statements = $repository->all($dateStart, $dateEnd, $auth->user()->getId());

            return $view->render(
                'statements.html.twig', [
                'statements' => $statements
                ]
            );
        }, 'statements.list'
    );

    
