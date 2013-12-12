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
 * Модуль работы с удаленными серверами
 *
 */

class PluginAdmin_ModuleRemoteserver extends Module {

	/*
	 * ключ массива запроса для ссылки
	 */
	const REQUEST_URL = 'url';
	/*
	 * ключ массива запроса для массив передаваемых данных
	 */
	const REQUEST_DATA = 'data';
	/*
	 * ключ массива запроса настроек для curl
	 */
	const REQUEST_CURL_OPTIONS = 'curl_options';

	/*
	 * ключ успеха массива ответа
	 */
	const RESPONSE_SUCCESS = 'success';
	/*
	 * ключ текста ошибки массива ответа
	 */
	const RESPONSE_ERROR_MESSAGE = 'error_message';
	/*
	 * ключ строки данных массива ответа
	 */
	const RESPONSE_DATA = 'data';

	/*
	 * подпись
	 */
	const USER_AGENT = 'LiveStreet CMS New Admin Panel';

	/*
	 * макс. время подключения к серверу (не обработки запроса), сек
	 */
	const CONNECT_TIMEOUT = 2;
	/*
	 * макс. общее время работы получения данных, сек
	 */
	const WORK_TIMEOUT = 4;

	/*
	 * путь к корневым сертификатам
	 */
	private $sCARootCertsPath = null;


	public function Init() {
		$this->sCARootCertsPath = Config::Get('path.application.plugins.server') . '/admin/ssl_ca_certs/cacert.pem';
	}


	/**
	 * Выполнить запрос на сервер через первый из доступных способов (curl, socket, file)
	 *
	 * @param $aRequestData		массив с данными для запроса
	 * @return array|null
	 */
	public function Send($aRequestData) {
		/*
		 * если на сервере можно использовать CURL
		 */
/*		if ($this->IsCurlSupported()) {
			return $this->SendByCurl(
				$aRequestData[self::REQUEST_URL],
				$aRequestData[self::REQUEST_DATA],
				isset($aRequestData[self::REQUEST_CURL_OPTIONS]) ? $aRequestData[self::REQUEST_CURL_OPTIONS] : array()
			);
		}*/
		/*
		 * если на сервере можно использовать сокеты
		 * todo: этот способ не протестирован т.к. не удалось запустить OpenSSL
		 */
		if ($this->IsSocketsSupported()) {
			return $this->SendBySocket(
				$aRequestData[self::REQUEST_URL],
				$aRequestData[self::REQUEST_DATA]
			);
		}

		/*
		 * попробовать загрузить через файл
		 * todo: не удалось запустить OpenSSL для file_get_contents()
		 */


		return null;
	}


	/**
	 * Выполнить запрос на сервер через CURL
	 *
	 * @param       $sUrl				урл запроса
	 * @param       $aData				массив передаваемых данных
	 * @param array $aCurlOptions		настройки curl, которые перекрывают настройки по-умолчанию
	 * @return array					array('success' => $bSuccess, 'error_message' => $sErrorMsg, 'data' => $mData)
	 */
	protected function SendByCurl($sUrl, $aData, $aCurlOptions = array()) {
		/*
		 * флаг отсутствия ошибки
		 */
		$bSuccess = true;
		/*
		 * текст ошибки
		 */
		$sErrorMsg = null;
		/*
		 * упаковать массив передаваемых данных в строку чтобы использовать application/x-www-form-urlencoded
		 */
		$sPostData = http_build_query($aData);
		/*
		 * результат запроса
		 */
		$mData = null;

		/*
		 * параметры по-умолчанию
		 * они могут быть изменены/дополнены через параметр метода $aCurlOptions
		 * docs: http://www.php.net/manual/ru/function.curl-setopt.php
		 */
		$aCurlDefaults = array(
			/*
			 * урл запроса
			 */
			CURLOPT_URL => $sUrl,
			/*
			 * вернуть результат в переменную, а не в браузер
			 */
			CURLOPT_RETURNTRANSFER => true,
			/*
			 * не возвращать заголовки
			 */
			CURLOPT_HEADER => false,


			/*
			 * не проверять сертификат безопасности (если имеются проблемы с проверкой сертификата)
			 */
			//CURLOPT_SSL_VERIFYPEER => false,
			/*
			 * проверять сертифкат
			 */
			CURLOPT_SSL_VERIFYPEER => true,
			/*
			 * путь к файлу с рутовыми CA сертификатами
			 */
			CURLOPT_CAINFO => $this->sCARootCertsPath,


			/*
			 * следовать редиректам
			 * tip: при включенном в пхп.ини "safe_mode" или "open_basedir" могут быть проблемы с CURLOPT_FOLLOWLOCATION и CURLOPT_MAXREDIRS на старых версиях пхп
			 */
			CURLOPT_FOLLOWLOCATION => true,
			/*
			 * макс. количество редиректов
			 */
			CURLOPT_MAXREDIRS => 3,
			/*
			 * установить рефер при редиректе
			 */
			CURLOPT_AUTOREFERER => true,


			/*
			 * таймаут подключения, сек
			 */
			CURLOPT_CONNECTTIMEOUT => self::CONNECT_TIMEOUT,
			/*
			 * макс. позволенное количество секунд для выполнения cURL-функций
			 */
			CURLOPT_TIMEOUT => self::WORK_TIMEOUT,
			/*
			 * мин. скорость передачи, байт/сек
			 */
			CURLOPT_LOW_SPEED_LIMIT => 1024,
			/*
			 * макс. время (сек.) когда разрешена скорость CURLOPT_LOW_SPEED_LIMIT после чего пхп оборвет соединение
			 */
			CURLOPT_LOW_SPEED_TIME => 3,


			/*
			 * использовать обычный HTTP POST с application/x-www-form-urlencoded
			 */
			CURLOPT_POST => true,
			/*
			 * пост данные строкой (если массив, то multipart/form-data)
			 */
			CURLOPT_POSTFIELDS => $sPostData,


			/*
			 * подпись (заголовок)
			 */
			CURLOPT_USERAGENT => self::USER_AGENT,
			/*
			 * реферер
			 */
			CURLOPT_REFERER => Config::Get('path.root.web'),
			/*
			 * заголовки
			 */
			CURLOPT_HTTPHEADER => array('X-Powered-By: ' . self::USER_AGENT),
		);

		$oCurl = curl_init();
		/*
		 * объеденить настройки
		 * tip: особенность работы оператора "+" для массивов: до заданных настроек добавляются настройки по-умолчанию, не перекрывая их
		 */
		$aCurlAllOptions = $aCurlOptions + $aCurlDefaults;
		/*
		 * установить все параметры курла
		 */
		if (curl_setopt_array($oCurl, $aCurlAllOptions) === false) {
			$bSuccess = false;
			$sErrorMsg = curl_error($oCurl);
		}
		/*
		 * выполнить запрос
		 */
		if ($bSuccess and ($mData = curl_exec($oCurl)) === false) {
			$bSuccess = false;
			$sErrorMsg = curl_error($oCurl);
		}

		curl_close($oCurl);

		return array(
			/*
			 * флаг успеха
			 */
			self::RESPONSE_SUCCESS => $bSuccess,
			/*
			 * текст ошибки
			 */
			self::RESPONSE_ERROR_MESSAGE => $sErrorMsg,
			/*
			 * полученные данные
			 */
			self::RESPONSE_DATA => $mData
		);
	}


