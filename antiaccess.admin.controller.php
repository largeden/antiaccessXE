<?php
    /**
     * @class  antiaccessAdminController
     * @author largeden (cbrghost@gmail.com)
     * @brief  antiaccessXE admin controller class
     **/

    class antiaccessAdminController extends antiaccess {

        /**
         * @brief 초기화
         **/
        function init() {
            $oModuleModel = &getModel('module');
            $anti_config = $oModuleModel->getModuleConfig('antiaccess');
            Context::set('anti_config', $anti_config);
        }

        /**
         * @brief 기본 설정
         **/
        function procAntiaccessAdminInsertConfig() {
            $oModuleController = &getController('module');
            $args = Context::getRequestVars();
            $anti_config = Context::get('anti_config');

            $anti_config->header->code = $args->code?$args->code:403;
            $anti_config->header->msg = $args->msg;

            $anti_config->block->limit_time = $args->limit_time;
            $anti_config->block->limit_count = $args->limit_count;
            $anti_config->block->limit_display = $args->limit_display;
            $anti_config->block->limit_rss = $args->limit_rss;
            $anti_config->block->limit_atom = $args->limit_atom;
            $anti_config->block->limit_trackback = $args->limit_trackback;
            $anti_config->block->limit_act = $args->limit_act;
            $anti_config->block->limit_block = $args->limit_block;

            $anti_config->not_act = $args->not_act;

            $anti_config->banned->occur_count = $args->occur_count;

            if($args->white_groups) {
                $args->white_groups = explode('|@|',$args->white_groups);
                if(is_array($args->white_groups)) foreach($args->white_groups as $val) $white_groups[$val] = true;
                elseif(!$args->white_groups) $white_groups = null;
                else $white_groups = array($args->white_groups=>true);
                $anti_config->white_groups = $white_groups;
            } else $anti_config->white_groups = $args->white_groups;

            $anti_config->cache->cache_type = $args->cache_type?$args->cache_type:1;

            /* 캐시용 index.php로 복사하고 원본은 백업 (※ FTP 계정에 XE 기본설정에 설정되어있어야 함) */
            $oFileHandler = new FileHandler();
            $index_path = _XE_PATH_."index.php";
            $index_bak_path = _XE_PATH_."files/antiaccess/index/index.bak.php";
            $index_antiaccess_path = _XE_PATH_."modules/antiaccess/tpl/index/index.php";
            $file_buff = $oFileHandler->readFile($index_path);

            if($args->ftp_password) {
                $this->ftp_password = $args->ftp_password;

                // 캐시 적용일 경우
                if($args->cache_index == true) {
                    preg_match_all("!\[@@([^\>]*)\@@]!is", $file_buff, $index_ver);

                    // 이미 캐시 적용이 되었는지 확인 후 과거버전이거나 적용이 안되어 있다면 index.php을 백업 후 적용
                    if(@$index_ver[1][0] != "Anti-accessXE") {
                        // FTP 로그인
                        if($this->ftpConn()) {
                            // 복사가 붙여넣기가 가능하도록 퍼미션을 변경
                            if($this->ftpChmod(0777, "index.php")) {
                                // 백업 시킴
                                $oFileHandler->copyFile($index_path, $index_bak_path, 'Y');
                                // Anti-accessXE 캐시용 index.php파일을 적용시킴(복사 overwrite)
                                $oFileHandler->copyFile($index_antiaccess_path, $index_path, 'Y');

                                // 퍼미션을 원래대로 복구
                                $this->ftpChmod(0644, "index.php");

                                // 캐시 설정을 위해 index.php이 복사가 완료 될 경우 기능 적용 설정을 함
                                $anti_config->cache->cache_index = $args->cache_index;
                            }

                            // FTP 종료
                            $this->FtpDisConn();
                        }
                    }
                } else { // 캐시 비적용일 경우
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

                                // 캐시 설정을 위해 index.php이 복사가 완료 될 경우 기능 적용 설정을 함
                                $anti_config->cache->cache_index = $args->cache_index;
                            }

                            // FTP 종료
                            $this->FtpDisConn();
                        }
                    }
                }
            } else {
                // 수작업으로 캐시기능을 적용할 경우 캐시 기능 적용하기
                preg_match_all("!\[@@([^\>]*)\@@]!is", $file_buff, $index_ver);

                // 이미 캐시 적용이 되었는지 확인 후 적용 되었을 경우 캐시 기능 설정
                if(@$index_ver[1][0] == "Anti-accessXE") $anti_config->cache->cache_index = $args->cache_index;
            }

            // DB Table Optimize 기간 설정
            $anti_config->optimize->date = $args->optimize_date;

            $oModuleController->insertModuleConfig('antiaccess', $anti_config);

            // 캐시용 index.php에서 처리하기 위해 기본 설정을 파일로 저장
            $anti_config = serialize($anti_config);
            @FileHandler::writeFile("files/antiaccess/config/config", $anti_config, 'w');

            $this->setMessage("success_saved");
        }

        /**
         * @brief 국가 접근 설정
         **/
        function procAntiaccessAdminInsertCountry() {
            $oModuleController = &getController('module');
            $anti_config = Context::get('anti_config');

        	$args = Context::gets('country_code', 'country_conn');
        	if($args->country_code)
        	{
				$country_code = explode(',', $args->country_code);
				foreach($country_code as $val)
				{
					if(!$val) continue;
					$anti_config->country->code[$val] = TRUE;
				}
			}

			if($args->country_conn)
			{
				$anti_config->country->conn = $args->country_conn;
			}

            $oModuleController->insertModuleConfig('antiaccess', $anti_config);

            $this->setMessage('success_registed');
			if (Context::get('success_return_url')){
				$this->setRedirectUrl(Context::get('success_return_url'));
			}else{
				$this->setRedirectUrl(getNotEncodedUrl('', 'module', 'admin', 'act', 'dispAntiaccessAdminConfig'));
			}
        }

        /**
         * @brief Anti-access 차단, 금지, 비금지 사용 여부 설정
         **/
        function procAntiaccessAdminInsertUse() {
            $oModuleController = &getController('module');
            $anti_config = Context::get('anti_config');

            $args = Context::getRequestVars();

            if($args->use_block) $anti_config->use->use_block = $args->use_block;
            if($args->use_banned) $anti_config->use->use_banned = $args->use_banned;
            if($args->use_white) $anti_config->use->use_white = $args->use_white;
            if($args->use_country) $anti_config->use->use_country = $args->use_country;

            $oModuleController->insertModuleConfig('antiaccess', $anti_config);

            // 캐시용 index.php에서 처리하기 위해 기본 설정을 파일로 저장
            $anti_config = serialize($anti_config);
            @FileHandler::writeFile("modules/antiaccess/config/config", $anti_config, 'w');

            $this->setMessage("success_saved");
        }

        /**
         * @brief 금지 ip 추가
         **/
        function procAntiaccessAdminInsertBanip() {
            $oAntiaccessModel = &getModel('antiaccess');
            $oAntiaccessController = &getController('antiaccess');
            $anti_config = Context::get('anti_config');

            // 등록하려는 IP가 비공인 IP라면 추가하지 않음
            $args = Context::gets('ipaddress', 'public');
//            if(!$oAntiaccessModel->checkIpaddress($args->ipaddress)) return new Object(-1, "msg_invalid_ipaddress");
            // 등록을 시도하는 HOST가 비공인 IP라면 추가하지 않음
            $request_uri = $oAntiaccessModel->parseUri(Context::get('request_uri'), 'www');
//            if(!$oAntiaccessModel->checkIpaddress($request_uri['host'], true)) return new Object(-1, "msg_invalid_host");

            $is_banip = $oAntiaccessModel->getAntiaccessBanipCount($args);
            if($is_banip) return new Object(-1, "msg_ipaddress_exists");

            // 캐시 이용이 차단과 동시에 사용이라면 캐시 생성
            if($anti_config->cache->cache_type == 1) @FileHandler::writeFile($this->cache_ban_path.$args->ipaddress, "Y", 'w');

            // 새로운 IP이기 때문에 등록자가 Source Host가 됨
            $uri = $oAntiaccessModel->parseUri(Context::get('request_uri'), 'www');
            $args->source_host = $uri['host'];
            $args->apply = 'Y';
            if($args->public != 'Y')
            {
            	$args->mode = 'sync';
            }

            $oAntiaccessController->insertAntiaccessBanip($args);
            $this->setMessage("success_registed");
        }

        /**
         * @brief 금지 ip 적용 상태 변경
         **/
        function procAntiaccessAdminUpdateBanipApply() {
            $oAntiaccessModel = &getModel('antiaccess');
            $oAntiaccessController = &getController('antiaccess');
            $anti_config = Context::get('anti_config');

            $args = Context::gets('ban_srl','apply');
            if(!$args->ban_srl || !$args->apply) return new Object(-1, "msg_invalid_request");

            // ban_srl로 해당 ipaddress를 구함
            $ipaddress = $oAntiaccessModel->getAntiaccessSrlByIp('ban', $args->ban_srl);

            // 캐시 이용이 차단과 동시에 사용이라면 캐시 생성
            if($anti_config->cache->cache_type == 1) {
               if($args->apply == 'Y') @FileHandler::writeFile($this->cache_ban_path.$ipaddress, "Y", 'w');
               else @FileHandler::removeFile($this->cache_ban_path.$ipaddress);
            }

            $oAntiaccessController->updateAntiaccessBanip($args);
            $this->setMessage("success_updated");
        }

        /**
         * @brief 금지 ip 삭제
         **/
        function procAntiaccessAdminDeleteBanip() {
            $oAntiaccessModel = &getModel('antiaccess');
            $oAntiaccessController = &getController('antiaccess');

            $args = Context::gets('cart');
            if(!$args->cart) return new Object(-1, "msg_not_checks");
            $args->cart = explode('|@|',$args->cart);
            $args->ban_srl = implode(',',$args->cart);

            foreach($args->cart as $val) {
                $ipaddress = $oAntiaccessModel->getAntiaccessSrlByIp('ban', $val);
                // 캐시 ip 삭제
                @FileHandler::removeFile($this->cache_ban_path.$ipaddress);
            }

            $oAntiaccessController->deleteAntiaccessBanip($args);
            $this->setMessage("success_deleted");
        }

        /**
         * @brief 금지 ip 공개 상태 변경
         **/
        function procAntiaccessAdminUpdateBanipPublic() {
            $oAntiaccessModel = &getModel('antiaccess');
            $oAntiaccessController = &getController('antiaccess');

            $args = Context::gets('ban_srl', 'public');
            if(!$args->ban_srl || !$args->public) return new Object(-1, "msg_invalid_request");

            if($args->public == 'Y')
            {
	            $oBanip = $oAntiaccessModel->getAntiaccessBanipInfo($args);
				$obj->ipaddress = $oBanip->ipaddress;
	            $obj->source_host = $oBanip->source_host;
            	$oAntiaccessController->insertAntiaccessBanipPush($obj);
            }
            elseif($args->public == 'N')
            {
            	$obj->cart[] = $args->ban_srl;
            	$oAntiaccessController->deleteAntiaccessBanipPush($obj);
            }

            $oAntiaccessController->updateAntiaccessBanip($args);
            $this->setMessage("success_updated");
        }

        /**
         * @brief 비금지 ip 추가
         **/
        function procAntiaccessAdminInsertWhiteip() {
            $oAntiaccessModel = &getModel('antiaccess');
            $oAntiaccessController = &getController('antiaccess');
            $anti_config = Context::get('anti_config');

            // 등록하려는 IP가 비공인 IP라면 추가하지 않음
            $args = Context::gets('ipaddress', 'public');
            //if(!$oAntiaccessModel->checkIpaddress($args->ipaddress)) return new Object(-1, "msg_invalid_ipaddress");
            // 등록을 시도하는 HOST가 비공인 IP라면 추가하지 않음
            $request_uri = $oAntiaccessModel->parseUri(Context::get('request_uri'), 'www');
            //if(!$oAntiaccessModel->checkIpaddress($request_uri['host'], true)) return new Object(-1, "msg_invalid_host");

            $is_whiteip = $oAntiaccessModel->getAntiaccessWhiteipCount($args);
            if($is_whiteip) return new Object(-1, "msg_ipaddress_exists");

            // 캐시 이용이 차단과 동시에 사용이라면 캐시 생성
            if($anti_config->cache->cache_type == 1) @FileHandler::writeFile($this->cache_white_path.$args->ipaddress, "Y", 'w');

            // 새로운 IP이기 때문에 등록자가 Source Host가 됨
            $uri = $oAntiaccessModel->parseUri(Context::get('request_uri'), 'www');
            $args->source_host = $uri['host'];
            $args->apply = 'Y';
            if($args->public != 'Y')
            {
            	$args->mode = 'sync';
            }

            $oAntiaccessController->insertAntiaccessWhiteip($args);
            $this->setMessage("success_registed");
        }

        /**
         * @brief 비금지 ip 적용 상태 변경
         **/
        function procAntiaccessAdminUpdateWhiteipApply() {
            $oAntiaccessModel = &getModel('antiaccess');
            $oAntiaccessController = &getController('antiaccess');
            $anti_config = Context::get('anti_config');

            $args = Context::gets('white_srl','apply');
            if(!$args->white_srl || !$args->apply) return new Object(-1, "msg_invalid_request");

            // white_srl로 해당 ipaddress를 구함
            $ipaddress = $oAntiaccessModel->getAntiaccessSrlByIp('white', $args->white_srl);

            // 캐시 이용이 차단과 동시에 사용이라면 캐시 생성
            if($anti_config->cache->cache_type == 1) {
               if($args->apply == 'Y') @FileHandler::writeFile($this->cache_white_path.$ipaddress, "Y", 'w');
               else @FileHandler::removeFile($this->cache_white_path.$ipaddress);
            }

            $oAntiaccessController->updateAntiaccessWhiteip($args);
            $this->setMessage("success_updated");
        }

        /**
         * @brief 비금지 ip 삭제
         **/
        function procAntiaccessAdminDeleteWhiteip() {
            $oAntiaccessModel = &getModel('antiaccess');
            $oAntiaccessController = &getController('antiaccess');

            $args = Context::gets('cart');
            if(!$args->cart) return new Object(-1, "msg_not_checks");
            $args->cart = explode('|@|',$args->cart);
            $args->white_srl = implode(',',$args->cart);

            foreach($args->cart as $val) {
                $ipaddress = $oAntiaccessModel->getAntiaccessSrlByIp('white', $val);
                // 캐시 ip 삭제
                @FileHandler::removeFile($this->cache_white_path.$ipaddress);
            }

            $oAntiaccessController->deleteAntiaccessWhiteip($args);
            $this->setMessage("success_deleted");
        }

        /**
         * @brief 비금지 ip 공개 상태 변경
         **/
        function procAntiaccessAdminUpdateWhiteipPublic() {
            $oAntiaccessModel = &getModel('antiaccess');
            $oAntiaccessController = &getController('antiaccess');

            $args = Context::gets('white_srl', 'public');
            if(!$args->white_srl || !$args->public) return new Object(-1, "msg_invalid_request");

            if($args->public == 'Y')
            {
	            $oWhiteip = $oAntiaccessModel->getAntiaccessWhiteipInfo($args);
				$obj->ipaddress = $oWhiteip->ipaddress;
	            $obj->source_host = $oWhiteip->source_host;
            	$oAntiaccessController->insertAntiaccessWhiteipPush($obj);
            }
            elseif($args->public == 'N')
            {
            	$obj->cart[] = $args->white_srl;
            	$oAntiaccessController->deleteAntiaccessWhiteipPush($obj);
            }

            $oAntiaccessController->updateAntiaccessWhiteip($args);
            $this->setMessage("success_updated");
        }

        /**
         * @brief 접근자 ip 리스트상에서 금지, 비금지 ip 설정
         **/
        function procAntiaccessAdminUpdateAccessipApply() {
            $oAntiaccessModel = &getModel('antiaccess');
            $oAntiaccessController = &getController('antiaccess');
            $anti_config = Context::get('anti_config');

            $args = Context::gets('ban','white','ipaddress');

            if((!$args->ban&&!$args->white) || !$args->ipaddress) return new Object(-1, "msg_invalid_request");

            $output = $oAntiaccessModel->getAntiaccessAccessipList($args);
            foreach($output->data as $val) $accessip_info = $val;

            if(!$accessip_info) return new Object(-1, "msg_invalid_request");

            // 새로운 IP라면 등록자가 Source Host가 됨
            $uri = $oAntiaccessModel->parseUri(Context::get('request_uri'), 'www');

            // 금지인지 비금지인지, 새로운 값인지 기존 값인지 캐시 사용인지 여부에 따른 추가, 수정 처리
            if($args->ban) {
                if($accessip_info->ban_apply) {
                    if($anti_config->cache->cache_type == 1) {
                        if($args->ban == 'Y') @FileHandler::writeFile($this->cache_ban_path.$args->ipaddress, "Y", 'w');
                        else @FileHandler::removeFile($this->cache_ban_path.$args->ipaddress);
                    }
                    $args->apply = $args->ban=='Y'?'Y':'N';
                    $oAntiaccessController->updateAntiaccessBanip($args);
                } else {
                    @FileHandler::writeFile($this->cache_ban_path.$args->ipaddress, "Y", 'w');
                    $args->source_host = $uri['host'];
                    $args->apply = 'Y';
                    $oAntiaccessController->insertAntiaccessBanip($args);
                }
            } elseif($args->white) {
                if($accessip_info->white_apply) {
                    if($anti_config->cache->cache_type == 1) {
                        if($args->white == 'Y') @FileHandler::writeFile($this->cache_white_path.$args->ipaddress, "Y", 'w');
                        else @FileHandler::removeFile($this->cache_white_path.$args->ipaddress);
                    }
                    $args->apply = $args->white=='Y'?'Y':'N';
                    $oAntiaccessController->updateAntiaccessWhiteip($args);
                } else {
                    @FileHandler::removeFile($this->cache_white_path.$args->ipaddress);
                    $args->source_host = $uri['host'];
                    $args->apply = 'Y';
                    $oAntiaccessController->insertAntiaccessWhiteip($args);
                }
            }

            $this->setMessage("success_updated");
        }

        /**
         * @brief 접근자 ip 삭제
         **/
        function procAntiaccessAdminDeleteAccessip() {
            $oAntiaccessModel = &getModel('antiaccess');
            $oAntiaccessController = &getController('antiaccess');

            $args = Context::gets('cart');
            if(!$args->cart) return new Object(-1, "msg_not_checks");
            $args->cart = explode('|@|',$args->cart);
            $args->access_srl = implode(',',$args->cart);

            foreach($args->cart as $val) {
                $ipaddress = $oAntiaccessModel->getAntiaccessSrlByIp('access', $val);
                // 캐시상에 차단된게 있다면 삭제
                @FileHandler::removeFile($this->cache_block_path.$ipaddress);
            }

            // ipv4 log에서 해당 ip의 정보를 모두 삭제
            $oAntiaccessController->deleteAntiaccessAccessip($args);
            $this->setMessage("success_deleted");
        }

        /**
         * @brief 자동 차단 해제
         **/
        function procAntiaccessAdminUpdateAccessipUnblock() {
            $oAntiaccessController = &getController('antiaccess');

            $args = Context::gets('ipaddress');
            if(!$args->ipaddress) return new Object(-1, "msg_invalid_request");
            // 캐시 삭제
            @FileHandler::removeFile($this->cache_block_path.$args->ipaddress);

            // 대상자의 모든 기록을 삭제 (차단되었던 횟수도 삭제 됨)
            $args->block = 'N';
            $args->limit_count = 0;
            $args->limit_display = 0;
            $args->limit_rss = 0;
            $args->limit_atom = 0;
            $args->limit_trackback = 0;
            $args->limit_act = 0;
            $args->module_srl = 0;
            $args->document_srl = 0;
            $args->act = '';
            $args->page = 1;
            $args->occur_count = 0;
            $oAntiaccessController->updateAntiaccessAccessip($args);
            $this->setMessage("success_updated");
        }

        /**
         * @brief 금지 Host 추가
         **/
        function procAntiaccessAdminInsertBanhost() {
            $oAntiaccessModel = &getModel('antiaccess');
            $oAntiaccessController = &getController('antiaccess');

            $args = Context::gets('host','ban_type','white_type');
            if(!$args->host) return new Object(-1, "msg_invalid_request");

            $uri = $oAntiaccessModel->parseUri($args->host, 'www');
            $request_uri = $oAntiaccessModel->parseUri(Context::get('request_uri'), 'www');
            if($uri['host'] == $request_uri['host']) return new Object(-1, "msg_request_uri_exists");
            //if(!$oAntiaccessModel->checkIpaddress($uri['host'], true) || !$oAntiaccessModel->checkIpaddress($request_uri['host'], true)) return new Object(-1, "msg_invalid_host");
            $args->host = $uri['host'];
            $is_banhost = $oAntiaccessModel->getAntiaccessBanhostCount($args);
            if($is_banhost) return new Object(-1, "msg_host_exists");

            $uri = $oAntiaccessModel->parseUri($args->host, 'www');
            $args->host = $uri['host'];
            $args->ban_type = $args->ban_type?$args->ban_type:'N';
            $args->white_type = $args->white_type?$args->white_type:'N';

            $oAntiaccessController->insertAntiaccessBanhost($args);
            $this->setMessage("success_registed");
        }

        /**
         * @brief 금지 Host 삭제
         **/
        function procAntiaccessAdminDeleteBanhost() {
            $oAntiaccessController = &getController('antiaccess');

            $args = Context::gets('cart');
            if(!$args->cart) return new Object(-1, "msg_not_checks");
            $args->cart = explode('|@|',$args->cart);
            $args->host_srl = implode(',',$args->cart);

            $oAntiaccessController->deleteAntiaccessBanhost($args);
            $this->setMessage("success_deleted");
        }

        /**
         * @brief 금지 Host 적용, 비적용 설정
         **/
        function procAntiaccessAdminUpdateBanhostType() {
            $oAntiaccessController = &getController('antiaccess');

            $args = Context::gets('host_srl','ban_type','white_type');
            if((!$args->ban_type&&!$args->white_type) || !$args->host_srl) return new Object(-1, "msg_invalid_request");

            $oAntiaccessController->updateAntiaccessBanhost($args);
            $this->setMessage("success_updated");
        }

        /**
         * @brief Follow Host 추가
         **/
        function procAntiaccessAdminInsertFollowhost() {
            $oAntiaccessModel = &getModel('antiaccess');
            $oAntiaccessController = &getController('antiaccess');

            $args = Context::gets('follow_srl','host','my_level');
            if(!$args->host || !$args->my_level) return new Object(-1, "msg_invalid_request");

            if(!preg_match("/\/$/",$args->host)) $args->host .= "/";

            $uri = $oAntiaccessModel->parseUri($args->host, 'www');
            $request_uri = $oAntiaccessModel->parseUri(Context::get('request_uri'), 'www');
            if($uri['host'] == $request_uri['host']) return new Object(-1, "msg_request_uri_exists");
//            if(!$oAntiaccessModel->checkIpaddress($uri['host'], true) || !$oAntiaccessModel->checkIpaddress($request_uri['host'], true)) return new Object(-1, "msg_invalid_host");

            if(!$args->follow_srl) {
                $obj->host = $args->host;
				$args->state = 103;
                $is_followhost = $oAntiaccessModel->getAntiaccessFollowhostCount($obj);
                if($is_followhost) return new Object(-1, "msg_host_exists");

                $output = $oAntiaccessController->insertAntiaccessFollowhost($args);
                if(!$output->toBool()) return new Object(-1, $output->message);
                $msg_code = "success_registed";
                $this->add('act','dispAntiaccessAdminFollowhost');
            } else {
                $obj->follow_srl = $args->follow_srl;
                $followhost_info = $oAntiaccessModel->getAntiaccessFollowhostInfo($obj);
                if(($followhost_info->state >= 105) && ($followhost_info->state <= 109)) return new Object(-1, "msg_synchronization");
                $output = $oAntiaccessController->updateAntiaccessFollowhost($args);
                if(!$output->toBool()) return new Object(-1, $output->message);
                $msg_code = "success_updated";
                $this->add('act','dispAntiaccessAdminInsertFollowhost');
            }

            $this->add('page', Context::get('page'));
            $this->add('follow_srl', $args->follow_srl);
            $this->setMessage($msg_code);
        }

        /**
         * @brief Follow Host 삭제
         **/
        function procAntiaccessAdminDeleteFollowhost() {
            $oAntiaccessController = &getController('antiaccess');

            $args = Context::gets('follow_srl');
            if(!$args->follow_srl) return new Object(-1, "msg_invalid_request");

            $oAntiaccessController->deleteAntiaccessFollowhost($args);

            $this->add('page',Context::get('page'));
            $this->add('act','dispAntiaccessAdminFollowhost');
            $this->setMessage("success_deleted");
        }

        /**
         * @brief 동기화 진행
         **/
        function procAntiaccessAdminSynchronization() {
            $oAntiaccessModel = &getModel('antiaccess');
            $oAntiaccessController = &getController('antiaccess');

            $args = Context::gets('follow_srl');
            if(!$args->follow_srl) return new Object(-1, "msg_invalid_request");

            $followhost_info = $oAntiaccessModel->getAntiaccessFollowhostInfo($args);
            if(!$followhost_info) return new Object(-1, "msg_invalid_request");
            if(!$followhost_info->my_level) return new Object(-1, "msg_not_my_level");

            $request_uri = $oAntiaccessModel->parseUri(Context::get('request_uri'), 'www');
            $follow_uri = $oAntiaccessModel->parseUri($followhost_info->host, 'www');

            $args->follow_key = md5($request_uri['host']."_by_".$follow_uri['host']);
            $output = $oAntiaccessController->updateAntiaccessFollowhost($args);
            if(!$output->toBool()) return new Object(-1, $output->message);

            $this->setMessage("success_synchronization");
        }
    }
?>