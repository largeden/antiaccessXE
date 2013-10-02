<?php
    /**
     * @class  antiaccessController
     * @author largeden (cbrghost@gmail.com)
     * @brief  antiaccessXE Controller class
     **/

    class antiaccessController extends antiaccess {

        /**
         * @brief 초기화
         **/
        function init() {
        }

        /**
         * @brief Ban ip 정보 추가
         **/
        function insertAntiaccessBanip($args) {
            // begin transaction
            $oDB = &DB::getInstance();
            $oDB->begin();

            // trigger 호출 (before) : Follow Host로 대상을 전달, 타 모듈 연동을 위해 선언
            $output = ModuleHandler::triggerCall('antiaccess.insertAntiaccessBanip', 'before', $args);
            if(!$output->toBool()) return $output;

             // ban_srl 생성
            if(!$args->ban_srl) $args->ban_srl = getNextSequence();

			// 코드 생성
			if(!$args->country_code)
			{
				$oAntiaccessModel = &getModel('antiaccess');
				$args->country_code = $oAntiaccessModel->getGeoip($args->ipaddress);
			}

            $output = executeQuery('antiaccess.insertAntiaccessBanip', $args);
            if(!$output->toBool()) {
                $oDB->rollback();
                return new Object(-1, "msg_error_occured");
            }

            // trigger 호출 (after) : Follow Host로 대상을 전달, 타 모듈 연동을 위해 선언
            if($output->toBool()) {
                $trigger_output = ModuleHandler::triggerCall('antiaccess.insertAntiaccessBanip', 'after', $args);
                if(!$trigger_output->toBool()) {
                    $oDB->rollback();
                    return $trigger_output;
                }
            }

            // commit
            $oDB->commit();

            return $output;
        }

        /**
         * @brief Ban ip 정보 수정
         **/
        function updateAntiaccessBanip($args) {
            // begin transaction
            $oDB = &DB::getInstance();
            $oDB->begin();

            $output = executeQuery('antiaccess.updateAntiaccessBanip', $args);
            if(!$output->toBool()) {
                $oDB->rollback();
                return new Object(-1, "msg_error_occured");
            }

            // commit
            $oDB->commit();

            return $output;
        }

        /**
         * @brief Ban ip 정보 삭제
         **/
        function deleteAntiaccessBanip($args) {
            // begin transaction
            $oDB = &DB::getInstance();
            $oDB->begin();

            // trigger 호출 (before) : Follow Host로 대상을 전달, 타 모듈 연동을 위해 선언
            $output = ModuleHandler::triggerCall('antiaccess.deleteAntiaccessBanip', 'before', $args);
            if(!$output->toBool()) return $output;

            $output = executeQuery('antiaccess.deleteAntiaccessBanip', $args);
            if(!$output->toBool()) {
                $oDB->rollback();
                return new Object(-1, "msg_error_occured");
            }

            // trigger 호출 (after) : Follow Host로 대상을 전달, 타 모듈 연동을 위해 선언
            if($output->toBool()) {
                $trigger_output = ModuleHandler::triggerCall('antiaccess.deleteAntiaccessBanip', 'after', $args);
                if(!$trigger_output->toBool()) {
                    $oDB->rollback();
                    return $trigger_output;
                }
            }

            // commit
            $oDB->commit();

            return $output;
        }

        /**
         * @brief White ip 정보 추가
         **/
        function insertAntiaccessWhiteip($args) {
            // begin transaction
            $oDB = &DB::getInstance();
            $oDB->begin();

            // trigger 호출 (before) : Follow Host로 대상을 전달, 타 모듈 연동을 위해 선언
            $output = ModuleHandler::triggerCall('antiaccess.insertAntiaccessWhiteip', 'before', $args);
            if(!$output->toBool()) return $output;

             // ban_srl 생성
            if(!$args->white_srl) $args->white_srl = getNextSequence();

			// 코드 생성
			if(!$args->country_code)
			{
				$oAntiaccessModel = &getModel('antiaccess');
				$args->country_code = $oAntiaccessModel->getGeoip($args->ipaddress);
			}

            $output = executeQuery('antiaccess.insertAntiaccessWhiteip', $args);
            if(!$output->toBool()) {
                $oDB->rollback();
                return new Object(-1, "msg_error_occured");
            }

            // trigger 호출 (after) : Follow Host로 대상을 전달, 타 모듈 연동을 위해 선언
            if($output->toBool()) {
                $trigger_output = ModuleHandler::triggerCall('antiaccess.insertAntiaccessWhiteip', 'after', $args);
                if(!$trigger_output->toBool()) {
                    $oDB->rollback();
                    return $trigger_output;
                }
            }

            // commit
            $oDB->commit();

            return $output;
        }

        /**
         * @brief White ip 정보 수정
         **/
        function updateAntiaccessWhiteip($args) {
            // begin transaction
            $oDB = &DB::getInstance();
            $oDB->begin();

            $output = executeQuery('antiaccess.updateAntiaccessWhiteip', $args);
            if(!$output->toBool()) {
                $oDB->rollback();
                return new Object(-1, "msg_error_occured");
            }

            // commit
            $oDB->commit();

            return $output;
        }

        /**
         * @brief White ip 정보 삭제
         **/
        function deleteAntiaccessWhiteip($args) {
            // begin transaction
            $oDB = &DB::getInstance();
            $oDB->begin();

            // trigger 호출 (before) : Follow Host로 대상을 전달, 타 모듈 연동을 위해 선언
            $output = ModuleHandler::triggerCall('antiaccess.deleteAntiaccessWhiteip', 'before', $args);
            if(!$output->toBool()) return $output;

            $output = executeQuery('antiaccess.deleteAntiaccessWhiteip', $args);
            if(!$output->toBool()) {
                $oDB->rollback();
                return new Object(-1, "msg_error_occured");
            }

            // trigger 호출 (after) : Follow Host로 대상을 전달, 타 모듈 연동을 위해 선언
            if($output->toBool()) {
                $trigger_output = ModuleHandler::triggerCall('antiaccess.deleteAntiaccessWhiteip', 'after', $args);
                if(!$trigger_output->toBool()) {
                    $oDB->rollback();
                    return $trigger_output;
                }
            }

            // commit
            $oDB->commit();

            return $output;
        }

        /**
         * @brief access ip 정보 추가
         **/
        function insertAntiaccessAccessip($args) {
            // begin transaction
            $oDB = &DB::getInstance();
            $oDB->begin();

            $output = executeQuery('antiaccess.insertAntiaccessAccessip', $args);
            if(!$output->toBool()) {
                $oDB->rollback();
                return new Object(-1, "msg_error_occured");
            }

            // commit
            $oDB->commit();

            return $output;
        }

        /**
         * @brief access ip 정보 수정
         **/
        function updateAntiaccessAccessip($args) {
            // begin transaction
            $oDB = &DB::getInstance();
            $oDB->begin();

            $output = executeQuery('antiaccess.updateAntiaccessAccessip', $args);
            if(!$output->toBool()) {
                $oDB->rollback();
                return new Object(-1, "msg_error_occured");
            }

            // commit
            $oDB->commit();

            return $output;
        }

        /**
         * @brief Access ip 정보 삭제
         **/
        function deleteAntiaccessAccessip($args) {
            // begin transaction
            $oDB = &DB::getInstance();
            $oDB->begin();

            $output = executeQuery('antiaccess.deleteAntiaccessAccessip', $args);
            if(!$output->toBool()) {
                $oDB->rollback();
                return new Object(-1, "msg_error_occured");
            }

            // commit
            $oDB->commit();

            return $output;
        }

        /**
         * @brief Ban Host 정보 추가
         **/
        function insertAntiaccessBanhost($args) {
            // begin transaction
            $oDB = &DB::getInstance();
            $oDB->begin();

             // ban_srl 생성
            if(!$args->host_srl) $args->host_srl = getNextSequence();

            $output = executeQuery('antiaccess.insertAntiaccessBanhost', $args);
            if(!$output->toBool()) {
                $oDB->rollback();
                return new Object(-1, "msg_error_occured");
            }

            // commit
            $oDB->commit();

            return $output;
        }

        /**
         * @brief Ban host 정보 수정
         **/
        function updateAntiaccessBanhost($args) {
            // begin transaction
            $oDB = &DB::getInstance();
            $oDB->begin();

            $output = executeQuery('antiaccess.updateAntiaccessBanhost', $args);
            if(!$output->toBool()) {
                $oDB->rollback();
                return new Object(-1, "msg_error_occured");
            }

            // commit
            $oDB->commit();

            return $output;
        }

        /**
         * @brief Ban host 정보 삭제
         **/
        function deleteAntiaccessBanhost($args) {
            // begin transaction
            $oDB = &DB::getInstance();
            $oDB->begin();

            $output = executeQuery('antiaccess.deleteAntiaccessBanhost', $args);
            if(!$output->toBool()) {
                $oDB->rollback();
                return new Object(-1, "msg_error_occured");
            }

            // commit
            $oDB->commit();

            return $output;
        }

        /**
         * @brief Follow Host 정보 추가
         **/
        function insertAntiaccessFollowhost($args) {
            // begin transaction
            $oDB = &DB::getInstance();
            $oDB->begin();

            // trigger 호출 (before) : Follow Host로 대상을 전달, 타 모듈 연동을 위해 선언
            $output = ModuleHandler::triggerCall('antiaccess.insertAntiaccessFollowhost', 'before', $args);
            if(!$output->toBool()) return $output;

            if(!$args->rank) {
	            if($output->rank) $args->rank = $output->rank;
            }

            // follow_srl 생성
            if(!$args->follow_srl) $args->follow_srl = getNextSequence();
            $output = executeQuery('antiaccess.insertAntiaccessFollowhost', $args);
            if(!$output->toBool()) {
                $oDB->rollback();
                return new Object(-1, "msg_error_occured");
            }

            // trigger 호출 (after) : Follow Host로 대상을 전달, 타 모듈 연동을 위해 선언
            if($output->toBool()) {
                $trigger_output = ModuleHandler::triggerCall('antiaccess.insertAntiaccessFollowhost', 'after', $args);
                if(!$trigger_output->toBool()) {
                    $oDB->rollback();
                    return $trigger_output;
                }
            }

            // commit
            $oDB->commit();

            return $output;
        }

        /**
         * @brief Follow Host 정보 수정
         **/
        function updateAntiaccessFollowhost($args) {
            // begin transaction
            $oDB = &DB::getInstance();
            $oDB->begin();

            // trigger 호출 (before) : Follow Host로 대상을 전달, 타 모듈 연동을 위해 선언
            $output = ModuleHandler::triggerCall('antiaccess.updateAntiaccessFollowhost', 'before', $args);
            if(!$output->toBool()) return $output;

            $output = executeQuery('antiaccess.updateAntiaccessFollowhost', $args);
            if(!$output->toBool()) {
                $oDB->rollback();
                return new Object(-1, "msg_error_occured");
            }

            // trigger 호출 (after) : Follow Host로 대상을 전달, 타 모듈 연동을 위해 선언
            if($output->toBool()) {
                $trigger_output = ModuleHandler::triggerCall('antiaccess.updateAntiaccessFollowhost', 'after', $args);
                if(!$trigger_output->toBool()) {
                    $oDB->rollback();
                    return $trigger_output;
                }
            }

            // commit
            $oDB->commit();

            return $output;
        }

        /**
         * @brief Follow Host 정보 삭제
         **/
        function deleteAntiaccessFollowhost($args) {
            // begin transaction
            $oDB = &DB::getInstance();
            $oDB->begin();

            // trigger 호출 (before) : Follow Host로 대상을 전달, 타 모듈 연동을 위해 선언
            $output = ModuleHandler::triggerCall('antiaccess.deleteAntiaccessFollowhost', 'before', $args);
            if(!$output->toBool()) return $output;

            $output = executeQuery('antiaccess.deleteAntiaccessFollowhost', $args);
            if(!$output->toBool()) {
                $oDB->rollback();
                return new Object(-1, "msg_error_occured");
            }

            // trigger 호출 (after) : Follow Host로 대상을 전달, 타 모듈 연동을 위해 선언
            if($output->toBool()) {
                $trigger_output = ModuleHandler::triggerCall('antiaccess.deleteAntiaccessFollowhost', 'after', $args);
                if(!$trigger_output->toBool()) {
                    $oDB->rollback();
                    return $trigger_output;
                }
            }

            // commit
            $oDB->commit();

            return $output;
        }

        /**
         * @brief Ipv4 Log 정보 추가
         **/
        function insertAntiaccessIpv4Log($args) {
            // begin transaction
            $oDB = &DB::getInstance();
            $oDB->begin();

            $output = executeQuery('antiaccess.insertAntiaccessIpv4Log', $args);
            if(!$output->toBool()) {
                $oDB->rollback();
                return new Object(-1, "msg_error_occured");
            }

            // commit
            $oDB->commit();

            return $output;
        }

        /**
         * @brief Ipv4 Log 정보 삭제
         **/
        function updateAntiaccessIpv4Log($args) {
            // begin transaction
            $oDB = &DB::getInstance();
            $oDB->begin();

            $output = executeQuery('antiaccess.updateAntiaccessIpv4Log', $args);
            if(!$output->toBool()) {
                $oDB->rollback();
                return new Object(-1, "msg_error_occured");
            }

            // commit
            $oDB->commit();

            return $output;
        }

        /**
         * @brief Ipv4 Log 정보 삭제
         **/
        function deleteAntiaccessIpv4Log($args) {
            // begin transaction
            $oDB = &DB::getInstance();
            $oDB->begin();

            $output = executeQuery('antiaccess.deleteAntiaccessIpv4Log', $args);
            if(!$output->toBool()) {
                $oDB->rollback();
                return new Object(-1, "msg_error_occured");
            }

            // commit
            $oDB->commit();

            return $output;
        }

        /**
         * @brief 차단 검사
         **/
        function procAntiaccess(&$obj) {
            // Anti-accessXE에서 사용하는 act는 차단 진행을 하지 않음
            if(Context::get('module') == 'antiaccess') return;

            $oModuleModel = &getModel('module');
            $oAntiaccessModel = &getModel('antiaccess');

            // Antiaccess config load
            $anti_config = $oModuleModel->getModuleConfig('antiaccess');
            Context::set('anti_config', $anti_config);

            // 제외 act일 경우 차단 검사 수행 안함
            if($anti_config->not_act) {
                $acts = explode(',',$anti_config->not_act);
                if(in_array(Context::get('act'), $acts)) return;
            }

            // remote ip create
            Context::set('_REMOTE_ADDR_', $_SERVER['REMOTE_ADDR']);

            // 사설 IP라면 수행하지 않음
            if(!$oAntiaccessModel->checkIpaddress(Context::get('_REMOTE_ADDR_'))) return;

            // White IP check (비금지 IP와 관계업이 최종관리자 로그인 상태라면 차단 동작하지 않음, 아래 주석으로 대체시에는 동작하게 됨)
            if(($anti_config->use->use_white == 'Y' && $oAntiaccessModel->getAntiaccessWhiteipCheck()) || $obj->grant->is_admin == 'Y') return;
//            if(($anti_config->use->use_white == 'Y' && $oAntiaccessModel->getAntiaccessWhiteipCheck())) return;

            // Country IP check
			if($anti_config->use->use_country == 'Y' && $oAntiaccessModel->getAntiaccessCountryipCheck()) $this->procAntiaccessStop();

            // Ban IP check
            if($anti_config->use->use_banned == 'Y' && $oAntiaccessModel->getAntiaccessBanipCheck()) $this->procAntiaccessStop();

            // Block IP check
            if($anti_config->use->use_block != 'Y' || !$anti_config->block->limit_time || !$anti_config->block->limit_block) return;
            if($oAntiaccessModel->getAntiaccessBlockipCheck()) $this->procAntiaccessStop();

            /* 다중접속 카운터를 수행 */
            $block_mode = false;
            $args->ipaddress = Context::get('_REMOTE_ADDR_');

            // 최초접근자인지 확인
            $accessip_info = $oAntiaccessModel->getAntiaccessAccessipInfo($args);
            if(!$accessip_info) $this->insertAntiaccessAccessip($args);
            else { // 기존 접근자라면 같은 위치를 중복 접속하는지 확인 (중복 접속 기준은 아래의 변수만을 확인)
                $args_vars = Context::gets('mid','document_srl','act','page');
                $module_srl = $oModuleModel->getModuleSrlByMid($args_vars->mid);

                $args_vars->ipaddress = Context::get('_REMOTE_ADDR_');
                $args_vars->module_srl = $args_vars->mid?$module_srl[0]:0;
                $args_vars->document_srl = $args_vars->document_srl?$args_vars->document_srl:0;
                $args_vars->act = $args_vars->act?$args_vars->act:'';
                $args_vars->page = $args_vars->page?$args_vars->page:1;

                if($anti_config->block->limit_act) {
                    if(($accessip_info->module_srl == $args_vars->module_srl)
                    && ($accessip_info->document_srl == $args_vars->document_srl)
                    && ($accessip_info->act == $args_vars->act)
                    && ($accessip_info->page == $args_vars->page)) $log->act = 1;
                    else { // 중복 접속하지 않았다면 ipv4 log act 값 제거
                        $args_ipv4->ipaddress = Context::get('_REMOTE_ADDR_');
                        $args_ipv4->act = 0;
                        $this->updateAntiaccessIpv4Log($args_ipv4);
                    }
                }
            }

            // 카운터 진행 전에 현재 기준으로 설정한 시간 전에 기록된 IP를 제거
            $limit_time = sprintf('-%d minutes', $anti_config->block->limit_time);
            $ipv4_log->regdate = date('YmdHis', strtotime($limit_time));
            $this->deleteAntiaccessIpv4Log($ipv4_log);

            // 대표적인 접근 방법에 따라서 카운터 수행 (※ dispBoardContent처럼 기본 act의 경우는 노출이 되지 않기에 act명이 없는걸로 진행 됨)
            $log->ipaddress = Context::get('_REMOTE_ADDR_');
            switch(Context::get('act')) {
                case 'rss': if($anti_config->block->limit_rss) $log->rss = 1; break;
                case 'atom': if($anti_config->block->limit_atom) $log->atom = 1; break;
                case 'trackback': if($anti_config->block->limit_trackback) $log->trackback = 1; break;
                default: if($anti_config->block->limit_display) $log->display = 1; break;
            }

            // act값에 따른 카운터를 증가(1의 값을 입력해 둠)
            $this->insertAntiaccessIpv4Log($log);

            // 입력된 모든 값을 카운터, 합계로 로드
            $ipv4_count = $oAntiaccessModel->getAntiaccessIpv4Log($log);

            // 다중접근 설정에 설정한 값을 비교하여 설정값보다 클 경우 차단 설정 수행
            if($anti_config->block->limit_count && ($anti_config->block->limit_count <= $ipv4_count->count)) $block_mode = true;
            if($anti_config->block->limit_display && ($anti_config->block->limit_display <= $ipv4_count->display)) $block_mode = true;
            if($anti_config->block->limit_rss && ($anti_config->block->limit_rss <= $ipv4_count->rss)) $block_mode = true;
            if($anti_config->block->limit_atom && ($anti_config->block->limit_atom <= $ipv4_count->atom)) $block_mode = true;
            if($anti_config->block->limit_trackback && ($anti_config->block->limit_trackback <= $ipv4_log->trackback)) $block_mode = true;
            if($anti_config->block->limit_act && ($anti_config->block->limit_act <= $ipv4_count->act)) $block_mode = true;
            // 차단 설정 수행
            if($block_mode == true) $this->procAntiaccessBlock();
            else {
                // access ip(접근한 ip)에 나타낼 현재 카운터 기록(수정)
                $args_vars->limit_count = $ipv4_count->count;
                $args_vars->limit_display = $ipv4_count->display;
                $args_vars->limit_rss = $ipv4_count->rss;
                $args_vars->limit_atom = $ipv4_count->atom;
                $args_vars->limit_trackback = $ipv4_count->trackback;
                $args_vars->limit_act = $ipv4_count->act;
                if(!$args_vars->ipaddress) $args_vars->ipaddress = Context::get('_REMOTE_ADDR_');

                $this->updateAntiaccessAccessip($args_vars);
            }

            // DB Table Optimize
            $this->optimize();
        }

        /**
         * @brief 차단 설정
         * 자동 차단이 설정되며 차단된 횟수가 기본 설정 횟수를 넘을 경우 금지 IP로 설정 됨
         **/
        function procAntiaccessBlock() {
            $oAntiaccessModel = &getModel('antiaccess');
            // Antiaccess config load
            $anti_config = Context::get('anti_config');

            // 캐시 기능을 사용할 경우 remote ip를 block 캐시 생성함
            if($anti_config->cache->cache_type <= 2) @FileHandler::writeFile($this->cache_block_path.Context::get('_REMOTE_ADDR_'), "Y", 'w');

            // 자동 차단처리를 하며, 기존 카운터는 초기화 함
            $args->ipaddress = $obj->ipaddress = Context::get('_REMOTE_ADDR_');
            $accessip_info = $oAntiaccessModel->getAntiaccessAccessipInfo($args);

            $args->block = $obj->apply = 'Y';
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
            $args->occur_count = $accessip_info->occur_count+1;

            $this->updateAntiaccessAccessip($args);

            // 해당 IP의 ipv4 log는 모두 삭제
            $this->deleteAntiaccessIpv4Log($obj);

            // 자동 차단 횟수가 설정 횟수를 넘을 경우 금지 IP로 등록
            if($anti_config->banned->occur_count <= $args->occur_count) {
                // 캐시 기능을 사용할 경우 remote ip를 ban 캐시 생성함
                if($anti_config->cache->cache_type <= 2) @FileHandler::writeFile($this->cache_ban_path.Context::get('_REMOTE_ADDR_'), "Y", 'w');
                // 해당 IP를 금지 IP로 등록
                $is_banip = $oAntiaccessModel->getAntiaccessBanipCount($args);
                if(!$is_banip) {
                    $uri = $oAntiaccessModel->parseUri(Context::get('request_uri'), 'www');
                    $obj->source_host = $uri['host'];
                    $this->insertAntiaccessBanip($obj);
                } else $this->updateAntiaccessBanip($obj);
            }
        }

        /**
         * @brief 차단, 금지 Header 출력
         **/
        function procAntiaccessStop() {
            Context::setResponseMethod('XMLRPC');
            $anti_config = Context::get('anti_config');

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

        /**
         * @brief Anti-accessXE XML request Synchronization
         **/
        function procAntiaccessSync() {
            $args = Context::getRequestVars();

            $oModuleModel = &getModel('module');
            $oAntiaccessModel = &getModel('antiaccess');

            // Antiaccess config load
            $anti_config = $oModuleModel->getModuleConfig('antiaccess');

            switch($args->state) {
                case 100: // 동기화 완료
                    $obj->mode = 'sync';

                    $obj->follow_key = $args->follow_key;
                    $followhost_info = $oAntiaccessModel->getAntiaccessFollowhostInfo($obj);

                    $obj->follow_srl = $followhost_info->follow_srl;
                    $obj->state = 100;
                    $this->updateAntiaccessFollowhost($obj);
                break;
                case 101: // Sync 요청 (Hello packet이 오면 응답을 보내준다)
                    // 서로의 rank가 Subscriber일 경우 follow 금지
                    if(!$args->rank) $this->add('state_error',403);
                    if($anti_config->rank == 'S' && $args->rank == 'S') $this->add('rank_error',401);

                    // Follow Host 신규 동기화 요청시 이미 동기화하고 있는 대상이 있는지 확인
                    if($args->host) {
                        $uri = $oAntiaccessModel->parseUri($args->host, 'www');
                        $obj->like_host = $uri['host']."/";
                        // 요청한 Host가 기존에 등록되어있는지 검사 후 있으면 에러코드를 보냄
                        $followhost_info = $oAntiaccessModel->getAntiaccessFollowhostInfo($obj);
                        if($followhost_info && ($followhost_info->state != 122)) $this->add('state_error',403);
                    }

                    $this->add('state',102);
					$this->add('rank',$anti_config->rank);
                break;
                case 503:
                    $obj->mode = 'sync';

                    $obj->host = $args->host;

                    // 요청한 Host가 기존에 등록되어있는지 검사 후 있으면 아래를 진행
                    $followhost_info = $oAntiaccessModel->getAntiaccessFollowhostInfo($obj);
                    // 요청한 Host를 등록
                    $obj->state = 504;
                    $obj->follow_level = $args->my_level;
                    $obj->rank = $args->rank;
                    $this->insertAntiaccessFollowhost($obj);
                break;
                case 103: // Follow 요청
                    $obj->mode = 'sync';

                    $obj->host = $args->host;

                    // 요청한 Host가 기존에 등록되어있는지 검사 후 있으면 아래를 진행
                    $followhost_info = $oAntiaccessModel->getAntiaccessFollowhostInfo($obj);
                    if($followhost_info && ($followhost_info->state == 122)) {
                        // 동기화 진행을 바로 시도
						$body->act = 'procAntiaccessSync';
						$body->host = Context::get('request_uri');
						$body->follow_key = $followhost_info->follow_key;
						$body->state = 105;
						$body->my_level = $args->my_level;
						$body->follow_level = $followhost_info->my_level;
                        $buff = $oAntiaccessModel->sendRequest($followhost_info->host, $body, false);

                        $obj->follow_srl = $followhost_info->follow_srl;
                        $obj->state = 108;
                        $obj->follow_level = $args->my_level;
                        $this->updateAntiaccessFollowhost($obj);
                    } else {
                        // 요청한 Host를 등록
                        $obj->state = 104;
                        $obj->follow_level = $args->my_level;
                        $obj->rank = $args->rank;
                        $this->insertAntiaccessFollowhost($obj);
                    }
                break;
                case 505: // Key 생성 (Key를 서로 등록 후 동기화 진행)
                    $obj->mode = 'sync';

                    $obj->host = $args->host;
                    $obj->follow_key = $args->follow_key;
                    $obj->state = 508; // 동기화 시작

                    /* 한번 동기화 되었다가 삭제 후 재시도 시를 위해 my_level과 follow_level 설정값을 바꿈 */
                    $obj->follow_level = $args->follow_level?$args->follow_level:$args->my_level;
                    $this->updateAntiaccessFollowhost($obj);
                    
                    $followhost_info = $oAntiaccessModel->getAntiaccessFollowhostInfo($obj);

                    if($followhost_info->rank == 'S') {
	                    // 동기화 진행
						$body->act = 'procAntiaccessSync';
						$body->follow_key = $followhost_info->follow_key;
						$body->state = 509;
						$body->mode = 'ban';
						$body->page = 1;
	                    $buff = $oAntiaccessModel->sendRequest(Context::get('request_uri'), $body, false);
                    } else {
                    	$this->add('key_complete',506);
                    }
                break;
                case 105: // Key 생성 (Key를 서로 등록 후 동기화 진행)
                    $obj->mode = 'sync';

                    $obj->host = $args->host;
                    $obj->follow_key = $args->follow_key;
                    $obj->state = 107; // 동기화 시작

                    /* 한번 동기화 되었다가 삭제 후 재시도 시를 위해 my_level과 follow_level 설정값을 바꿈 */
                    $obj->follow_level = $args->follow_level?$args->follow_level:$args->my_level;
                    $this->updateAntiaccessFollowhost($obj);

                    $followhost_info = $oAntiaccessModel->getAntiaccessFollowhostInfo($obj);

                    // 동기화 진행
					$body->act = 'procAntiaccessSync';
					$body->follow_key = $followhost_info->follow_key;
					$body->state = 108;
					$body->mode = 'ban';
					$body->page = 1;
                    $buff = $oAntiaccessModel->sendRequest($followhost_info->host, $body, false);
                break;
                case 108: // 동기화 중 (처음 요청자 동기화 시도)
                    $obj->mode = 'sync';

                    // 동기화 중 상대방이나 내가 Follow Host를 삭제하면 동기화 중지
                    $obj->follow_key = $args->follow_key;
                    $followhost_info = $oAntiaccessModel->getAntiaccessFollowhostInfo($obj);
                    if(!$followhost_info || $followhost_info->state == 122) return;

                    $obj->follow_srl = $followhost_info->follow_srl;
                    $obj->state = 108; // 동기화 중
                    $this->updateAntiaccessFollowhost($obj);

                    // 동기화 모드를 처음은 ban 그다음은 white순으로 동기화진행
                    if($args->mode == 'ban') $output = $this->procAntiaccessFollowBanipSet($args, 108);
                    elseif($args->mode == 'white') $output = $this->procAntiaccessFollowWhiteipSet($args, 108);
                    // 아직 동기화 처리중이라면 다음스탭 진행 중단
                    if(!$output) return;
                    // 나의 동기화가 완료 되었다면 상대방 측으로 동기화 시도 요청
                    if($output->state == 109) {
                        // 동기화 진행
						$body->act = 'procAntiaccessSync';
						$body->follow_key = $output->follow_key;
						$body->state = $output->state;
						$body->mode = $output->mode;
						$body->page = $output->page;
                        $buff = $oAntiaccessModel->sendRequest($output->host, $body, false);

                        return;
                    }

                    // Ban IP 동기화가 완료되면 White IP 동기화 시도
					$body->act = 'procAntiaccessSync';
					$body->follow_key = $output->follow_key;
					$body->state = $output->state;
					$body->mode = $output->mode;
					$body->page = $output->page;
                    $buff = $oAntiaccessModel->sendRequest($output->host, $body, false);
                break;
                case 109: // 동기화 중 (처음 요청자 동기화 완료 후 동기화 시도)
                    $obj->mode = 'sync';

                    // 동기화 중 상대방이나 내가 Follow Host를 삭제하면 동기화 중지
                    $obj->follow_key = $args->follow_key;
                    $followhost_info = $oAntiaccessModel->getAntiaccessFollowhostInfo($obj);
                    if(!$followhost_info || $followhost_info->state == 122) return;

                    $obj->follow_srl = $followhost_info->follow_srl;
                    $obj->state = 109; // 동기화 중
                    $this->updateAntiaccessFollowhost($obj);

                    // 동기화 모드를 처음은 ban 그다음은 white순으로 동기화진행
                    if($args->mode == 'ban') $output = $this->procAntiaccessFollowBanipSet($args, 109);
                    elseif($args->mode == 'white') $output = $this->procAntiaccessFollowWhiteipSet($args, 109);
                    // 아직 동기화 처리중이라면 다음스탭 진행 중단
                    if(!$output) return;
                    // 동기화가 완료 되었다면 동기화 완료 신호를 보냄
                    if($output->state == 100) {
                        // 동기화 완료 신호를 보냄
						$body->act = 'procAntiaccessSync';
						$body->follow_key = $output->follow_key;
						$body->state = 100;
                        $buff = $oAntiaccessModel->sendRequest($output->host, $body, false);
                        $obj->mode = 'sync';

                        $obj->follow_key = $args->follow_key;
                        $obj->state = 100;  // 동기화 완료
                        $this->updateAntiaccessFollowhost($obj);

                        return;
                    }

                    // Ban IP 동기화가 완료되면 White IP 동기화 시도
					$body->act = 'getAntiaccessFollowCall';
					$body->follow_key = $output->follow_key;
					$body->state = $output->state;
					$body->mode = $output->mode;
					$body->page = $output->page;
                    $buff = $oAntiaccessModel->sendRequest($output->host, $body, false);
                break;
                case 110: // Follow 정보 수정 (한쪽에서 수정할때 다른 한쪽으로 값을 보내 적용)
                    $obj->follow_key = $args->follow_key;
                    $followhost_info = $oAntiaccessModel->getAntiaccessFollowhostInfo($obj);
                    if(!$followhost_info) return;
                    $obj->mode = 'sync';

                    $obj->follow_srl = $followhost_info->follow_srl;
                    $obj->follow_level = $args->my_level;
                    $this->updateAntiaccessFollowhost($obj);
                    $this->add('state',111); // 정보 수정 완료
                break;
                case 120: // Follow Host 삭제 (한쪽에서 삭제할때 다른 한쪽으로 삭제했다는 값을 보냄)
                    $obj->host = $args->host;
                    $obj->follow_key = $args->follow_key;
                    $followhost_info = $oAntiaccessModel->getAntiaccessFollowhostInfo($obj);
                    if(!$followhost_info) return;
                    $obj->mode = 'sync';

                    $obj->follow_srl = $followhost_info->follow_srl;
                    $obj->state = 122; // Follow 삭제라는 메시지 상태를 표시
                    // 만약 동기화를 하지 않은 상태라면 해당 Follow Host를 삭제
                    if(!$followhost_info->follow_key && $followhost_info->state == 104) $this->deleteAntiaccessFollowhost($obj);
                    else $this->updateAntiaccessFollowhost($obj);
                    $this->add('state',121); // 정보 삭제 완료
                break;
                case 201: // Ban ip 전달 받음
                    $obj->follow_key = $args->follow_key;
                    $followhost_info = $oAntiaccessModel->getAntiaccessFollowhostInfo($obj);
                    if(!$followhost_info) return;
                    $my_level = $followhost_info->my_level;

                    //$obj->mode = 'sync';

                    // 이미 해당 IP가 존재한다면 수행 중단
                    $obj->ipaddress = $args->ipaddress;
                    $is_banip = $oAntiaccessModel->getAntiaccessBanipCount($obj);
                    if($is_banip) return;

                    // Source host가 거부 host라면 수행 중단
                    $obj->source_host = $args->source_host;
                    $obj->host = $obj->source_host;
                    $obj->ban_type = 'Y';
                    $is_banhost = $oAntiaccessModel->getAntiaccessBanhostCount($obj);
                    if($is_banhost) return;

                    // follow state, my_level에 따른 적용값을 선언
                    $oAntiaccessModel->getAntiaccessApplyMode($my_level);
                    $obj->apply = Context::get('anti_apply');
                    $follow_host = $oAntiaccessModel->parseUri($args->follow_host, 'www');
                    $obj->follow_host = $follow_host['host'];

					// 추가 값 선언
					$obj->country_code = $args->country_code;
					$obj->public = 'Y';

                    // 캐시 이용이 차단과 동시에 사용이라면 캐시 생성
                    if($anti_config->cache->cache_type == 1 && $obj->apply == 'Y') @FileHandler::writeFile($this->cache_ban_path.$obj->ipaddress, "Y", 'w');

                    // Ban ip 등록
                    $this->insertAntiaccessBanip($obj);
                    $this->add('state',202); // Ban ip 등록 완료
                break;
                case 211: // White ip 전달 받음
                    $obj->follow_key = $args->follow_key;
                    $followhost_info = $oAntiaccessModel->getAntiaccessFollowhostInfo($obj);
                    if(!$followhost_info) return;

                    //$obj->mode = 'sync';

                    // 이미 해당 IP가 존재한다면 수행 중단
                    $obj->ipaddress = $args->ipaddress;
                    $is_whiteip = $oAntiaccessModel->getAntiaccessWhiteipCount($obj);
                    if($is_whiteip) return;

                    // Source host가 거부 host라면 수행 중단
                    $obj->source_host = $args->source_host;
                    $obj->host = $obj->source_host;
                    $obj->white_type = 'Y';
                    $whiteip_info = $oAntiaccessModel->getAntiaccessBanhostInfo($obj);
                    if($whiteip_info) return;

                    // follow state, my_level에 따른 적용값을 선언
                    $oAntiaccessModel->getAntiaccessApplyMode($followhost_info->my_level);
                    $obj->apply = Context::get('anti_apply');
                    $follow_host = $oAntiaccessModel->parseUri($args->follow_host, 'www');
                    $obj->follow_host = $follow_host['host'];

					// 추가 값 선언
					$obj->country_code = $args->country_code;
					$obj->public = 'Y';

                    // 캐시 이용이 차단과 동시에 사용이라면 캐시 생성
                    if($anti_config->cache->cache_type == 1 && $obj->apply == 'Y') @FileHandler::writeFile($this->cache_white_path.$obj->ipaddress, "Y", 'w');

                    // White ip 등록
                    $this->insertAntiaccessWhiteip($obj);
                    $this->add('state',212); // White ip 등록 완료
                break;
                case 301: // Ban ip 삭제 요청 받음
                    $obj->follow_key = $args->follow_key;
                    $is_followhost = $oAntiaccessModel->getAntiaccessFollowhostCount($obj);
                    if(!$is_followhost) return;

                    //$obj->mode = 'sync';

                    // 삭제를 요청한 IP의 Source host가 다를 경우는 수행 중단
                    $obj->ipaddress = $args->ipaddress;
                    $obj->source_host = $args->source_host;
                    $is_banip = $oAntiaccessModel->getAntiaccessBanipCount($obj);
                    if(!$is_banip) return;

                    // 캐시 삭제
                    @FileHandler::removeFile($this->cache_ban_path.$obj->ipaddress);

                    // Ban ip 삭제
                    $this->deleteAntiaccessBanip($obj);
                    $this->add('state',302); // Ban ip 삭제 완료
                break;
                case 311: // White ip 삭제 요청 받음
                    $obj->follow_key = $args->follow_key;
                    $is_followhost = $oAntiaccessModel->getAntiaccessFollowhostCount($obj);
                    if(!$is_followhost) return;

                    //$obj->mode = 'sync';

                    // 삭제를 요청한 IP의 Source host가 다를 경우는 수행 중단
                    $obj->ipaddress = $args->ipaddress;
                    $obj->source_host = $args->source_host;
                    $is_whiteip = $oAntiaccessModel->getAntiaccessWhiteipCount($obj);
                    if(!$is_whiteip) return;

                    // 캐시 삭제
                    @FileHandler::removeFile($this->cache_white_path.$obj->ipaddress);

                    $this->deleteAntiaccessWhiteip($obj);
                    $this->add('state',312); // White ip 삭제 완료
                break;
                case 509:
                    $obj->mode = 'sync';
                    $oAntiaccessModel = &getModel('antiaccess');

                    // 동기화 중 상대방이나 내가 Follow Host를 삭제하면 동기화 중지
                    $obj->follow_key = $args->follow_key;
                    $followhost_info = $oAntiaccessModel->getAntiaccessFollowhostInfo($obj);
                    if(!$followhost_info || $followhost_info->state == 122) return;

                    $obj->follow_srl = $followhost_info->follow_srl;
                    $obj->state = 509; // 동기화 중
                    $this->updateAntiaccessFollowhost($obj);

                    if($args->mode == 'sync') return;

                    // 동기화 중 신호를 보냄
					$body->act = 'procAntiaccessSync';
					$body->follow_key = $followhost_info->follow_key;
					$body->mode = 'sync';
					$body->state = 509;
                    $buff = $oAntiaccessModel->sendRequest($followhost_info->host, $body, true);

                    // 동기화 모드를 처음은 ban 그다음은 white순으로 동기화진행
                    if($args->mode == 'ban') $output = $this->procAntiaccessFollowBanipGet($args, 509);
                    elseif($args->mode == 'white') $output = $this->procAntiaccessFollowWhiteipGet($args, 509);
                    // 아직 동기화 처리중이라면 다음스탭 진행 중단
                    if(!$output) return;
                    // 나의 동기화가 완료 되었다면 상대방 측으로 동기화 시도 요청
                    if($output->state == 510) {
                        // 동기화 진행
						$body->act = 'procAntiaccessSync';
						$body->follow_key = $output->follow_key;
						$body->state = $output->state;
						$body->mode = $output->mode;
						$body->page = $output->page;
                        $buff = $oAntiaccessModel->sendRequest(Context::get('request_uri'), $body, false);

                        return;
                    }

                    // Ban IP 동기화가 완료되면 White IP 동기화 시도
					$body->act = 'procAntiaccessSync';
					$body->follow_key = $output->follow_key;
					$body->state = $output->state;
					$body->mode = $output->mode;
					$body->page = $output->page;
                    $buff = $oAntiaccessModel->sendRequest(Context::get('request_uri'), $body, false);
                break;
                case 510: // 동기화 중 (처음 요청자 동기화 완료 후 동기화 시도)
                    $obj->mode = 'sync';

                    // 동기화 중 상대방이나 내가 Follow Host를 삭제하면 동기화 중지
                    $obj->follow_key = $args->follow_key;
                    $followhost_info = $oAntiaccessModel->getAntiaccessFollowhostInfo($obj);
                    if(!$followhost_info || $followhost_info->state == 122) return;

                    $obj->follow_srl = $followhost_info->follow_srl;
                    $obj->state = 510; // 동기화 중
                    $this->updateAntiaccessFollowhost($obj);

                    if($args->mode == 'sync') return;

                    // 동기화 중 신호를 보냄
					$body->act = 'procAntiaccessSync';
					$body->follow_key = $followhost_info->follow_key;
					$body->mode = 'sync';
					$body->state = 510;
                    $buff = $oAntiaccessModel->sendRequest($followhost_info->host, $body, true);

                    // 동기화 모드를 처음은 ban 그다음은 white순으로 동기화진행
                    if($args->mode == 'ban') $output = $this->procAntiaccessFollowBanipSet($args, 510);
                    elseif($args->mode == 'white') $output = $this->procAntiaccessFollowWhiteipSet($args, 510);
                    // 아직 동기화 처리중이라면 다음스탭 진행 중단
                    if(!$output) return;
                    // 동기화가 완료 되었다면 동기화 완료 신호를 보냄
                    if($output->state == 100) {
                        // 동기화 완료 신호를 보냄
						$body->act = 'procAntiaccessSync';
						$body->follow_key = $output->follow_key;
						$body->state = 100;
                        $buff = $oAntiaccessModel->sendRequest($output->host, $body, true);
                        $obj->mode = 'sync';

                        $obj->follow_key = $args->follow_key;
                        $obj->state = 100;  // 동기화 완료
                        $this->updateAntiaccessFollowhost($obj);

                        return;
                    }

                    // Ban IP 동기화가 완료되면 White IP 동기화 시도
					$body->act = 'procAntiaccessSync';
					$body->follow_key = $output->follow_key;
					$body->state = $output->state;
					$body->mode = $output->mode;
					$body->page = $output->page;
                    $buff = $oAntiaccessModel->sendRequest(Context::get('request_uri'), $body, false);
                break;
                default: // state code 값이 선언되어있지 않은 경우는 error 404를 보냄
                    $this->add('error',404);
                break;
            }
        }

        /**
         * @brief Anti-accessXE XML request Ban Ip Synchronization
         **/
        function procAntiaccessFollowBanipSet($args = null, $state = 108) {
            if(!$args) return;
            // 간혹 동기화 처리 중 제한 시간으로 인해 실패하는 경우를 위해 처리
            @set_time_limit(0);
            $oModuleModel = &getModel('module');
            $oAntiaccessModel = &getModel('antiaccess');

            // Antiaccess config load
            $anti_config = $oModuleModel->getModuleConfig('antiaccess');

            $obj->follow_key = $args->follow_key;
            $followhost_info = $oAntiaccessModel->getAntiaccessFollowhostInfo($obj);

            // IP 적용 여부 설정 (이곳에서는 선언 후 Follow로 IP를 보낼때 재 설정되는 경우로 인해 선언 값을 따로 기억시킴)
            $oAntiaccessModel->getAntiaccessApplyMode($followhost_info->my_level);
            $apply = Context::get('anti_apply');
            $not_follow_host = Context::get('not_follow_host');
            $is_follow_host = Context::get('is_follow_host');

            // Ban IP 적용 설정 (Ban IP를 적용하도록 설정한 level만 진행)
            if(in_array($followhost_info->my_level, array(101,102,103,104,111,112,113,114,121,122,123,124))) {

				// XML
				$body->act = 'getAntiaccessBanipApi';
				$body->follow_key = $followhost_info->follow_key;
				$body->not_follow_host = $not_follow_host;
				$body->is_follow_host = $is_follow_host;
				$body->page = $args->page;
                $buff = $oAntiaccessModel->sendRequest($followhost_info->host, $body, true);
                
                // 정보를 받지 못할 경우 다음 스탭을 진행
                if(!$buff || $buff->response->error->body == 401) {
                    $output->follow_key = $followhost_info->follow_key;
                    $output->state = $state;
                    $output->mode = 'white';
                    $output->page = 1;
                    $output->host = $followhost_info->host;

                    return $output;
                }

                // 1건일 경우는 배열화 시킴
                if(!is_array($buff->response->items->item)) $buff->response->items->item = array($buff->response->items->item);
                foreach($buff->response->items->item as $val) {
                    $obj->mode = 'sync'; // 이 부분을 주석 해제하면 IP 입력 후 다른 Follow 들에게 정보를 보내지 않음

                    // 사설 IP라면 다음 값을 진행
                    if(!$oAntiaccessModel->checkIpaddress($val->ipaddress->body)) continue;

                    // Source host가 거부 host라면 다음 값을 진행
                    $obj->host = $val->source_host->body;
                    $obj->ban_type = 'Y';
                    $is_banhost = $oAntiaccessModel->getAntiaccessBanhostCount($obj);
                    if($is_banhost) continue;

                    // 이미 존재한다면 다음 값을 진행
                    $obj->ipaddress = $val->ipaddress->body;
                    $is_banip = $oAntiaccessModel->getAntiaccessBanipCount($obj);
                    if($is_banip) continue;

					// 국가코드 구하기
					if($val->country_code->body) $obj->country_code = $val->country_code->body;

                    // 추가할 정보를 만듬
                    $obj->source_host = $val->source_host->body;
                    $follow_host = $oAntiaccessModel->parseUri($followhost_info->host, 'www');
                    $obj->follow_host = $follow_host['host'];
                    $obj->apply = $apply;

                    // 차단과 동시에 캐시를 만들 경우 캐시 생성
                    if($anti_config->cache->cache_type == 1 && $apply == 'Y') @FileHandler::writeFile($this->cache_ban_path.$val->ipaddress->body, "Y", 'w');

                    // 입력 과정에서 sync 모드가 아니라면 나의 Follow들에게 이 IP를 보냄
                    $this->insertAntiaccessBanip($obj);
                    unset($obj);

                    // 부하를 방지하기 위해 딜레이를 줌
                    sleep(2);
                }

                // 사이클이 돌때마다 부하를 방지하기 위해 딜레이를 줌
                sleep(2);

				$follow_obj->follow_srl = $followhost_info->follow_srl;
				$follow_obj->mode = 'sync';
				$follow_obj->extra_vars->type = 'ban';
				$follow_obj->extra_vars->total_page = $buff->response->total_page->body;
				$follow_obj->extra_vars->page = $args->page;
				$follow_obj->extra_vars->state = 'my';
				$follow_obj->extra_vars = serialize($follow_obj->extra_vars);
				$this->updateAntiaccessFollowhost($follow_obj);

                // 보내준 내용의 전체 페이지수와 요청 페이지 수가 같을 경우 다음 스텝을 진행
                if($buff->response->total_page->body <= $args->page) {
                    $output->follow_key = $followhost_info->follow_key;
                    $output->state = $state;
                    $output->mode = 'white';
                    $output->page = 1;
                    $output->host = $followhost_info->host;

                    return $output;
                }

                if($followhost_info->rank == 'S') {	
                	// 동기화 진행 (상대방이 구독자(Subscriber)일 경우 본인의 주소로 내용의 페이지를 증가시켜 새로운 건을 받음)
					$body->act = 'procAntiaccessSync';
					$body->follow_key = $followhost_info->follow_key;
					$body->state = $state;
					$body->mode = 'ban';
					$body->page = $args->page+1;
			        $buff = $oAntiaccessModel->sendRequest(Context::get('request_uri'), $body, false);
				} else {
	                // 동기화 진행 (내용의 페이지를 증가시켜 새로운 건을 받음)
					$body->act = 'getAntiaccessFollowCall';
					$body->follow_key = $followhost_info->follow_key;
					$body->state = $state;
					$body->mode = 'ban';
					$body->page = $args->page+1;
	                $buff = $oAntiaccessModel->sendRequest($followhost_info->host, $body, false);
				}

                return false;
            } else {
                // Ban IP 정보를 처리하지 않는 설정일 경우 다음 스탭을 진행
                $output->follow_key = $followhost_info->follow_key;
                $output->state = $state;
                $output->mode = 'white';
                $output->page = 1;
                $output->host = $followhost_info->host;

                return $output;
            }
        }

        /**
         * @brief Anti-accessXE XML transmission Ban Ip Synchronization
         **/
        function procAntiaccessFollowBanipGet($args = null, $state = 509) {
            if(!$args) return;
            // 간혹 동기화 처리 중 제한 시간으로 인해 실패하는 경우를 위해 처리
            @set_time_limit(0);
            $oModuleModel = &getModel('module');
            $oAntiaccessModel = &getModel('antiaccess');

            // Antiaccess config load
            $anti_config = $oModuleModel->getModuleConfig('antiaccess');

            $obj->follow_key = $args->follow_key;
            $followhost_info = $oAntiaccessModel->getAntiaccessFollowhostInfo($obj);

            // IP 적용 여부 설정 (이곳에서는 선언 후 Follow로 IP를 보낼때 재 설정되는 경우로 인해 선언 값을 따로 기억시킴)
            $oAntiaccessModel->getAntiaccessApplyMode($followhost_info->my_level);
            $apply = Context::get('anti_apply');
            $not_follow_host = Context::get('not_follow_host');
            $is_follow_host = Context::get('is_follow_host');

            // Ban IP 적용 설정 (Ban IP를 적용하도록 설정한 level만 진행)
            if(in_array($followhost_info->my_level, array(101,102,103,104,111,112,113,114,121,122,123,124))) {
				$obj->order_type = 'asc';
				$ban_obj->page = $args->page;
				$ban_obj->list_count = 50;
				if($not_follow_host == 'Y') $ban_obj->not_follow_host = array($followhost_info->host);
				if($is_follow_host == 'Y') $ban_obj->is_follow_host = array($followhost_info->host);
				$ban_output = $oAntiaccessModel->getAntiaccessBanipList($ban_obj);

				// XML
				$body->act = 'setAntiaccessBanipApi';
				$body->follow_key = $followhost_info->follow_key;
				$body->output = serialize($ban_output->data);
				$body->total_page = $ban_output->page_navigation->total_page;
				$body->page = $args->page;
                $buff = $oAntiaccessModel->sendRequest($followhost_info->host, $body, true);

				$follow_obj->follow_srl = $followhost_info->follow_srl;
				$follow_obj->mode = 'sync';
				$follow_obj->extra_vars->type = 'ban';
				$follow_obj->extra_vars->total_page = $ban_output->page_navigation->total_page;
				$follow_obj->extra_vars->page = $args->page;
				$follow_obj->extra_vars->state = 'follower';
				$follow_obj->extra_vars = serialize($follow_obj->extra_vars);
				$this->updateAntiaccessFollowhost($follow_obj);

                // 더 이상 정보가 없다면 (전체 페이지 수와 요청 페이지 수가 같다면) 처리를 종료
				if($ban_output->page_navigation->total_page <= $args->page) {
                    $output->follow_key = $followhost_info->follow_key;
                    $output->state = $state;
                    $output->mode = 'white';
                    $output->page = 1;
                    $output->host = $followhost_info->host;

                    return $output;
                }

				sleep(5);

                // 동기화 진행
				$body->act = 'procAntiaccessSync';
				$body->follow_key = $followhost_info->follow_key;
				$body->state = 509;
				$body->mode = 'ban';
				$body->page = $args->page+1;
                $buff = $oAntiaccessModel->sendRequest(Context::get('request_uri'), $body, false);

                return false;
            } else {
                // Ban IP 정보를 처리하지 않는 설정일 경우 다음 스탭을 진행
                $output->follow_key = $followhost_info->follow_key;
                $output->state = $state;
                $output->mode = 'white';
                $output->page = 1;
                $output->host = $followhost_info->host;

                return $output;
            }
        }

        /**
         * @brief Anti-accessXE XML request White Ip Synchronization
         **/
        function procAntiaccessFollowWhiteipSet($args = null, $state = 108) {
            if(!$args) return;
            // 간혹 동기화 처리 중 제한 시간으로 인해 실패하는 경우를 위해 처리
            @set_time_limit(0);
            $oModuleModel = &getModel('module');
            $oAntiaccessModel = &getModel('antiaccess');

            // Antiaccess config load
            $anti_config = $oModuleModel->getModuleConfig('antiaccess');

            $obj->follow_key = $args->follow_key;
            $followhost_info = $oAntiaccessModel->getAntiaccessFollowhostInfo($obj);

            // IP 적용 여부 설정 (이곳에서는 선언 후 Follow로 IP를 보낼때 재 설정되는 경우로 인해 선언 값을 따로 기억시킴)
            $oAntiaccessModel->getAntiaccessApplyMode($followhost_info->my_level);
            $apply = Context::get('anti_apply');
            $not_follow_host = Context::get('not_follow_host');
            $is_follow_host = Context::get('is_follow_host');

            // White IP 적용 설정 (White IP를 적용하도록 설정한 level만 진행)
            if(in_array($followhost_info->my_level, array(101,102,105,106,111,112,115,116,121,122,125,126))) {

				// XML
				$body->act = 'getAntiaccessWhiteipApi';
				$body->follow_key = $followhost_info->follow_key;
				$body->not_follow_host = $not_follow_host;
				$body->is_follow_host = $is_follow_host;
				$body->page = $args->page;
                $buff = $oAntiaccessModel->sendRequest($followhost_info->host, $body, true);

                // 정보를 받지 못할 경우 다음 스탭을 진행
                if(!$buff || $buff->response->error->body == 401) {
                    $output->follow_key = $follow_info->follow_key;
                    if($followhost_info->rank == 'S') {
	                	$output->state = $state==510?100:510;
                    } else {
	                    $output->state = $state==109?100:109;
                    }
                    $output->mode = 'ban';
                    $output->page = 1;
                    $output->host = $follow_info->host;

                    return $output;
                }
                // 1건일 경우는 배열화 시킴
                if(!is_array($buff->response->items->item)) $buff->response->items->item = array($buff->response->items->item);
                foreach($buff->response->items->item as $val) {
                    $obj->mode = 'sync'; // 이 부분을 주석 해제하면 IP 입력 후 다른 Follow 들에게 정보를 보내지 않음

                    // 사설 IP라면 다음 값을 진행
                    if(!$oAntiaccessModel->checkIpaddress($val->ipaddress->body)) continue;

                    // Source host가 거부 host라면 다음 값을 진행
                    $obj->host = $val->source_host->body;
                    $obj->white_type = 'Y';
                    $is_banhost = $oAntiaccessModel->getAntiaccessBanhostCount($obj);
                    if($is_banhost) continue;

                    // 이미 존재한다면 다음 값을 진행
                    $obj->ipaddress = $val->ipaddress->body;
                    $is_whiteip = $oAntiaccessModel->getAntiaccessWhiteipCount($obj);
                    if($is_whiteip) continue;

					// 국가코드 구하기
					if($val->country_code->body) $obj->country_code = $val->country_code->body;

                    // 추가할 정보를 만듬
                    $obj->source_host = $val->source_host->body;
                    $follow_host = $oAntiaccessModel->parseUri($followhost_info->host, 'www');
                    $obj->follow_host = $follow_host['host'];
                    $obj->apply = $apply;

                    // 차단과 동시에 캐시를 만들 경우 캐시 생성
                    if($anti_config->cache->cache_type == 1 && $apply == 'Y') @FileHandler::writeFile($this->cache_white_path.$val->ipaddress->body, "Y", 'w');

                    // 입력 과정에서 sync 모드가 아니라면 나의 Follow들에게 이 IP를 보냄
                    $this->insertAntiaccessWhiteip($obj);
                    unset($obj);

                    // 부하를 방지하기 위해 딜레이를 줌
                    sleep(2);
                }

                // 사이클이 돌때마다 부하를 방지하기 위해 딜레이를 줌
                sleep(2);

				$follow_obj->follow_srl = $followhost_info->follow_srl;
				$follow_obj->mode = 'sync';
				$follow_obj->extra_vars->type = 'white';
				$follow_obj->extra_vars->total_page = $buff->response->total_page->body;
				$follow_obj->extra_vars->page = $args->page;
				$follow_obj->extra_vars->state = 'my';
				$follow_obj->extra_vars = serialize($follow_obj->extra_vars);
				$this->updateAntiaccessFollowhost($follow_obj);

                // 보내준 내용의 전체 페이지수와 요청 페이지 수가 같을 경우 다음 스텝을 진행
                if($buff->response->total_page->body <= $args->page) {
                    $output->follow_key = $followhost_info->follow_key;
                    if($followhost_info->rank == 'S') {
	                	$output->state = $state==510?100:510;
                    } else {
	                    $output->state = $state==109?100:109;
                    }
                    $output->mode = 'ban';
                    $output->page = 1;
                    $output->host = $followhost_info->host;

                    return $output;
                }

                if($followhost_info->rank == 'S') {	
                	// 동기화 진행 (상대방이 구독자(Subscriber)일 경우 본인의 주소로 내용의 페이지를 증가시켜 새로운 건을 받음)
					$body->act = 'procAntiaccessSync';
					$body->follow_key = $followhost_info->follow_key;
					$body->state = $state;
					$body->mode = 'white';
					$body->page = $args->page+1;
			        $buff = $oAntiaccessModel->sendRequest(Context::get('request_uri'), $body, false);
				} else {
	                // 동기화 진행 (내용의 페이지를 증가시켜 새로운 건을 받음)
					$body->act = 'getAntiaccessFollowCall';
					$body->follow_key = $followhost_info->follow_key;
					$body->state = $state;
					$body->mode = 'white';
					$body->page = $args->page+1;
	                $buff = $oAntiaccessModel->sendRequest($followhost_info->host, $body, false);
				}

                return false;
            } else {
                // White IP 정보를 처리하지 않는 설정일 경우 다음 스탭을 진행
                $output->follow_key = $followhost_info->follow_key;
                if($followhost_info->rank == 'S') {
                	$output->state = $state==510?100:510;
                } else {
                    $output->state = $state==109?100:109;
                }
                $output->mode = 'ban';
                $output->page = 1;
                $output->host = $followhost_info->host;

                return $output;
            }
        }

        /**
         * @brief Anti-accessXE XML transmission White Ip Synchronization
         **/
        function procAntiaccessFollowWhiteipGet($args = null, $state = 509) {
            if(!$args) return;
            // 간혹 동기화 처리 중 제한 시간으로 인해 실패하는 경우를 위해 처리
            @set_time_limit(0);
            $oModuleModel = &getModel('module');
            $oAntiaccessModel = &getModel('antiaccess');

            // Antiaccess config load
            $anti_config = $oModuleModel->getModuleConfig('antiaccess');

            $obj->follow_key = $args->follow_key;
            $followhost_info = $oAntiaccessModel->getAntiaccessFollowhostInfo($obj);

            // IP 적용 여부 설정 (이곳에서는 선언 후 Follow로 IP를 보낼때 재 설정되는 경우로 인해 선언 값을 따로 기억시킴)
            $oAntiaccessModel->getAntiaccessApplyMode($followhost_info->my_level);
            $apply = Context::get('anti_apply');
            $not_follow_host = Context::get('not_follow_host');
            $is_follow_host = Context::get('is_follow_host');

            // White IP 적용 설정 (White IP를 적용하도록 설정한 level만 진행)
            if(in_array($followhost_info->my_level, array(101,102,105,106,111,112,115,116,121,122,125,126))) {
				$obj->order_type = 'asc';
				$white_obj->page = $args->page;
				$white_obj->list_count = 50;
				if($not_follow_host == 'Y') $ban_obj->not_follow_host = array($followhost_info->host);
				if($is_follow_host == 'Y') $ban_obj->is_follow_host = array($followhost_info->host);
				$white_output = $oAntiaccessModel->getAntiaccessWhiteipList($white_obj);

				// XML
				$body->act = 'setAntiaccessWhiteipApi';
				$body->follow_key = $followhost_info->follow_key;
				$body->output = serialize($white_output->data);
				$body->total_page = $white_output->page_navigation->total_page;
				$body->page = $args->page;
                $buff = $oAntiaccessModel->sendRequest($followhost_info->host, $body, true);

				$follow_obj->follow_srl = $followhost_info->follow_srl;
				$follow_obj->mode = 'sync';
				$follow_obj->extra_vars->type = 'white';
				$follow_obj->extra_vars->total_page = $white_output->page_navigation->total_page;
				$follow_obj->extra_vars->page = $args->page;
				$follow_obj->extra_vars->state = 'follower';
				$follow_obj->extra_vars = serialize($follow_obj->extra_vars);
				$this->updateAntiaccessFollowhost($follow_obj);

                // 더 이상 정보가 없다면 (전체 페이지 수와 요청 페이지 수가 같다면) 처리를 종료
				if($white_output->page_navigation->total_page <= $args->page) {
                    $output->follow_key = $followhost_info->follow_key;
                    $output->state = $state==510?100:510;
                    $output->mode = 'ban';
                    $output->page = 1;
                    $output->host = $followhost_info->host;

                    return $output;
                }

				sleep(5);

                // 동기화 진행
				$body->act = 'procAntiaccessSync';
				$body->follow_key = $followhost_info->follow_key;
				$body->state = 510;
				$body->mode = 'white';
				$body->page = $args->page+1;
                $buff = $oAntiaccessModel->sendRequest(Context::get('request_uri'), $body, false);

                return false;
            } else {
                // White IP 정보를 처리하지 않는 설정일 경우 다음 스탭을 진행
                $output->follow_key = $followhost_info->follow_key;
                $output->state = $state==510?100:510;
                $output->mode = 'ban';
                $output->page = 1;
                $output->host = $followhost_info->host;

                return $output;
            }
        }

        /**
         * @brief Anti-accessXE XML request update config call
         **/
        function procAntiaccessFollowSync(&$obj) {
            if($obj->mode) return;
            $oAntiaccessModel = &getModel('antiaccess');

            // Follow 업데이트 시 Follow Key와 나의 Follow Host로부터 전달받을 IP 종류가 설정되어있지 않으면 수행 중단
            $args->follow_srl = $obj->follow_srl;
            $followhost_info = $oAntiaccessModel->getAntiaccessFollowhostInfo($args);
            if(!$followhost_info->my_level || !$followhost_info->follow_key) return;

            // Follow Host 대상이 응답하는지 확인
            if(!$oAntiaccessModel->getAntiaccessFollowCheck($followhost_info, true)) return new Object(-1, "msg_not_response");

            switch($followhost_info->state) {
                case 100: // 동기화 완료 상태에서 수정일 경우
                    // 상대방에게 수정 요청을 보냄 (단, 완료 값인 111이 아닐 경우는 수정 중단)
					$body->act = 'procAntiaccessSync';
					$body->follow_key = $followhost_info->follow_key;
					$body->state = 110;
					$body->my_level = $followhost_info->my_level;
                    $buff = $oAntiaccessModel->sendRequest($followhost_info->host, $body, true);
                    if(!$buff || $buff->response->state->body != 111) return new Object(-1, "msg_fail_to_update");
                break;
                case 104: // Follow에게 Key를 생성해서 보내고 동기화 시작 준비를 함
					$body->act = 'procAntiaccessSync';
					$body->host = Context::get('request_uri');
					$body->follow_key = $followhost_info->follow_key;
					$body->state = 105;
					$body->my_level = $followhost_info->my_level;
                    $buff = $oAntiaccessModel->sendRequest($followhost_info->host, $body, false);
                    $args->mode = 'sync';

                    $args->follow_srl = $followhost_info->follow_srl;
                    $args->state = 106;
                    $this->updateAntiaccessFollowhost($args);
                break;
                case 504: // Follow에게 Key를 생성해서 보내고 동기화 시작 준비를 함
					$body->act = 'procAntiaccessSync';
					$body->host = Context::get('request_uri');
					$body->follow_key = $followhost_info->follow_key;
					$body->state = 505;
					$body->my_level = $followhost_info->my_level;

                    if($followhost_info->rank == 'S') {
	                    $buff = $oAntiaccessModel->sendRequest($followhost_info->host, $body, true);
			            if($buff->response->key_complete->body == 506) {
		                    // 동기화 진행
							$body->act = 'procAntiaccessSync';
							$body->follow_key = $followhost_info->follow_key;
							$body->state = 509;
							$body->mode = 'ban';
							$body->page = 1;
		                    $buff = $oAntiaccessModel->sendRequest(Context::get('request_uri'), $body, false);
			            } else {
							 return new Object(-1, "msg_not_response");
			            }
                    } else {
	                    $buff = $oAntiaccessModel->sendRequest($followhost_info->host, $body, false);
                    }

                    $args->mode = 'sync';
                    $args->follow_srl = $followhost_info->follow_srl;
                    $args->state = 508;
                    $this->updateAntiaccessFollowhost($args);
                break;
                default: break;
            }
        }

        /**
         * @brief Anti-accessXE XML request delete call
         **/
        function procAntiaccessFollowDelete(&$obj) {
            if($obj->mode) return;
            $oAntiaccessModel = &getModel('antiaccess');

            $args->follow_srl = $obj->follow_srl;
            $followhost_info = $oAntiaccessModel->getAntiaccessFollowhostInfo($args);

            // Follow Host 삭제 정보를 보냄
			$body->act = 'procAntiaccessSync';
			$body->host = Context::get('request_uri');
			$body->state = 120;
            $buff = $oAntiaccessModel->sendRequest($followhost_info->host, $body, true);
        }

        /**
         * @brief Anti-accessXE Ban IP insert push
         **/
        function insertAntiaccessBanipPush(&$obj) {
            if($obj->mode) return;
            $oAntiaccessModel = &getModel('antiaccess');

            // 사설 IP라면 정보를 보내지 않음
            if(!$oAntiaccessModel->checkIpaddress($obj->ipaddress)) return;

            // 등록된 IP를 보낼 Follow 대상자 중 IP를 보내준 Follow Host를 제외 함
            if($obj->follow_key) $args->not_follow_key = $obj->follow_key;

            // 동기화가 안된 state code일 경우를 제외
            $args->not_state = array(103,104,105,106,122);
            $output = $oAntiaccessModel->getAntiaccessFollowhostTotal($args);
            foreach($output as $val) {
                // follow state, my_level에 따른 적용값을 선언
                $oAntiaccessModel->getAntiaccessApplyMode($val->follow_level);

                // 전부 값을 받지 않던가 white만 받는 설정일 경우 다음 Follow를 진행
                if(Context::get('is_ip_type') == '' || Context::get('is_ip_type') == 'white') continue;
                // Follow가 만든 IP일 경우가 아니면 다음 Follow를 진행
                if(Context::get('is_follow_host') == 'Y' && $obj->follow_host) continue;
                // Follow이외의 대상이 만든 IP일 경우가 아니면 다음 Follow를 진행
                if(Context::get('not_follow_host') == 'Y' && !$obj->follow_host) continue;

                // Ban ip 전달
				$body->act = 'procAntiaccessSync';
				$body->follow_key = $val->follow_key;
				$body->ipaddress = $obj->ipaddress;
				$body->country_code = $obj->country_code;
				$body->source_host = $obj->source_host;
				$body->follow_host = Context::get('request_uri');
				$body->state = 201;
				if($val->rank == 'S') $buff = $oAntiaccessModel->sendRequest($val->host, $body, true);
                else $buff = $oAntiaccessModel->sendRequest($val->host, $body, false);
            }
        }

        /**
         * @brief Anti-accessXE White IP insert push
         **/
        function insertAntiaccessWhiteipPush(&$obj) {
            if($obj->mode) return;
            $oAntiaccessModel = &getModel('antiaccess');

            // 사설 IP라면 정보를 보내지 않음
            if(!$oAntiaccessModel->checkIpaddress($obj->ipaddress)) return;

            // 등록된 IP를 보낼 Follow 대상자 중 IP를 보내준 Follow Host를 제외 함
            if($obj->follow_key) $args->not_follow_key = $obj->follow_key;

            // 동기화가 안된 state code일 경우를 제외
            $args->not_state = array(103,104,105,106,122);
            $output = $oAntiaccessModel->getAntiaccessFollowhostTotal($args);
            foreach($output as $val) {
                // follow state, my_level에 따른 적용값을 선언
                $oAntiaccessModel->getAntiaccessApplyMode($val->follow_level);

                // 전부 값을 받지 않던가 white만 받는 설정일 경우 다음 Follow를 진행
                if(Context::get('is_ip_type') == '' || Context::get('is_ip_type') == 'ban') continue;
                // Follow가 만든 IP일 경우가 아니면 다음 Follow를 진행
                if(Context::get('is_follow_host') == 'Y' && $obj->follow_host) continue;
                // Follow이외의 대상이 만든 IP일 경우가 아니면 다음 Follow를 진행
                if(Context::get('not_follow_host') == 'Y' && !$obj->follow_host) continue;

                // White ip 전달
				$body->act = 'procAntiaccessSync';
				$body->follow_key = $val->follow_key;
				$body->ipaddress = $obj->ipaddress;
				$body->country_code = $obj->country_code;
				$body->source_host = $obj->source_host;
				$body->follow_host = Context::get('request_uri');
				$body->state = 211;
                if($val->rank == 'S') $buff = $oAntiaccessModel->sendRequest($val->host, $body, true);
                else $buff = $oAntiaccessModel->sendRequest($val->host, $body, false);
            }
        }

        /**
         * @brief Anti-accessXE Ban IP delete push
         **/
        function deleteAntiaccessBanipPush(&$obj) {
            if($obj->mode) return;
            $oAntiaccessModel = &getModel('antiaccess');

            // 직접 삭제하는 경우
            if($obj->cart) {
                foreach($obj->cart as $key) {
                    $args->ban_srl = $key;
                    $banip_info = $oAntiaccessModel->getAntiaccessBanipInfo($args);
                    if(!$banip_info) continue;
                    // 해당 IP를 최초 생성하지 않았다면 다음을 진행
                    if($banip_info->follow_host) continue;
					// 공개한 IP가 아니면 다음을 진행
					if($banip_info->public != 'Y') continue;

                    // 삭제된 IP를 보낼 Follow 대상자 중 IP를 보내준 Follow Host를 제외 함
                    if($obj->follow_key) $args->not_follow_key = $obj->follow_key;

                    // 동기화가 안된 state code일 경우를 제외
                    $args->not_state = array(103,104,105,106,122);
                    $output = $oAntiaccessModel->getAntiaccessFollowhostTotal($args);
                    foreach($output as $val) {
                        // follow state, my_level에 따른 적용값을 선언
                        $oAntiaccessModel->getAntiaccessApplyMode($val->follow_level);
                        if(Context::get('is_ip_type') == '' || Context::get('is_ip_type') == 'white') continue;

                        // Ban ip 삭제 정보를 보냄
						$body->act = 'procAntiaccessSync';
						$body->follow_key = $val->follow_key;
						$body->ipaddress = $banip_info->ipaddress;
						$body->source_host = $banip_info->source_host;
						$body->state = 301;
                        if($val->rank == 'S') $buff = $oAntiaccessModel->sendRequest($val->host, $body, true);
                        else $buff = $oAntiaccessModel->sendRequest($val->host, $body, false);
                    }
                }
            } else { // 삭제 대상 IP값이 Follow로 부터 넘어온 경우
                $banip_info = $oAntiaccessModel->getAntiaccessBanipInfo($obj);
                if(!$banip_info) return;

                // 삭제된 IP를 보낼 Follow 대상자 중 IP를 보내준 Follow Host를 제외 함
                if($obj->follow_key) $args->not_follow_key = $obj->follow_key;

                // 동기화가 안된 state code일 경우를 제외
                $args->not_state = array(103,104,105,106,122);
                $output = $oAntiaccessModel->getAntiaccessFollowhostTotal($args);
                foreach($output as $val) {
                    // follow state, my_level에 따른 적용값을 선언
                    $oAntiaccessModel->getAntiaccessApplyMode($val->follow_level);
                    if(Context::get('is_ip_type') == '' || Context::get('is_ip_type') == 'white') continue;

                    // Ban ip 삭제 정보를 보냄
					$body->act = 'procAntiaccessSync';
					$body->follow_key = $val->follow_key;
					$body->ipaddress = $banip_info->ipaddress;
					$body->source_host = $banip_info->source_host;
					$body->state = 301;
                    if($val->rank == 'S') $buff = $oAntiaccessModel->sendRequest($val->host, $body, true);
                    else $buff = $oAntiaccessModel->sendRequest($val->host, $body, false);
                }
            }
        }

        /**
         * @brief Anti-accessXE White IP delete push
         **/
        function deleteAntiaccessWhiteipPush(&$obj) {
            if($obj->mode) return;
            $oAntiaccessModel = &getModel('antiaccess');

            // 직접 삭제하는 경우
            if($obj->cart) {
                foreach($obj->cart as $key) {
                    $args->white_srl = $key;
                    $whiteip_info = $oAntiaccessModel->getAntiaccessWhiteipInfo($args);
                    if(!$whiteip_info) continue;
                    // 해당 IP를 최초 생성하지 않았다면 다음을 진행
                    if($whiteip_info->follow_host) continue;
					// 공개한 IP가 아니면 다음을 진행
					if($whiteip_info->public != 'Y') continue;

                    // 삭제된 IP를 보낼 Follow 대상자 중 IP를 보내준 Follow Host를 제외 함
                    if($obj->follow_key) $args->not_follow_key = $obj->follow_key;

                    // 동기화가 안된 state code일 경우를 제외
                    $args->not_state = array(103,104,105,106,122);
                    $output = $oAntiaccessModel->getAntiaccessFollowhostTotal($args);
                    foreach($output as $val) {
                        // follow state, my_level에 따른 적용값을 선언
                        $oAntiaccessModel->getAntiaccessApplyMode($val->follow_level);
                        if(Context::get('is_ip_type') == '' || Context::get('is_ip_type') == 'ban') continue;

                        // White ip 삭제 정보를 보냄
						$body->act = 'procAntiaccessSync';
						$body->follow_key = $val->follow_key;
						$body->ipaddress = $whiteip_info->ipaddress;
						$body->source_host = $whiteip_info->source_host;
						$body->state = 311;
                        if($val->rank == 'S') $buff = $oAntiaccessModel->sendRequest($val->host, $body, true);
                        else $buff = $oAntiaccessModel->sendRequest($val->host, $body, false);
                    }
                }
            } else { // 삭제 대상 IP값이 Follow로 부터 넘어온 경우
                $whiteip_info = $oAntiaccessModel->getAntiaccessWhiteipInfo($obj);
                if(!$whiteip_info) return;

                // 삭제된 IP를 보낼 Follow 대상자 중 IP를 보내준 Follow Host를 제외 함
                if($obj->follow_key) $args->not_follow_key = $obj->follow_key;

                // 동기화가 안된 state code일 경우를 제외
                $args->not_state = array(103,104,105,106,122);
                $output = $oAntiaccessModel->getAntiaccessFollowhostTotal($args);
                foreach($output as $val) {
                    // follow state, my_level에 따른 적용값을 선언
                    $oAntiaccessModel->getAntiaccessApplyMode($val->follow_level);
                    if(Context::get('is_ip_type') == '' || Context::get('is_ip_type') == 'ban') continue;

                    // White ip 삭제 정보를 보냄
					$body->act = 'procAntiaccessSync';
					$body->follow_key = $val->follow_key;
					$body->ipaddress = $whiteip_info->ipaddress;
					$body->source_host = $whiteip_info->source_host;
					$body->state = 311;
                    if($val->rank == 'S') $buff = $oAntiaccessModel->sendRequest($val->host, $body, true);
                    else $buff = $oAntiaccessModel->sendRequest($val->host, $body, false);
                }
            }
        }

        /**
         * @brief Rank 체크
         **/        
        function procAntiaccessRankCheck() {
            $oAntiaccessModel = &getModel('antiaccess');

			// XML
			$body->act = 'procAntiaccessRankCheckApi';
            $buff = $oAntiaccessModel->sendRequest(Context::getRequestUri(), $body, false);

            $this->setMessage("antiaccess_rank_success");
        }

        /**
         * @brief Rank 체크(Api)
         **/        
        function procAntiaccessRankCheckApi() {
            sleep(5);
            $oModuleModel = &getModel('module');
            $oModuleController = &getController('module');

            $anti_config = $oModuleModel->getModuleConfig('antiaccess');
            $anti_config->rank = 'D';
            $oModuleController->insertModuleConfig('antiaccess', $anti_config);
        }

        /**
         * @brief Ban IP 입력 (동기화 용)
         **/
        function setAntiaccessBanipApi() {
            $args = Context::getRequestVars();
            $oModuleModel = &getModel('module');
            $oAntiaccessModel = &getModel('antiaccess');

            // Antiaccess config load
            $anti_config = $oModuleModel->getModuleConfig('antiaccess');

            $obj->follow_key = $args->follow_key;
            $followhost_info = $oAntiaccessModel->getAntiaccessFollowhostInfo($obj);

            // IP 적용 여부 설정 (이곳에서는 선언 후 Follow로 IP를 보낼때 재 설정되는 경우로 인해 선언 값을 따로 기억시킴)
            $oAntiaccessModel->getAntiaccessApplyMode($followhost_info->my_level);
            $apply = Context::get('anti_apply');

            $output = unserialize($args->output);

            // 1건일 경우는 배열화 시킴
            if(!is_array($output)) $output = array($output);
            foreach($output as $val) {
                $obj->mode = 'sync'; // 이 부분을 주석 해제하면 IP 입력 후 다른 Follow 들에게 정보를 보내지 않음

                // 사설 IP라면 다음 값을 진행
                if(!$oAntiaccessModel->checkIpaddress($val->ipaddress)) continue;

                // Source host가 거부 host라면 다음 값을 진행
                $host->host = $val->source_host;
                $host->ban_type = 'Y';
                $is_banhost = $oAntiaccessModel->getAntiaccessBanhostCount($host);
                if($is_banhost) continue;

                // 이미 존재한다면 다음 값을 진행
                $ip->ipaddress = $val->ipaddress;
                $is_banip = $oAntiaccessModel->getAntiaccessBanipCount($ip);
                if($is_banip) continue;

                // 추가할 정보를 만듬
				$obj->ipaddress = $val->ipaddress;
				$obj->country_code = $val->country_code;
				$obj->source_host = $val->source_host;
                $follow_host = $oAntiaccessModel->parseUri($followhost_info->host, 'www');
                $obj->follow_host = $follow_host['host'];
                $obj->apply = $apply;

                // 차단과 동시에 캐시를 만들 경우 캐시 생성
                if($anti_config->cache->cache_type == 1 && $apply == 'Y') @FileHandler::writeFile($this->cache_ban_path.$val->ipaddress, "Y", 'w');

                // 입력 과정에서 sync 모드가 아니라면 나의 Follow들에게 이 IP를 보냄
                $this->insertAntiaccessBanip($obj);
                unset($obj);
            }
        
			$follow_obj->follow_srl = $followhost_info->follow_srl;
			$follow_obj->mode = 'sync';
			$follow_obj->extra_vars->type = 'ban';
			$follow_obj->extra_vars->total_page = $args->total_page;
			$follow_obj->extra_vars->page = $args->page;
			$follow_obj->extra_vars->state = 'my';
			$follow_obj->extra_vars = serialize($follow_obj->extra_vars);
			$this->updateAntiaccessFollowhost($follow_obj);
        }

        /**
         * @brief White IP 입력 (동기화 용)
         **/
        function setAntiaccessWhiteipApi() {
            $args = Context::getRequestVars();
            $oModuleModel = &getModel('module');
            $oAntiaccessModel = &getModel('antiaccess');

            // Antiaccess config load
            $anti_config = $oModuleModel->getModuleConfig('antiaccess');

            $obj->follow_key = $args->follow_key;
            $followhost_info = $oAntiaccessModel->getAntiaccessFollowhostInfo($obj);

            // IP 적용 여부 설정 (이곳에서는 선언 후 Follow로 IP를 보낼때 재 설정되는 경우로 인해 선언 값을 따로 기억시킴)
            $oAntiaccessModel->getAntiaccessApplyMode($followhost_info->my_level);
            $apply = Context::get('anti_apply');

            $output = unserialize($args->output);

            // 1건일 경우는 배열화 시킴
            if(!is_array($output)) $output = array($output);
            foreach($output as $val) {
                $obj->mode = 'sync'; // 이 부분을 주석 해제하면 IP 입력 후 다른 Follow 들에게 정보를 보내지 않음

                // 사설 IP라면 다음 값을 진행
                if(!$oAntiaccessModel->checkIpaddress($val->ipaddress)) continue;

                // Source host가 거부 host라면 다음 값을 진행
                $host->host = $val->source_host;
                $host->white_type = 'Y';
                $is_whitehost = $oAntiaccessModel->getAntiaccessBanhostCount($host);
                if($is_whitehost) continue;

                // 이미 존재한다면 다음 값을 진행
                $ip->ipaddress = $val->ipaddress;
                $is_whiteip = $oAntiaccessModel->getAntiaccessWhiteipCount($ip);
                if($is_whiteip) continue;

                // 추가할 정보를 만듬
				$obj->ipaddress = $val->ipaddress;
				$obj->country_code = $val->country_code;
				$obj->source_host = $val->source_host;
                $follow_host = $oAntiaccessModel->parseUri($followhost_info->host, 'www');
                $obj->follow_host = $follow_host['host'];
                $obj->apply = $apply;

                // 차단과 동시에 캐시를 만들 경우 캐시 생성
                if($anti_config->cache->cache_type == 1 && $apply == 'Y') @FileHandler::writeFile($this->cache_white_path.$val->ipaddress, "Y", 'w');

                // 입력 과정에서 sync 모드가 아니라면 나의 Follow들에게 이 IP를 보냄
                $this->insertAntiaccessWhiteip($obj);
                unset($obj);
            }

			$follow_obj->follow_srl = $followhost_info->follow_srl;
			$follow_obj->mode = 'sync';
			$follow_obj->extra_vars->type = 'white';
			$follow_obj->extra_vars->total_page = $args->total_page;
			$follow_obj->extra_vars->page = $args->page;
			$follow_obj->extra_vars->state = 'my';
			$follow_obj->extra_vars = serialize($follow_obj->extra_vars);
			$this->updateAntiaccessFollowhost($follow_obj);
        }

        /**
         * @brief 국가 Code 값 추가하기
         **/
		function procGeoip($obj = array())
		{
			if(!is_array($obj))
			{
				return;
			}

			require_once(_XE_PATH_.'modules/antiaccess/libs/geoip/geoip.inc');
			$gi = geoip_open(_XE_PATH_.'modules/antiaccess/libs/geoip/GeoIP.dat', GEOIP_STANDARD);
			foreach($obj as $key => $val)
			{
				$output[$key] = $val;
				if(!$val->country_code)
				{
					$output[$key]->country_code = geoip_country_code_by_addr($gi, $val->ipaddress);
					$this->updateAntiaccessWhiteip($output[$key]);
				}
			}
			geoip_close($gi);

			return $output;
        }
    }
?>