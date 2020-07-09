<?php
/**
 * Created by PhpStorm.
 * User: lvxj
 * Date: 2018/1/18 0018
 * Time: 16:09
 */

namespace common\utils;

use common\constants\CacheKey;

class LoggerUtils extends BaseUtil{
	private $m_YcFilePath;
	private $m_YcFileName;
	private $m_YcErrorFileName;
	private $m_YcMaxLogFileNum;
	private $m_YcRotaType;
	private $m_YcRotaParam;
	private $m_YcInitOk;
	private $m_YcPriority;
	private $m_YcLogCount;
	private $m_YcErrorFlag;
	private $m_YcRemoteAddr = '';

	public function __construct($filename,$dir='', $priority = LoggerUtils::LEVEL_DEBUG, $maxlogfilenum = 5, $rotatype = 1, $rotaparam = 50000000) {

	    if(empty($dir)){
	        if(!empty(\Yii::$app->basePath)){
	            $tmps = explode('/',\Yii::$app->basePath);
                $dir = end($tmps);
            }
        }

		$dir = empty($dir) ? date('ymd') : date('ymd').'/'.$dir;
		$this->m_YcErrorFlag = 0;
		$dot_offset = strpos ( $filename, "." );
		if ($dot_offset !== false) {
			$this->m_YcFileName = substr($filename, 0, $dot_offset);
		}else {
			$this->m_YcFileName = $filename;
		}
		$this->m_YcErrorFileName = $this->m_YcFileName;
		$logdir = isset(\Yii::$app->params['error_log_dir']) && !empty(\Yii::$app->params['error_log_dir'])? \Yii::$app->params['error_log_dir'] : '/tmp/logs';
        	$logdir = rtrim($logdir,'/');
		$this->m_YcFilePath = $logdir.'/'.$dir;
		$this->m_YcMaxLogFileNum = intval ( $maxlogfilenum );
		$this->m_YcRotaParam = intval ( $rotaparam );
		$this->m_YcRotaType = intval ( $rotatype );
		$this->m_YcPriority = intval ( $priority );
		$this->m_YcLogCount = 0;

		$this->m_YcInitOk = $this->InitDir ();
		umask ( 0000 );

		(isset ( $_SERVER ['REMOTE_ADDR'] )) && $this->m_YcRemoteAddr = $_SERVER ['REMOTE_ADDR'];
	}

	/**
	 * 致命错误
	 * @param $msg
	 * @param int $uid
	 */
	public function LogCrit($msg, $uid = 0) {
		$this->m_YcErrorFlag = 0;
		$this->Log ( LoggerUtils::LEVEL_CRIT, '【crit】'.getmypid () . '|' . $this->get_ip () . '|' . $this->m_YcRemoteAddr . '|' . $uid . '|' . $msg );
	}

	/**
	 * 严重级别错误
	 * @param $msg
	 * @param int $uid
	 */
	public function LogError($msg, $uid = 0) {
		$this->m_YcErrorFlag = 0;
		$this->Log ( LoggerUtils::LEVEL_ERROR, '【error】'.getmypid () . '|' . $this->get_ip () . '|' . $this->m_YcRemoteAddr . '|' . $uid . '|' . $msg );
	}

	/**
	 * 记录日志消息
	 * @param $log
	 */
	function LogInfo($msg) {
		$this->Log ( LoggerUtils::LEVEL_INFO, '【info】'.$msg );
	}

	/**
	 * debug级别错误
	 * @param $log
	 */
	function LogDebug($msg) {
		$this->Log ( LoggerUtils::LEVEL_DEBUG, '【debug】'.$msg );
	}

	/**
	 * notice注意
	 * @param $msg
	 */
	function LogNotice($msg) {
		$this->Log ( LoggerUtils::LEVEL_NOTICE, '【notice】'.$msg );
	}


	/**----------------------------------------------------------------华丽的分割线 (下面方法使用者不需要关注)--------------------------------------------------------------------------------**/

