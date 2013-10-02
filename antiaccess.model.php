<?php
    /**
     * @class  antiaccessModel
     * @author largeden (cbrghost@gmail.com)
     * @brief  antiaccessXE Model class
     **/

    class antiaccessModel extends antiaccess {

        /**
         * @brief 초기화
         **/
        function init() {
            $oModuleModel = &getModel('module');
            $anti_config = $oModuleModel->getModuleConfig('antiaccess');
            Context::set('anti_config', $anti_config);
        }

        /**
         * @brief Ban IP 리스트 출력
         **/
        function getAntiaccessBanipList($args = null) {
            $args->order_type = in_array($args->order_type, array('asc','desc'))?$args->order_type:'desc';
            $args->page_count = $args->page_count?$args->page_count:10;

            if($args->search_keyword) {
                $args->s_source_host = $args->search_keyword;
                $args->s_follow_host = $args->search_keyword;
                $args->s_ipaddress = $args->search_keyword;
                $args->s_apply = $args->search_keyword;
                $args->s_regdate = $args->search_keyword;
            }

            $output = executeQueryArray('antiaccess.getAntiaccessBanipList', $args);
            if(!$output->toBool()) return new Object(-1, 'msg_error_occured');
            if(!$output->data) $output->data = array();

            return $output;
        }

        /**
         * @brief Ban IP 정보 출력
         **/
        function getAntiaccessBanipInfo($args = null) {
            $output = executeQuery('antiaccess.getAntiaccessBanipInfo', $args);
            if(!$output->toBool()) return new Object(-1, 'msg_error_occured');

            return $output->data;
        }

        /**
         * @brief Ban IP 전체 정보 출력
         **/
        function getAntiaccessBanipTotal($args = null) {
            $output = executeQueryArray('antiaccess.getAntiaccessBanipTotal', $args);
            if(!$output->toBool()) return new Object(-1, 'msg_error_occured');
            if(!$output->data) $output->data = array();

            return $output->data;
        }

        /**
         * @brief Ban IP 정보 갯수 확인
         **/
        function getAntiaccessBanipCount($args = null) {
            $output = executeQuery('antiaccess.getAntiaccessBanipCount', $args);
            if(!$output->toBool()) return new Object(-1, 'msg_error_occured');

            return $output->data->count;
        }

        /**
         * @brief Ban IP 리스트 출력 (동기화 용)
         **/
        function getAntiaccessBanipApi() {
            $args = Context::getRequestVars();
            $obj->order_type = 'asc';
            $obj->list_count = 50; // 한번 요청시 몇건씩 보내줄지를 결정
            $obj->page = $args->page;
            $obj->follow_key = $args->follow_key;
			$followhost_info = $this->getAntiaccessFollowhostInfo($obj);

            if($args->not_follow_host == 'Y') {
	            $obj->not_follow_host = array($followhost_info->host);
            }
            
            if($args->is_follow_host == 'Y') {
            	$obj->is_follow_host = array($followhost_info->host);
            }

            $output = executeQueryArray('antiaccess.getAntiaccessBanipList', $obj);
            if(!$output->toBool()) return $this->add('error','401');

			$follow_obj->follow_srl = $followhost_info->follow_srl;
			$follow_obj->mode = 'sync';
			$follow_obj->extra_vars->type = 'ban';
			$follow_obj->extra_vars->total_page = $output->total_page;
			$follow_obj->extra_vars->page = $args->page;
			$follow_obj->extra_vars->state = 'follower';
			$follow_obj->extra_vars = serialize($follow_obj->extra_vars);
            $oAntiaccessController = &getController('antiaccess');
			$oAntiaccessController->updateAntiaccessFollowhost($follow_obj);

            $this->add('total_page',$output->total_page);
            $this->add('items',$output->data);
        }

        /**
         * @brief White IP 리스트 출력
         **/
        function getAntiaccessWhiteipList($args = null) {
            $args->order_type = in_array($args->order_type, array('asc','desc'))?$args->order_type:'desc';
            $args->page_count = $args->page_count?$args->page_count:10;

            if($args->search_keyword) {
                $args->s_source_host = $args->search_keyword;
                $args->s_follow_host = $args->search_keyword;
                $args->s_ipaddress = $args->search_keyword;
                $args->s_apply = $args->search_keyword;
                $args->s_regdate = $args->search_keyword;
            }

            $output = executeQueryArray('antiaccess.getAntiaccessWhiteipList', $args);
            if(!$output->toBool()) return new Object(-1, 'msg_error_occured');
            if(!$output->data) $output->data = array();

            return $output;
        }

        /**
         * @brief White IP 정보 출력
         **/
        function getAntiaccessWhiteipInfo($args = null) {
            $output = executeQuery('antiaccess.getAntiaccessWhiteipInfo', $args);
            if(!$output->toBool()) return new Object(-1, 'msg_error_occured');

            return $output->data;
        }

        /**
         * @brief White IP 전체 정보 출력
         **/
        function getAntiaccessWhiteipTotal($args = null) {
            $output = executeQueryArray('antiaccess.getAntiaccessWhiteipTotal', $args);
            if(!$output->toBool()) return new Object(-1, 'msg_error_occured');
            if(!$output->data) $output->data = array();

            return $output->data;
        }

        /**
         * @brief White IP 정보 갯수 확인
         **/
        function getAntiaccessWhiteipCount($args = null) {
            $output = executeQuery('antiaccess.getAntiaccessWhiteipCount', $args);
            if(!$output->toBool()) return new Object(-1, 'msg_error_occured');

            return $output->data->count;
        }

        /**
         * @brief White IP 리스트 출력 (동기화 용)
         **/
        function getAntiaccessWhiteipApi() {
            $args = Context::getRequestVars();
            $obj->order_type = 'asc';
            $obj->list_count = 50; // 한번 요청시 몇건씩 보내줄지를 결정
            $obj->page = $args->page;
            $obj->follow_key = $args->follow_key;
			$followhost_info = $this->getAntiaccessFollowhostInfo($obj);

            if($args->not_follow_host == 'Y') {
	            $obj->not_follow_host = array($followhost_info->host);
            }
            
            if($args->is_follow_host == 'Y') {
            	$obj->is_follow_host = array($followhost_info->host);
            }

            $output = executeQueryArray('antiaccess.getAntiaccessWhiteipList', $obj);
            if(!$output->toBool()) return $this->add('error','401');

			$follow_obj->follow_srl = $followhost_info->follow_srl;
			$follow_obj->mode = 'sync';
			$follow_obj->extra_vars->type = 'white';
			$follow_obj->extra_vars->total_page = $output->total_page;
			$follow_obj->extra_vars->page = $args->page;
			$follow_obj->extra_vars->state = 'follower';
			$follow_obj->extra_vars = serialize($follow_obj->extra_vars);
            $oAntiaccessController = &getController('antiaccess');
			$oAntiaccessController->updateAntiaccessFollowhost($follow_obj);

            $this->add('total_page',$output->total_page);
            $this->add('items',$output->data);
        }

        /**
         * @brief Access IP 리스트 출력
         **/
        function getAntiaccessAccessipList($args = null) {
            $args->order_type = in_array($args->order_type, array('asc','desc'))?$args->order_type:'desc';
            $args->page_count = $args->page_count?$args->page_count:10;

            if($args->sort_index) $args->sort_index = 'access_ip.'.$args->sort_index;

            if($args->search_keyword) {
                $args->s_ipaddress = $args->search_keyword;
                $args->s_block = $args->search_keyword;
                $args->s_limit_count = !preg_match("/^[0-9]$/", $args->search_keyword)?null:$args->search_keyword;
                $args->s_limit_display = !preg_match("/^[0-9]$/", $args->search_keyword)?null:$args->search_keyword;
                $args->s_limit_rss = !preg_match("/^[0-9]$/", $args->search_keyword)?null:$args->search_keyword;
                $args->s_limit_atom = !preg_match("/^[0-9]$/", $args->search_keyword)?null:$args->search_keyword;
                $args->s_limit_trackback = !preg_match("/^[0-9]$/", $args->search_keyword)?null:$args->search_keyword;
                $args->s_limit_act = !preg_match("/^[0-9]$/", $args->search_keyword)?null:$args->search_keyword;
                $args->s_occur_count = !preg_match("/^[0-9]$/", $args->search_keyword)?null:$args->search_keyword;
                $args->s_banip_apply = $args->search_keyword;
                $args->s_whiteip_apply = $args->search_keyword;
                $args->s_regdate = $args->search_keyword;
                $args->s_last_regdate = $args->search_keyword;
            }

            $output = executeQueryArray('antiaccess.getAntiaccessAccessipList', $args);
            if(!$output->toBool()) return new Object(-1, 'msg_error_occured');
            if(!$output->data) $output->data = array();

            return $output;
        }

        /**
         * @brief Access IP 리스트 출력
         **/
        function getAntiaccessAccessipInfo($args = null) {
            $output = executeQuery('antiaccess.getAntiaccessAccessipInfo', $args);
            if(!$output->toBool()) return new Object(-1, 'msg_error_occured');

            return $output->data;
        }

        /**
         * @brief Access IP 리스트 출력
         **/
        function getAntiaccessAccessipCount($args = null) {
            $output = executeQuery('antiaccess.getAntiaccessAccessipCount', $args);
            if(!$output->toBool()) return new Object(-1, 'msg_error_occured');

            return $output->data->count;
        }

        /**
         * @brief Follow Host 리스트 출력
         **/
        function getAntiaccessFollowhostList($args = null) {
            $args->order_type = in_array($args->order_type, array('asc','desc'))?$args->order_type:'desc';
            $args->page_count = $args->page_count?$args->page_count:10;

            if($args->search_keyword) {
                $args->s_host = $args->search_keyword;
                $args->s_state = $args->search_keyword;
                $args->s_my_level = $args->search_keyword;
                $args->s_follow_level = $args->search_keyword;
                $args->s_regdate = $args->search_keyword;
                $args->s_last_regdate = $args->search_keyword;
            }

            $output = executeQueryArray('antiaccess.getAntiaccessFollowhostList', $args);
            if(!$output->toBool()) return new Object(-1, 'msg_error_occured');
            if(!$output->data) $output->data = array();

            return $output;
        }

        /**
         * @brief Follow Host 정보 출력
         **/
        function getAntiaccessFollowhostInfo($args = null) {
            $output = executeQuery('antiaccess.getAntiaccessFollowhostInfo', $args);
            if(!$output->toBool()) return new Object(-1, 'msg_error_occured');

            return $output->data;
        }

        /**
         * @brief Follow Host 전체 정보 출력
         **/
        function getAntiaccessFollowhostTotal($args = null) {
            $output = executeQueryArray('antiaccess.getAntiaccessFollowhostTotal', $args);
            if(!$output->toBool()) return new Object(-1, 'msg_error_occured');
            if(!$output->data) $output->data = array();

            return $output->data;
        }

        /**
         * @brief Follow Host 정보 갯수 확인
         **/
        function getAntiaccessFollowhostCount($args = null) {
            $output = executeQuery('antiaccess.getAntiaccessFollowhostCount', $args);
            if(!$output->toBool()) return new Object(-1, 'msg_error_occured');

            return $output->data->count;
        }

        /**
         * @brief Ban Host 리스트 출력
         **/
        function getAntiaccessBanhostList($args = null) {
            $args->order_type = in_array($args->order_type, array('asc','desc'))?$args->order_type:'desc';
            $args->page_count = $args->page_count?$args->page_count:10;

            if($args->search_keyword) {
                $args->s_host = $args->search_keyword;
                $args->s_ban_type = $args->search_keyword;
                $args->s_white_type = $args->search_keyword;
                $args->s_regdate = $args->search_keyword;
            }

            $output = executeQueryArray('antiaccess.getAntiaccessBanhostList', $args);
            if(!$output->toBool()) return new Object(-1, 'msg_error_occured');
            if(!$output->data) $output->data = array();

            return $output;
        }

        /**
         * @brief Ban Host 정보 출력
         **/
        function getAntiaccessBanhostInfo($args = null) {
            $output = executeQuery('antiaccess.getAntiaccessBanhostInfo', $args);
            if(!$output->toBool()) return new Object(-1, 'msg_error_occured');

            return $output->data;
        }

        /**
         * @brief Ban Host 정보 출력
         **/
        function getAntiaccessBanhostCount($args = null) {
            $output = executeQuery('antiaccess.getAntiaccessBanhostCount', $args);
            if(!$output->toBool()) return new Object(-1, 'msg_error_occured');

            return $output->data->count;
        }

        /**
         * @brief Ipv4 Log 출력
         **/
        function getAntiaccessIpv4Log($args = null) {
            $output = executeQuery('antiaccess.getAntiaccessIpv4Log', $args);
            if(!$output->toBool()) return new Object(-1, 'msg_error_occured');

            return $output->data;
        }

        /**
         * @brief sequence 주소로 해당 ipaddress 구함
         **/
        function getAntiaccessSrlByIp($type = null, $srl = null) {
            if(!$type || !$srl) return;
            switch($type) {
                case 'white':
                    $args->white_srl = $srl;
                    $whiteip_info = $this->getAntiaccessWhiteipInfo($args);
                    $ipaddress = $whiteip_info->ipaddress;
                break;
                case 'ban':
                    $args->ban_srl = $srl;
                    $banip_info = $this->getAntiaccessBanipInfo($args);
                    $ipaddress = $banip_info->ipaddress;
                break;
                case 'access':
                    $args->access_srl = $srl;
                    $accessip_info = $this->getAntiaccessAccessipInfo($args);
                    $ipaddress = $accessip_info->ipaddress;
                break;
                default: break;
            }

            return $ipaddress;
        }

        /**
         * @brief White ip Check
         **/
        function getAntiaccessWhiteipCheck() {
            $anti_config = Context::get('anti_config');

            // 캐시 사용일 경우 캐시 파일이 있는지 검사 후 일치하면 true를 리턴
            if($anti_config->cache->cache_type <= 2) {
                $buff = @FileHandler::readFile($this->cache_white_path.Context::get('_REMOTE_ADDR_'));
                if($buff == "Y") return true;
            }

            // 비금지 ip 값 중 적용 상태인 해당 IP를 찾아 존재할 경우 캐시를 생성 후 true를 리턴
            $args->ipaddress = Context::get('_REMOTE_ADDR_');
            $whiteip_info = $this->getAntiaccessWhiteipInfo($args);
            if($whiteip_info->apply == 'Y') {
                $oModuleModel = &getModel('module');
                $anti_config = $oModuleModel->getModuleConfig('antiaccess');
                if($anti_config->cache->cache_type <= 2) @FileHandler::writeFile($this->cache_white_path.Context::get('_REMOTE_ADDR_'), "Y", 'w');
                return true;
            }

            // 기본 설정에서 자동 비금지 등록으로 설정된 멤버그룹일 경우 자동적으로 비금지 ip에 등록과 동시에 캐시 생성 (※ 단 사설IP는 추가 안됨)
            if($logged_info = Context::get('logged_info')) {
                $oAntiaccessModel = &getModel('antiaccess');
                if(!$oAntiaccessModel->checkIpaddress(Context::get('_REMOTE_ADDR_'))) return false;

                if(!is_array($anti_config->white_groups)) $anti_config->white_groups = array();
                foreach($anti_config->white_groups as $key=>$val) {
                    if($logged_info->group_list[$key]) {
                        $oAntiaccessController = &getController('antiaccess');

                        if($anti_config->cache->cache_type == 1) @FileHandler::writeFile($this->cache_white_path.$args->ipaddress, "Y", 'w');

                        $args->apply = 'Y';

                        if(!$whiteip_info) {
                            // 새로운 IP이기 때문에 등록자가 Source Host가 됨
                            $uri = $this->parseUri(Context::get('request_uri'), 'www');
                            $args->source_host = $uri['host'];
                            $oAntiaccessController->insertAntiaccessWhiteip($args);
                        } else $oAntiaccessController->updateAntiaccessWhiteip($args);

                        break;
                    }
                }
            }

            return false;
        }

        /**
         * @brief Country ip Check
         **/
        function getAntiaccessCountryipCheck() {
            $anti_config = Context::get('anti_config');

			// 접근한 IP가 국가코드와 일치한다면 ...
            $args->ipaddress = Context::get('_REMOTE_ADDR_');
            $args->ipaddress = "126.210.52.202";

            // 캐시 사용일 경우 캐시 파일이 있는지 검사 후 일치하면 true를 리턴
            if($anti_config->cache->cache_type <= 2) {
                $buff = @FileHandler::readFile($this->cache_country_path.$args->ipaddress);
                if($buff)
                {
					// 국가코드 비교 검사
					if($anti_config->country->code[$buff])
					{
						$is_country = TRUE;
					}

					if($anti_config->country->conn == 'block')
					{
						if($is_country)
						{
							return TRUE;
						}
					}
					elseif($anti_config->country->conn == 'white')
					{
						if(!$is_country)
						{
							return TRUE;
						}
					}

					return false;
                }
            }

			$country_code = $this->getGeoip($args->ipaddress);

			if($anti_config->country->code[$country_code])
			{
				$is_country = TRUE;
			}

			if($anti_config->country->conn == 'block')
			{
				if($is_country)
				{
					$is_block = TRUE;
				}
			}
			elseif($anti_config->country->conn == 'white')
			{
				if(!$is_country)
				{
					$is_block = TRUE;
				}		
			}

			if($is_block)
			{
                if($anti_config->cache->cache_type <= 2) @FileHandler::writeFile($this->cache_country_path.$args->ipaddress, $country_code, 'w');
                return true;
			}

            return false;
        }

        /**
         * @brief Ban ip Check
         **/
        function getAntiaccessBanipCheck() {
            $anti_config = Context::get('anti_config');

            // 캐시 사용일 경우 캐시 파일이 있는지 검사 후 일치하면 true를 리턴
            if($anti_config->cache->cache_type <= 2) {
                $buff = @FileHandler::readFile($this->cache_ban_path.Context::get('_REMOTE_ADDR_'));
                if($buff == "Y") return true;
            }

            // 비금지 ip 값 중 적용 상태인 해당 IP를 찾아 존재할 경우 캐시를 생성 후 true를 리턴
            $args->ipaddress = Context::get('_REMOTE_ADDR_');
            $args->apply = 'Y';
            $is_banip = $this->getAntiaccessBanipCount($args);
            if($is_banip) {
                $oModuleModel = &getModel('module');
                $anti_config = $oModuleModel->getModuleConfig('antiaccess');

                if($anti_config->cache->cache_type <= 2) @FileHandler::writeFile($this->cache_ban_path.Context::get('_REMOTE_ADDR_'), 'Y', 'w');
                return true;
            }

            return false;
        }

        /**
         * @brief Block ip Check
         **/
        function getAntiaccessBlockipCheck() {
            $anti_config = Context::get('anti_config');

            // 캐시 사용일 경우 캐시 파일이 있는지 검사
            if($anti_config->cache->cache_type <= 2) {
                $buff = @FileHandler::readFile($this->cache_block_path.Context::get('_REMOTE_ADDR_'));
                if($buff == "Y") {
                    // 차단 지정시간보다 짧은 시간에 접속할 경우 다시 차단 지정시간만큼 차단 진행
                    $last_update = date('YmdHis', filemtime($this->cache_block_path.Context::get('_REMOTE_ADDR_')));
                    $limit_period = strtotime(date('YmdHis')) - strtotime($last_update);
                    $limit_block = sprintf('-%d minutes', $anti_config->block->limit_block);
                    $limit_interval = strtotime(date('YmdHis')) - strtotime($limit_block);

                    if($limit_interval < $limit_period) @FileHandler::removeFile($this->cache_block_path.Context::get('_REMOTE_ADDR_'));
                    else {
                        @FileHandler::writeFile($this->cache_block_path.Context::get('_REMOTE_ADDR_'), "Y", 'w');
                        return true;
                    }
                }
            }

            // 차단 지정시간이 지난 후 접속할 경우 차단 해제
            $args->ipaddress = Context::get('_REMOTE_ADDR_');
            $args->block = 'Y';
            $access_info = $this->getAntiaccessAccessipInfo($args);
            if($access_info) {
                $oAntiaccessController = &getController('antiaccess');

                $last_update = $access_info->last_update;
                $limit_period = strtotime(date('YmdHis')) - strtotime($last_update);
                $limit_block = sprintf('-%d minutes', $anti_config->block->limit_block);
                $limit_interval = strtotime(date('YmdHis')) - strtotime($limit_block);
                if($limit_interval < $limit_period) {
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
                    $oAntiaccessController->updateAntiaccessAccessip($args);
                } else {
                    if($anti_config->cache->cache_type <= 2) @FileHandler::writeFile($this->cache_block_path.Context::get('_REMOTE_ADDR_'), "Y", 'w');
                    $oAntiaccessController->updateAntiaccessAccessip($args);
                    return true;
                }
            }

            return false;
        }

        /**
         * @brief 동기식/비동기식 Api Request
         **/
        function sendRequest($uri, $body = array(), $blocking = true) {
            if(!$body) return;

			foreach($body as $key => $val)
			{
				$contents_body .= sprintf('<%s><![CDATA[%s]]></%s>', $key, $val, $key);
			}

            $contents = sprintf('<?xml version="1.0" encoding="utf-8" ?>
                <methodCall>
                <params>
                <module><![CDATA[antiaccess]]></module>
                %s
                </params>
                </methodCall>',
                $contents_body);

            if($blocking) {
                $buff = @FileHandler::getRemoteResource($uri, $contents, 3, 'POST', 'application/xml');

                if($buff) {
                    $oXmlParser = new XmlParser();
                    $buff = $oXmlParser->parse($buff);
                }
            } else {
                $uri = $this->parseUri($uri);

                $fp = @fsockopen($uri['host'], $uri['port'], $errno, $errstr, 1);
                if($fp) {
                    $header  = "POST ".$uri['path']." HTTP/1.1\r\n";
                    $header .= "Host: ".$uri['host']."\r\n";
                    $header .= "Content-type: application/xml\r\n";
                    $header .= "Content-length: ".strlen($contents)."\r\n\r\n";
                    $header .= $contents."\r\n";
                    @fputs($fp, $header."\r\n\r\n");
                    @socket_set_blocking($fp, FALSE);
                    @fclose($fp);
                } else {
                    $buff->error = $errno;
                    $buff->message = $errstr;
                }
            }

            return $buff;
        }

        /**
         * @brief URI 정보를 종류별로 나눔
         **/
        function parseUri($uri = null, $mode = null) {
            if(!preg_match("/^(http|https|tcp|udp|ssl|vls):\/\//", $uri)) $uri = "http://{$uri}";
              $uri = parse_url($uri);

            if(preg_match("/^(http|https|tcp|udp|ssl|vls)$/", $uri['host'])) {
                $uri['host'] = $uri['path'];
                $uri['path'] = '/';
            }

            if($mode == 'www') $uri['host'] = preg_replace("/^www\./","",$uri['host']);
            $uri['host'] = preg_replace("/(\/|\:)/","",$uri['host']);
            $uri['port'] = @$uri['port']?@$uri['port']:80;
            $uri['path'] = @preg_match("/\/$/", @$uri['path'])?@$uri['path']:@$uri['path'].'/';

            return $uri;
        }

        /**
         * @brief Ipv4 ipaddress check
         **/
        function checkIpaddress($ipaddress = null, $private = null) {
            // IP 형식인지 검사
            if(preg_match('/^(?:25[0-5]|2[0-4]\d|1\d\d|[1-9]\d|\d)(?:[.](?:25[0-5]|2[0-4]\d|1\d\d|[1-9]\d|\d)){3}$/', $ipaddress)) {
                // 비공인 IP인지 검사
                if(preg_match('/^(10\.|172\.(1[6-9]|2[0-9]|3[0-1])\.|192\.168\.|127\.0\.0\.1|(24[0-9]|25[0-5]\.))/', $ipaddress)) return false;

                return true;
            }

            // 도메인이 넘어올 경우 true를 보냄
            if($private) return true;

            return false;
        }

        /**
         * @brief Follow Sync Check
         **/
        function getAntiaccessFollowCheck($obj, $mode = null) {
            if($obj->mode) return;
            $oModuleModel = &getModel('module');
            $anti_config = $oModuleModel->getModuleConfig('antiaccess');
            
			$body->act = 'procAntiaccessSync';
			$body->host = Context::get('request_uri');
			$body->state = 101;
			$body->rank = $anti_config->rank;
            $buff = $this->sendRequest($obj->host, $body, true);

            if(!$buff || $buff->response->state->body != 102) {
                if($mode) return false;
                else return new Object(-1, "msg_not_response");
            }

            if(!in_array($obj->state, array(100,104,504)) && $buff->response->rank_error->body == 401) {
                if($mode) return false;
                else return new Object(-1, "msg_not_rank");
            }

            if(!in_array($obj->state, array(100,104,504)) && $buff->response->state_error->body == 403) {
                if($mode) return false;
                else return new Object(-1, "msg_follow_exists");
            }

            $obj->rank = $buff->response->rank->body;

            return true;
        }

        /**
         * @brief Follow Synchronization Request
         **/
        function getAntiaccessFollowSync(&$obj) {
            if($obj->mode) return;
            $oModuleModel = &getModel('module');
            $oAntiaccessController = &getController('antiaccess');
            $anti_config = $oModuleModel->getModuleConfig('antiaccess');

//            if(!$this->getAntiaccessFollowCheck($obj, true)) return new Object(-1, "msg_not_response");

			if($anti_config->rank != $obj->rank) $state = 503;
			else $state = 103;

			// XML
			$body->act = 'procAntiaccessSync';
			$body->host = Context::get('request_uri');
			$body->state = $state;
			$body->my_level = $obj->my_level;
			$body->rank = $anti_config->rank;
            if($anti_config->rank != $obj->rank) $buff = $this->sendRequest($obj->host, $body, true);
            else $buff = $this->sendRequest($obj->host, $body, false);

            $args = $obj;
            $args->state = $state;
            $obj->mode = 'sync';
            $oAntiaccessController->updateAntiaccessFollowhost($args);
        }

        /**
         * @brief Follow Sync Call (동기화를 사이클별로 수행할 수 있도록 합니다.)
         **/
        function getAntiaccessFollowCall() {
            $args = Context::getRequestVars();
            $oAntiaccessModel = &getModel('antiaccess');

            $obj->follow_key = $args->follow_key;
            $followhost_info = $oAntiaccessModel->getAntiaccessFollowhostInfo($obj);

			// XML
			$body->act = 'procAntiaccessSync';
			$body->follow_key = $followhost_info->follow_key;
			$body->state = $args->state;
			$body->mode = $args->mode;
			$body->page = $args->page;
            $buff = $this->sendRequest($followhost_info->host, $body, false);
        }

        /**
         * @brief level code 값에 따른 설정값 정의
         **/
        function getAntiaccessApplyMode($level) {
            if(in_array($level, array(101,103,105,111,113,115,121,123,125))) Context::set('anti_apply','Y');
            else Context::set('anti_apply','N');

            if(in_array($level, array(111,112,113,114,115,116))) Context::set('is_follow_host','Y');
            else Context::set('is_follow_host','N');

            if(in_array($level, array(121,122,123,124,125,126))) Context::set('not_follow_host','Y');
            else Context::set('not_follow_host','N');

            if(in_array($level, array(101,102,111,112,121,122))) Context::set('is_ip_type','all');
            elseif(in_array($level, array(103,104,113,114,123,124))) Context::set('is_ip_type','ban');
            elseif(in_array($level, array(105,106,115,116,125,126))) Context::set('is_ip_type','white');
            else  Context::set('is_ip_type','');
        }

        /**
         * @brief 국가 Code 구하기
         **/        
        function getGeoip($ipaddress = NULL)
        {
			if(!$ipaddress)
			{
				return;
			}

			require_once(_XE_PATH_.'modules/antiaccess/libs/geoip/geoip.inc');
			$gi = geoip_open(_XE_PATH_.'modules/antiaccess/libs/geoip/GeoIP.dat', GEOIP_STANDARD);
			$country_code = geoip_country_code_by_addr($gi, $ipaddress);
			geoip_close($gi);

			return $country_code;
		}
    }
?>