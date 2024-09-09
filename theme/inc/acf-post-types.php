<?php
add_action('acf/include_fields', function () {
    if (! function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_local_field_group(array(
        'key' => 'group_66df3876bb12d',
        'title' => 'Mapas',
        'fields' => array(
            array(
                'key' => 'field_66df3876e1346',
                'label' => 'Detalhes do mapa',
                'name' => 'mapas_details',
                'aria-label' => '',
                'type' => 'group',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'layout' => 'block',
                'sub_fields' => array(
                    array(
                        'key' => 'field_66df38a7e1347',
                        'label' => 'Nome completo',
                        'name' => '_mapas_nome_completo',
                        'aria-label' => '',
                        'type' => 'text',
                        'instructions' => '',
                        'required' => 1,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'default_value' => '',
                        'maxlength' => '',
                        'allow_in_bindings' => 0,
                        'placeholder' => '',
                        'prepend' => '',
                        'append' => '',
                    ),
                    array(
                        'key' => 'field_66df38e7e1348',
                        'label' => 'Data de nascimento',
                        'name' => '_mapas_data_nascimento',
                        'aria-label' => '',
                        'type' => 'date_picker',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'display_format' => 'd/m/Y',
                        'return_format' => 'd/m/Y',
                        'first_day' => 1,
                        'allow_in_bindings' => 0,
                    ),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'mapas',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'show_in_rest' => 0,
    ));

    acf_add_local_field_group(array(
        'key' => 'group_66df41172782e',
        'title' => 'Placas',
        'fields' => array(
            array(
                'key' => 'field_66df41170aa1e',
                'label' => 'Placas',
                'name' => 'placas_details',
                'aria-label' => '',
                'type' => 'group',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'layout' => 'block',
                'sub_fields' => array(
                    array(
                        'key' => 'field_66df41340aa1f',
                        'label' => 'Data de nascimento',
                        'name' => '_placas_data_nascimento',
                        'aria-label' => '',
                        'type' => 'date_picker',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'display_format' => 'd/m/Y',
                        'return_format' => 'd/m/Y',
                        'first_day' => 1,
                        'allow_in_bindings' => 0,
                    ),
                    array(
                        'key' => 'field_66df41990aa20',
                        'label' => 'Número de telefone',
                        'name' => '_placas_numero_telefone',
                        'aria-label' => '',
                        'type' => 'text',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'default_value' => '',
                        'maxlength' => '',
                        'allow_in_bindings' => 0,
                        'placeholder' => '',
                        'prepend' => '',
                        'append' => '',
                    ),
                    array(
                        'key' => 'field_66df428f0aa21',
                        'label' => 'Placa do veículo',
                        'name' => '_placas_placa_veiculo',
                        'aria-label' => '',
                        'type' => 'text',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'default_value' => '',
                        'maxlength' => '',
                        'allow_in_bindings' => 0,
                        'placeholder' => '',
                        'prepend' => '',
                        'append' => '',
                    ),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'placas',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'show_in_rest' => 0,
    ));
});

add_action('init', function () {
    register_post_type('mapas', array(
        'labels' => array(
            'name' => 'Mapas',
            'singular_name' => 'Mapa',
            'menu_name' => 'Mapas',
            'all_items' => 'Todos os Mapas',
            'edit_item' => 'Editar Mapa',
            'view_item' => 'Ver Mapa',
            'view_items' => 'Ver Mapas',
            'add_new_item' => 'Adicionar novo Mapa',
            'add_new' => 'Adicionar novo Mapa',
            'new_item' => 'Novo Mapa',
            'parent_item_colon' => 'Mapa ascendente:',
            'search_items' => 'Pesquisar Mapas',
            'not_found' => 'Não foi possível encontrar mapas',
            'not_found_in_trash' => 'Não foi possível encontrar mapas na lixeira',
            'archives' => 'Arquivos de Mapa',
            'attributes' => 'Atributos de Mapa',
            'insert_into_item' => 'Inserir no mapa',
            'uploaded_to_this_item' => 'Enviado para este mapa',
            'filter_items_list' => 'Filtrar lista de mapas',
            'filter_by_date' => 'Filtrar mapas por data',
            'items_list_navigation' => 'Navegação na lista de Mapas',
            'items_list' => 'Lista de Mapas',
            'item_published' => 'Mapa publicado.',
            'item_published_privately' => 'Mapa publicado de forma privada.',
            'item_reverted_to_draft' => 'Mapa revertido para rascunho.',
            'item_scheduled' => 'Mapa agendado.',
            'item_updated' => 'Mapa atualizado.',
            'item_link' => 'Link de Mapa',
            'item_link_description' => 'Um link para um mapa.',
        ),
        'description' => 'Mapas criados por clientes',
        'public' => false,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_nav_menus' => true,
        'show_in_rest' => true,
        'menu_position' => 3,
        'menu_icon' => 'dashicons-location',
        'supports' => array(
            0 => 'title',
            1 => 'author',
            2 => 'editor',
            3 => 'page-attributes',
            4 => 'thumbnail',
            5 => 'custom-fields',
        ),
        'delete_with_user' => false,
    ));

    register_post_type('mapa-pessoal', array(
        'labels' => array(
            'name' => 'Mapas Pessoais',
            'singular_name' => 'Mapa Pessoal',
            'menu_name' => 'Mapas Pessoais',
            'all_items' => 'Todos os Mapas Pessoais',
            'edit_item' => 'Editar Mapa Pessoal',
            'view_item' => 'Ver Mapa Pessoal',
            'view_items' => 'Ver Mapas Pessoais',
            'add_new_item' => 'Adicionar novo Mapa Pessoal',
            'add_new' => 'Adicionar novo Mapa Pessoal',
            'new_item' => 'Novo Mapa Pessoal',
            'parent_item_colon' => 'Mapa Pessoal ascendente:',
            'search_items' => 'Pesquisar Mapas Pessoais',
            'not_found' => 'Não foi possível encontrar mapas pessoais',
            'not_found_in_trash' => 'Não foi possível encontrar mapas pessoais na lixeira',
            'archives' => 'Arquivos de Mapa Pessoal',
            'attributes' => 'Atributos de Mapa Pessoal',
            'insert_into_item' => 'Inserir no mapa pessoal',
            'uploaded_to_this_item' => 'Enviado para este mapa pessoal',
            'filter_items_list' => 'Filtrar lista de mapas pessoais',
            'filter_by_date' => 'Filtrar mapas pessoais por data',
            'items_list_navigation' => 'Navegação na lista de Mapas Pessoais',
            'items_list' => 'Lista de Mapas Pessoais',
            'item_published' => 'Mapa Pessoal publicado.',
            'item_published_privately' => 'Mapa Pessoal publicado de forma privada.',
            'item_reverted_to_draft' => 'Mapa Pessoal revertido para rascunho.',
            'item_scheduled' => 'Mapa Pessoal agendado.',
            'item_updated' => 'Mapa Pessoal atualizado.',
            'item_link' => 'Link de Mapa Pessoal',
            'item_link_description' => 'Um link para um mapa pessoal.',
        ),
        'public' => true,
        'show_in_rest' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-businessperson',
        'supports' => array(
            0 => 'title',
            1 => 'custom-fields',
        ),
        'delete_with_user' => false,
    ));

    register_post_type('placas', array(
        'labels' => array(
            'name' => 'Placas',
            'singular_name' => 'Placa',
            'menu_name' => 'Placas',
            'all_items' => 'Todos os Placas',
            'edit_item' => 'Editar Placa',
            'view_item' => 'Ver Placa',
            'view_items' => 'Ver Placas',
            'add_new_item' => 'Adicionar novo Placa',
            'add_new' => 'Adicionar novo Placa',
            'new_item' => 'Novo Placa',
            'parent_item_colon' => 'Placa ascendente:',
            'search_items' => 'Pesquisar Placas',
            'not_found' => 'Não foi possível encontrar placas',
            'not_found_in_trash' => 'Não foi possível encontrar placas na lixeira',
            'archives' => 'Arquivos de Placa',
            'attributes' => 'Atributos de Placa',
            'insert_into_item' => 'Inserir no placa',
            'uploaded_to_this_item' => 'Enviado para este placa',
            'filter_items_list' => 'Filtrar lista de placas',
            'filter_by_date' => 'Filtrar placas por data',
            'items_list_navigation' => 'Navegação na lista de Placas',
            'items_list' => 'Lista de Placas',
            'item_published' => 'Placa publicado.',
            'item_published_privately' => 'Placa publicado de forma privada.',
            'item_reverted_to_draft' => 'Placa revertido para rascunho.',
            'item_scheduled' => 'Placa agendado.',
            'item_updated' => 'Placa atualizado.',
            'item_link' => 'Link de Placa',
            'item_link_description' => 'Um link para um placa.',
        ),
        'description' => 'Placas e telefones salvos pelo usuário',
        'public' => false,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_nav_menus' => true,
        'show_in_admin_bar' => false,
        'show_in_rest' => true,
        'menu_position' => 4,
        'menu_icon' => 'dashicons-car',
        'supports' => array(
            0 => 'title',
            1 => 'author',
            2 => 'editor',
            3 => 'page-attributes',
            4 => 'thumbnail',
            5 => 'custom-fields',
        ),
        'delete_with_user' => false,
    ));

    acf_add_local_field_group(array(
        'key' => 'group_66df563e1483f',
        'title' => 'Empresarial',
        'fields' => array(
            array(
                'key' => 'field_66df563e7e4a3',
                'label' => 'Razão Social',
                'name' => 'razao_social',
                'aria-label' => '',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'maxlength' => '',
                'allow_in_bindings' => 0,
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
            ),
            array(
                'key' => 'field_66df565d7e4a4',
                'label' => 'Nome fantasia',
                'name' => 'nome_fantasia',
                'aria-label' => '',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'maxlength' => '',
                'allow_in_bindings' => 0,
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
            ),
            array(
                'key' => 'field_66df567b7e4a5',
                'label' => 'Data de abertura',
                'name' => 'data_abertura',
                'aria-label' => '',
                'type' => 'date_picker',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'display_format' => 'd-m-Y',
                'return_format' => 'd-m-Y',
                'first_day' => 1,
                'allow_in_bindings' => 0,
            ),
            array(
                'key' => 'field_66df56b87e4a6',
                'label' => 'Data de alteração',
                'name' => 'data_alteracao',
                'aria-label' => '',
                'type' => 'date_picker',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'display_format' => 'd-m-Y',
                'return_format' => 'd-m-Y',
                'first_day' => 1,
                'allow_in_bindings' => 0,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'empresarial',
                ),
            ),
        ),
        'menu_order' => 5,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'show_in_rest' => 0,
    ));

    acf_add_local_field_group(array(
        'key' => 'group_66df546b25778',
        'title' => 'Endereços',
        'fields' => array(
            array(
                'key' => 'field_66df546b908c3',
                'label' => 'CEP',
                'name' => 'cep',
                'aria-label' => '',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'maxlength' => '',
                'allow_in_bindings' => 0,
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
            ),
            array(
                'key' => 'field_66df548c908c4',
                'label' => 'Endereço',
                'name' => 'endereco',
                'aria-label' => '',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'maxlength' => '',
                'allow_in_bindings' => 0,
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
            ),
            array(
                'key' => 'field_66df549f908c5',
                'label' => 'Número',
                'name' => 'numero',
                'aria-label' => '',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'maxlength' => '',
                'allow_in_bindings' => 0,
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
            ),
            array(
                'key' => 'field_66df5539908c6',
                'label' => 'Complemento',
                'name' => 'complemento',
                'aria-label' => '',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'maxlength' => '',
                'allow_in_bindings' => 0,
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'enderecos',
                ),
            ),
        ),
        'menu_order' => 6,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'show_in_rest' => 0,
    ));
});

add_action('init', function () {
    register_post_type('empresarial', array(
        'labels' => array(
            'name' => 'Empresarial',
            'singular_name' => 'Empresa',
            'menu_name' => 'Empresarial',
            'all_items' => 'Todos os Empresarial',
            'edit_item' => 'Editar Empresa',
            'view_item' => 'Ver Empresa',
            'view_items' => 'Ver Empresarial',
            'add_new_item' => 'Adicionar novo Empresa',
            'add_new' => 'Adicionar novo Empresa',
            'new_item' => 'Novo Empresa',
            'parent_item_colon' => 'Empresa ascendente:',
            'search_items' => 'Pesquisar Empresarial',
            'not_found' => 'Não foi possível encontrar empresarial',
            'not_found_in_trash' => 'Não foi possível encontrar empresarial na lixeira',
            'archives' => 'Arquivos de Empresa',
            'attributes' => 'Atributos de Empresa',
            'insert_into_item' => 'Inserir no empresa',
            'uploaded_to_this_item' => 'Enviado para este empresa',
            'filter_items_list' => 'Filtrar lista de empresarial',
            'filter_by_date' => 'Filtrar empresarial por data',
            'items_list_navigation' => 'Navegação na lista de Empresarial',
            'items_list' => 'Lista de Empresarial',
            'item_published' => 'Empresa publicado.',
            'item_published_privately' => 'Empresa publicado de forma privada.',
            'item_reverted_to_draft' => 'Empresa revertido para rascunho.',
            'item_scheduled' => 'Empresa agendado.',
            'item_updated' => 'Empresa atualizado.',
            'item_link' => 'Link de Empresa',
            'item_link_description' => 'Um link para um empresa.',
        ),
        'public' => false,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_nav_menus' => true,
        'show_in_admin_bar' => false,
        'show_in_rest' => true,
        'menu_icon' => 'dashicons-building',
        'supports' => array(
            0 => 'title',
            1 => 'author',
            2 => 'editor',
            3 => 'page-attributes',
            4 => 'thumbnail',
            5 => 'custom-fields',
        ),
        'delete_with_user' => false,
    ));

    register_post_type('enderecos', array(
        'labels' => array(
            'name' => 'Endereços',
            'singular_name' => 'Endereço',
            'menu_name' => 'Endereços',
            'all_items' => 'Todos os Endereços',
            'edit_item' => 'Editar Endereço',
            'view_item' => 'Ver Endereço',
            'view_items' => 'Ver Endereços',
            'add_new_item' => 'Adicionar novo Endereço',
            'add_new' => 'Adicionar novo Endereço',
            'new_item' => 'Novo Endereço',
            'parent_item_colon' => 'Endereço ascendente:',
            'search_items' => 'Pesquisar Endereços',
            'not_found' => 'Não foi possível encontrar endereços',
            'not_found_in_trash' => 'Não foi possível encontrar endereços na lixeira',
            'archives' => 'Arquivos de Endereço',
            'attributes' => 'Atributos de Endereço',
            'insert_into_item' => 'Inserir no endereço',
            'uploaded_to_this_item' => 'Enviado para este endereço',
            'filter_items_list' => 'Filtrar lista de endereços',
            'filter_by_date' => 'Filtrar endereços por data',
            'items_list_navigation' => 'Navegação na lista de Endereços',
            'items_list' => 'Lista de Endereços',
            'item_published' => 'Endereço publicado.',
            'item_published_privately' => 'Endereço publicado de forma privada.',
            'item_reverted_to_draft' => 'Endereço revertido para rascunho.',
            'item_scheduled' => 'Endereço agendado.',
            'item_updated' => 'Endereço atualizado.',
            'item_link' => 'Link de Endereço',
            'item_link_description' => 'Um link para um endereço.',
        ),
        'description' => 'Endereços cadastrados pelos clientes',
        'public' => false,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_nav_menus' => true,
        'show_in_admin_bar' => false,
        'show_in_rest' => true,
        'menu_icon' => 'dashicons-admin-multisite',
        'supports' => array(
            0 => 'title',
            1 => 'author',
            2 => 'editor',
            3 => 'page-attributes',
            4 => 'thumbnail',
            5 => 'custom-fields',
        ),
        'delete_with_user' => false,
    ));
});
