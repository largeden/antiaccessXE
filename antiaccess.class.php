<?php
    /**
     * @class  antiaccess
     * @author largeden (cbrghost@gmail.com)
     * @brief  antiaccessXE Class
     **/

    class antiaccess extends ModuleObject {

        var $antiaccess_version = '1.0.3.1';
        var $remote_addr = '';
        var $cache_white_path = "files/cache/antiaccess/white/";
        var $cache_country_path = "files/cache/antiaccess/country/";
        var $cache_ban_path = "files/cache/antiaccess/ban/";
        var $cache_block_path = "files/cache/antiaccess/block/";
        var $ftpConn = '';
        var $ftp_password = '';
        var $ftp_info = array();

        /**
         * @brief 설치시 추가 작업이 필요할시 구현
         **/
        function moduleInstall() {
            $oModuleController = &getController('module');

            $oModuleController->insertTrigger('moduleObject.proc', 'antiaccess', 'controller', 'procAntiaccess', 'before');
            $oModuleController->insertTrigger('antiaccess.insertAntiaccessFollowhost', 'antiaccess', 'model', 'getAntiaccessFollowCheck', 'before');
            $oModuleController->insertTrigger('antiaccess.insertAntiaccessFollowhost', 'antiaccess', 'model', 'getAntiaccessFollowSync', 'after');
            $oModuleController->insertTrigger('antiaccess.updateAntiaccessFollowhost', 'antiaccess', 'controller', 'procAntiaccessFollowSync', 'after');
            $oModuleController->insertTrigger('antiaccess.deleteAntiaccessFollowhost', 'antiaccess', 'controller', 'procAntiaccessFollowDelete', 'before');
            $oModuleController->insertTrigger('antiaccess.insertAntiaccessBanip', 'antiaccess', 'controller', 'insertAntiaccessBanipPush', 'after');
            $oModuleController->insertTrigger('antiaccess.insertAntiaccessWhiteip', 'antiaccess', 'controller', 'insertAntiaccessWhiteipPush', 'after');
            $oModuleController->insertTrigger('antiaccess.deleteAntiaccessBanip', 'antiaccess', 'controller', 'deleteAntiaccessBanipPush', 'before');
            $oModuleController->insertTrigger('antiaccess.deleteAntiaccessWhiteip', 'antiaccess', 'controller', 'deleteAntiaccessWhiteipPush', 'before');

            $oFileHandler = new FileHandler();
            $oFileHandler->makeDir(_XE_PATH_."files/antiaccess/config/");
            $oFileHandler->makeDir(_XE_PATH_."files/antiaccess/index/");

            return new Object();
        }

        /**
         * @brief 설치가 이상이 없는지 체크하는 method
         **/
        function checkUpdate() {
			$oDB = &DB::getInstance();
            $oModuleModel = &getModel('module');

            if(!is_dir(_XE_PATH_."files/antiaccess/config/")) return true;

            $anti_config = $oModuleModel->getModuleConfig('antiaccess');
            if(!$anti_config->rank) return true;

			if(!$oDB->isColumnExists("antiaccess_access_ip","country_code")) return true;
			if(!$oDB->isColumnExists("antiaccess_ban_ip","country_code")) return true;
			if(!$oDB->isColumnExists("antiaccess_white_ip","country_code")) return true;
			if(!$oDB->isColumnExists("antiaccess_ban_ip","public")) return true;
			if(!$oDB->isColumnExists("antiaccess_white_ip","public")) return true;
			if(!$oDB->isColumnExists("antiaccess_follow_host","extra_vars")) return true;

            return false;
        }

        /**
         * @brief 업데이트 실행
         **/
        function moduleUpdate() {
			$oDB = &DB::getInstance();
            $oModuleModel = &getModel('module');
            $oModuleController = &getController('module');
            $oAntiaccessModel = &getModel('antiaccess');
            $anti_config = $oModuleModel->getModuleConfig('antiaccess');
            
            if(!is_dir(_XE_PATH_."files/antiaccess/config/")) {
                // 캐시용 index.php에서 처리하기 위해 기본 설정을 파일로 저장
                $anti_config = serialize($anti_config);
                $oFileHandler = new FileHandler();
                $oFileHandler->writeFile(_XE_PATH_."files/antiaccess/config/config", $anti_config, 'w');
                $oFileHandler->copyFile(_XE_PATH_."modules/antiaccess/tpl/index/index.bak.php", _XE_PATH_."files/antiaccess/index/index.bak.php", 'Y');
            }

            if(!$anti_config->rank) {
                $anti_config->rank = 'S';
	            $oModuleController->insertModuleConfig('antiaccess', $anti_config);

				// XML
				$body->act = 'procAntiaccessRankCheckApi';
	            $buff = $oAntiaccessModel->sendRequest(Context::getRequestUri(), $body, false);
			}

			if(!$oDB->isColumnExists("antiaccess_access_ip", "country_code"))
			{
				$oDB->addColumn('antiaccess_access_ip', 'country_code', 'char', 2, '', true);
			}

			if(!$oDB->isColumnExists("antiaccess_ban_ip", "country_code"))
			{
				$oDB->addColumn('antiaccess_ban_ip', 'country_code', 'char', 2, '', true);
			}

			if(!$oDB->isColumnExists("antiaccess_white_ip", "country_code"))
			{
				$oDB->addColumn('antiaccess_white_ip', 'country_code', 'char', 2, '', true);
			}

			if(!$oDB->isColumnExists("antiaccess_ban_ip", "public"))
			{
				$oDB->addColumn('antiaccess_ban_ip', 'public', 'char', 1, 'N', true);
			}

			if(!$oDB->isColumnExists("antiaccess_white_ip", "public"))
			{
				$oDB->addColumn('antiaccess_white_ip', 'public', 'char', 1, 'N', true);
			}

			if(!$oDB->isColumnExists("antiaccess_follow_host", "extra_vars"))
			{
				$oDB->addColumn('antiaccess_follow_host', 'extra_vars', 'text');
			}

            return new Object(0,'success_updated');
        }

        /**
         * @brief 모듈 제거
         **/
        function moduleUninstall() {
            /* 캐시 사용 중일 경우 원본 index.php를 복구 */
            $this->ftp_password = Context::get('ftp_password');

            $oFileHandler = new FileHandler();
            $index_path = _XE_PATH_."index.php";
            $index_bak_path = _XE_PATH_."files/antiaccess/index/index.bak.php";

            $file_buff = $oFileHandler->readFile($index_path);
            preg_match_all("!\[@@([^\>]*)\@@]!is", $file_buff, $index_ver);

            if(@$index_ver[1][0] == "Anti-accessXE") { 
                // 백업시켰던 파일이 존재할 경우
                if(is_file($index_bak_path)) {
                    // FTP 로그인
                    if($this->ftpConn()) {
                        // 복사가 붙여넣기가 가능하도록 퍼미션을 변경
                        if($this->ftpChmod(0777, "index.php")) {
                            // 백업 시켰던 index.php파일을 복구시킴(복사 overwrite)
                            $oFileHandler->copyFile($index_bak_path, $index_path, 'Y');
                            // 백업파일을 삭제
                            $oFileHandler->removeFile($index_bak_path);

                            // 퍼미션을 원래대로 복구
                            $this->ftpChmod(0644, "index.php");
                        }

                        // FTP 종료
                        $this->FtpDisConn();
                    }
                } else return new Object(-1, "msg_backup_fail");
            }

            $oModuleModel = &getModel('module');
            $oModuleController = &getController('module');
            $oAntiaccessModel = &getModel('antiaccess');
            $oAntiaccessController = &getController('antiaccess');
            $oDB = &DB::getInstance();

            // antiaccess module config delete
            $args->module = 'antiaccess';
            $output = executeQuery('module.deleteModuleConfig', $args);
            if(!$output->toBool()) { $oDB->rollback(); return; }

            // Follow Host Delete
            $output = $oAntiaccessModel->getAntiaccessFollowhostTotal();
            foreach($output as $val) $oAntiaccessController->deleteAntiaccessFollowhost($val);

            // Trigger Delete
            if($oModuleModel->getTrigger('moduleObject.proc', 'antiaccess', 'controller', 'procAntiaccess', 'before'))
                $oModuleController->deleteTrigger('moduleObject.proc', 'antiaccess', 'controller', 'procAntiaccess', 'before');
            if($oModuleModel->getTrigger('antiaccess.insertAntiaccessFollowhost', 'antiaccess', 'model', 'getAntiaccessFollowCheck', 'before'))
                $oModuleController->deleteTrigger('antiaccess.insertAntiaccessFollowhost', 'antiaccess', 'model', 'getAntiaccessFollowCheck', 'before');
            if($oModuleModel->getTrigger('antiaccess.insertAntiaccessFollowhost', 'antiaccess', 'model', 'getAntiaccessFollowSync', 'after'))
                $oModuleController->deleteTrigger('antiaccess.insertAntiaccessFollowhost', 'antiaccess', 'model', 'getAntiaccessFollowSync', 'after');
            if($oModuleModel->getTrigger('antiaccess.updateAntiaccessFollowhost', 'antiaccess', 'controller', 'procAntiaccessFollowSync', 'after'))
                $oModuleController->deleteTrigger('antiaccess.updateAntiaccessFollowhost', 'antiaccess', 'controller', 'procAntiaccessFollowSync', 'after');
            if($oModuleModel->getTrigger('antiaccess.deleteAntiaccessFollowhost', 'antiaccess', 'controller', 'procAntiaccessFollowDelete', 'before'))
                $oModuleController->deleteTrigger('antiaccess.deleteAntiaccessFollowhost', 'antiaccess', 'controller', 'procAntiaccessFollowDelete', 'before');
            if($oModuleModel->getTrigger('antiaccess.insertAntiaccessBanip', 'antiaccess', 'controller', 'insertAntiaccessBanipPush', 'after'))
                $oModuleController->deleteTrigger('antiaccess.insertAntiaccessBanip', 'antiaccess', 'controller', 'insertAntiaccessBanipPush', 'after');
            if($oModuleModel->getTrigger('antiaccess.insertAntiaccessWhiteip', 'antiaccess', 'controller', 'insertAntiaccessWhiteipPush', 'after'))
                $oModuleController->deleteTrigger('antiaccess.insertAntiaccessWhiteip', 'antiaccess', 'controller', 'insertAntiaccessWhiteipPush', 'after');
            if($oModuleModel->getTrigger('antiaccess.deleteAntiaccessBanip', 'antiaccess', 'controller', 'deletetAntiaccessBanipPush', 'before'))
                $oModuleController->deleteTrigger('antiaccess.deleteAntiaccessBanip', 'antiaccess', 'controller', 'deleteAntiaccessBanipPush', 'before');
            if($oModuleModel->getTrigger('antiaccess.deleteAntiaccessWhiteip', 'antiaccess', 'controller', 'deleteAntiaccessWhiteipPush', 'before'))
                $oModuleController->deleteTrigger('antiaccess.deleteAntiaccessWhiteip', 'antiaccess', 'controller', 'deleteAntiaccessWhiteipPush', 'before');

            // Table Delete
            $table_list = array(
                'antiaccess_access_ip',
                'antiaccess_ban_host',
                'antiaccess_ban_ip',
                'antiaccess_follow_host',
                'antiaccess_ipv4_log',
                'antiaccess_white_ip'
            );

            foreach($table_list as $table_name) {
                if($oDB->isTableExists($table_name)) {
                    $oDB->begin();
                    $result = $oDB->_query(sprintf("drop table %s%s", $oDB->prefix, $table_name));
                    if($oDB->isError()) { $oDB->rollback(); return; }
                }
            }

            // commit
            $oDB->commit();

            // Cache & Config Delete
            @FileHandler::removeDir(_XE_PATH_."files/cache/antiaccess");
            @FileHandler::removeDir(_XE_PATH_."files/antiaccess");
            return new Object();
        }

        /**
         * @brief 캐시 파일 재생성
         **/
        function recompileCache() {
            $oModuleModel = &getModel('module');
            $oAntiaccessModel = &getModel('antiaccess');
            $oFileHandler = new FileHandler();
            $anti_config = $oModuleModel->getModuleConfig('antiaccess');

            if($anti_config->cache->cache_type >= 2) return;

            // 금지IP와 비금지IP에 대해서만 캐시 파일을 다시 생성합니다.
            $args->apply = 'Y';
            $output = $oAntiaccessModel->getAntiaccessWhiteipTotal($args);
            foreach($output as $val) $oFileHandler->writeFile($this->cache_white_path.$val->ipaddress, "Y", 'w');

            $output = $oAntiaccessModel->getAntiaccessBanipTotal($args);
            foreach($output as $val) $oFileHandler->writeFile($this->cache_ban_path.$val->ipaddress, "Y", 'w');

            return false;
        }

        /**
         * @brief version check
         **/
        function checkVersion() {
            $body = '<?xml version="1.0" encoding="utf-8" ?>
                <methodCall>
                <params>
                <module><![CDATA[resource]]></module>
                <act><![CDATA[getResourceItems]]></act>
                <module_srl><![CDATA[18322904]]></module_srl>
                <package_srl><![CDATA[19323693]]></package_srl>
                <list_count><![CDATA[1]]></list_count>
                </params>
                </methodCall>';
            $buff = @FileHandler::getRemoteResource('http://www.xpressengine.com', $body, 3, 'POST', 'application/xml');

            if($buff) {
                 $oXmlParser = new XmlParser();
                 $xml = $oXmlParser->parse($buff);

                 if($this->antiaccess_version != $xml->response->items->item->version->body) return true;
            }
        }

        /**
         * @brief Ftp connected
         **/
        function ftpConn() {
            require_once(_XE_PATH_."files/config/ftp.config.php");
            $this->ftp_info = $ftp_info;

            $this->ftpConn = ftp_connect($this->ftp_info->ftp_host, $this->ftp_info->ftp_port);
            if(!$this->ftpConn) return false;

            if(@ftp_login($this->ftpConn, $this->ftp_info->ftp_user, $this->ftp_password)) {
                if($ftp_info->ftp_pasv == 'Y') ftp_pasv($this->ftpConn, true);
            } else return false;

            return true;
        }

        /**
         * @brief Ftp Chmod (퍼미션 변경)
         **/
        function ftpChmod($chmod = null, $path = null) {
            if(!$chmod || !$path) return false;
            require_once(_XE_PATH_."files/config/ftp.config.php");

            if(@ftp_chmod($this->ftpConn, $chmod, $this->ftp_info->ftp_root_path.$path)) return true;

            return false;
        }

        /**
         * @brief Ftp disconnected
         **/
        function ftpDisConn() {
            @ftp_close($this->ftpConn);
        }

        /**
         * @brief Table Optimize (단편화를 최적화 합니다.)
         **/
        function optimize() {
            $oModuleModel = &getModel('module');
            $oModuleController = &getController('module');
            $anti_config = $oModuleModel->getModuleConfig('antiaccess');

            // 최적화 사용 주기를 설정하지 않을 경우 수행 중단
            if(!$anti_config->optimize->date) return false;

            // 최적화 사용 주기마다 수행
            $time = date('Ymd', strtotime(sprintf('-%d days', $anti_config->optimize->date)));
            if($anti_config->optimize->checkdate && ($anti_config->optimize->checkdate > $time)) return false;

            // 마지막 수행 시간 저장
            $anti_config->optimize->checkdate = date('Ymd');
            $oModuleController->insertModuleConfig('antiaccess', $anti_config);

            $oDB = &DB::getInstance();
            // Optimize 기능이 사용되는 종류의 데이터베이스가 아니면 수행 중단
            if(!in_array(Context::getDBType(), array('mysql','mysql_innodb','mysqli'))) return false;

            // Anti-accessXE에서 사용하는 테이블들의 단편화 현황을 보기 위해 검색
            $query = sprintf("show table status where name in('%s','%s','%s','%s','%s','%s')",
                $oDB->prefix.'antiaccess_access_ip',
                $oDB->prefix.'antiaccess_ban_host',
                $oDB->prefix.'antiaccess_ban_ip',
                $oDB->prefix.'antiaccess_follow_host',
                $oDB->prefix.'antiaccess_ipv4_log',
                $oDB->prefix.'antiaccess_white_ip');

            $result = $oDB->_query($query);
            if($oDB->isError()) return false;
            $output = $oDB->_fetch($result);
            if(!$output) $output = array();

            foreach($output as $val) {
                // 단편화가 이루어져있는 대상만 최적화 함
                if($val->Data_free == 0) {
                    $oDB->_query(sprintf("optimize table `%s`", $val->Name));
                    if($oDB->isError()) continue;
                }
            }

            return true;
        }
    }
?>