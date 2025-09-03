<?php

return [
    'pages' => [
        'auth' => [
            'login' => [
                'heading' => 'Iniciar sesión en su cuenta',
                'actions' => [
                    'register' => [
                        'before' => '¿No tienes una cuenta?',
                        'label' => 'Regístrate',
                    ],
                    'request_password_reset' => [
                        'label' => '¿Olvidaste tu contraseña?',
                    ],
                ],
                'form' => [
                    'email' => [
                        'label' => 'Dirección de correo electrónico',
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
                'notifications' => [
                    'throttled' => [
                        'title' => 'Demasiados intentos de inicio de sesión',
                        'body' => 'Por favor, inténtalo de nuevo en :seconds segundos.',
                    ],
                ],
            ],
        ],
        'dashboard' => [
            'title' => 'Panel de control',
            'heading' => 'Panel de control',
        ],
    ],
    'layout' => [
        'actions' => [
            'logout' => [
                'label' => 'Cerrar sesión',
            ],
            'open_database_notifications' => [
                'label' => 'Abrir notificaciones',
            ],
            'open_user_menu' => [
                'label' => 'Menú de usuario',
            ],
            'sidebar' => [
                'collapse' => [
                    'label' => 'Contraer barra lateral',
                ],
                'expand' => [
                    'label' => 'Expandir barra lateral',
                ],
            ],
            'theme_switcher' => [
                'dark' => [
                    'label' => 'Activar modo oscuro',
                ],
                'light' => [
                    'label' => 'Activar modo claro',
                ],
                'system' => [
                    'label' => 'Activar modo del sistema',
                ],
            ],
        ],
    ],
    'resources' => [
        'label' => 'Recurso|Recursos',
        'plural_label' => 'Recursos',
    ],
];