<?php
/**
 * LiveStreet CMS
 * Copyright © 2013 OOO "ЛС-СОФТ"
 *
 * ------------------------------------------------------
 *
 * Official site: www.livestreetcms.com
 * Contact e-mail: office@livestreetcms.com
 *
 * GNU General Public License, version 2:
 * http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 *
 * ------------------------------------------------------
 *
 * @link http://www.livestreetcms.com
 * @copyright 2013 OOO "ЛС-СОФТ"
 * @author Serge Pustovit (PSNet) <light.feel@gmail.com>
 *
 */

/*
 *
 * Дополнительный конфиг движка, содержащий схему и список групп
 *
 */

return array(
    /*
     * --- Списки групп настроек главного конфига движка и принадлежащих им разделов и их параметров ---
     *
     * Для каждой группы указывается как минимум один раздел, в котором указываются ключи:
     *
     * 		"name" 				относительный ключ языкового файла для названия раздела группы
     * 		"allowed_keys"		первые символы разрешенных параметров (ключей)
     * 		"excluded_keys" 	начала параметров, которые необходимо исключить из группы (правило работает после списка разрешенных, исключаемое подмножество)
     */
    '$config_groups$' => array(

        'main'   => array(
            array(
                'name'         => 'Общие',
                'allowed_keys' => array(
                    'view.name',
                    'view.description',
                    'view.keywords',
                    'general.admin_mail',
                    'general.close',
                    'general.reg.*',
                    'general.login.captcha',
                    'module.user.captcha_use_registration',
                ),
            ),
        ),
        'blog'   => array(
            array(
                'name'         => 'Блоги',
                'allowed_keys' => array(
                    'module.blog.category_allow',
                    'module.blog.category_only_without_children',
                    'module.blog.category_allow_empty',
                    'module.blog.per_page',
                    'module.blog.users_per_page',
                    'module.blog.personal_good',
                    'module.blog.collective_good',
                    'module.blog.index_good',
                ),
            ),
            array(
                'name'         => 'Права доступа блогов',
                'allowed_keys' => array(
                    'module.blog.category_only_admin',
                    'acl.create.blog.rating',
                ),
            ),
            array(
                'name'         => 'Топики',
                'allowed_keys' => array(
                    'module.topic.new_time',
                    'module.topic.per_page',
                    'module.topic.max_length',
                    'module.topic.min_length',
                    'module.topic.allow_empty',
                    'module.topic.title_max_length',
                    'module.topic.title_min_length',
                    'module.topic.title_allow_empty',
                    'module.topic.tags_allow_empty',
                    'module.topic.tags_count_max',
                    'module.topic.tags_count_min',
                ),
            ),
            array(
                'name'         => 'Права доступа топиков',
                'allowed_keys' => array(
                    'acl.create.topic.limit_time',
                    'acl.create.topic.limit_time_rating',
                    'acl.create.topic.limit_rating',
                    'acl.vote.topic.rating',
                    'acl.vote.topic.limit_time',
                ),
            ),
            array(
                'name'         => 'Комментарии',
                'allowed_keys' => array(
                    'module.comment.per_page',
                    'module.comment.bad',
                    'module.comment.max_tree',
                    'module.comment.use_nested',
                    'module.comment.nested_per_page',
                    'module.comment.nested_page_reverse',
                ),
            ),
            array(
                'name'         => 'Права доступов комментариев',
                'allowed_keys' => array(
                    'acl.create.comment.rating',
                    'acl.create.comment.limit_time',
                    'acl.create.comment.limit_time_rating',
                    'acl.vote.comment.rating',
                    'acl.vote.comment.limit_time',
                ),
            ),
        ),
        'user'   => array(
            array(
                'name'         => 'Пользователи',
                'allowed_keys' => array(
                    'module.user.per_page',
                    'module.user.friend_on_profile',
                    'module.user.friend_notice.delete',
                    'module.user.friend_notice.accept',
                    'module.user.friend_notice.reject',
                    'module.user.login.min_size',
                    'module.user.login.max_size',
                    'module.user.login.charset',
                    'module.user.time_active',
                    'module.user.usernote_text_max',
                    'module.user.usernote_per_page',
                    'module.user.userfield_max_identical',
                    'module.user.profile_photo_size',
                    'module.user.name_max',
                ),
            ),
            array(
                'name'         => 'Жалобы на пользователя',
                'allowed_keys' => array(
                    'module.user.complaint_captcha',
                    'module.user.complaint_notify_by_mail',
                    'module.user.complaint_text_required',
                    'module.user.complaint_text_max',
                    'module.user.complaint_type',
                ),
            ),
            array(
                'name'         => 'Личные сообщения',
                'allowed_keys' => array(
                    'module.talk.per_page',
                    'module.talk.encrypt',
                    'module.talk.max_users',
                ),
            ),
            array(
                'name'         => 'Стена, активность и персональная лента',
                'allowed_keys' => array(
                    'module.wall.count_last_reply',
                    'module.wall.per_page',
                    'module.wall.text_max',
                    'module.wall.text_min',
                    'module.stream.count_default',
                    'module.stream.disable_vote_events',
                    'module.userfeed.count_default',
                ),
            ),
            array(
                'name'         => 'Права доступов',
                'allowed_keys' => array(
                    'acl.create.talk.limit_time',
                    'acl.create.talk.limit_time_rating',
                    'acl.create.talk_comment.limit_time',
                    'acl.create.talk_comment.limit_time_rating',
                    'acl.create.wall.limit_time',
                    'acl.create.wall.limit_time_rating',
                ),
            ),
        ),
        'system' => array(
            array(
                'name'         => 'Шаблонизатор',
                'allowed_keys' => array(
                    'view.skin',
                    'smarty.compile_check',
                    'smarty.force_compile',
                ),
            ),
            array(
                'name'         => 'Настройка Cookie',
                'allowed_keys' => array(
                    'sys.cookie.path',
                ),
            ),
            array(
                'name'         => 'Почта',
                'allowed_keys' => array(
                    'sys.mail.type',
                    'sys.mail.from_email',
                    'sys.mail.from_name',
                    'sys.mail.charset',
                    'sys.mail.smtp.*',
                    'module.notify.delayed',
                    'module.notify.insert_single',
                    'module.notify.per_process',
                ),
            ),
            array(
                'name'         => 'Сжатие CSS, JS',
                'allowed_keys' => array(
                    'module.asset.css.merge',
                    'module.asset.css.compress',
                    'module.asset.js.merge',
                    'module.asset.js.compress',
                ),
            ),
            array(
                'name'         => 'Отправка данных LS',
                'allowed_keys' => array(
                    'module.ls.send_general',
                    'module.ls.use_counter',
                ),
            ),
        ),

    ),
    /*
     * --- Список ключей конфига, значения которых разрешаем хранить в админке в любом случае - есть для них визуальный интерфейс или нет
     */
    '$config_allowed_keys$' => array(
        'view.skin', 'view.theme'
    ),
    /*
     *
     * --- Описание настроек главного конфига LiveStreet CMS ---
     *
     */
    '$config_scheme$' => array(
        'view.skin'                                  => array(
            'type'        => 'string',
            'name'        => 'config_parameters.view.skin.name',
            'description' => 'config_parameters.view.skin.description',
            'validator'   => array(
                'type'   => 'String',
                'params' => array(
                    'min'        => 1,
                    'max'        => 200,
                    'allowEmpty' => false,
                ),
            ),
        ),
        'view.theme'                                  => array(
            'type'        => 'string',
            'name'        => 'config_parameters.view.theme.name',
            'description' => 'config_parameters.view.theme.description',
            'validator'   => array(
                'type'   => 'String',
                'params' => array(
                    'min'        => 1,
                    'max'        => 200,
                    'allowEmpty' => true,
                ),
            ),
        ),
        'view.name'                                  => array(
            'type'        => 'string',
            'name'        => 'config_parameters.view.name.name',
            'description' => 'config_parameters.view.name.description',
            'validator'   => array(
                'type'   => 'String',
                'params' => array(
                    'min'        => 2,
                    'max'        => 200,
                    'allowEmpty' => false,
                ),
            ),
        ),
        'view.description'                           => array(
            'type'        => 'string',
            'name'        => 'config_parameters.view.description.name',
            'description' => 'config_parameters.view.description.description',
            'validator'   => array(
                'type'   => 'String',
                'params' => array(
                    'min'        => 2,
                    'max'        => 1000,
                    'allowEmpty' => false,
                ),
            ),
        ),
        'view.keywords'                              => array(
            'type'        => 'string',
            'name'        => 'config_parameters.view.keywords.name',
            'description' => 'config_parameters.view.keywords.description',
            'validator'   => array(
                'type'   => 'String',
                'params' => array(
                    'min'        => 2,
                    'max'        => 500,
                    'allowEmpty' => false,
                ),
            ),
        ),
        'view.wysiwyg'                               => array(
            'type'        => 'boolean',
            'name'        => 'config_parameters.view.wysiwyg.name',
            'description' => 'config_parameters.view.wysiwyg.description',
            'validator'   => array(
                'type'   => 'Boolean',
                'params' => array(),
            ),
        ),
        'view.noindex'                               => array(
            'type'        => 'boolean',
            'name'        => 'config_parameters.view.noindex.name',
            'description' => 'config_parameters.view.noindex.description',
            'validator'   => array(
                'type'   => 'Boolean',
                'params' => array(),
            ),
        ),
        'view.img_resize_width'                      => array(
            'type'        => 'integer',
            'name'        => 'config_parameters.view.img_resize_width.name',
            'description' => 'config_parameters.view.img_resize_width.description',
            'validator'   => array(
                'type'   => 'Number',
                'params' => array(
                    'min'         => 100,
                    'max'         => 5000,
                    'integerOnly' => true,
                    'allowEmpty'  => false,
                ),
            ),
        ),
        'view.img_max_width'                         => array(
            'type'        => 'integer',
            'name'        => 'config_parameters.view.img_max_width.name',
            'description' => 'config_parameters.view.img_max_width.description',
            'validator'   => array(
                'type'   => 'Number',
                'params' => array(
                    'min'         => 100,
                    'max'         => 5000,
                    'integerOnly' => true,
                    'allowEmpty'  => false,
                ),
            ),
        ),
        'view.img_max_height'                        => array(
            'type'        => 'integer',
            'name'        => 'config_parameters.view.img_max_height.name',
            'description' => 'config_parameters.view.img_max_height.description',
            'validator'   => array(
                'type'   => 'Number',
                'params' => array(
                    'min'         => 100,
                    'max'         => 5000,
                    'integerOnly' => true,
                    'allowEmpty'  => false,
                ),
            ),
        ),
        'view.img_max_size_url'                      => array(
            'type'        => 'integer',
            'name'        => 'config_parameters.view.img_max_size_url.name',
            'description' => 'config_parameters.view.img_max_size_url.description',
            'validator'   => array(
                'type'   => 'Number',
                'params' => array(
                    'min'         => 10,
                    'max'         => 7000,
                    'integerOnly' => true,
                    'allowEmpty'  => false,
                ),
            ),
        ),
        'seo.description_words_count'                => array(
            'type'        => 'integer',
            'name'        => 'config_parameters.seo.description_words_count.name',
            'description' => 'config_parameters.seo.description_words_count.description',
            'validator'   => array(
                'type'   => 'Number',
                'params' => array(
                    'min'         => 5,
                    'max'         => 300,
                    'integerOnly' => true,
                    'allowEmpty'  => false,
                ),
            ),
        ),
        'general.close'                              => array(
            'type'        => 'boolean',
            'name'        => 'config_parameters.general.close.name',
            'description' => 'config_parameters.general.close.description',
            'validator'   => array(
                'type'   => 'Boolean',
                'params' => array(),
            ),
        ),
        'general.reg.invite'                         => array(
            'type'        => 'boolean',
            'name'        => 'config_parameters.general.reg.invite.name',
            'description' => 'config_parameters.general.reg.invite.description',
            'validator'   => array(
                'type'   => 'Boolean',
                'params' => array(),
            ),
        ),
        'general.reg.activation'                     => array(
            'type'        => 'boolean',
            'name'        => 'config_parameters.general.reg.activation.name',
            'description' => 'config_parameters.general.reg.activation.description',
            'validator'   => array(
                'type'   => 'Boolean',
                'params' => array(),
            ),
        ),
        'general.login.captcha'                      => array(
            'type'        => 'boolean',
            'name'        => 'config_parameters.general.login.captcha.name',
            'description' => 'config_parameters.general.login.captcha.description',
            'validator'   => array(
                'type'   => 'Boolean',
                'params' => array(),
            ),
        ),
        'general.admin_mail'                         => array(
            'type'        => 'string',
            'name'        => 'config_parameters.general.admin_mail.name',
            'description' => 'config_parameters.general.admin_mail.description',
            'validator'   => array(
                'type'   => 'Email',
                'params' => array(
                    'allowEmpty' => false,
                ),
            ),
        ),
        'block.stream.row'                           => array(
            'type'        => 'integer',
            'name'        => 'config_parameters.block.stream.row.name',
            'description' => 'config_parameters.block.stream.row.description',
            'validator'   => array(
                'type'   => 'Number',
                'params' => array(
                    'min'         => 3,
                    'max'         => 100,
                    'integerOnly' => true,
                    'allowEmpty'  => false,
                ),
            ),
        ),
        'block.stream.show_tip'                      => array(
            'type'        => 'boolean',
            'name'        => 'config_parameters.block.stream.show_tip.name',
            'description' => 'config_parameters.block.stream.show_tip.description',
            'validator'   => array(
                'type'   => 'Boolean',
                'params' => array(),
            ),
        ),
        'block.blogs.row'                            => array(
            'type'        => 'integer',
            'name'        => 'config_parameters.block.blogs.row.name',
            'description' => 'config_parameters.block.blogs.row.description',
            'validator'   => array(
                'type'   => 'Number',
                'params' => array(
                    'min'         => 3,
                    'max'         => 100,
                    'integerOnly' => true,
                    'allowEmpty'  => false,
                ),
            ),
        ),
        'block.tags.tags_count'                      => array(
            'type'        => 'integer',
            'name'        => 'config_parameters.block.tags.tags_count.name',
            'description' => 'config_parameters.block.tags.tags_count.description',
            'validator'   => array(
                'type'   => 'Number',
                'params' => array(
                    'min'         => 5,
                    'max'         => 500,
                    'integerOnly' => true,
                    'allowEmpty'  => false,
                ),
            ),
        ),
        'block.tags.personal_tags_count'             => array(
            'type'        => 'integer',
            'name'        => 'config_parameters.block.tags.personal_tags_count.name',
            'description' => 'config_parameters.block.tags.personal_tags_count.description',
            'validator'   => array(
                'type'   => 'Number',
                'params' => array(
                    'min'         => 5,
                    'max'         => 500,
                    'integerOnly' => true,
                    'allowEmpty'  => false,
                ),
            ),
        ),
        'pagination.pages.count'                     => array(
            'type'        => 'integer',
            'name'        => 'config_parameters.pagination.pages.count.name',
            'description' => 'config_parameters.pagination.pages.count.description',
            'validator'   => array(
                'type'   => 'Number',
                'params' => array(
                    'min'         => 3,
                    'max'         => 100,
                    'integerOnly' => true,
                    'allowEmpty'  => false,
                ),
            ),
        ),
        'smarty.compile_check'                       => array(
            'type'        => 'boolean',
            'name'        => 'config_parameters.smarty.compile_check.name',
            'description' => 'config_parameters.smarty.compile_check.description',
            'validator'   => array(
                'type'   => 'Boolean',
                'params' => array(),
            ),
        ),
        'smarty.force_compile'                       => array(
            'type'        => 'boolean',
            'name'        => 'config_parameters.smarty.force_compile.name',
            'description' => 'config_parameters.smarty.force_compile.description',
            'validator'   => array(
                'type'   => 'Boolean',
                'params' => array(),
            ),
        ),
        'sys.mail.type'                              => array(
            'type'        => 'string',
            'name'        => 'config_parameters.sys.mail.type.name',
            'description' => 'config_parameters.sys.mail.type.description',
            'validator'   => array(
                'type'   => 'String',
                'params' => array(
                    'min'        => 2,
                    'max'        => 12,
                    'allowEmpty' => false,
                ),
            ),
        ),
        'sys.mail.from_email'                        => array(
            'type'        => 'string',
            'name'        => 'config_parameters.sys.mail.from_email.name',
            'description' => 'config_parameters.sys.mail.from_email.description',
            'validator'   => array(
                'type'   => 'Email',
                'params' => array(
                    'allowEmpty' => false,
                ),
            ),
        ),
        'sys.mail.from_name'                         => array(
            'type'        => 'string',
            'name'        => 'config_parameters.sys.mail.from_name.name',
            'description' => 'config_parameters.sys.mail.from_name.description',
            'validator'   => array(
                'type'   => 'String',
                'params' => array(
                    'min'        => 2,
                    'max'        => 70,
                    'allowEmpty' => false,
                ),
            ),
        ),
        'sys.mail.charset'                           => array(
            'type'        => 'string',
            'name'        => 'config_parameters.sys.mail.charset.name',
            'description' => 'config_parameters.sys.mail.charset.description',
            'validator'   => array(
                'type'   => 'String',
                'params' => array(
                    'min'        => 2,
                    'max'        => 10,
                    'allowEmpty' => false,
                ),
            ),
        ),
        'sys.mail.smtp.host'                         => array(
            'type'        => 'string',
            'name'        => 'config_parameters.sys.mail.smtp.host.name',
            'description' => 'config_parameters.sys.mail.smtp.host.description',
            'validator'   => array(
                'type'   => 'String',
                'params' => array(
                    'min'        => 2,
                    'max'        => 100,
                    'allowEmpty' => false,
                ),
            ),
        ),
        'sys.mail.smtp.port'                         => array(
            'type'        => 'integer',
            'name'        => 'config_parameters.sys.mail.smtp.port.name',
            'description' => 'config_parameters.sys.mail.smtp.port.description',
            'validator'   => array(
                'type'   => 'Number',
                'params' => array(
                    'min'        => 0,
                    'max'        => 65535,
                    'allowEmpty' => false,
                ),
            ),
        ),
        'sys.mail.smtp.user'                         => array(
            'type'        => 'string',
            'name'        => 'config_parameters.sys.mail.smtp.user.name',
            'description' => 'config_parameters.sys.mail.smtp.user.description',
            'validator'   => array(
                'type'   => 'String',
                'params' => array(
                    'min'        => 0,
                    'max'        => 50,
                    'allowEmpty' => true,
                ),
            ),
        ),
        'sys.mail.smtp.password'                     => array(
            'type'        => 'string',
            'name'        => 'config_parameters.sys.mail.smtp.password.name',
            'description' => 'config_parameters.sys.mail.smtp.password.description',
            'validator'   => array(
                'type'   => 'String',
                'params' => array(
                    'min'        => 0,
                    'max'        => 50,
                    'allowEmpty' => true,
                ),
            ),
        ),
        'sys.mail.smtp.secure'                       => array(
            'type'        => 'string',
            'name'        => 'config_parameters.sys.mail.smtp.secure.name',
            'description' => 'config_parameters.sys.mail.smtp.secure.description',
            'validator'   => array(
                'type'   => 'String',
                'params' => array(
                    'min'        => 0,
                    'max'        => 10,
                    'allowEmpty' => true,
                ),
            ),
        ),
        'sys.mail.smtp.auth'                         => array(
            'type'        => 'boolean',
            'name'        => 'config_parameters.sys.mail.smtp.auth.name',
            'description' => 'config_parameters.sys.mail.smtp.auth.description',
            'validator'   => array(
                'type'   => 'Boolean',
                'params' => array(),
            ),
        ),
        'sys.mail.include_comment'                   => array(
            'type'        => 'boolean',
            'name'        => 'config_parameters.sys.mail.include_comment.name',
            'description' => 'config_parameters.sys.mail.include_comment.description',
            'validator'   => array(
                'type'   => 'Boolean',
                'params' => array(),
            ),
        ),
        'sys.mail.include_talk'                      => array(
            'type'        => 'boolean',
            'name'        => 'config_parameters.sys.mail.include_talk.name',
            'description' => 'config_parameters.sys.mail.include_talk.description',
            'validator'   => array(
                'type'   => 'Boolean',
                'params' => array(),
            ),
        ),
        // ?
        'sys.cache.use'                              => array(
            'type'        => 'boolean',
            'name'        => 'config_parameters.sys.cache.use.name',
            'description' => 'config_parameters.sys.cache.use.description',
            'validator'   => array(
                'type'   => 'Boolean',
                'params' => array(),
            ),
        ),
        'sys.cache.type'                             => array(
            'type'        => 'string',
            'name'        => 'config_parameters.sys.cache.type.name',
            'description' => 'config_parameters.sys.cache.type.description',
            'validator'   => array(
                'type'   => 'Enum',
                'params' => array(
                    'enum'       => array(
                        'file',
                        'xcache',
                        'memory',
                    ),
                    'allowEmpty' => false,
                ),
            ),
        ),
        'sys.cache.dir'                              => array(
            'type'        => 'string',
            'name'        => 'config_parameters.sys.cache.dir.name',
            'description' => 'config_parameters.sys.cache.dir.description',
            'validator'   => array(
                'type'   => 'String',
                'params' => array(),
            ),
        ),
        'sys.cache.prefix'                           => array(
            'type'        => 'string',
            'name'        => 'config_parameters.sys.cache.prefix.name',
            'description' => 'config_parameters.sys.cache.prefix.description',
            'validator'   => array(
                'type'   => 'String',
                'params' => array(),
            ),
        ),
        'sys.cache.directory_level'                  => array(
            'type'        => 'integer',
            'name'        => 'config_parameters.sys.cache.directory_level.name',
            'description' => 'config_parameters.sys.cache.directory_level.description',
            'validator'   => array(
                'type'   => 'Number',
                'params' => array(),
            ),
        ),
        'sys.cache.solid'                            => array(
            'type'        => 'boolean',
            'name'        => 'config_parameters.sys.cache.solid.name',
            'description' => 'config_parameters.sys.cache.solid.description',
            'validator'   => array(
                'type'   => 'Boolean',
                'params' => array(),
            ),
        ),
        'sys.logs.file'                              => array(
            'type'        => 'string',
            'name'        => 'config_parameters.sys.logs.file.name',
            'description' => 'config_parameters.sys.logs.file.description',
            'validator'   => array(
                'type'   => 'String',
                'params' => array(),
            ),
        ),
        'sys.logs.sql_query'                         => array(
            'type'        => 'boolean',
            'name'        => 'config_parameters.sys.logs.sql_query.name',
            'description' => 'config_parameters.sys.logs.sql_query.description',
            'validator'   => array(
                'type'   => 'Boolean',
                'params' => array(),
            ),
        ),
        'sys.logs.sql_query_file'                    => array(
            'type'        => 'string',
            'name'        => 'config_parameters.sys.logs.sql_query_file.name',
            'description' => 'config_parameters.sys.logs.sql_query_file.description',
            'validator'   => array(
                'type'   => 'String',
                'params' => array(),
            ),
        ),
        'sys.logs.sql_error'                         => array(
            'type'        => 'boolean',
            'name'        => 'config_parameters.sys.logs.sql_error.name',
            'description' => 'config_parameters.sys.logs.sql_error.description',
            'validator'   => array(
                'type'   => 'Boolean',
                'params' => array(),
            ),
        ),
        'sys.logs.sql_error_file'                    => array(
            'type'        => 'string',
            'name'        => 'config_parameters.sys.logs.sql_error_file.name',
            'description' => 'config_parameters.sys.logs.sql_error_file.description',
            'validator'   => array(
                'type'   => 'String',
                'params' => array(),
            ),
        ),
        'sys.logs.cron'                              => array(
            'type'        => 'boolean',
            'name'        => 'config_parameters.sys.logs.cron.name',
            'description' => 'config_parameters.sys.logs.cron.description',
            'validator'   => array(
                'type'   => 'Boolean',
                'params' => array(),
            ),
        ),
        'sys.logs.console'                           => array(
            'type'        => 'boolean',
            'name'        => 'config_parameters.sys.logs.console.name',
            'description' => 'config_parameters.sys.logs.console.description',
            'validator'   => array(
                'type'   => 'Boolean',
                'params' => array(),
            ),
        ),
        'sys.cookie.path'                            => array(
            'type'        => 'string',
            'name'        => 'config_parameters.sys.cookie.path.name',
            'description' => 'config_parameters.sys.cookie.path.description',
            'validator'   => array(
                'type'   => 'String',
                'params' => array(
                    'min'        => 1,
                    'allowEmpty' => false,
                ),
            ),
        ),
        'lang.current'                               => array(
            'type'        => 'string',
            'name'        => 'config_parameters.lang.current.name',
            'description' => 'config_parameters.lang.current.description',
            'validator'   => array(
                'type'   => 'String',
                'params' => array(),
            ),
        ),
        'lang.default'                               => array(
            'type'        => 'string',
            'name'        => 'config_parameters.lang.default.name',
            'description' => 'config_parameters.lang.default.description',
            'validator'   => array(
                'type'   => 'String',
                'params' => array(),
            ),
        ),
        'acl.create.blog.rating'                     => array(
            'type'        => 'integer',
            'name'        => 'config_parameters.acl.create.blog.rating.name',
            'description' => 'config_parameters.acl.create.blog.rating.description',
            'validator'   => array(
                'type'   => 'Number',
                'params' => array(
                    'integerOnly' => true,
                    'allowEmpty'  => false,
                ),
            ),
        ),
        'acl.create.comment.rating'                  => array(
            'type'        => 'integer',
            'name'        => 'config_parameters.acl.create.comment.rating.name',
            'description' => 'config_parameters.acl.create.comment.rating.description',
            'validator'   => array(
                'type'   => 'Number',
                'params' => array(
                    'integerOnly' => true,
                    'allowEmpty'  => false,
                ),
            ),
        ),
        'acl.create.comment.limit_time'              => array(
            'type'        => 'integer',
            'name'        => 'config_parameters.acl.create.comment.limit_time.name',
            'description' => 'config_parameters.acl.create.comment.limit_time.description',
            'validator'   => array(
                'type'   => 'Number',
                'params' => array(
                    'min'         => 0,
                    'max'         => 60 * 60 * 24,
                    'integerOnly' => true,
                    'allowEmpty'  => false,
                ),
            ),
        ),
        'acl.create.comment.limit_time_rating'       => array(
            'type'        => 'integer',
            'name'        => 'config_parameters.acl.create.comment.limit_time_rating.name',
            'description' => 'config_parameters.acl.create.comment.limit_time_rating.description',
            'validator'   => array(
                'type'   => 'Number',
                'params' => array(
                    'integerOnly' => true,
                    'allowEmpty'  => false,
                ),
            ),
        ),
        'acl.create.topic.limit_time'                => array(
            'type'        => 'integer',
            'name'        => 'config_parameters.acl.create.topic.limit_time.name',
            'description' => 'config_parameters.acl.create.topic.limit_time.description',
            'validator'   => array(
                'type'   => 'Number',
                'params' => array(
                    'min'         => 0,
                    'max'         => 60 * 60 * 24,
                    'integerOnly' => true,
                    'allowEmpty'  => false,
                ),
            ),
        ),
        'acl.create.topic.limit_time_rating'         => array(
            'type'        => 'integer',
            'name'        => 'config_parameters.acl.create.topic.limit_time_rating.name',
            'description' => 'config_parameters.acl.create.topic.limit_time_rating.description',
            'validator'   => array(
                'type'   => 'Number',
                'params' => array(
                    'integerOnly' => true,
                    'allowEmpty'  => false,
                ),
            ),
        ),
        'acl.create.topic.limit_rating'              => array(
            'type'        => 'integer',
            'name'        => 'config_parameters.acl.create.topic.limit_rating.name',
            'description' => 'config_parameters.acl.create.topic.limit_rating.description',
            'validator'   => array(
                'type'   => 'Number',
                'params' => array(
                    'integerOnly' => true,
                    'allowEmpty'  => false,
                ),
            ),
        ),
        'acl.create.talk.limit_time'                 => array(
            'type'        => 'integer',
            'name'        => 'config_parameters.acl.create.talk.limit_time.name',
            'description' => 'config_parameters.acl.create.talk.limit_time.description',
            'validator'   => array(
                'type'   => 'Number',
                'params' => array(
                    'min'         => 0,
                    'max'         => 60 * 60 * 24,
                    'integerOnly' => true,
                    'allowEmpty'  => false,
                ),
            ),
        ),
        'acl.create.talk.limit_time_rating'          => array(
            'type'        => 'integer',
            'name'        => 'config_parameters.acl.create.talk.limit_time_rating.name',
            'description' => 'config_parameters.acl.create.talk.limit_time_rating.description',
            'validator'   => array(
                'type'   => 'Number',
                'params' => array(
                    'integerOnly' => true,
                    'allowEmpty'  => false,
                ),
            ),
        ),
        'acl.create.talk_comment.limit_time'         => array(
            'type'        => 'integer',
            'name'        => 'config_parameters.acl.create.talk_comment.limit_time.name',
            'description' => 'config_parameters.acl.create.talk_comment.limit_time.description',
            'validator'   => array(
                'type'   => 'Number',
                'params' => array(
                    'min'         => 0,
                    'max'         => 60 * 60 * 24,
                    'integerOnly' => true,
                    'allowEmpty'  => false,
                ),
            ),
        ),
        'acl.create.talk_comment.limit_time_rating'  => array(
            'type'        => 'integer',
            'name'        => 'config_parameters.acl.create.talk_comment.limit_time_rating.name',
            'description' => 'config_parameters.acl.create.talk_comment.limit_time_rating.description',
            'validator'   => array(
                'type'   => 'Number',
                'params' => array(
                    'integerOnly' => true,
                    'allowEmpty'  => false,
                ),
            ),
        ),
        'acl.create.wall.limit_time'                 => array(
            'type'        => 'integer',
            'name'        => 'config_parameters.acl.create.wall.limit_time.name',
            'description' => 'config_parameters.acl.create.wall.limit_time.description',
            'validator'   => array(
                'type'   => 'Number',
                'params' => array(
                    'min'         => 0,
                    'max'         => 60 * 60 * 24,
                    'integerOnly' => true,
                    'allowEmpty'  => false,
                ),
            ),
        ),
        'acl.create.wall.limit_time_rating'          => array(
            'type'        => 'integer',
            'name'        => 'config_parameters.acl.create.wall.limit_time_rating.name',
            'description' => 'config_parameters.acl.create.wall.limit_time_rating.description',
            'validator'   => array(
                'type'   => 'Number',
                'params' => array(
                    'integerOnly' => true,
                    'allowEmpty'  => false,
                ),
            ),
        ),
        'acl.vote.comment.rating'                    => array(
            'type'        => 'integer',
            'name'        => 'config_parameters.acl.vote.comment.rating.name',
            'description' => 'config_parameters.acl.vote.comment.rating.description',
            'validator'   => array(
                'type'   => 'Number',
                'params' => array(
                    'integerOnly' => true,
                    'allowEmpty'  => false,
                ),
            ),
        ),
        'acl.vote.topic.rating'                      => array(
            'type'        => 'integer',
            'name'        => 'config_parameters.acl.vote.topic.rating.name',
            'description' => 'config_parameters.acl.vote.topic.rating.description',
            'validator'   => array(
                'type'   => 'Number',
                'params' => array(
                    'integerOnly' => true,
                    'allowEmpty'  => false,
                ),
            ),
        ),
        'acl.vote.topic.limit_time'                  => array(
            'type'        => 'integer',
            'name'        => 'config_parameters.acl.vote.topic.limit_time.name',
            'description' => 'config_parameters.acl.vote.topic.limit_time.description',
            'validator'   => array(
                'type'   => 'Number',
                'params' => array(
                    'min'         => 0,
                    'max'         => 60 * 60 * 24 * 100,
                    'integerOnly' => true,
                    'allowEmpty'  => false,
                ),
            ),
        ),
        'acl.vote.comment.limit_time'                => array(
            'type'        => 'integer',
            'name'        => 'config_parameters.acl.vote.comment.limit_time.name',
            'description' => 'config_parameters.acl.vote.comment.limit_time.description',
            'validator'   => array(
                'type'   => 'Number',
                'params' => array(
                    'min'         => 0,
                    'max'         => 60 * 60 * 24 * 100,
                    'integerOnly' => true,
                    'allowEmpty'  => false,
                ),
            ),
        ),
        'module.blog.per_page'                       => array(
            'type'        => 'integer',
            'name'        => 'config_parameters.module.blog.per_page.name',
            'description' => 'config_parameters.module.blog.per_page.description',
            'validator'   => array(
                'type'   => 'Number',
                'params' => array(
                    'min'         => 5,
                    'max'         => 100,
                    'integerOnly' => true,
                    'allowEmpty'  => false,
                ),
            ),
        ),
        'module.blog.users_per_page'                 => array(
            'type'        => 'integer',
            'name'        => 'config_parameters.module.blog.users_per_page.name',
            'description' => 'config_parameters.module.blog.users_per_page.description',
            'validator'   => array(
                'type'   => 'Number',
                'params' => array(
                    'min'         => 5,
                    'max'         => 100,
                    'integerOnly' => true,
                    'allowEmpty'  => false,
                ),
            ),
        ),
        'module.blog.personal_good'                  => array(
            'type'        => 'integer',
            'name'        => 'config_parameters.module.blog.personal_good.name',
            'description' => 'config_parameters.module.blog.personal_good.description',
            'validator'   => array(
                'type'   => 'Number',
                'params' => array(
                    'integerOnly' => true,
                    'allowEmpty'  => false,
                ),
            ),
        ),
        'module.blog.collective_good'                => array(
            'type'        => 'integer',
            'name'        => 'config_parameters.module.blog.collective_good.name',
            'description' => 'config_parameters.module.blog.collective_good.description',
            'validator'   => array(
                'type'   => 'Number',
                'params' => array(
                    'integerOnly' => true,
                    'allowEmpty'  => false,
                ),
            ),
        ),
        'module.blog.index_good'                     => array(
            'type'        => 'integer',
            'name'        => 'config_parameters.module.blog.index_good.name',
            'description' => 'config_parameters.module.blog.index_good.description',
            'validator'   => array(
                'type'   => 'Number',
                'params' => array(
                    'integerOnly' => true,
                    'allowEmpty'  => false,
                ),
            ),
        ),
        'module.blog.encrypt'                        => array(
            'type'        => 'string',
            'name'        => 'config_parameters.module.blog.encrypt.name',
            'description' => 'config_parameters.module.blog.encrypt.description',
            'validator'   => array(
                'type'   => 'String',
                'params' => array(
                    'min'        => 5,
                    'max'        => 100,
                    'allowEmpty' => false,
                ),
            ),
        ),
        'module.blog.avatar_size'                    => array(
            'type'        => 'array',
            'name'        => 'config_parameters.module.blog.avatar_size.name',
            'description' => 'config_parameters.module.blog.avatar_size.description',
            'validator'   => array(
                'type'   => 'Array',
                'params' => array(
                    'min_items'      => 1,
                    'max_items'      => 20,
                    'item_validator' => array(
                        'type'   => 'Number',
                        'params' => array(
                            'min'         => 0,
                            'max'         => 500,
                            'integerOnly' => true,
                            'allowEmpty'  => false,
                        ),
                    ),
                    'allowEmpty'     => false,
                ),
            ),
        ),
        'module.blog.category_allow'                 => array(
            'type'        => 'boolean',
            'name'        => 'config_parameters.module.blog.category_allow.name',
            'description' => 'config_parameters.module.blog.category_allow.description',
            'validator'   => array(
                'type'   => 'Boolean',
                'params' => array(),
            ),
        ),
        'module.blog.category_only_admin'            => array(
            'type'        => 'boolean',
            'name'        => 'config_parameters.module.blog.category_only_admin.name',
            'description' => 'config_parameters.module.blog.category_only_admin.description',
            'validator'   => array(
                'type'   => 'Boolean',
                'params' => array(),
            ),
        ),
        'module.blog.category_only_without_children' => array(
            'type'        => 'boolean',
            'name'        => 'config_parameters.module.blog.category_only_without_children.name',
            'description' => 'config_parameters.module.blog.category_only_without_children.description',
            'validator'   => array(
                'type'   => 'Boolean',
                'params' => array(),
            ),
        ),
        'module.blog.category_allow_empty'           => array(
            'type'        => 'boolean',
            'name'        => 'config_parameters.module.blog.category_allow_empty.name',
            'description' => 'config_parameters.module.blog.category_allow_empty.description',
            'validator'   => array(
                'type'   => 'Boolean',
                'params' => array(),
            ),
        ),
        'module.topic.new_time'                      => array(
            'type'        => 'integer',
            'name'        => 'config_parameters.module.topic.new_time.name',
            'description' => 'config_parameters.module.topic.new_time.description',
            'validator'   => array(
                'type'   => 'Number',
                'params' => array(),
            ),
        ),
        'module.topic.per_page'                      => array(
            'type'        => 'integer',
            'name'        => 'config_parameters.module.topic.per_page.name',
            'description' => 'config_parameters.module.topic.per_page.description',
            'validator'   => array(
                'type'   => 'Number',
                'params' => array(),
            ),
        ),
        'module.topic.max_length'                    => array(
            'type'        => 'integer',
            'name'        => 'config_parameters.module.topic.max_length.name',
            'description' => 'config_parameters.module.topic.max_length.description',
            'validator'   => array(
                'type'   => 'Number',
                'params' => array(),
            ),
        ),
        'module.topic.min_length'                    => array(
            'type'        => 'integer',
            'name'        => 'config_parameters.module.topic.min_length.name',
            'description' => 'config_parameters.module.topic.min_length.description',
            'validator'   => array(
                'type'   => 'Number',
                'params' => array(),
            ),
        ),
        'module.topic.allow_empty'                   => array(
            'type'        => 'boolean',
            'name'        => 'config_parameters.module.topic.allow_empty.name',
            'description' => 'config_parameters.module.topic.allow_empty.description',
            'validator'   => array(
                'type'   => 'Boolean',
                'params' => array(),
            ),
        ),
        'module.topic.title_max_length'              => array(
            'type'        => 'integer',
            'name'        => 'config_parameters.module.topic.title_max_length.name',
            'description' => 'config_parameters.module.topic.title_max_length.description',
            'validator'   => array(
                'type'   => 'Number',
                'params' => array(),
            ),
        ),
        'module.topic.title_min_length'              => array(
            'type'        => 'integer',
            'name'        => 'config_parameters.module.topic.title_min_length.name',
            'description' => 'config_parameters.module.topic.title_min_length.description',
            'validator'   => array(
                'type'   => 'Number',
                'params' => array(),
            ),
        ),
        'module.topic.title_allow_empty'             => array(
            'type'        => 'boolean',
            'name'        => 'config_parameters.module.topic.title_allow_empty.name',
            'description' => 'config_parameters.module.topic.title_allow_empty.description',
            'validator'   => array(
                'type'   => 'Boolean',
                'params' => array(),
            ),
        ),
        'module.topic.tags_allow_empty'              => array(
            'type'        => 'boolean',
            'name'        => 'config_parameters.module.topic.tags_allow_empty.name',
            'description' => 'config_parameters.module.topic.tags_allow_empty.description',
            'validator'   => array(
                'type'   => 'Boolean',
                'params' => array(),
            ),
        ),
        'module.topic.tags_count_max'              => array(
            'type'        => 'integer',
            'name'        => 'config_parameters.module.topic.tags_count_max.name',
            'description' => 'config_parameters.module.topic.tags_count_max.description',
            'validator'   => array(
                'type'   => 'Number',
                'params' => array(),
            ),
        ),
        'module.topic.tags_count_min'              => array(
            'type'        => 'integer',
            'name'        => 'config_parameters.module.topic.tags_count_min.name',
            'description' => 'config_parameters.module.topic.tags_count_min.description',
            'validator'   => array(
                'type'   => 'Number',
                'params' => array(),
            ),
        ),
        'module.topic.url'                        => array(
            'type'        => 'string',
            'name'        => 'config_parameters.module.topic.url.name',
            'description' => 'config_parameters.module.topic.url.description',
            'validator'   => array(
                'type'   => 'String',
                'params' => array(
                    'allowEmpty' => false,
                ),
            ),
        ),
        'module.user.per_page'                       => array(
            'type'        => 'integer',
            'name'        => 'config_parameters.module.user.per_page.name',
            'description' => 'config_parameters.module.user.per_page.description',
            'validator'   => array(
                'type'   => 'Number',
                'params' => array(),
            ),
        ),
        'module.user.friend_on_profile'              => array(
            'type'        => 'integer',
            'name'        => 'config_parameters.module.user.friend_on_profile.name',
            'description' => 'config_parameters.module.user.friend_on_profile.description',
            'validator'   => array(
                'type'   => 'Number',
                'params' => array(),
            ),
        ),
        'module.user.friend_notice.delete'           => array(
            'type'        => 'boolean',
            'name'        => 'config_parameters.module.user.friend_notice.delete.name',
            'description' => 'config_parameters.module.user.friend_notice.delete.description',
            'validator'   => array(
                'type'   => 'Boolean',
                'params' => array(),
            ),
        ),
        'module.user.friend_notice.accept'           => array(
            'type'        => 'boolean',
            'name'        => 'config_parameters.module.user.friend_notice.accept.name',
            'description' => 'config_parameters.module.user.friend_notice.accept.description',
            'validator'   => array(
                'type'   => 'Boolean',
                'params' => array(),
            ),
        ),
        'module.user.friend_notice.reject'           => array(
            'type'        => 'boolean',
            'name'        => 'config_parameters.module.user.friend_notice.reject.name',
            'description' => 'config_parameters.module.user.friend_notice.reject.description',
            'validator'   => array(
                'type'   => 'Boolean',
                'params' => array(),
            ),
        ),
        'module.user.avatar_size'                    => array(
            'type'        => 'array',
            'name'        => 'config_parameters.module.user.avatar_size.name',
            'description' => 'config_parameters.module.user.avatar_size.description',
            'validator'   => array(
                'type'   => 'Array',
                'params' => array(),
            ),
        ),
        'module.user.login.min_size'                 => array(
            'type'        => 'integer',
            'name'        => 'config_parameters.module.user.login.min_size.name',
            'description' => 'config_parameters.module.user.login.min_size.description',
            'validator'   => array(
                'type'   => 'Number',
                'params' => array(),
            ),
        ),
        'module.user.login.max_size'                 => array(
            'type'        => 'integer',
            'name'        => 'config_parameters.module.user.login.max_size.name',
            'description' => 'config_parameters.module.user.login.max_size.description',
            'validator'   => array(
                'type'   => 'Number',
                'params' => array(),
            ),
        ),
        'module.user.login.charset'                  => array(
            'type'        => 'string',
            'name'        => 'config_parameters.module.user.login.charset.name',
            'description' => 'config_parameters.module.user.login.charset.description',
            'validator'   => array(
                'type'   => 'String',
                'params' => array(),
            ),
        ),
        'module.user.time_active'                    => array(
            'type'        => 'integer',
            'name'        => 'config_parameters.module.user.time_active.name',
            'description' => 'config_parameters.module.user.time_active.description',
            'validator'   => array(
                'type'   => 'Number',
                'params' => array(),
            ),
        ),
        'module.user.usernote_text_max'              => array(
            'type'        => 'integer',
            'name'        => 'config_parameters.module.user.usernote_text_max.name',
            'description' => 'config_parameters.module.user.usernote_text_max.description',
            'validator'   => array(
                'type'   => 'Number',
                'params' => array(),
            ),
        ),
        'module.user.usernote_per_page'              => array(
            'type'        => 'integer',
            'name'        => 'config_parameters.module.user.usernote_per_page.name',
            'description' => 'config_parameters.module.user.usernote_per_page.description',
            'validator'   => array(
                'type'   => 'Number',
                'params' => array(),
            ),
        ),
        'module.user.userfield_max_identical'        => array(
            'type'        => 'integer',
            'name'        => 'config_parameters.module.user.userfield_max_identical.name',
            'description' => 'config_parameters.module.user.userfield_max_identical.description',
            'validator'   => array(
                'type'   => 'Number',
                'params' => array(),
            ),
        ),
        'module.user.profile_photo_size'             => array(
            'type'        => 'integer',
            'name'        => 'config_parameters.module.user.profile_photo_size.name',
            'description' => 'config_parameters.module.user.profile_photo_size.description',
            'validator'   => array(
                'type'   => 'String',
                'params' => array(),
            ),
        ),
        'module.user.name_max'                       => array(
            'type'        => 'integer',
            'name'        => 'config_parameters.module.user.name_max.name',
            'description' => 'config_parameters.module.user.name_max.description',
            'validator'   => array(
                'type'   => 'Number',
                'params' => array(),
            ),
        ),
        'module.user.captcha_use_registration'       => array(
            'type'        => 'boolean',
            'name'        => 'config_parameters.module.user.captcha_use_registration.name',
            'description' => 'config_parameters.module.user.captcha_use_registration.description',
            'validator'   => array(
                'type'   => 'Boolean',
                'params' => array(),
            ),
        ),
        'module.user.complaint_captcha'              => array(
            'type'        => 'boolean',
            'name'        => 'config_parameters.module.user.complaint_captcha.name',
            'description' => 'config_parameters.module.user.complaint_captcha.description',
            'validator'   => array(
                'type'   => 'Boolean',
                'params' => array(),
            ),
        ),
        'module.user.complaint_notify_by_mail'       => array(
            'type'        => 'boolean',
            'name'        => 'config_parameters.module.user.complaint_notify_by_mail.name',
            'description' => 'config_parameters.module.user.complaint_notify_by_mail.description',
            'validator'   => array(
                'type'   => 'Boolean',
                'params' => array(),
            ),
        ),
        'module.user.complaint_text_required'        => array(
            'type'        => 'boolean',
            'name'        => 'config_parameters.module.user.complaint_text_required.name',
            'description' => 'config_parameters.module.user.complaint_text_required.description',
            'validator'   => array(
                'type'   => 'Boolean',
                'params' => array(),
            ),
        ),
        'module.user.complaint_text_max'             => array(
            'type'        => 'integer',
            'name'        => 'config_parameters.module.user.complaint_text_max.name',
            'description' => 'config_parameters.module.user.complaint_text_max.description',
            'validator'   => array(
                'type'   => 'Number',
                'params' => array(
                    'integerOnly' => true,
                    'allowEmpty'  => false,
                ),
            ),
        ),
        'module.user.complaint_type'                 => array(
            'type'        => 'array',
            'name'        => 'config_parameters.module.user.complaint_type.name',
            'description' => 'config_parameters.module.user.complaint_type.description',
            'validator'   => array(
                'type'   => 'Array',
                'params' => array(
                    'min_items'      => 2,
                    'allowEmpty'     => false,
                    'item_validator' => array(
                        'type'   => 'String',
                        'params' => array(
                            'min'        => 1,
                            'max'        => 100,
                            'allowEmpty' => false,
                        ),
                    ),
                ),
            ),
        ),
        'module.comment.per_page'                    => array(
            'type'        => 'integer',
            'name'        => 'config_parameters.module.comment.per_page.name',
            'description' => 'config_parameters.module.comment.per_page.description',
            'validator'   => array(
                'type'   => 'Number',
                'params' => array(),
            ),
        ),
        'module.comment.bad'                         => array(
            'type'        => 'integer',
            'name'        => 'config_parameters.module.comment.bad.name',
            'description' => 'config_parameters.module.comment.bad.description',
            'validator'   => array(
                'type'   => 'Number',
                'params' => array(),
            ),
        ),
        'module.comment.max_tree'                    => array(
            'type'        => 'integer',
            'name'        => 'config_parameters.module.comment.max_tree.name',
            'description' => 'config_parameters.module.comment.max_tree.description',
            'validator'   => array(
                'type'   => 'Number',
                'params' => array(),
            ),
        ),
        'module.comment.use_nested'                  => array(
            'type'        => 'boolean',
            'name'        => 'config_parameters.module.comment.use_nested.name',
            'description' => 'config_parameters.module.comment.use_nested.description',
            'validator'   => array(
                'type'   => 'Boolean',
                'params' => array(),
            ),
        ),
        'module.comment.nested_per_page'             => array(
            'type'        => 'integer',
            'name'        => 'config_parameters.module.comment.nested_per_page.name',
            'description' => 'config_parameters.module.comment.nested_per_page.description',
            'validator'   => array(
                'type'   => 'Number',
                'params' => array(),
            ),
        ),
        'module.comment.nested_page_reverse'         => array(
            'type'        => 'boolean',
            'name'        => 'config_parameters.module.comment.nested_page_reverse.name',
            'description' => 'config_parameters.module.comment.nested_page_reverse.description',
            'validator'   => array(
                'type'   => 'Boolean',
                'params' => array(),
            ),
        ),
        'module.comment.favourite_target_allow'      => array(
            'type'        => 'array',
            'name'        => 'config_parameters.module.comment.favourite_target_allow.name',
            'description' => 'config_parameters.module.comment.favourite_target_allow.description',
            'validator'   => array(
                'type'   => 'Array',
                'params' => array(),
            ),
        ),
        'module.talk.per_page'                       => array(
            'type'        => 'integer',
            'name'        => 'config_parameters.module.talk.per_page.name',
            'description' => 'config_parameters.module.talk.per_page.description',
            'validator'   => array(
                'type'   => 'Number',
                'params' => array(),
            ),
        ),
        'module.talk.encrypt'                        => array(
            'type'        => 'string',
            'name'        => 'config_parameters.module.talk.encrypt.name',
            'description' => 'config_parameters.module.talk.encrypt.description',
            'validator'   => array(
                'type'   => 'String',
                'params' => array(),
            ),
        ),
        'module.talk.max_users'                      => array(
            'type'        => 'integer',
            'name'        => 'config_parameters.module.talk.max_users.name',
            'description' => 'config_parameters.module.talk.max_users.description',
            'validator'   => array(
                'type'   => 'Number',
                'params' => array(),
            ),
        ),
        'module.lang.delete_undefined'               => array(
            'type'        => 'boolean',
            'name'        => 'config_parameters.module.lang.delete_undefined.name',
            'description' => 'config_parameters.module.lang.delete_undefined.description',
            'validator'   => array(
                'type'   => 'Boolean',
                'params' => array(),
            ),
        ),
        'module.notify.delayed'                      => array(
            'type'        => 'boolean',
            'name'        => 'config_parameters.module.notify.delayed.name',
            'description' => 'config_parameters.module.notify.delayed.description',
            'validator'   => array(
                'type'   => 'Boolean',
                'params' => array(),
            ),
        ),
        'module.notify.insert_single'                => array(
            'type'        => 'boolean',
            'name'        => 'config_parameters.module.notify.insert_single.name',
            'description' => 'config_parameters.module.notify.insert_single.description',
            'validator'   => array(
                'type'   => 'Boolean',
                'params' => array(),
            ),
        ),
        'module.notify.per_process'                  => array(
            'type'        => 'integer',
            'name'        => 'config_parameters.module.notify.per_process.name',
            'description' => 'config_parameters.module.notify.per_process.description',
            'validator'   => array(
                'type'   => 'Number',
                'params' => array(),
            ),
        ),
        'module.notify.dir'                          => array(
            'type'        => 'string',
            'name'        => 'config_parameters.module.notify.dir.name',
            'description' => 'config_parameters.module.notify.dir.description',
            'validator'   => array(
                'type'   => 'String',
                'params' => array(),
            ),
        ),
        'module.notify.prefix'                       => array(
            'type'        => 'string',
            'name'        => 'config_parameters.module.notify.prefix.name',
            'description' => 'config_parameters.module.notify.prefix.description',
            'validator'   => array(
                'type'   => 'String',
                'params' => array(),
            ),
        ),
        'module.security.hash'                       => array(
            'type'        => 'string',
            'name'        => 'config_parameters.module.security.hash.name',
            'description' => 'config_parameters.module.security.hash.description',
            'validator'   => array(
                'type'   => 'String',
                'params' => array(),
            ),
        ),
        'module.userfeed.count_default'              => array(
            'type'        => 'integer',
            'name'        => 'config_parameters.module.userfeed.count_default.name',
            'description' => 'config_parameters.module.userfeed.count_default.description',
            'validator'   => array(
                'type'   => 'Number',
                'params' => array(),
            ),
        ),
        'module.stream.count_default'                => array(
            'type'        => 'integer',
            'name'        => 'config_parameters.module.stream.count_default.name',
            'description' => 'config_parameters.module.stream.count_default.description',
            'validator'   => array(
                'type'   => 'Number',
                'params' => array(),
            ),
        ),
        'module.stream.disable_vote_events'          => array(
            'type'        => 'boolean',
            'name'        => 'config_parameters.module.stream.disable_vote_events.name',
            'description' => 'config_parameters.module.stream.disable_vote_events.description',
            'validator'   => array(
                'type'   => 'Boolean',
                'params' => array(),
            ),
        ),
        'module.ls.send_general'                     => array(
            'type'        => 'boolean',
            'name'        => 'config_parameters.module.ls.send_general.name',
            'description' => 'config_parameters.module.ls.send_general.description',
            'validator'   => array(
                'type'   => 'Boolean',
                'params' => array(),
            ),
        ),
        'module.ls.use_counter'                      => array(
            'type'        => 'boolean',
            'name'        => 'config_parameters.module.ls.use_counter.name',
            'description' => 'config_parameters.module.ls.use_counter.description',
            'validator'   => array(
                'type'   => 'Boolean',
                'params' => array(),
            ),
        ),
        'module.wall.count_last_reply'               => array(
            'type'        => 'integer',
            'name'        => 'config_parameters.module.wall.count_last_reply.name',
            'description' => 'config_parameters.module.wall.count_last_reply.description',
            'validator'   => array(
                'type'   => 'Number',
                'params' => array(),
            ),
        ),
        'module.wall.per_page'                       => array(
            'type'        => 'integer',
            'name'        => 'config_parameters.module.wall.per_page.name',
            'description' => 'config_parameters.module.wall.per_page.description',
            'validator'   => array(
                'type'   => 'Number',
                'params' => array(),
            ),
        ),
        'module.wall.text_max'                       => array(
            'type'        => 'integer',
            'name'        => 'config_parameters.module.wall.text_max.name',
            'description' => 'config_parameters.module.wall.text_max.description',
            'validator'   => array(
                'type'   => 'Number',
                'params' => array(),
            ),
        ),
        'module.wall.text_min'                       => array(
            'type'        => 'integer',
            'name'        => 'config_parameters.module.wall.text_min.name',
            'description' => 'config_parameters.module.wall.text_min.description',
            'validator'   => array(
                'type'   => 'Number',
                'params' => array(),
            ),
        ),
        'memcache.compression'                       => array(
            'type'        => 'boolean',
            'name'        => 'config_parameters.memcache.compression.name',
            'description' => 'config_parameters.memcache.compression.description',
            'validator'   => array(
                'type'   => 'Boolean',
                'params' => array(),
            ),
        ),
        /*		'router.rewrite' => array(
                    'type' => 'array',
                    'name' => 'config_parameters.router.rewrite.name',
                    'description' => 'config_parameters.router.rewrite.description',
                    'validator' => array(
                        'type' => 'Array',
                        'params' => array(
                        ),
                    ),
                ),
                'router.uri' => array(
                    'type' => 'array',
                    'name' => 'config_parameters.router.uri.name',
                    'description' => 'config_parameters.router.uri.description',
                    'validator' => array(
                        'type' => 'Array',
                        'params' => array(
                        ),
                    ),
                ),*/
        /*		'router.config.default.action' => array(
                    'type' => 'string',
                    'name' => 'config_parameters.router.config.default.action.name',
                    'description' => 'config_parameters.router.config.default.action.description',
                    'validator' => array(
                        'type' => 'String',
                        'params' => array(
                        ),
                    ),
                ),
                'router.config.action_not_found' => array(
                    'type' => 'string',
                    'name' => 'config_parameters.router.config.action_not_found.name',
                    'description' => 'config_parameters.router.config.action_not_found.description',
                    'validator' => array(
                        'type' => 'String',
                        'params' => array(
                        ),
                    ),
                ),*/
        'module.asset.css.merge'                     => array(
            'type'        => 'boolean',
            'name'        => 'config_parameters.module.asset.css.merge.name',
            'description' => 'config_parameters.module.asset.css.merge.description',
            'validator'   => array(
                'type'   => 'Boolean',
                'params' => array(),
            ),
        ),
        'module.asset.css.compress'                  => array(
            'type'        => 'boolean',
            'name'        => 'config_parameters.module.asset.css.compress.name',
            'description' => 'config_parameters.module.asset.css.compress.description',
            'validator'   => array(
                'type'   => 'Boolean',
                'params' => array(),
            ),
        ),
        'module.asset.js.merge'                      => array(
            'type'        => 'boolean',
            'name'        => 'config_parameters.module.asset.js.merge.name',
            'description' => 'config_parameters.module.asset.js.merge.description',
            'validator'   => array(
                'type'   => 'Boolean',
                'params' => array(),
            ),
        ),
        'module.asset.js.compress'                   => array(
            'type'        => 'boolean',
            'name'        => 'config_parameters.module.asset.js.compress.name',
            'description' => 'config_parameters.module.asset.js.compress.description',
            'validator'   => array(
                'type'   => 'Boolean',
                'params' => array(),
            ),
        ),
    ),
);

?>