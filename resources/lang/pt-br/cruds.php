<?php

return [
    'userManagement' => [
        'title'          => 'Usuários',
        'title_singular' => 'Usuários',
    ],
    'permission'     => [
        'title'          => 'Permissões',
        'title_singular' => 'Permissão',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => '',
            'title'             => 'Título',
            'title_helper'      => '',
            'created_at'        => 'Criado em',
            'created_at_helper' => '',
            'updated_at'        => 'Atualizado em',
            'updated_at_helper' => '',
            'deleted_at'        => 'Deletado em',
            'deleted_at_helper' => '',
        ],
    ],
    'role'           => [
        'title'          => 'Regras',
        'title_singular' => 'Regra',
        'fields'         => [
            'id'                 => 'ID',
            'id_helper'          => '',
            'title'              => 'Título',
            'title_helper'       => '',
            'permissions'        => 'Permissões',
            'permissions_helper' => '',
            'created_at'         => 'Criado em',
            'created_at_helper'  => '',
            'updated_at'         => 'Atualizado em',
            'updated_at_helper'  => '',
            'deleted_at'         => 'Deletado em',
            'deleted_at_helper'  => '',
        ],
    ],
    'user'           => [
        'title'          => 'Usuários',
        'title_singular' => 'Usuário',
        'fields'         => [
            'id'                       => 'ID',
            'id_helper'                => '',
            'name'                     => 'Nome',
            'name_helper'              => '',
            'email'                    => 'Email',
            'email_helper'             => '',
            'email_verified_at'        => 'Email verificado em',
            'email_verified_at_helper' => '',
            'password'                 => 'Senha',
            'password_helper'          => '',
            'roles'                    => 'Regra',
            'roles_helper'             => '',
            'remember_token'           => 'Lembrar Token',
            'remember_token_helper'    => '',
            'created_at'               => 'Criado em',
            'created_at_helper'        => '',
            'updated_at'               => 'Atualizado em',
            'updated_at_helper'        => '',
            'deleted_at'               => 'Deletado em',
            'deleted_at_helper'        => '',
        ],
    ],
    'status'         => [
        'title'          => 'Status',
        'title_singular' => 'Status',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => '',
            'name'              => 'Nome',
            'name_helper'       => '',
            'color'             => 'Cor',
            'color_helper'      => '',
            'created_at'        => 'Criado em',
            'created_at_helper' => '',
            'updated_at'        => 'Atualizado em',
            'updated_at_helper' => '',
            'deleted_at'        => 'Deletado em',
            'deleted_at_helper' => '',
        ],
    ],
    'priority'       => [
        'title'          => 'Prioridades',
        'title_singular' => 'Prioridades',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => '',
            'name'              => 'Nome',
            'name_helper'       => '',
            'color'             => 'Cor',
            'color_helper'      => '',
            'created_at'        => 'Criado em',
            'created_at_helper' => '',
            'updated_at'        => 'Atualizado em',
            'updated_at_helper' => '',
            'deleted_at'        => 'Deletado em',
            'deleted_at_helper' => '',
        ],
    ],
    'category'       => [
        'title'          => 'Categorias',
        'title_singular' => 'Categoria',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => '',
            'name'              => 'Nome',
            'name_helper'       => '',
            'color'             => 'Cor',
            'color_helper'      => '',
            'created_at'        => 'Criado em',
            'created_at_helper' => '',
            'updated_at'        => 'Atualizado em',
            'updated_at_helper' => '',
            'deleted_at'        => 'Deletado em',
            'deleted_at_helper' => '',
        ],
    ],
    'ticket'         => [
        'title'          => 'OS',
        'title_singular' => 'OS',
        'fields'         => [
            'id'                      => 'ID',
            'id_helper'               => '',
            'title'                   => 'Título',
            'title_helper'            => '',
            'content'                 => 'Conteúdo',
            'content_helper'          => '',
            'status'                  => 'Status',
            'status_helper'           => '',
            'priority'                => 'Prioridade',
            'priority_helper'         => '',
            'category'                => 'Categoria',
            'category_helper'         => '',
            'author_name'             => 'Requerente',
            'author_name_helper'      => '',
            'author_email'            => 'Email do Requerente',
            'author_email_helper'     => '',
            'assigned_to_user'        => 'Atribuído ao Usuário',
            'assigned_to_user_helper' => '',
            'comments'                => 'Comentários',
            'comments_helper'         => '',
            'created_at'              => 'Criado',
            'created_at_helper'       => '',
            'updated_at'              => 'Atualizado',
            'updated_at_helper'       => '',
            'deleted_at'              => 'Deletado',
            'deleted_at_helper'       => '',
            'attachments'             => 'Anexos',
            'attachments_helper'      => '',
        ],
    ],
    'comment'        => [
        'title'          => 'Comentários OS',
        'title_singular' => 'Comentário',
        'fields'         => [
            'id'                  => 'ID',
            'id_helper'           => '',
            'ticket'              => 'OS',
            'ticket_helper'       => '',
            'author_name'         => 'Requerente',
            'author_name_helper'  => '',
            'author_email'        => 'Email do Requerente',
            'author_email_helper' => '',
            'user'                => 'Usuário',
            'user_helper'         => '',
            'comment_text'        => 'Texto do Comentário',
            'comment_text_helper' => '',
            'created_at'          => 'Criado em',
            'created_at_helper'   => '',
            'updated_at'          => 'Atualizado em',
            'updated_at_helper'   => '',
            'deleted_at'          => 'Deletado em',
            'deleted_at_helper'   => '',
        ],
    ],
    'auditLog'       => [
        'title'          => 'Registros',
        'title_singular' => 'Registro',
        'fields'         => [
            'id'                  => 'ID',
            'id_helper'           => '',
            'description'         => 'Descrição',
            'description_helper'  => '',
            'subject_id'          => 'Tópico do ID',
            'subject_id_helper'   => '',
            'subject_type'        => 'Tipo de Tópico',
            'subject_type_helper' => '',
            'user_id'             => 'ID do Usuário',
            'user_id_helper'      => '',
            'properties'          => 'Propriedades',
            'properties_helper'   => '',
            'host'                => 'Host',
            'host_helper'         => '',
            'created_at'          => 'Criado em',
            'created_at_helper'   => '',
            'updated_at'          => 'Atualizado em',
            'updated_at_helper'   => '',
        ],
    ],
];