	/**
	 * Выполнить запрос на сервер через сокеты
	 *
	 * @param       $sUrl				урл запроса
	 * @param       $aData				массив передаваемых данных
	 * @return array					array('success' => $bSuccess, 'error_message' => $sErrorMsg, 'data' => $mData)
	 */
	protected function SendBySocket($sUrl, $aData) {
		/*
		 * флаг отсутствия ошибки
		 */
		$bSuccess = true;
		/*
		 * текст ошибки
		 */
		$sErrorMsg = null;
		/*
		 * упаковать массив передаваемых данных в строку чтобы использовать application/x-www-form-urlencoded
		 */
		$sPostData = http_build_query($aData);
		/*
		 * результат запроса
		 */
		$mData = null;

		/*
		 * для защищенных соединений через https:// у сокетов другой протокол - ssl://
		 */
		$sUrl = str_replace('https://', 'ssl://', $sUrl);
		/*
		 * получить части адреса т.к. fsockopen не понимает весь урл полностью
		 */
		$aAdressParts = parse_url($sUrl);

		if (!$oSocket = @fsockopen(
			$aAdressParts['host'],
			strpos('ssl://', $sUrl) !== false ? 443 : 80,								// todo: check for port
			$iErrorMsg,
			$sErrorMsg,
			self::CONNECT_TIMEOUT
		)) {
			$bSuccess = false;
		}
		/*
		 * выполнить запрос
		 */
		if ($bSuccess) {
			/*
			 * послать заголовки
			 */
			$aSendData = array(
				'POST ' . $aAdressParts['path'] . ' HTTP/1.1',
				'Connection: Close',

				'User-Agent: ' . self::USER_AGENT,
				'Host: ' . $aAdressParts['host'],
				'X-Powered-By: ' . self::USER_AGENT,
				'Accept: */*',

				'Content-Type: application/x-www-form-urlencoded',
				'Content-Length: ' . strlen($sPostData),
				/*
				 * этот перевод кареток нужен т.к. так отделяются пост данные от заголовков,
				 * в противном случае сервер будет ждать данных на длину Content-Length и "зависнет"
				 */
				'',
				$sPostData,
			);
			fwrite($oSocket, implode("\r\n", $aSendData));
			/*
			 * задать общее время работы
			 */
			stream_set_timeout($oSocket, self::WORK_TIMEOUT);
			/*
			 * получить информацию
			 */
			$aInfo = stream_get_meta_data($oSocket);
			/*
			 * получать ответ пока есть данные или не вышло время получения данных (заданное в stream_set_timeout)
			 */
			while (!feof($oSocket) and !$aInfo['timed_out']) {
				$aInfo = stream_get_meta_data($oSocket);
				$mData .= fgets($oSocket, 8192);
			}
			/*
			 * проверить на ошибки
			 */
			if ($aInfo['timed_out'] or strpos($mData, 'HTTP/1.1 400') !== false) {// todo: or 404
				$bSuccess = false;
				$sErrorMsg = 'response: 40x codes';
			}

			fclose($oSocket);
		}

		return array(
			/*
			 * флаг успеха
			 */
			self::RESPONSE_SUCCESS => $bSuccess,
			/*
			 * текст ошибки
			 */
			self::RESPONSE_ERROR_MESSAGE => $sErrorMsg,
			/*
			 * полученные данные
			 */
			self::RESPONSE_DATA => $mData
		);
	}


	/*
	 *
	 * --- Проверка наличия методов ---
	 *
	 */

	/**
	 * Включена ли поддержка CURL на сервере
	 *
	 * @return bool
	 */
	protected function IsCurlSupported() {
		return function_exists('curl_init');
	}


	/**
	 * Включена ли поддержка сокетов на сервере
	 *
	 * @return bool
	 */
	protected function IsSocketsSupported() {
		return function_exists('fsockopen');
	}

}

?>