	private function InitDir() {
		if (is_dir ( $this->m_YcFilePath ) === false) {
			if (! $this->createDir ( $this->m_YcFilePath )) {
				return false;
			}
		}
		return true;
	}
	private function get_ip() {
		static $realIP;
		if ($realIP)
			return $realIP;
		// 代理时
		$ip = getenv ( 'HTTP_X_CLIENT_IP' ) ? getenv ( 'HTTP_X_CLIENT_IP' ) : getenv ( 'HTTP_X_FORWARDED_FOR' );
		preg_match ( "/[\d\.]{7,15}/", $ip, $match );
		if (isset ( $match [0] ))
			return $realIP = $match [0];

		// 非代理时
		$ip = ! empty ( $_SERVER ['REMOTE_ADDR'] ) ? $_SERVER ['REMOTE_ADDR'] : '0.0.0.0';
		preg_match ( "/[\d\.]{7,15}/", $ip, $match );

		return $realIP = isset ( $match [0] ) ? $match [0] : '0.0.0.0';
	}
	private function Log($priority, $log) {
		if ($this->m_YcInitOk == false)
			return;
		if ($priority > $this->m_YcPriority)
			return;

//		//这里先用redis存储，如果redis出现异常，就用文件存储
//        if(YII_ENV == 'prod'){
//            try{
//                $redis = new RedisUtil();
//                $reidsLog = json_encode([
//                    'filename'=>$this->m_YcFileName,
//                    'log'=>$log,
//                    'time'=>time()
//                ]);
//                $rs = $redis->lPush(CacheKey::getLogQueue(),$reidsLog);
//                if($rs){
//                    return;
//                }
//            }catch (\Exception $e){
//                $log .= '!!!redis log 连接操作异常，暂时使用文件记录日志，尽快排查!!!,error:'.$e->getMessage();
//            }
//        }

        if ($this->m_YcErrorFlag == 0) {
            $path = $this->getLogFilePath ( $this->m_YcFilePath, $this->m_YcFileName ) . ".log";
        } else {
            $path = $this->getLogFilePath ( $this->m_YcFilePath, $this->m_YcFileName ) . "_error.log";
        }

        $handle = @fopen ( $path, "a+" );
        if ($handle === false) {
            return;
        }
        $datestr = strftime ( "%Y-%m-%d %H:%M:%S " );
        $caller_info = $this->GetCallerInfo ();

        if (! @fwrite ( $handle, "[".$datestr.$caller_info."] " . $log . "\n" )) {
        }

        @fclose ( $handle );
        $this->RotaLog ();

	}
	private function GetCallerInfo() {
		$ret = debug_backtrace (DEBUG_BACKTRACE_IGNORE_ARGS);
		foreach ( $ret as $item ) {
			$file_name = basename ( $item ['file'] );
			if (isset ( $item ['file'] ) && 'LoggerUtils.php' == $file_name) {
				continue;
			}

			return "{$file_name}:{$item['line']}";
		}
	}
	private function RotaLog() {
		if ($this->m_YcErrorFlag == 0) {
			$file_path = $this->getLogFilePath ( $this->m_YcFilePath, $this->m_YcFileName ) . ".log";
		} else {
			$file_path = $this->getLogFilePath ( $this->m_YcFilePath, $this->m_YcFileName ) . "_error.log";
		}

		if ($this->m_YcLogCount % 10 == 0)
			clearstatcache ();
		++ $this->m_YcLogCount;
		$file_stat_info = stat ( $file_path );
		if ($file_stat_info === FALSE)
			return;
		if ($this->m_YcRotaType != 1)
			return;

		if ($file_stat_info ['size'] < $this->m_YcRotaParam)
			return;

		if ($this->m_YcErrorFlag == 0) {
			$raw_file_path = $this->getLogFilePath ( $this->m_YcFilePath, $this->m_YcFileName );
		} else {
			$raw_file_path = $this->getLogFilePath ( $this->m_YcFilePath, $this->m_YcFileName ) . "_error";
		}

		$file_path = $raw_file_path . ($this->m_YcMaxLogFileNum - 1) . ".log";

		if ($this->isExist ( $file_path )) {
			unlink ( $file_path );
		}
		for($i = $this->m_YcMaxLogFileNum - 2; $i >= 0; $i --) {
			if ($i == 0)
				$file_path = $raw_file_path . ".log";
			else
				$file_path = $raw_file_path . $i . ".log";

			if ($this->isExist ( $file_path )) {
				$new_file_path = $raw_file_path . ($i + 1) . ".log";
				if (rename ( $file_path, $new_file_path ) < 0) {
					continue;
				}
			}
		}
	}
	private function isExist($path) {
		return file_exists ( $path );
	}

	private function createDir($dir) {
		return mkdir($dir, 0777, true);
	}

	private function createLogFile($path) {
		$handle = @fopen ( $path, "w" );
		@fclose ( $handle );
		return $this->isExist ( $path );
	}

	private function getLogFilePath($dir, $filename) {
		return $dir . "/" . $filename;
	}
	const LEVEL_EMERG = 0;
	const LEVEL_FATAL = 0;
	const LEVEL_ALERT = 100;
	const LEVEL_CRIT = 200;
	const LEVEL_ERROR = 300;
	const LEVEL_WARN = 400;
	const LEVEL_NOTICE = 500;
	const LEVEL_INFO = 600;
	const LEVEL_DEBUG = 700;
}