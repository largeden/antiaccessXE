<?php
    /**
     * @class  antiaccessIndex
     * @author largeden (cbrghost@gmail.com)
     * @brief  antiaccessXE Index class
     **/

    class antiaccessIndex {

        var $remote_addr = '';
        var $cache_white_path = "files/cache/antiaccess/white/";
        var $cache_ban_path = "files/cache/antiaccess/ban/";
        var $cache_block_path = "files/cache/antiaccess/block/";

        /**
         * @brief is_admin을 검사하고 차단 기능을 수행
         **/
        function init() {
            // 세선을 확인하여 관리자 권한이면 캐시 기능을 수행하지 않음
            session_start();
            if(@$_SESSION['logged_info']) {
                $logged_info = $_SESSION['logged_info'];
                if($logged_info->is_admin == 'Y') return false;
            }
//            session_destroy();

            define('_ANTI_CACHE_PATH_', str_replace('index.php', '', str_replace('\\', '/', __FILE__)));
            $this->procAntiaccess();
        }

        /**
         * @brief 유일한 antiaccessIndex 객체를 반환 (Singleton)
         * antiaccessIndex는 어디서든 객체 선언없이 사용하기 위해서 static 하게 사용
         **/
        function &getInstance() {
            static $theInstance;
            if(!isset($theInstance)) $theInstance = new antiaccessIndex();
            return $theInstance;
        }

        /**
         * @brief changes path of target file, directory into absolute path
         * @param[in] $source path
         * @return absolute path
         **/
        function getRealPath($source) {
            $temp = explode('/', $source);
            if($temp[0] == '.') $source = _ANTI_CACHE_PATH_.substr($source, 2);
            return $source;
        }

        /**
         * @brief returns the content of the file
         * @param[in] $file_name path of target file
         * @return the content of the file. if target file does not exist, this function returns nothing.
         **/
        function readFile($file_name) {
            $file_name = $this->getRealPath($file_name);

            if(!file_exists($file_name)) return;
            $filesize = filesize($file_name);
            if($filesize<1) return;

            if(function_exists('file_get_contents')) return file_get_contents($file_name);

            $fp = fopen($file_name, "r");
            $buff = '';
            if($fp) {
                while(!feof($fp) && strlen($buff)<=$filesize) {
                    $str = fgets($fp, 1024);
                    $buff .= $str;
                }
                fclose($fp);
            }
            return $buff;
        }

        /**
         * @brief write $buff into the specified file
         * @param[in] $file_name path of target file
         * @param[in] $buff content to be writeen
         * @param[in] $mode a(append) / w(write)
         * @return none
         **/
        function writeFile($file_name, $buff, $mode = "w") {
            $file_name = $this->getRealPath($file_name);

            $mode = strtolower($mode);
            if($mode != "a") $mode = "w";
            if(@!$fp = fopen($file_name,$mode)) return false;
            fwrite($fp, $buff);
            fclose($fp);
            @chmod($file_name, 0644);
        }

        /**
         * @brief 차단 검사 (캐시용)
         **/
        function procAntiaccess() {
            // Antiaccess config load
            $anti_config = $this->readFile(_ANTI_CACHE_PATH_.'files/antiaccess/config/config');
            if(!$anti_config) return;
            $anti_config = unserialize($anti_config);

            $act = @$_REQUEST['act'];

            // 제외 act일 경우 차단 검사 수행 안함
            if($anti_config->not_act) {
                $acts = explode(',',$anti_config->not_act);
                if(in_array($act, $acts)) return;
            }

            // remote ip create
            $this->remote_addr = $_SERVER['REMOTE_ADDR'];

            // White IP check
            if($anti_config->use->use_white == 'Y' && $anti_config->cache->cache_type <= 2) {
                $buff = $this->readFile($this->cache_white_path.$this->remote_addr);
                if($buff == "Y") return false;
            }

            // Ban IP check
            if($anti_config->use->use_banned == 'Y' && $anti_config->cache->cache_type <= 2) {
                $buff = $this->readFile($this->cache_ban_path.$this->remote_addr);
                if($buff == "Y") $this->procAntiaccessStop($anti_config);
            }

            // Block IP check
            if($anti_config->use->use_block != 'Y' && $anti_config->cache->cache_type <= 2) {
                $buff = $this->readFile($this->cache_block_path.$this->remote_addr);
                if($buff == "Y") {
                    // 차단 지정시간보다 짧은 시간에 접속할 경우 다시 차단 지정시간만큼 차단 진행
                    $last_update = date('YmdHis', filemtime($this->cache_block_path.$this->remote_addr));
                    $limit_period = strtotime(date('YmdHis')) - strtotime($last_update);
                    $limit_block = sprintf('-%d minutes', $anti_config->block->limit_block);
                    $limit_interval = strtotime(date('YmdHis')) - strtotime($limit_block);

                    if($limit_interval > $limit_period) {
                        $this->writeFile($this->cache_block_path.$this->remote_addr, "Y", 'w');
                        $this->procAntiaccessStop($anti_config);
                    }
                }
            }
        }

        /**
         * @brief 차단, 금지 Header 출력
         **/
        function procAntiaccessStop($anti_config) {
            $code = $anti_config->header->code;
            $header = array(
                '403' => "Forbidden",
                '404' => "Not Found",
            );
            $header_message = sprintf("%s %s", $code, $header[$code]);
            header("HTTP/1.0 ".$header_message);
            header("Status: ".$header_message);
            header("Content-Type: text/html; charset=UTF-8");
            $html = sprintf(
                '<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN"><html lang="en" xml:lang="en"><head><title>'.
                '%s</title></head><body><h1>%s</h1>'.$anti_config->header->msg.'</body></html>',
                $header_message, $header[$code]
            );

            die($html);
            return new Object();
        }
    }

    if(!defined('__XE__')) define('__XE__',   true);

    $antiaccessIndex = &antiaccessIndex::getInstance();
    $antiaccessIndex->init();
?>