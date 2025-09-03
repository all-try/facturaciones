<?php

return [
    'fields' => [
        'code_editor' => [
            'actions' => [
                'copy_to_clipboard' => [
                    'label' => 'Copiar al portapapeles',
                ],
            ],
        ],
        'date_time_picker' => [
            'actions' => [
                'clear' => [
                    'label' => 'Limpiar',
                ],
                'now' => [
                    'label' => 'Ahora',
                ],
            ],
        ],
        'file_upload' => [
            'editor' => [
                'actions' => [
                    'cancel' => [
                        'label' => 'Cancelar',
                    ],
                    'drag_crop' => [
                        'label' => 'Modo de arrastre "recortar"',
                    ],
                    'drag_move' => [
                        'label' => 'Modo de arrastre "mover"',
                    ],
                    'flip_horizontal' => [
                        'label' => 'Voltear imagen horizontalmente',
                    ],
                    'flip_vertical' => [
                        'label' => 'Voltear imagen verticalmente',
                    ],
                    'move_down' => [
                        'label' => 'Mover imagen hacia abajo',
                    ],
                    'move_left' => [
                        'label' => 'Mover imagen hacia la izquierda',
                    ],
                    'move_right' => [
                        'label' => 'Mover imagen hacia la derecha',
                    ],
                    'move_up' => [
                        'label' => 'Mover imagen hacia arriba',
                    ],
                    'reset' => [
                        'label' => 'Restablecer',
                    ],
                    'rotate_left' => [
                        'label' => 'Rotar imagen hacia la izquierda',
                    ],
                    'rotate_right' => [
                        'label' => 'Rotar imagen hacia la derecha',
                    ],
                    'set_aspect_ratio' => [
                        'label' => 'Establecer relación de aspecto a :ratio',
                    ],
                    'save' => [
                        'label' => 'Guardar',
                    ],
                    'zoom_100' => [
                        'label' => 'Zoom imagen al 100%',
                    ],
                    'zoom_in' => [
                        'label' => 'Acercar',
                    ],
                    'zoom_out' => [
                        'label' => 'Alejar',
                    ],
                ],
            ],
        ],
        'key_value' => [
            'actions' => [
                'add' => [
                    'label' => 'Agregar fila',
                ],
                'delete' => [
                    'label' => 'Eliminar fila',
                ],
                'reorder' => [
                    'label' => 'Reordenar fila',
                ],
            ],
            'fields' => [
                'key' => [
                    'label' => 'Clave',
                ],
                'value' => [
                    'label' => 'Valor',
                ],
            ],
        ],
        'markdown_editor' => [
            'toolbar_buttons' => [
                'attach_files' => 'Adjuntar archivos',
                'blockquote' => 'Cita',
                'bold' => 'Negrita',
                'bullet_list' => 'Lista con viñetas',
                'code_block' => 'Bloque de código',
                'heading' => 'Encabezado',
                'italic' => 'Cursiva',
                'link' => 'Enlace',
                'ordered_list' => 'Lista numerada',
                'redo' => 'Rehacer',
                'strike' => 'Tachado',
                'table' => 'Tabla',
                'undo' => 'Deshacer',
            ],
        ],
        'repeater' => [
            'actions' => [
                'add' => [
                    'label' => 'Agregar a :label',
                ],
                'add_between' => [
                    'label' => 'Insertar entre',
                ],
                'delete' => [
                    'label' => 'Eliminar',
                ],
                'clone' => [
                    'label' => 'Clonar',
                ],
                'move_down' => [
                    'label' => 'Mover hacia abajo',
                ],
                'move_up' => [
                    'label' => 'Mover hacia arriba',
                ],
                'collapse' => [
                    'label' => 'Contraer',
                ],
                'expand' => [
                    'label' => 'Expandir',
                ],
                'collapse_all' => [
                    'label' => 'Contraer todo',
                ],
                'expand_all' => [
                    'label' => 'Expandir todo',
                ],
            ],
        ],
        'rich_editor' => [
            'dialogs' => [
                'link' => [
                    'actions' => [
                        'link' => 'Enlazar',
                        'unlink' => 'Desenlazar',
                    ],
                    'label' => 'URL',
                    'placeholder' => 'Ingresa una URL',
                ],
            ],
            'toolbar_buttons' => [
                'attach_files' => 'Adjuntar archivos',
                'blockquote' => 'Cita',
                'bold' => 'Negrita',
                'bullet_list' => 'Lista con viñetas',
                'code_block' => 'Bloque de código',
                'h1' => 'Título',
                'h2' => 'Encabezado',
                'h3' => 'Subencabezado',
                'italic' => 'Cursiva',
                'link' => 'Enlace',
                'ordered_list' => 'Lista numerada',
                'redo' => 'Rehacer',
                'strike' => 'Tachado',
                'underline' => 'Subrayado',
                'undo' => 'Deshacer',
            ],
        ],
        'select' => [
            'actions' => [
                'create_option' => [
                    'modal' => [
                        'heading' => 'Crear',
                        'actions' => [
                            'create' => [
                                'label' => 'Crear',
                            ],
                            'create_another' => [
                                'label' => 'Crear y crear otro',
                            ],
                        ],
                    ],
                ],
                'edit_option' => [
                    'modal' => [
                        'heading' => 'Editar',
                        'actions' => [
                            'save' => [
                                'label' => 'Guardar',
                            ],
                        ],
                    ],
                ],
            ],
            'boolean' => [
                'true' => 'Sí',
                'false' => 'No',
            ],
            'loading_message' => 'Cargando...',
            'max_items_message' => 'Solo se puede seleccionar :count.',
            'no_search_results_message' => 'No se encontraron opciones que coincidan con tu búsqueda.',
            'placeholder' => 'Selecciona una opción',
            'searching_message' => 'Buscando...',
            'search_prompt' => 'Comienza a escribir para buscar...',
        ],
        'tags_input' => [
            'placeholder' => 'Nueva etiqueta',
        ],
        'text_input' => [
            'actions' => [
                'hide_password' => [
                    'label' => 'Ocultar contraseña',
                ],
                'show_password' => [
                    'label' => 'Mostrar contraseña',
                ],
            ],
        ],
        'toggle_buttons' => [
            'boolean' => [
                'true' => 'Sí',
                'false' => 'No',
            ],
        ],
        'wizard' => [
            'actions' => [
                'previous_step' => [
                    'label' => 'Anterior',
                ],
                'next_step' => [
                    'label' => 'Siguiente',
                ],
            ],
        ],
    ],
];