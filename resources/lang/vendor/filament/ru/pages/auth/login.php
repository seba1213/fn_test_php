<?php

return [

    'title' => 'Вход',

    'heading' => 'Вход',

    'actions' => [

        'register' => [
            'before' => 'или',
            'label' => 'создать аккаунт',
        ],

        'request_password_reset' => [
            'label' => 'Забыли пароль?',
        ],

    ],

    'form' => [

        'email' => [
            'label' => 'Email',
        ],

        'password' => [
            'label' => 'Пароль',
        ],

        'remember' => [
            'label' => 'Запомнить меня',
        ],

        'actions' => [

            'authenticate' => [
                'label' => 'Войти',
            ],

        ],

    ],

    'messages' => [
        'failed' => 'Неверный логин или пароль.',
    ],

    'notifications' => [

        'throttled' => [
            'title' => 'Слишком много попыток входа',
            'body' => 'Попробуйте снова через :seconds сек.',
        ],

    ],

];

