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
 *	Описание каждого параметра конфига для отображения в админке LiveStreet CMS
 */

return array(
	'config_parameters' => array(
		'view' => array(
			'skin' => array(
				'name' => 'шаблон (скин)',
				'description' => 'Настройки HTML вида',
			),
			'name' => array(
				'name' => 'название сайта',
				'description' => '',
			),
			'description' => array(
				'name' => 'seo description',
				'description' => '',
			),
			'keywords' => array(
				'name' => 'seo keywords',
				'description' => '',
			),
			'wysiwyg' => array(
				'name' => 'использовать или нет визуальный редактор TinyMCE',
				'description' => '',
			),
			'noindex' => array(
				'name' => '"прятать" или нет ссылки от поисковиков, оборачивая их в тег &lt;noindex&gt; и добавляя rel="nofollow"',
				'description' => '',
			),
			'img_resize_width' => array(
				'name' => 'до какого размера в пикселях ужимать картинку по щирине при загрузки её в топики и комменты',
				'description' => '',
			),
			'img_max_width' => array(
				'name' => 'максимальная ширина загружаемых изображений в пикселях',
				'description' => '',
			),
			'img_max_height' => array(
				'name' => 'максимальная высота загружаемых изображений в пикселях',
				'description' => '',
			),
			'img_max_size_url' => array(
				'name' => 'максимальный размер картинки в kB для загрузки по URL',
				'description' => '',
			),
		),
		'seo' => array(
			'description_words_count' => array(
				'name' => 'количество слов из топика для вывода в метатег description',
				'description' => 'Настройки СЕО для вывода топиков',
			),
		),
		'block' => array(
			'stream' => array(
				'row' => array(
					'name' => 'сколько записей выводить в блоке "Прямой эфир"',
					'description' => 'Настройка основных блоков',
				),
				'show_tip' => array(
					'name' => 'выводить или нет всплывающие сообщения в блоке "Прямой эфир"',
					'description' => '',
				),
			),
			'blogs' => array(
				'row' => array(
					'name' => 'сколько записей выводить в блоке "Блоги"',
					'description' => '',
				),
			),
			'tags' => array(
				'tags_count' => array(
					'name' => 'сколько тегов выводить в блоке "теги"',
					'description' => '',
				),
				'personal_tags_count' => array(
					'name' => 'сколько тегов пользователя выводить в блоке "теги"',
					'description' => '',
				),
			),
			'rule_index_blog' => array(
				'name' => '',
				'description' => 'Настройки вывода блоков',
			),
			'rule_index' => array(
				'name' => '',
				'description' => '',
			),
			'rule_topic_type' => array(
				'name' => '',
				'description' => '',
			),
			'rule_personal_blog' => array(
				'name' => '',
				'description' => '',
			),
			'rule_tag' => array(
				'name' => '',
				'description' => '',
			),
			'rule_blogs' => array(
				'name' => '',
				'description' => '',
			),
			'userfeedBlogs' => array(
				'name' => '',
				'description' => '',
			),
			'userfeedUsers' => array(
				'name' => '',
				'description' => '',
			),
			'rule_blog_info' => array(
				'name' => '',
				'description' => '',
			),
			'rule_users' => array(
				'name' => '',
				'description' => '',
			),
			'rule_profile' => array(
				'name' => '',
				'description' => '',
			),
		),
		'pagination' => array(
			'pages' => array(
				'count' => array(
					'name' => 'количество ссылок на другие страницы в пагинации',
					'description' => 'Настройка пагинации',
				),
			),
		),
		'path' => array(
			'root' => array(
/*				'web' => array(
					'name' => '',
					'description' => '',
				),*/
				'server' => array(
					'name' => 'полный путь до сайта в файловой системе',
					'description' => '',
				),
				'engine' => array(
					'name' => 'полный путь до сайта в файловой системе;',
					'description' => 'Для CLI режима использовать<br />$config[\'path\'][\'root\'][\'server\'] = dirname(dirname(__FILE__));',
				),
				'engine_lib' => array(
					'name' => 'полный путь до сайта в файловой системе',
					'description' => '',
				),
			),
			'static' => array(
				'root' => array(
					'name' => 'чтоб можно было статику засунуть на отдельный сервер',
					'description' => '',
				),
				'skin' => array(
					'name' => '',
					'description' => '',
				),
				'assets' => array(
					'name' => 'Папка с ассетами (js, css, images)',
					'description' => '',
				),
				'framework' => array(
					'name' => 'Front-end framework',
					'description' => '',
				),
			),
			'uploads' => array(
				'root' => array(
					'name' => 'директория для загрузки файлов',
					'description' => '',
				),
				'images' => array(
					'name' => '',
					'description' => '',
				),
			),
			'offset_request_url' => array(
				'name' => 'иногда помогает если сервер использует внутренние реврайты',
				'description' => '',
			),
			'smarty' => array(
				'template' => array(
					'name' => '',
					'description' => 'Настройки шаблонизатора Smarty',
				),
				'compiled' => array(
					'name' => '',
					'description' => '',
				),
				'cache' => array(
					'name' => '',
					'description' => '',
				),
				'plug' => array(
					'name' => '',
					'description' => '',
				),
			),
		),
		'smarty' => array(
			'compile_check' => array(
				'name' => 'Проверять или нет файлы шаблона на изменения перед компиляцией, false может значительно увеличить быстродействие, но потребует ручного удаления кеша при изменения шаблона',
				'description' => '',
			),
		),
		'sys' => array(
			'plugins' => array(
				'activation_file' => array(
					'name' => 'файл со списком активных плагинов в каталоге /plugins/',
					'description' => 'Настройки плагинов',
				),
			),
			'cookie' => array(
/*				'host' => array(
					'name' => 'хост для установки куков',
					'description' => 'Настройки куков',
				),*/
				'path' => array(
					'name' => 'путь для установки куков',
					'description' => '',
				),
				'time' => array(
					'name' => 'время жизни куки когда пользователь остается залогиненым на сайте, 3 дня',
					'description' => '',
				),
			),
			'session' => array(
				'standart' => array(
					'name' => 'Использовать или нет стандартный механизм сессий',
					'description' => 'Настройки сессий',
				),
				'name' => array(
					'name' => 'название сессии',
					'description' => '',
				),
/*				'timeout' => array(
					'name' => 'Тайм-аут сессии в секундах',
					'description' => '',
				),*/
				'host' => array(
					'name' => 'хост сессии в куках',
					'description' => '',
				),
				'path' => array(
					'name' => 'путь сессии в куках',
					'description' => '',
				),
			),
			'mail' => array(
				'type' => array(
					'name' => 'Какой тип отправки использовать',
					'description' => 'Настройки почтовых уведомлений',
				),
				'from_email' => array(
					'name' => 'Мыло с которого отправляются все уведомления',
					'description' => '',
				),
				'from_name' => array(
					'name' => 'Имя с которого отправляются все уведомления',
					'description' => '',
				),
				'charset' => array(
					'name' => 'Какую кодировку использовать в письмах',
					'description' => '',
				),
				'smtp' => array(
					'host' => array(
						'name' => 'Настройки SMTP - хост',
						'description' => '',
					),
					'port' => array(
						'name' => 'Настройки SMTP - порт',
						'description' => '',
					),
					'user' => array(
						'name' => 'Настройки SMTP - пользователь',
						'description' => '',
					),
					'password' => array(
						'name' => 'Настройки SMTP - пароль',
						'description' => '',
					),
					'secure' => array(
						'name' => 'Настройки SMTP - протокол шифрования: tls, ssl',
						'description' => '',
					),
					'auth' => array(
						'name' => 'Использовать авторизацию при отправке',
						'description' => '',
					),
				),
				'include_comment' => array(
					'name' => 'Включает в уведомление о новых комментах текст коммента',
					'description' => '',
				),
				'include_talk' => array(
					'name' => 'Включает в уведомление о новых личных сообщениях текст сообщения',
					'description' => '',
				),
			),
			'cache' => array(
				'use' => array(
					'name' => 'использовать кеширование или нет',
					'description' => 'Устанавливаем настройки кеширования',
				),
				'type' => array(
					'name' => 'тип кеширования: file, xcache и memory. memory использует мемкеш, xcache - использует XCache',
					'description' => '',
				),
				'dir' => array(
					'name' => 'каталог для файлового кеша, также используется для временных картинок. По умолчанию подставляем каталог для хранения сессий',
					'description' => '',
				),
				'prefix' => array(
					'name' => 'префикс кеширования, чтоб можно было на одной машине держать несколько сайтов с общим кешевым хранилищем',
					'description' => '',
				),
				'directory_level' => array(
					'name' => 'уровень вложенности директорий файлового кеша',
					'description' => '',
				),
				'solid' => array(
					'name' => 'Настройка использования раздельного и монолитного кеша для отдельных операций',
					'description' => '',
				),
			),
			'logs' => array(
				'file' => array(
					'name' => 'файл общего лога',
					'description' => 'Настройки логирования',
				),
				'sql_query' => array(
					'name' => 'логировать или нет SQL запросы',
					'description' => '',
				),
				'sql_query_file' => array(
					'name' => 'файл лога SQL запросов',
					'description' => '',
				),
				'sql_error' => array(
					'name' => 'логировать или нет ошибки SQl',
					'description' => '',
				),
				'sql_error_file' => array(
					'name' => 'файл лога ошибок SQL',
					'description' => '',
				),
				'cron' => array(
					'name' => 'логировать или нет cron скрипты',
					'description' => '',
				),
				'cron_file' => array(
					'name' => 'файл лога запуска крон-процессов',
					'description' => '',
				),
				'profiler' => array(
					'name' => 'логировать или нет профилирование процессов',
					'description' => '',
				),
				'profiler_file' => array(
					'name' => 'файл лога профилирования процессов',
					'description' => '',
				),
				'hacker_console' => array(
					'name' => 'позволяет удобно выводить логи дебага через функцию dump(), использя "хакерскую" консоль Дмитрия Котерова',
					'description' => '',
				),
			),
		),
		'general' => array(
			'close' => array(
				'name' => 'использовать закрытый режим работы сайта, сайт будет доступен только авторизованным пользователям',
				'description' => 'Общие настройки',
			),
			'rss_editor_mail' => array(
				'name' => 'мыло редактора РСС',
				'description' => '',
			),
			'reg' => array(
				'invite' => array(
					'name' => 'использовать режим регистрации по приглашению или нет. Если использовать, то регистрация будет доступна ТОЛЬКО по приглашениям!',
					'description' => '',
				),
				'activation' => array(
					'name' => 'использовать активацию при регистрации или нет',
					'description' => '',
				),
			),
		),
		'lang' => array(
			'current' => array(
				'name' => 'текущий язык текстовок',
				'description' => 'Языковые настройки',
			),
			'default' => array(
				'name' => 'язык, который будет использовать на сайте по умолчанию',
				'description' => '',
			),
			'path' => array(
				'name' => 'полный путь до языковых файлов',
				'description' => '',
			),
			'load_to_js' => array(
				'name' => 'Массив текстовок, которые необходимо прогружать на страницу в виде JS хеша, позволяет использовать текстовки внутри js',
				'description' => '',
			),
		),
		'acl' => array(
			'create' => array(
				'blog' => array(
					'rating' => array(
						'name' => 'порог рейтинга при котором юзер может создать коллективный блог',
						'description' => 'Настройки ACL (Access Control List — список контроля доступа)',
					),
				),
				'comment' => array(
					'rating' => array(
						'name' => 'порог рейтинга при котором юзер может добавлять комментарии',
						'description' => '',
					),
					'limit_time' => array(
						'name' => 'время в секундах между постингом комментариев, если 0 то ограничение по времени не будет работать',
						'description' => '',
					),
					'limit_time_rating' => array(
						'name' => 'рейтинг, выше которого перестаёт действовать ограничение по времени на постинг комментов. Не имеет смысла при $config[\'acl\'][\'create\'][\'comment\'][\'limit_time\']=0',
						'description' => '',
					),
				),
				'topic' => array(
					'limit_time' => array(
						'name' => 'время в секундах между созданием записей, если 0 то ограничение по времени не будет работать',
						'description' => '',
					),
					'limit_time_rating' => array(
						'name' => 'рейтинг, выше которого перестаёт действовать ограничение по времени на создание записей',
						'description' => '',
					),
					'limit_rating' => array(
						'name' => 'порог рейтинга при котором юзер может создавать топики(учитываются любые блоги, включая персональные), как дополнительная защита от спама/троллинга',
						'description' => '',
					),
				),
				'talk' => array(
					'limit_time' => array(
						'name' => 'время в секундах между отправкой инбоксов, если 0 то ограничение по времени не будет работать',
						'description' => '',
					),
					'limit_time_rating' => array(
						'name' => 'рейтинг, выше которого перестаёт действовать ограничение по времени на отправку инбоксов',
						'description' => '',
					),
				),
				'talk_comment' => array(
					'limit_time' => array(
						'name' => 'время в секундах между отправкой инбоксов, если 0 то ограничение по времени не будет работать',
						'description' => '',
					),
					'limit_time_rating' => array(
						'name' => 'рейтинг, выше которого перестаёт действовать ограничение по времени на отправку инбоксов',
						'description' => '',
					),
				),
				'wall' => array(
					'limit_time' => array(
						'name' => 'рейтинг, выше которого перестаёт действовать ограничение по времени на отправку сообщений на стену',
						'description' => '',
					),
					'limit_time_rating' => array(
						'name' => 'рейтинг, выше которого перестаёт действовать ограничение по времени на отправку сообщений на стену',
						'description' => '',
					),
				),
			),
			'vote' => array(
				'comment' => array(
					'rating' => array(
						'name' => 'порог рейтинга при котором юзер может голосовать за комментарии',
						'description' => '',
					),
					'limit_time' => array(
						'name' => 'ограничение времени голосования за комментарий',
						'description' => '',
					),
				),
				'blog' => array(
					'rating' => array(
						'name' => 'порог рейтинга при котором юзер может голосовать за блог',
						'description' => '',
					),
				),
				'topic' => array(
					'rating' => array(
						'name' => 'порог рейтинга при котором юзер может голосовать за топик',
						'description' => '',
					),
					'limit_time' => array(
						'name' => 'ограничение времени голосования за топик',
						'description' => '',
					),
				),
				'user' => array(
					'rating' => array(
						'name' => 'порог рейтинга при котором юзер может голосовать за пользователя',
						'description' => '',
					),
				),
			),
		),
		'module' => array(
			'blog' => array(
				'per_page' => array(
					'name' => 'Число блогов на страницу',
					'description' => 'Модуль Blog',
				),
				'users_per_page' => array(
					'name' => 'Число пользователей блога на страницу',
					'description' => '',
				),
				'personal_good' => array(
					'name' => 'Рейтинг топика в персональном блоге ниже которого он считается плохим',
					'description' => '',
				),
				'collective_good' => array(
					'name' => 'рейтинг топика в коллективных блогах ниже которого он считается плохим',
					'description' => '',
				),
				'index_good' => array(
					'name' => 'Рейтинг топика выше которого(включительно) он попадает на главную',
					'description' => '',
				),
				'encrypt' => array(
					'name' => 'Ключ XXTEA шифрования идентификаторов в ссылках приглашения в блоги',
					'description' => '',
				),
				'avatar_size' => array(
					'name' => 'Список размеров аватаров у блога. 0 - исходный размер',
					'description' => '',
				),
				'category_allow' => array(
					'name' => 'Разрешить использование категорий бля блогов',
					'description' => '',
				),
				'category_only_admin' => array(
					'name' => 'Задавать и менять категории для блога может только админ',
					'description' => '',
				),
				'category_only_children' => array(
					'name' => 'Для блога можно выбрать только конечную категорию, у которой нет других вложенных',
					'description' => '',
				),
				'category_allow_empty' => array(
					'name' => 'Разрешить блоги без категории',
					'description' => '',
				),
			),
			'topic' => array(
				'new_time' => array(
					'name' => 'Время в секундах в течении которого топик считается новым',
					'description' => 'Модуль Topic',
				),
				'per_page' => array(
					'name' => 'Число топиков на одну страницу',
					'description' => '',
				),
				'max_length' => array(
					'name' => 'Максимальное количество символов в одном топике',
					'description' => '',
				),
				'link_max_length' => array(
					'name' => 'Максимальное количество символов в одном топике-ссылке',
					'description' => '',
				),
				'question_max_length' => array(
					'name' => 'Максимальное количество символов в одном топике-опросе',
					'description' => '',
				),
				'allow_empty_tags' => array(
					'name' => 'Разрешать или нет не заполнять теги',
					'description' => '',
				),
			),
			'user' => array(
				'per_page' => array(
					'name' => 'Число юзеров на страницу на странице статистики и в профиле пользователя',
					'description' => 'Модуль User',
				),
				'friend_on_profile' => array(
					'name' => 'Ограничение на вывод числа друзей пользователя на странице его профиля',
					'description' => '',
				),
				'friend_notice' => array(
					'delete' => array(
						'name' => 'Отправить talk-сообщение в случае удаления пользователя из друзей',
						'description' => '',
					),
					'accept' => array(
						'name' => 'Отправить talk-сообщение в случае одобрения заявки на добавление в друзья',
						'description' => '',
					),
					'reject' => array(
						'name' => 'Отправить talk-сообщение в случае отклонения заявки на добавление в друзья',
						'description' => '',
					),
				),
				'avatar_size' => array(
					'name' => 'Список размеров аватаров у пользователя. 0 - исходный размер',
					'description' => '',
				),
				'login' => array(
					'min_size' => array(
						'name' => 'Минимальное количество символов в логине',
						'description' => '',
					),
					'max_size' => array(
						'name' => 'Максимальное количество символов в логине',
						'description' => '',
					),
					'charset' => array(
						'name' => 'Допустимые в имени пользователя символы',
						'description' => '',
					),
				),
				'time_active' => array(
					'name' => 'Число секунд с момента последнего посещения пользователем сайта, в течение которых он считается активным',
					'description' => '',
				),
				'usernote_text_max' => array(
					'name' => 'Максимальный размер заметки о пользователе',
					'description' => '',
				),
				'usernote_per_page' => array(
					'name' => 'Число заметок на одну страницу',
					'description' => '',
				),
				'userfield_max_identical' => array(
					'name' => 'Максимальное число контактов одного типа',
					'description' => '',
				),
				'profile_photo_width' => array(
					'name' => 'ширина квадрата фотографии в профиле, px',
					'description' => '',
				),
				'name_max' => array(
					'name' => 'максимальная длинна имени в профиле пользователя',
					'description' => '',
				),
				'captcha_use_registration' => array(
					'name' => 'проверять поле капчи при регистрации пользователя',
					'description' => '',
				),
			),
			'comment' => array(
				'per_page' => array(
					'name' => 'Число комментариев на одну страницу(это касается только полного списка комментариев прямого эфира)',
					'description' => 'Модуль Comment',
				),
				'bad' => array(
					'name' => 'Рейтинг комментария, начиная с которого он будет скрыт',
					'description' => '',
				),
				'max_tree' => array(
					'name' => 'Максимальная вложенность комментов при отображении',
					'description' => '',
				),
				'use_nested' => array(
					'name' => 'Использовать или нет nested set при выборке комментов, увеличивает производительность при большом числе комментариев + позволяет делать постраничное разбиение комментов',
					'description' => '',
				),
				'nested_per_page' => array(
					'name' => 'Число комментов на одну страницу в топике, актуально только при use_nested = true',
					'description' => '',
				),
				'nested_page_reverse' => array(
					'name' => 'Определяет порядок вывода страниц. true - последние комментарии на первой странице, false - последние комментарии на последней странице',
					'description' => '',
				),
				'favourite_target_allow' => array(
					'name' => 'Список типов комментов, которые разрешено добавлять в избранное',
					'description' => '',
				),
			),
			'talk' => array(
				'per_page' => array(
					'name' => 'Число приватных сообщений на одну страницу',
					'description' => 'Модуль Talk',
				),
				'encrypt' => array(
					'name' => 'Ключ XXTEA шифрования идентификаторов в ссылках',
					'description' => '',
				),
				'max_users' => array(
					'name' => 'Максимальное число адресатов в одном личном сообщении',
					'description' => '',
				),
			),
			'lang' => array(
				'delete_undefined' => array(
					'name' => 'Если установлена true, то модуль будет автоматически удалять из языковых конструкций переменные вида %%var%%, по которым не была произведена замена',
					'description' => 'Модуль Lang',
				),
			),
			'notify' => array(
				'delayed' => array(
					'name' => 'Указывает на необходимость использовать режим отложенной рассылки сообщений на email',
					'description' => 'Модуль Notify',
				),
				'insert_single' => array(
					'name' => 'Если опция установлена в true, систему будет собирать записи заданий удаленной публикации, для вставки их в базу единым INSERT',
					'description' => '',
				),
				'per_process' => array(
					'name' => 'Количество отложенных заданий, обрабатываемых одним крон-процессом',
					'description' => '',
				),
				'dir' => array(
					'name' => 'Путь до папки с емэйлами относительно шаблона',
					'description' => '',
				),
				'prefix' => array(
					'name' => 'Префикс шаблонов емэйлов',
					'description' => '',
				),
			),
			'image' => array(
				'default' => array(
					'watermark_use' => array(
						'name' => '',
						'description' => 'Модуль Image',
					),
					'watermark_type' => array(
						'name' => '',
						'description' => '',
					),
					'watermark_position' => array(
						'name' => '',
						'description' => '',
					),
					'watermark_text' => array(
						'name' => '',
						'description' => '',
					),
					'watermark_font' => array(
						'name' => '',
						'description' => '',
					),
					'watermark_font_color' => array(
						'name' => '',
						'description' => '',
					),
					'watermark_font_size' => array(
						'name' => '',
						'description' => '',
					),
					'watermark_font_alfa' => array(
						'name' => '',
						'description' => '',
					),
					'watermark_back_color' => array(
						'name' => '',
						'description' => '',
					),
					'watermark_back_alfa' => array(
						'name' => '',
						'description' => '',
					),
					'watermark_image' => array(
						'name' => '',
						'description' => '',
					),
					'watermark_min_width' => array(
						'name' => '',
						'description' => '',
					),
					'watermark_min_height' => array(
						'name' => '',
						'description' => '',
					),
					'round_corner' => array(
						'name' => '',
						'description' => '',
					),
					'round_corner_radius' => array(
						'name' => '',
						'description' => '',
					),
					'round_corner_rate' => array(
						'name' => '',
						'description' => '',
					),
					'path' => array(
						'watermarks' => array(
							'name' => '',
							'description' => '',
						),
						'fonts' => array(
							'name' => '',
							'description' => '',
						),
					),
					'jpg_quality' => array(
						'name' => 'Число от 0 до 100',
						'description' => '',
					),
				),
				'foto' => array(
					'watermark_use' => array(
						'name' => '',
						'description' => '',
					),
					'round_corner' => array(
						'name' => '',
						'description' => '',
					),
				),
				'topic' => array(
					'watermark_use' => array(
						'name' => '',
						'description' => '',
					),
					'round_corner' => array(
						'name' => '',
						'description' => '',
					),
				),
			),
			'security' => array(
				'hash' => array(
					'name' => '"примесь" к строке, хешируемой в качестве security-кода',
					'description' => 'Модуль Security',
				),
			),
			'userfeed' => array(
				'count_default' => array(
					'name' => 'Число топиков в ленте по умолчанию',
					'description' => '',
				),
			),
			'stream' => array(
				'count_default' => array(
					'name' => 'Число топиков в ленте по умолчанию',
					'description' => '',
				),
				'disable_vote_events' => array(
					'name' => '',
					'description' => '',
				),
			),
			'ls' => array(
				'send_general' => array(
					'name' => 'Отправка на сервер LS общей информации о сайте(домен, версия LS и плагинов)',
					'description' => 'Модуль Ls',
				),
				'use_counter' => array(
					'name' => 'Использование счетчика GA',
					'description' => '',
				),
			),
			'wall' => array(
				'count_last_reply' => array(
					'name' => 'Число последних ответов на сообщени на стене для отображения в ленте',
					'description' => 'Модуль Wall - стена',
				),
				'per_page' => array(
					'name' => 'Число сообщений на стене на одну страницу',
					'description' => '',
				),
				'text_max' => array(
					'name' => 'Ограничение на максимальное количество символов в одном сообщении на стене',
					'description' => '',
				),
				'text_min' => array(
					'name' => 'Ограничение на минимальное количество символов в одном сообщении на стене',
					'description' => '',
				),
			),
			'autoLoad' => array(
				'name' => '',
				'description' => 'Какие модули должны быть загружены на старте',
			),
		),
		'db' => array(
			'params' => array(
				'host' => array(
					'name' => '',
					'description' => 'Настройка базы данных',
				),
				'port' => array(
					'name' => '',
					'description' => '',
				),
				'user' => array(
					'name' => '',
					'description' => '',
				),
				'pass' => array(
					'name' => '',
					'description' => '',
				),
				'type' => array(
					'name' => '',
					'description' => '',
				),
				'dbname' => array(
					'name' => '',
					'description' => '',
				),
			),
			'table' => array(
				'prefix' => array(
					'name' => '',
					'description' => 'Настройка таблиц базы данных',
				),
				'user' => array(
					'name' => '',
					'description' => '',
				),
				'blog' => array(
					'name' => '',
					'description' => '',
				),
				'blog_category' => array(
					'name' => '',
					'description' => '',
				),
				'topic' => array(
					'name' => '',
					'description' => '',
				),
				'topic_tag' => array(
					'name' => '',
					'description' => '',
				),
				'comment' => array(
					'name' => '',
					'description' => '',
				),
				'vote' => array(
					'name' => '',
					'description' => '',
				),
				'topic_read' => array(
					'name' => '',
					'description' => '',
				),
				'blog_user' => array(
					'name' => '',
					'description' => '',
				),
				'favourite' => array(
					'name' => '',
					'description' => '',
				),
				'favourite_tag' => array(
					'name' => '',
					'description' => '',
				),
				'talk' => array(
					'name' => '',
					'description' => '',
				),
				'talk_user' => array(
					'name' => '',
					'description' => '',
				),
				'talk_blacklist' => array(
					'name' => '',
					'description' => '',
				),
				'friend' => array(
					'name' => '',
					'description' => '',
				),
				'topic_content' => array(
					'name' => '',
					'description' => '',
				),
				'topic_question_vote' => array(
					'name' => '',
					'description' => '',
				),
				'user_administrator' => array(
					'name' => '',
					'description' => '',
				),
				'comment_online' => array(
					'name' => '',
					'description' => '',
				),
				'invite' => array(
					'name' => '',
					'description' => '',
				),
				'page' => array(
					'name' => '',
					'description' => '',
				),
				'reminder' => array(
					'name' => '',
					'description' => '',
				),
				'session' => array(
					'name' => '',
					'description' => '',
				),
				'notify_task' => array(
					'name' => '',
					'description' => '',
				),
				'userfeed_subscribe' => array(
					'name' => '',
					'description' => '',
				),
				'stream_subscribe' => array(
					'name' => '',
					'description' => '',
				),
				'stream_event' => array(
					'name' => '',
					'description' => '',
				),
				'stream_user_type' => array(
					'name' => '',
					'description' => '',
				),
				'user_field' => array(
					'name' => '',
					'description' => '',
				),
				'user_field_value' => array(
					'name' => '',
					'description' => '',
				),
				'topic_photo' => array(
					'name' => '',
					'description' => '',
				),
				'subscribe' => array(
					'name' => '',
					'description' => '',
				),
				'wall' => array(
					'name' => '',
					'description' => '',
				),
				'user_note' => array(
					'name' => '',
					'description' => '',
				),
				'geo_country' => array(
					'name' => '',
					'description' => '',
				),
				'geo_region' => array(
					'name' => '',
					'description' => '',
				),
				'geo_city' => array(
					'name' => '',
					'description' => '',
				),
				'geo_target' => array(
					'name' => '',
					'description' => '',
				),
				'user_changemail' => array(
					'name' => '',
					'description' => '',
				),
				'storage' => array(
					'name' => 'Таблица хранилища',
					'description' => '',
				),
			),
			'tables' => array(
				'engine' => array(
					'name' => 'InnoDB или MyISAM',
					'description' => '',
				),
			),
		),
		'memcache' => array(
			'servers' => array(
				0 => array(
					'host' => array(
						'name' => '',
						'description' => 'Настройка memcache',
					),
					'port' => array(
						'name' => 'port',
						'description' => '',
					),
					'persistent' => array(
						'name' => 'persistent',
						'description' => '',
					),
				),
			),
			'compression' => array(
				'name' => 'compression',
				'description' => '',
			),
		),
		'router' => array(
			'rewrite' => array(
				'name' => '',
				'description' => 'Настройки роутинга',
			),
			'uri' => array(
				'name' => '',
				'description' => 'Правила реврайта для REQUEST_URI',
			),
			'page' => array(
				'error' => array(
					'name' => '',
					'description' => 'Распределение action',
				),
				'registration' => array(
					'name' => '',
					'description' => '',
				),
				'profile' => array(
					'name' => '',
					'description' => '',
				),
				'my' => array(
					'name' => '',
					'description' => '',
				),
				'blog' => array(
					'name' => '',
					'description' => '',
				),
				'personal_blog' => array(
					'name' => '',
					'description' => '',
				),
				'index' => array(
					'name' => '',
					'description' => '',
				),
				'topic' => array(
					'name' => '',
					'description' => '',
				),
				'login' => array(
					'name' => '',
					'description' => '',
				),
				'people' => array(
					'name' => '',
					'description' => '',
				),
				'settings' => array(
					'name' => '',
					'description' => '',
				),
				'tag' => array(
					'name' => '',
					'description' => '',
				),
				'talk' => array(
					'name' => '',
					'description' => '',
				),
				'comments' => array(
					'name' => '',
					'description' => '',
				),
				'rss' => array(
					'name' => '',
					'description' => '',
				),
				'link' => array(
					'name' => '',
					'description' => '',
				),
				'question' => array(
					'name' => '',
					'description' => '',
				),
				'blogs' => array(
					'name' => '',
					'description' => '',
				),
				'search' => array(
					'name' => '',
					'description' => '',
				),
				'admin' => array(
					'name' => '',
					'description' => '',
				),
				'ajax' => array(
					'name' => '',
					'description' => '',
				),
				'feed' => array(
					'name' => '',
					'description' => '',
				),
				'stream' => array(
					'name' => '',
					'description' => '',
				),
				'subscribe' => array(
					'name' => '',
					'description' => '',
				),
			),
			'config' => array(
				'action_default' => array(
					'name' => '',
					'description' => 'Глобальные настройки роутинга',
				),
				'action_not_found' => array(
					'name' => '',
					'description' => '',
				),
			),
		),
		'head' => array(
			'default' => array(
				'js' => array(
					'name' => '',
					'description' => '',
				),
				'css' => array(
					'name' => '',
					'description' => '',
				),
			),
		),
		'compress' => array(
			'css' => array(
				'merge' => array(
					'name' => 'указывает на необходимость слияния файлов по указанным блокам.',
					'description' => 'Параметры компрессии css-файлов',
				),
				'use' => array(
					'name' => 'указывает на необходимость компрессии файлов. Компрессия используется только в активированном режиме слияния файлов.',
					'description' => '',
				),
				'case_properties' => array(
					'name' => '',
					'description' => '',
				),
				'merge_selectors' => array(
					'name' => '',
					'description' => '',
				),
				'optimise_shorthands' => array(
					'name' => '',
					'description' => '',
				),
				'remove_last_;' => array(
					'name' => '',
					'description' => '',
				),
				'css_level' => array(
					'name' => '',
					'description' => '',
				),
				'template' => array(
					'name' => '',
					'description' => '',
				),
			),
			'js' => array(
				'merge' => array(
					'name' => 'указывает на необходимость слияния файлов по указанным блокам.',
					'description' => 'Параметры компрессии js-файлов',
				),
				'use' => array(
					'name' => 'указывает на необходимость компрессии файлов. Компрессия используется только в активированном режиме слияния файлов.',
					'description' => '',
				),
			),
		),
	),
);

?>