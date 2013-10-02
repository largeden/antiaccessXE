<?php
    /**
     * @class  antiaccessAdminView
     * @author largeden (webmaster@animeclub.net)
     * @brief  antiaccessXE admin view class
     **/

    class antiaccessAdminView extends antiaccess {

        /**
         * @brief 초기화
         **/
        function init() {
            // 템플릿 경로 지정
            $this->setTemplatePath($this->module_path.'tpl');
        }

        /**
         * @brief 기본 설정
         **/
        function dispAntiaccessAdminConfig() {
            $oModuleModel = &getModel('module');
            $oMemberModel = &getModel('member');

            $anti_config = $oModuleModel->getModuleConfig('antiaccess');


            $group_list = $oMemberModel->getGroups();
            Context::set('group_list', $group_list);

			require_once(_XE_PATH_.'modules/antiaccess/libs/geoip/geoip.inc');
			$gi = new GeoIP;
			foreach($gi->GEOIP_COUNTRY_CODE_TO_NUMBER as $code => $c_num)
			{
				$country_list[$code] = $gi->GEOIP_COUNTRY_NAMES[$c_num];
				if($anti_config->country->code[$code])
				{
					$anti_config->country->code[$code] = $gi->GEOIP_COUNTRY_NAMES[$c_num];
					$anti_config->country->list .= $code.',';
				}
			}

            $oFileHandler = new FileHandler();
            $index_path = _XE_PATH_."index.php";
            $index_bak_path = _XE_PATH_."files/antiaccess/index/index.bak.php";

            $file_buff = $oFileHandler->readFile($index_path);
            preg_match_all("!\[@@([^\>]*)\@@]!is", $file_buff, $index_ver);

            if(@$index_ver[1][0] && is_file($index_bak_path)) $index_bak = "complete";
            elseif(is_file($index_bak_path)) $index_bak = "none_index";
            elseif(@$index_ver[1][0]) $index_bak = "backup_fail";
            else $index_bak = "none";

            Context::set('country_list', $country_list);
            Context::set('index_bak', $index_bak);
            Context::set('anti_config', $anti_config);

            $this->setTemplateFile('config');
        }

        /**
         * @brief Access ip
         **/
        function dispAntiaccessAdminAccessip() {
            $oModuleModel = &getModel('module');
            $oAntiaccessModel = &getModel('antiaccess');
            $oAntiaccessController = &getController('antiaccess');

            $anti_config = $oModuleModel->getModuleConfig('antiaccess');
            Context::set('anti_config',$anti_config);

            $args = Context::gets('page','sort_index','order_type','search_keyword');

            $output = $oAntiaccessModel->getAntiaccessAccessipList($args);
			$output->data = $oAntiaccessController->procGeoip($output->data);

            Context::set('total_count', $output->total_count);
            Context::set('total_page', $output->total_page);
            Context::set('page', $output->page);
            Context::set('accessip_list',$output->data);
            Context::set('page_navigation', $output->page_navigation);

            /* 버전 업데이트가 되면 해당일을 알림 */
            if($anti_config->check_date < date('Ymd')) {
                if($this->checkVersion()) Context::set('new_version',true);
                $oModuleController = &getController('module');
                $anti_config->check_date = date('Ymd');
                $oModuleController->insertModuleConfig('antiaccess', $anti_config);
            }

            $this->setTemplateFile('access_ip');
        }

        /**
         * @brief Ban ip
         **/
        function dispAntiaccessAdminBanip() {
            $oAntiaccessModel = &getModel('antiaccess');
            $oAntiaccessController = &getController('antiaccess');

            $args = Context::gets('page','sort_index','order_type','search_keyword');

            $output = $oAntiaccessModel->getAntiaccessBanipList($args);
			$output->data = $oAntiaccessController->procGeoip($output->data);

            Context::set('total_count', $output->total_count);
            Context::set('total_page', $output->total_page);
            Context::set('page', $output->page);
            Context::set('banip_list',$output->data);
            Context::set('page_navigation', $output->page_navigation);

            $this->setTemplateFile('ban_ip');
        }

        /**
         * @brief White ip
         **/
        function dispAntiaccessAdminWhiteip() {
            $oAntiaccessModel = &getModel('antiaccess');
            $oAntiaccessController = &getController('antiaccess');

            $args = Context::gets('page','sort_index','order_type','search_keyword');

            $output = $oAntiaccessModel->getAntiaccessWhiteipList($args);
			$output->data = $oAntiaccessController->procGeoip($output->data);

            Context::set('total_count', $output->total_count);
            Context::set('total_page', $output->total_page);
            Context::set('page', $output->page);
            Context::set('whiteip_list', $output->data);
            Context::set('page_navigation', $output->page_navigation);

            $this->setTemplateFile('white_ip');
        }

        /**
         * @brief Ban Host
         **/
        function dispAntiaccessAdminBanhost() {
            $oAntiaccessModel = &getModel('antiaccess');

            $args = Context::gets('page','sort_index','order_type','search_keyword');

            $output = $oAntiaccessModel->getAntiaccessBanhostList($args);

            Context::set('total_count', $output->total_count);
            Context::set('total_page', $output->total_page);
            Context::set('page', $output->page);
            Context::set('banhost_list',$output->data);
            Context::set('page_navigation', $output->page_navigation);

            $this->setTemplateFile('ban_host');
        }

        /**
         * @brief Follow Host
         **/
        function dispAntiaccessAdminFollowhost() {
            $oAntiaccessModel = &getModel('antiaccess');

            $args = Context::gets('follow_srl','page','sort_index','order_type','search_keyword');

            $output = $oAntiaccessModel->getAntiaccessFollowhostList($args);

            Context::set('total_count', $output->total_count);
            Context::set('total_page', $output->total_page);
            Context::set('page', $output->page);
            Context::set('followhost_list',$output->data);
            Context::set('page_navigation', $output->page_navigation);

            $this->setTemplateFile('follow_host');
        }

        /**
         * @brief Follow Host Insert
         **/
        function dispAntiaccessAdminInsertFollowhost() {
            $oAntiaccessModel = &getModel('antiaccess');

            $args = Context::gets('follow_srl');

            if($args->follow_srl) {
                $followhost_info = $oAntiaccessModel->getAntiaccessFollowhostInfo($args);
                Context::set('followhost_info', $followhost_info);
            }

            $this->setTemplateFile('follow_host_insert');
        }

        /**
         * @brief Follow Host Delete
         **/
        function dispAntiaccessAdminDeleteFollowhost() {
            $oAntiaccessModel = &getModel('antiaccess');

            $args = Context::gets('follow_srl');

            if($args->follow_srl) {
                $followhost_info = $oAntiaccessModel->getAntiaccessFollowhostInfo($args);
                Context::set('followhost_info', $followhost_info);
            }

            $this->setTemplateFile('follow_host_delete');
        }
    }
?>