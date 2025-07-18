<?php

return [

    'title' => 'Redefina sua senha',

    'heading' => 'Esqueceu sua senha?',

    'actions' => [

        'login' => [
            'label' => 'voltar ao login',
        ],

    ],

    'form' => [

        'email' => [
            'label' => 'E-mail',
        ],

        'actions' => [

            'request' => [
                'label' => 'Enviar email',
            ],

        ],

    ],

    'notifications' => [

        'sent' => [
            'body' => 'Se sua conta não existir, você não receberá o e-mail.',
        ],

        'throttled' => [
            'title' => 'Muitas solicitações',
            'body' => 'Por favor tente novamente em :seconds segundos.',
        ],

    ],

];
