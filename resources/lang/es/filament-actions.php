<?php

return [
    'single' => [
        'label' => 'Acción',
    ],
    'multiple' => [
        'label' => 'Acciones',
    ],
    'group' => [
        'label' => 'Grupo de acciones',
    ],
    'keyboardShortcut' => [
        'label' => 'Atajo de teclado',
    ],
    'tooltip' => [
        'label' => 'Información sobre herramientas',
    ],
    'create' => [
        'single' => [
            'label' => 'Crear',
            'modal' => [
                'heading' => 'Crear :label',
                'actions' => [
                    'create' => [
                        'label' => 'Crear',
                    ],
                    'create_another' => [
                        'label' => 'Crear y crear otro',
                    ],
                ],
            ],
            'notifications' => [
                'created' => [
                    'title' => 'Creado',
                ],
            ],
        ],
    ],
    'edit' => [
        'single' => [
            'label' => 'Editar',
            'modal' => [
                'heading' => 'Editar :label',
                'actions' => [
                    'save' => [
                        'label' => 'Guardar cambios',
                    ],
                ],
            ],
            'notifications' => [
                'saved' => [
                    'title' => 'Guardado',
                ],
            ],
        ],
    ],
    'view' => [
        'single' => [
            'label' => 'Ver',
            'modal' => [
                'heading' => 'Ver :label',
                'actions' => [
                    'close' => [
                        'label' => 'Cerrar',
                    ],
                ],
            ],
        ],
    ],
    'delete' => [
        'single' => [
            'label' => 'Eliminar',
            'modal' => [
                'heading' => 'Eliminar :label',
                'actions' => [
                    'delete' => [
                        'label' => 'Eliminar',
                    ],
                ],
            ],
            'notifications' => [
                'deleted' => [
                    'title' => 'Eliminado',
                ],
            ],
        ],
        'multiple' => [
            'label' => 'Eliminar seleccionados',
            'modal' => [
                'heading' => 'Eliminar :label seleccionados',
                'actions' => [
                    'delete' => [
                        'label' => 'Eliminar',
                    ],
                ],
            ],
            'notifications' => [
                'deleted' => [
                    'title' => 'Eliminados',
                ],
            ],
        ],
    ],
    'force_delete' => [
        'single' => [
            'label' => 'Eliminar permanentemente',
            'modal' => [
                'heading' => 'Eliminar permanentemente :label',
                'actions' => [
                    'delete' => [
                        'label' => 'Eliminar',
                    ],
                ],
            ],
            'notifications' => [
                'deleted' => [
                    'title' => 'Eliminado',
                ],
            ],
        ],
        'multiple' => [
            'label' => 'Eliminar permanentemente seleccionados',
            'modal' => [
                'heading' => 'Eliminar permanentemente :label seleccionados',
                'actions' => [
                    'delete' => [
                        'label' => 'Eliminar',
                    ],
                ],
            ],
            'notifications' => [
                'deleted' => [
                    'title' => 'Eliminados',
                ],
            ],
        ],
    ],
    'restore' => [
        'single' => [
            'label' => 'Restaurar',
            'modal' => [
                'heading' => 'Restaurar :label',
                'actions' => [
                    'restore' => [
                        'label' => 'Restaurar',
                    ],
                ],
            ],
            'notifications' => [
                'restored' => [
                    'title' => 'Restaurado',
                ],
            ],
        ],
        'multiple' => [
            'label' => 'Restaurar seleccionados',
            'modal' => [
                'heading' => 'Restaurar :label seleccionados',
                'actions' => [
                    'restore' => [
                        'label' => 'Restaurar',
                    ],
                ],
            ],
            'notifications' => [
                'restored' => [
                    'title' => 'Restaurados',
                ],
            ],
        ],
    ],
    'replicate' => [
        'single' => [
            'label' => 'Replicar',
            'modal' => [
                'heading' => 'Replicar :label',
                'actions' => [
                    'replicate' => [
                        'label' => 'Replicar',
                    ],
                ],
            ],
            'notifications' => [
                'replicated' => [
                    'title' => 'Replicado',
                ],
            ],
        ],
    ],
    'import' => [
        'single' => [
            'label' => 'Importar',
            'modal' => [
                'heading' => 'Importar :label',
                'form' => [
                    'file' => [
                        'label' => 'Archivo',
                        'placeholder' => 'Subir un archivo CSV',
                    ],
                    'columns' => [
                        'label' => 'Columnas',
                        'placeholder' => 'Selecciona una columna',
                    ],
                ],
                'actions' => [
                    'download_example' => [
                        'label' => 'Descargar archivo CSV de ejemplo',
                    ],
                    'import' => [
                        'label' => 'Importar',
                    ],
                ],
            ],
            'notifications' => [
                'completed' => [
                    'title' => 'Importación completada',
                    'actions' => [
                        'download_failed_rows_csv' => [
                            'label' => 'Descargar información sobre la fila fallida|Descargar información sobre las filas fallidas',
                        ],
                    ],
                ],
                'max_rows' => [
                    'title' => 'El archivo CSV subido es demasiado grande',
                    'body' => 'No puedes importar más de 1 fila a la vez.|No puedes importar más de :count filas a la vez.',
                ],
                'started' => [
                    'title' => 'Importación iniciada',
                    'body' => 'Tu importación ha comenzado y 1 fila será procesada en segundo plano.|Tu importación ha comenzado y :count filas serán procesadas en segundo plano.',
                ],
            ],
            'example_csv' => [
                'file_name' => ':importer-ejemplo',
            ],
        ],
    ],
    'export' => [
        'single' => [
            'label' => 'Exportar',
            'modal' => [
                'heading' => 'Exportar :label',
                'form' => [
                    'columns' => [
                        'label' => 'Columnas',
                        'form' => [
                            'is_enabled' => [
                                'label' => ':column habilitado',
                            ],
                            'label' => [
                                'label' => 'Etiqueta de :column',
                            ],
                        ],
                    ],
                ],
                'actions' => [
                    'export' => [
                        'label' => 'Exportar',
                    ],
                ],
            ],
            'notifications' => [
                'completed' => [
                    'title' => 'Exportación completada',
                    'actions' => [
                        'download_csv' => [
                            'label' => 'Descargar .csv',
                        ],
                        'download_xlsx' => [
                            'label' => 'Descargar .xlsx',
                        ],
                    ],
                ],
                'max_rows' => [
                    'title' => 'La exportación es demasiado grande',
                    'body' => 'No puedes exportar más de 1 fila a la vez.|No puedes exportar más de :count filas a la vez.',
                ],
                'started' => [
                    'title' => 'Exportación iniciada',
                    'body' => 'Tu exportación ha comenzado y 1 fila será procesada en segundo plano.|Tu exportación ha comenzado y :count filas serán procesadas en segundo plano.',
                ],
            ],
            'file_name' => 'exportar-:export_id-:model',
        ],
    ],
    'attach' => [
        'single' => [
            'label' => 'Adjuntar',
            'modal' => [
                'heading' => 'Adjuntar :label',
                'fields' => [
                    'record_id' => [
                        'label' => 'Registro',
                    ],
                ],
                'actions' => [
                    'attach' => [
                        'label' => 'Adjuntar',
                    ],
                    'attach_another' => [
                        'label' => 'Adjuntar y adjuntar otro',
                    ],
                ],
            ],
            'notifications' => [
                'attached' => [
                    'title' => 'Adjuntado',
                ],
            ],
        ],
    ],
    'detach' => [
        'single' => [
            'label' => 'Separar',
            'modal' => [
                'heading' => 'Separar :label',
                'actions' => [
                    'detach' => [
                        'label' => 'Separar',
                    ],
                ],
            ],
            'notifications' => [
                'detached' => [
                    'title' => 'Separado',
                ],
            ],
        ],
        'multiple' => [
            'label' => 'Separar seleccionados',
            'modal' => [
                'heading' => 'Separar :label seleccionados',
                'actions' => [
                    'detach' => [
                        'label' => 'Separar',
                    ],
                ],
            ],
            'notifications' => [
                'detached' => [
                    'title' => 'Separados',
                ],
            ],
        ],
    ],
    'associate' => [
        'single' => [
            'label' => 'Asociar',
            'modal' => [
                'heading' => 'Asociar :label',
                'fields' => [
                    'record_id' => [
                        'label' => 'Registro',
                    ],
                ],
                'actions' => [
                    'associate' => [
                        'label' => 'Asociar',
                    ],
                    'associate_another' => [
                        'label' => 'Asociar y asociar otro',
                    ],
                ],
            ],
            'notifications' => [
                'associated' => [
                    'title' => 'Asociado',
                ],
            ],
        ],
    ],
    'dissociate' => [
        'single' => [
            'label' => 'Desasociar',
            'modal' => [
                'heading' => 'Desasociar :label',
                'actions' => [
                    'dissociate' => [
                        'label' => 'Desasociar',
                    ],
                ],
            ],
            'notifications' => [
                'dissociated' => [
                    'title' => 'Desasociado',
                ],
            ],
        ],
        'multiple' => [
            'label' => 'Desasociar seleccionados',
            'modal' => [
                'heading' => 'Desasociar :label seleccionados',
                'actions' => [
                    'dissociate' => [
                        'label' => 'Desasociar',
                    ],
                ],
            ],
            'notifications' => [
                'dissociated' => [
                    'title' => 'Desasociados',
                ],
            ],
        ],
    ],
    'modal' => [
        'require_confirmation' => [
            'description' => '¿Estás seguro de que quieres hacer esto?',
        ],
    ],
];