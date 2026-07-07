<?php

return [

    'title' => 'Регистрация',

    'heading' => 'Регистрация',

    'actions' => [

        'login' => [
            'before' => 'или',
            'label' => 'войти в аккаунт',
        ],

    ],

    'form' => [

        'email' => [
            'label' => 'Email',
        ],

        'name' => [
            'label' => 'Имя',
        ],

        'password' => [
            'label' => 'Пароль',
            'validation_attribute' => 'пароль',
        ],

        'password_confirmation' => [
            'label' => 'Подтверждение пароля',
        ],

        'actions' => [

            'register' => [
                'label' => 'Зарегистрироваться',
            ],

        ],

    ],

    'notifications' => [

        'throttled' => [
            'title' => 'Слишком много попыток регистрации',
            'body' => 'Попробуйте снова через :seconds сек.',
        ],

    ],

];

