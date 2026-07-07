<?php

return [
    'nav' => [
        'my_links' => 'Мои ссылки',
        'statistics' => 'Статистика',
    ],
    'resource' => [
        'model' => 'короткая ссылка',
        'plural' => 'Короткие ссылки',
    ],
    'table' => [
        'short_url' => 'Короткая ссылка',
        'original_url' => 'Исходная ссылка',
        'total_clicks' => 'Итого кликов',
        'created_at' => 'Создана',
        'actions' => [
            'statistics' => 'Статистика',
            'delete' => 'Удалить',
        ],
        'delete' => [
            'heading' => 'Удалить ссылку?',
            'description' => 'Ссылка и вся статистика переходов будут удалены безвозвратно.',
            'submit' => 'Удалить',
        ],
    ],
    'create' => [
        'action' => 'Добавить ссылку',
        'heading' => 'Новая короткая ссылка',
        'submit' => 'Создать',
        'fields' => [
            'original_url' => [
                'label' => 'Исходная ссылка',
                'placeholder' => 'https://example.com/page',
            ],
        ],
        'notifications' => [
            'created' => 'Ссылка создана',
            'unreachable_404' => 'Ссылка недоступна (не найдена)',
            'unreachable_5xx' => 'Не удалось проверить ссылку (ошибка сервера)',
            'unreachable_network' => 'Не удалось проверить ссылку (ошибка соединения)',
        ],
    ],
    'clicks' => [
        'loading' => 'Загрузка…',
    ],
];

