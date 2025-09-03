<?php

return [
    'login' => [
        'heading' => 'Iniciar sesión',
        'form' => [
            'email' => [
                'label' => 'Correo electrónico',
            ],
            'password' => [
                'label' => 'Contraseña',
            ],
            'remember' => [
                'label' => 'Recordarme',
            ],
            'actions' => [
                'authenticate' => [
                    'label' => 'Iniciar sesión',
                ],
            ],
        ],
        'messages' => [
            'failed' => 'Estas credenciales no coinciden con nuestros registros.',
        ],
    ],
    'logout' => [
        'label' => 'Cerrar sesión',
    ],
    'navigation' => [
        'dashboard' => 'Panel de control',
        'users' => 'Usuarios',
        'products' => 'Productos',
        'sales' => 'Ventas',
    ],
    'actions' => [
        'create' => 'Crear',
        'edit' => 'Editar',
        'delete' => 'Eliminar',
        'save' => 'Guardar',
        'cancel' => 'Cancelar',
        'view' => 'Ver',
        'export' => 'Exportar',
        'import' => 'Importar',
        'search' => 'Buscar',
        'filter' => 'Filtrar',
        'reset' => 'Restablecer',
    ],
    'table' => [
        'empty' => 'No se encontraron registros',
        'search_placeholder' => 'Buscar...',
        'per_page' => 'por página',
        'showing' => 'Mostrando',
        'to' => 'a',
        'of' => 'de',
        'results' => 'resultados',
    ],
    'form' => [
        'required' => 'Este campo es obligatorio',
        'invalid_email' => 'Debe ser un correo electrónico válido',
        'min_length' => 'Debe tener al menos :min caracteres',
        'max_length' => 'No puede tener más de :max caracteres',
    ],
];