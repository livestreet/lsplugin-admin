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
 * Дополнительные текстовки движка, содержащие заголовки разделов групп и описание настроек главного конфига
 *
 */

return array(
    /*
     *
     * --- Заголовки разделов групп настроек ---
     *
     */
    'config_sections'   => array(
        'main'   => array(
            'name'   => 'Основные',
            'groups' => array(),
        ),
        'blog'   => array(
            'name'   => 'Блоги и топики',
            'groups' => array(),
        ),
        'user'   => array(
            'name'   => 'Пользователи',
            'groups' => array(),
        ),
        'system' => array(
            'name'   => 'Системные',
            'groups' => array(),
        ),
    ),
    /*
     *
     * --- Описание каждого параметра конфига для отображения в админке LiveStreet CMS ---
     *
     */
    'config_parameters' => array(
        'view'       => array(
            'skin'             => array(
                'name'        => 'Шаблон',
                'description' => '',
            ),
            'theme'             => array(
                'name'        => 'Тема шаблона',
                'description' => '',
            ),
            'name'             => array(
                'name'        => 'Название сайта',
                'description' => 'Выводится в шапке шаблона, письмах и т.п.',
            ),
            'description'      => array(
                'name'        => 'Описание',
                'description' => 'Мета-тег "description"',
            ),
            'keywords'         => array(
                'name'        => 'Ключевые слова',
                'description' => 'Мета-тег "keywords"',
            ),
            'wysiwyg'          => array(
                'name'        => 'Использовать визуальный редактор TinyMCE',
                'description' => '',
            ),
            'noindex'          => array(
                'name'        => 'Отключить индексирование ссылок в текстах, добавляя атрибут rel="nofollow"',
                'description' => '',
            ),
            'img_resize_width' => array(
                'name'        => 'Ширина изображений',
                'description' => 'До какого размера в пикселях ужимать картинку при загрузке по ширине',
            ),
            'img_max_width'    => array(
                'name'        => 'Максимальная ширина загружаемых изображений в пикселях',
                'description' => 'Иначе будет выведено сообщение об ошибке',
            ),
            'img_max_height'   => array(
                'name'        => 'Максимальная высота загружаемых изображений в пикселях',
                'description' => 'Иначе будет выведено сообщение об ошибке',
            ),
            'img_max_size_url' => array(
                'name'        => 'Максимальный размер картинки в kB для загрузки по ссылке',
                'description' => 'Иначе будет выведено сообщение об ошибке',
            ),
        ),
        'seo'        => array(
            'description_words_count' => array(
                'name'        => 'Количество слов из топика для вывода в метатег description',
                'description' => 'Метатег description будет автоматически заполнен указанным количеством слов из отображаемого топика',
            ),
        ),
        'general'    => array(
            'close'      => array(
                'name'        => 'Использовать закрытый режим работы сайта',
                'description' => 'Сайт будет доступен только авторизованным пользователям',
            ),
            'reg'        => array(
                'invite'     => array(
                    'name'        => 'Использовать режим регистрации по приглашению',
                    'description' => 'Регистрация будет доступна ТОЛЬКО по приглашениям!',
                ),
                'activation' => array(
                    'name'        => 'Использовать активацию при регистрации',
                    'description' => 'На почту, указанную при регистрации будет выслано письмо',
                ),
            ),
            'login'      => array(
                'captcha' => array(
                    'name'        => 'Использовать каптчу при входе',
                    'description' => '',
                ),
            ),
            'admin_mail' => array(
                'name'        => 'Почта администратора',
                'description' => 'На неё будут приходить письма, например, при жалобах на пользователей',
            ),
        ),
        'block'      => array(
            'stream' => array(
                'row'      => array(
                    'name'        => 'Сколько записей выводить в блоке "Прямой эфир"',
                    'description' => '',
                ),
                'show_tip' => array(
                    'name'        => 'Выводить всплывающие сообщения в блоке "Прямой эфир"',
                    'description' => '',
                ),
            ),
            'blogs'  => array(
                'row' => array(
                    'name'        => 'Сколько записей выводить в блоке "Блоги"',
                    'description' => '',
                ),
            ),
            'tags'   => array(
                'tags_count'          => array(
                    'name'        => 'Сколько тегов выводить в блоке "теги"',
                    'description' => '',
                ),
                'personal_tags_count' => array(
                    'name'        => 'Сколько тегов пользователя выводить в блоке "теги"',
                    'description' => '',
                ),
            ),
        ),
        'pagination' => array(
            'pages' => array(
                'count' => array(
                    'name'        => 'Количество ссылок на другие страницы в пагинации',
                    'description' => '',
                ),
            ),
        ),
        'smarty'     => array(
            'compile_check' => array(
                'name'        => 'Проверять файлы шаблона на изменения перед компиляцией',
                'description' => 'Отключение может значительно увеличить быстродействие, но потребует ручного удаления кеша при изменении шаблона',
            ),
            'force_compile' => array(
                'name'        => 'Принудительно компилировать шаблоны при каждом запросе',
                'description' => 'Включение существенно снижает производительность',
            ),
        ),
        'memcache'   => array(
            'compression' => array(
                'name'        => 'Сжатие',
                'description' => '',
            ),
        ),
        'sys'        => array(
            'mail'   => array(
                'type'            => array(
                    'name'        => 'Какой тип отправки использовать',
                    'description' => '',
                ),
                'from_email'      => array(
                    'name'        => 'Мыло с которого отправляются все уведомления',
                    'description' => '',
                ),
                'from_name'       => array(
                    'name'        => 'Имя с которого отправляются все уведомления',
                    'description' => '',
                ),
                'charset'         => array(
                    'name'        => 'Какую кодировку использовать в письмах',
                    'description' => '',
                ),
                'smtp'            => array(
                    'host'     => array(
                        'name'        => 'Настройки SMTP - хост',
                        'description' => '',
                    ),
                    'port'     => array(
                        'name'        => 'Настройки SMTP - порт',
                        'description' => '',
                    ),
                    'user'     => array(
                        'name'        => 'Настройки SMTP - пользователь',
                        'description' => '',
                    ),
                    'password' => array(
                        'name'        => 'Настройки SMTP - пароль',
                        'description' => '',
                    ),
                    'secure'   => array(
                        'name'        => 'Настройки SMTP - протокол шифрования: tls, ssl',
                        'description' => '',
                    ),
                    'auth'     => array(
                        'name'        => 'Использовать авторизацию при отправке',
                        'description' => '',
                    ),
                ),
                'include_comment' => array(
                    'name'        => 'Включает в уведомление о новых комментах текст коммента',
                    'description' => '',
                ),
                'include_talk'    => array(
                    'name'        => 'Включает в уведомление о новых личных сообщениях текст сообщения',
                    'description' => '',
                ),
            ),
            'cache'  => array(
                'use'             => array(
                    'name'        => 'использовать кеширование или нет',
                    'description' => 'Устанавливаем настройки кеширования',
                ),
                'type'            => array(
                    'name'        => 'тип кеширования: file, xcache и memory. memory использует мемкеш, xcache - использует XCache',
                    'description' => '',
                ),
                'dir'             => array(
                    'name'        => 'каталог для файлового кеша, также используется для временных картинок. По умолчанию подставляем каталог для хранения сессий',
                    'description' => '',
                ),
                'prefix'          => array(
                    'name'        => 'префикс кеширования, чтоб можно было на одной машине держать несколько сайтов с общим кешевым хранилищем',
                    'description' => '',
                ),
                'directory_level' => array(
                    'name'        => 'уровень вложенности директорий файлового кеша',
                    'description' => '',
                ),
                'solid'           => array(
                    'name'        => 'Настройка использования раздельного и монолитного кеша для отдельных операций',
                    'description' => '',
                ),
            ),
            'logs'   => array(
                'file'           => array(
                    'name'        => 'файл общего лога',
                    'description' => 'Настройки логирования',
                ),
                'sql_query'      => array(
                    'name'        => 'логировать или нет SQL запросы',
                    'description' => '',
                ),
                'sql_query_file' => array(
                    'name'        => 'файл лога SQL запросов',
                    'description' => '',
                ),
                'sql_error'      => array(
                    'name'        => 'логировать или нет ошибки SQl',
                    'description' => '',
                ),
                'sql_error_file' => array(
                    'name'        => 'файл лога ошибок SQL',
                    'description' => '',
                ),
                'cron'           => array(
                    'name'        => 'логировать или нет cron скрипты',
                    'description' => '',
                ),
                'console'        => array(
                    'name'        => 'позволяет удобно выводить отладочную информацию через консоль браузера',
                    'description' => '',
                ),
            ),
            'cookie' => array(
                'path' => array(
                    'name'        => 'путь для установки куков',
                    'description' => '',
                ),
                'time' => array(
                    'name'        => 'время жизни куки, когда пользователь остается залогиненым на сайте',
                    'description' => '',
                ),
            ),

        ),
        'lang'       => array(
            'current' => array(
                'name'        => 'текущий язык текстовок',
                'description' => 'Языковые настройки',
            ),
            'default' => array(
                'name'        => 'язык, который будет использовать на сайте по умолчанию',
                'description' => '',
            ),
        ),
        'acl'        => array(
            'create' => array(
                'blog'         => array(
                    'rating' => array(
                        'name'        => 'Порог рейтинга при котором юзер может создать коллективный блог',
                        'description' => '',
                    ),
                ),
                'comment'      => array(
                    'rating'            => array(
                        'name'        => 'Порог рейтинга при котором юзер может добавлять комментарии',
                        'description' => '',
                    ),
                    'limit_time'        => array(
                        'name'        => 'Время в секундах между постингом комментариев, если 0 то ограничение по времени не будет работать',
                        'description' => '',
                    ),
                    'limit_time_rating' => array(
                        'name'        => 'Рейтинг, выше которого перестаёт действовать ограничение по времени на постинг комментов. Не имеет смысла если параметр выше равен 0',
                        'description' => '',
                    ),
                ),
                'topic'        => array(
                    'limit_time'        => array(
                        'name'        => 'Время в секундах между созданием записей, если 0 то ограничение по времени не будет работать',
                        'description' => '',
                    ),
                    'limit_time_rating' => array(
                        'name'        => 'Рейтинг, выше которого перестаёт действовать ограничение по времени на создание записей',
                        'description' => '',
                    ),
                    'limit_rating'      => array(
                        'name'        => 'Порог рейтинга при котором юзер может создавать топики (учитываются любые блоги, включая персональные), как дополнительная защита от спама/троллинга',
                        'description' => '',
                    ),
                ),
                'talk'         => array(
                    'limit_time'        => array(
                        'name'        => 'Время в секундах между отправкой инбоксов, если 0 то ограничение по времени не будет работать',
                        'description' => '',
                    ),
                    'limit_time_rating' => array(
                        'name'        => 'Рейтинг, выше которого перестаёт действовать ограничение по времени на отправку инбоксов',
                        'description' => '',
                    ),
                ),
                'talk_comment' => array(
                    'limit_time'        => array(
                        'name'        => 'Время в секундах между отправкой комментариев к инбоксам, если 0 то ограничение по времени не будет работать',
                        'description' => '',
                    ),
                    'limit_time_rating' => array(
                        'name'        => 'Рейтинг, выше которого перестаёт действовать ограничение по времени на отправку комментариев к инбоксам',
                        'description' => '',
                    ),
                ),
                'wall'         => array(
                    'limit_time'        => array(
                        'name'        => 'Рейтинг, выше которого перестаёт действовать ограничение по времени на отправку сообщений на стену',
                        'description' => '',
                    ),
                    'limit_time_rating' => array(
                        'name'        => 'Рейтинг, выше которого перестаёт действовать ограничение по времени на отправку сообщений на стену',
                        'description' => '',
                    ),
                ),
            ),
            'vote'   => array(
                'comment' => array(
                    'rating'     => array(
                        'name'        => 'Порог рейтинга при котором юзер может голосовать за комментарии',
                        'description' => '',
                    ),
                    'limit_time' => array(
                        'name'        => 'Ограничение времени голосования за комментарий',
                        'description' => 'Сколько секунд будет разрешено отдавать голоса за объект',
                    ),
                ),
                'blog'    => array(
                    'rating' => array(
                        'name'        => 'Порог рейтинга при котором юзер может голосовать за блог',
                        'description' => '',
                    ),
                ),
                'topic'   => array(
                    'rating'     => array(
                        'name'        => 'Порог рейтинга при котором юзер может голосовать за топик',
                        'description' => '',
                    ),
                    'limit_time' => array(
                        'name'        => 'Ограничение времени голосования за топик',
                        'description' => 'Сколько секунд будет разрешено отдавать голоса за объект',
                    ),
                ),
                'user'    => array(
                    'rating' => array(
                        'name'        => 'Порог рейтинга при котором юзер может голосовать за пользователя',
                        'description' => '',
                    ),
                ),
            ),
        ),
        'module'     => array(
            'blog'     => array(
                'per_page'                       => array(
                    'name'        => 'Число блогов на страницу',
                    'description' => '',
                ),
                'users_per_page'                 => array(
                    'name'        => 'Число пользователей блога на страницу',
                    'description' => '',
                ),
                'personal_good'                  => array(
                    'name'        => 'Рейтинг топика в персональном блоге ниже которого он считается плохим',
                    'description' => '',
                ),
                'collective_good'                => array(
                    'name'        => 'Рейтинг топика в коллективных блогах ниже которого он считается плохим',
                    'description' => '',
                ),
                'index_good'                     => array(
                    'name'        => 'Рейтинг топика выше которого (включительно) он попадает на главную',
                    'description' => '',
                ),
                'encrypt'                        => array(
                    'name'        => 'Ключ XXTEA шифрования идентификаторов в ссылках приглашения в блоги',
                    'description' => '',
                ),
                'avatar_size'                    => array(
                    'name'        => 'Список размеров аватаров у блога. 0 - исходный размер',
                    'description' => '',
                ),
                'category_allow'                 => array(
                    'name'        => 'Разрешить использование категорий для блогов',
                    'description' => '',
                ),
                'category_only_admin'            => array(
                    'name'        => 'Задавать и менять категории для блога может только админ',
                    'description' => '',
                ),
                'category_only_without_children' => array(
                    'name'        => 'Для блога можно выбрать только конечную категорию, у которой нет других вложенных',
                    'description' => '',
                ),
                'category_allow_empty'           => array(
                    'name'        => 'Разрешить блоги без категории',
                    'description' => '',
                ),
            ),
            'topic'    => array(
                'new_time'          => array(
                    'name'        => 'Время в секундах в течении которого топик считается новым',
                    'description' => '',
                ),
                'per_page'          => array(
                    'name'        => 'Число топиков на одну страницу',
                    'description' => '',
                ),
                'max_length'        => array(
                    'name'        => 'Максимальное количество символов в одном топике',
                    'description' => '',
                ),
                'min_length'        => array(
                    'name'        => 'Минимальное количество символов в одном топике',
                    'description' => '',
                ),
                'allow_empty'       => array(
                    'name'        => 'Разрешать или нет не заполнять текст топика',
                    'description' => '',
                ),
                'title_max_length'  => array(
                    'name'        => 'Максимальное количество символов в заголовке топика',
                    'description' => '',
                ),
                'title_min_length'  => array(
                    'name'        => 'Минимальное количество символов в заголовке топика',
                    'description' => '',
                ),
                'title_allow_empty' => array(
                    'name'        => 'Разрешать или нет не заполнять заголовок топика',
                    'description' => '',
                ),
                'tags_allow_empty'  => array(
                    'name'        => 'Разрешать или нет не заполнять теги',
                    'description' => '',
                ),
                'tags_count_max'  => array(
                    'name'        => 'Максимальное число тегов',
                    'description' => '',
                ),
                'tags_count_min'  => array(
                    'name'        => 'Минимальное число тегов',
                    'description' => '',
                ),
                'url'  => array(
                    'name'        => 'Настройка ЧПУ урлов топиков',
                    'description' => '
                        Допустимы шаблоны:<br/>
                        %year% - год топика (2010)<br/>
                        %month% - месяц (08)<br/>
                        %day% - день (24)<br/>
                        %hour% - час (17)<br/>
                        %minute% - минуты (06)<br/>
                        %second% - секунды (54)<br/>
                        %login% - логин автора топика (admin)<br/>
                        %blog% - url основного блога (report), если топик без блога, то этот параметр заменится на логин автора топика<br/>
                        %id% - id топика (325)<br/>
                        %title% - заголовок топика в транслите (moy_topic)<br/>
                        %type% - тип топика (news)<br/>
                        <br/>
                        В шаблоне обязательно должен быть %id% или %title%, это необходимо для точной идентификации топика
                    ',
                ),
            ),
            'user'     => array(
                'per_page'                 => array(
                    'name'        => 'Число юзеров на страницу на странице статистики и в профиле пользователя',
                    'description' => 'Модуль User',
                ),
                'friend_on_profile'        => array(
                    'name'        => 'Ограничение на вывод числа друзей пользователя на странице его профиля',
                    'description' => '',
                ),
                'friend_notice'            => array(
                    'delete' => array(
                        'name'        => 'Отправить talk-сообщение в случае удаления пользователя из друзей',
                        'description' => '',
                    ),
                    'accept' => array(
                        'name'        => 'Отправить talk-сообщение в случае одобрения заявки на добавление в друзья',
                        'description' => '',
                    ),
                    'reject' => array(
                        'name'        => 'Отправить talk-сообщение в случае отклонения заявки на добавление в друзья',
                        'description' => '',
                    ),
                ),
                'avatar_size'              => array(
                    'name'        => 'Список размеров аватаров у пользователя. 0 - исходный размер',
                    'description' => '',
                ),
                'login'                    => array(
                    'min_size' => array(
                        'name'        => 'Минимальное количество символов в логине',
                        'description' => '',
                    ),
                    'max_size' => array(
                        'name'        => 'Максимальное количество символов в логине',
                        'description' => '',
                    ),
                    'charset'  => array(
                        'name'        => 'Допустимые в имени пользователя символы',
                        'description' => '',
                    ),
                ),
                'time_active'              => array(
                    'name'        => 'Число секунд с момента последнего посещения пользователем сайта, в течение которых он считается активным',
                    'description' => '',
                ),
                'usernote_text_max'        => array(
                    'name'        => 'Максимальный размер заметки о пользователе',
                    'description' => '',
                ),
                'usernote_per_page'        => array(
                    'name'        => 'Число заметок на одну страницу',
                    'description' => '',
                ),
                'userfield_max_identical'  => array(
                    'name'        => 'Максимальное число контактов одного типа',
                    'description' => '',
                ),
                'profile_photo_size'       => array(
                    'name'        => 'размер фото в профиле пользователя, формат вида: WxH[crop]',
                    'description' => '',
                ),
                'name_max'                 => array(
                    'name'        => 'максимальная длинна имени в профиле пользователя',
                    'description' => '',
                ),
                'captcha_use_registration' => array(
                    'name'        => 'проверять поле капчи при регистрации пользователя',
                    'description' => '',
                ),
                'complaint_captcha'        => array(
                    'name'        => 'Использовать или нет каптчу при написании жалобы',
                    'description' => '',
                ),
                'complaint_notify_by_mail' => array(
                    'name'        => 'Уведомлять администратора на емайл о поступлении новой жалобы',
                    'description' => '',
                ),
                'complaint_text_required'  => array(
                    'name'        => 'Обязательно указывать текст при жалобе',
                    'description' => '',
                ),
                'complaint_text_max'       => array(
                    'name'        => 'Максимальный размер текста жалобы',
                    'description' => '',
                ),
                'complaint_type'           => array(
                    'name'        => 'Список типов жалоб на пользователя',
                    'description' => 'Расшифровка типов задается в языковом файле',
                ),
            ),
            'comment'  => array(
                'per_page'               => array(
                    'name'        => 'Число комментариев на одну страницу(это касается только полного списка комментариев прямого эфира)',
                    'description' => 'Модуль Comment',
                ),
                'bad'                    => array(
                    'name'        => 'Рейтинг комментария, начиная с которого он будет скрыт',
                    'description' => '',
                ),
                'max_tree'               => array(
                    'name'        => 'Максимальная вложенность комментов при отображении',
                    'description' => '',
                ),
                'use_nested'             => array(
                    'name'        => 'Использовать или нет nested set при выборке комментов, увеличивает производительность при большом числе комментариев + позволяет делать постраничное разбиение комментов. После включения необходимо запустить перестроение комментариев из раздела Оптимизация',
                    'description' => '',
                ),
                'nested_per_page'        => array(
                    'name'        => 'Число комментов на одну страницу в топике, актуально только при use_nested = true',
                    'description' => '',
                ),
                'nested_page_reverse'    => array(
                    'name'        => 'Определяет порядок вывода страниц. true - последние комментарии на первой странице, false - последние комментарии на последней странице',
                    'description' => '',
                ),
                'favourite_target_allow' => array(
                    'name'        => 'Список типов комментов, которые разрешено добавлять в избранное',
                    'description' => '',
                ),
            ),
            'talk'     => array(
                'per_page'  => array(
                    'name'        => 'Число приватных сообщений на одну страницу',
                    'description' => 'Модуль Talk',
                ),
                'encrypt'   => array(
                    'name'        => 'Ключ XXTEA шифрования идентификаторов в ссылках',
                    'description' => '',
                ),
                'max_users' => array(
                    'name'        => 'Максимальное число адресатов в одном личном сообщении',
                    'description' => '',
                ),
            ),
            'lang'     => array(
                'delete_undefined' => array(
                    'name'        => 'Если установлена true, то модуль будет автоматически удалять из языковых конструкций переменные вида %%var%%, по которым не была произведена замена',
                    'description' => 'Модуль Lang',
                ),
            ),
            'notify'   => array(
                'delayed'       => array(
                    'name'        => 'Указывает на необходимость использовать режим отложенной рассылки сообщений на email',
                    'description' => 'Модуль Notify',
                ),
                'insert_single' => array(
                    'name'        => 'Если опция установлена в true, система будет собирать записи заданий удаленной публикации, для вставки их в базу единым INSERT',
                    'description' => '',
                ),
                'per_process'   => array(
                    'name'        => 'Количество отложенных заданий, обрабатываемых одним крон-процессом',
                    'description' => '',
                ),
                'dir'           => array(
                    'name'        => 'Путь до папки с емэйлами относительно шаблона',
                    'description' => '',
                ),
                'prefix'        => array(
                    'name'        => 'Префикс шаблонов емэйлов',
                    'description' => '',
                ),
            ),
            'security' => array(
                'hash' => array(
                    'name'        => '"примесь" к строке, хешируемой в качестве security-кода',
                    'description' => 'Модуль Security',
                ),
            ),
            'userfeed' => array(
                'count_default' => array(
                    'name'        => 'Число топиков в ленте по умолчанию',
                    'description' => '',
                ),
            ),
            'stream'   => array(
                'count_default'       => array(
                    'name'        => 'Число топиков в ленте по умолчанию',
                    'description' => '',
                ),
                'disable_vote_events' => array(
                    'name'        => 'Отключить отображение голосований в ленте',
                    'description' => '',
                ),
            ),
            'ls'       => array(
                'send_general' => array(
                    'name'        => 'Отправка на сервер LS общей информации о сайте(домен, версия LS и плагинов)',
                    'description' => '',
                ),
                'use_counter'  => array(
                    'name'        => 'Использование счетчика GA',
                    'description' => '',
                ),
            ),
            'wall'     => array(
                'count_last_reply' => array(
                    'name'        => 'Число последних ответов на сообщени на стене для отображения в ленте',
                    'description' => 'Модуль Wall - стена',
                ),
                'per_page'         => array(
                    'name'        => 'Число сообщений на стене на одну страницу',
                    'description' => '',
                ),
                'text_max'         => array(
                    'name'        => 'Ограничение на максимальное количество символов в одном сообщении на стене',
                    'description' => '',
                ),
                'text_min'         => array(
                    'name'        => 'Ограничение на минимальное количество символов в одном сообщении на стене',
                    'description' => '',
                ),
            ),
            'asset'    => array(
                'css' => array(
                    'merge'    => array(
                        'name'        => 'Указывает на необходимость слияния css файлов',
                        'description' => '',
                    ),
                    'compress' => array(
                        'name'        => 'Указывает на необходимость компрессии css файлов.',
                        'description' => 'Компрессия используется только в активированном режиме слияния файлов.',
                    ),
                ),
                'js'  => array(
                    'merge'    => array(
                        'name'        => 'Указывает на необходимость слияния js файлов',
                        'description' => '',
                    ),
                    'compress' => array(
                        'name'        => 'Указывает на необходимость компрессии js файлов.',
                        'description' => 'Компрессия используется только в активированном режиме слияния файлов.',
                    ),
                ),
            ),
        ),
        'router'     => array(
            'rewrite' => array(
                'name'        => '',
                'description' => 'Настройки роутинга',
            ),
            'uri'     => array(
                'name'        => '',
                'description' => 'Правила реврайта для REQUEST_URI',
            ),
            'config'  => array(
                'default'          => array(
                    'action' => array(
                        'name'        => '',
                        'description' => 'Глобальные настройки роутинга',
                    ),
                ),
                'action_not_found' => array(
                    'name'        => 'Экшен не найден',
                    'description' => '',
                ),
            ),
        ),
    ),
);

?>
