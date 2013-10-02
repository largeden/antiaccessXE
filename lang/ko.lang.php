<?php
    /**
     * @file   modules/antiaccess/lang/ko.lang.php
     * @author largeden (cbrghost@gmail.com)
     * @brief  한글 기본 언어팩
     **/

    $lang->antiaccess = "anti-accessXE";
    $lang->antiaccess_description = "다중접근IP, 스팸IP를 자동적으로 차단해주는 학습형 IP차단 모듈 입니다.\n자세한 설명은 <a href=\"http://www.animeclub.net/wiki/Anti-accessXE\" title=\"anti-accessXE 프로젝트 위키\" target=\"_blank\">프로젝트 위키</a>를 참조해주세요.	";

    $lang->antiaccess_caption = "목록 정보";
    $lang->antiaccess_sync = "동기화 하기";
    $lang->antiaccess_apply = "적용";
    $lang->antiaccess_not_apply = "비적용";
    $lang->antiaccess_public = "공개";

    /* header */
    $lang->antiaccess_config = "기본 설정";
    $lang->antiaccess_access_ip = "접근한 IP";
    $lang->antiaccess_ban_ip = "금지 IP";
    $lang->antiaccess_white_ip = "비금지 IP";
    $lang->antiaccess_follow_host = "Follow HOST";
    $lang->antiaccess_ban_host = "금지 HOST";

    /* config */
    $lang->antiaccess_use = "설정 기능 사용";
    $lang->antiaccess_use_summary = "설정 기능을 사용여부를 설정하는 내용 입니다.";
    $lang->antiaccess_use_description = "※ 옵션을 체크할 경우 바로 적용 됩니다.";
    $lang->antiaccess_use_block = "다중접속 차단 기능 사용";
    $lang->antiaccess_use_block_description = "체크할 경우 기능이 수행 됩니다.(단 지정시간, 차단시간과 함께 접속횟수 종류 중 하나 이상의 값이 설정되어있어야 합니다.)";
    $lang->antiaccess_use_banned = "금지 기능 사용";
    $lang->antiaccess_use_banned_description = "체크할 경우 기능이 수행 됩니다.";
    $lang->antiaccess_use_white = "비금지 기능 사용";
    $lang->antiaccess_use_white_description = "체크할 경우 기능이 수행 됩니다.";
    $lang->antiaccess_use_country = "국가금지 기능 사용";
    $lang->antiaccess_use_country_description = "체크할 경우 기능이 수행 됩니다.";

	$lang->antiaccess_country = "국가 접근 기능";
	$lang->antiaccess_country_select = "국가 선택";
	$lang->antiaccess_country_select_total = "전체 국가";
	$lang->antiaccess_country_selected = "선택한 국가";
	$lang->antiaccess_country_conn = "접근 여부";
	$lang->antiaccess_country_conn_block = "선택한 국가의 접근을 차단";
	$lang->antiaccess_country_conn_white = "선택한 국가만 접근 허용";
	$lang->antiaccess_country_conn_description = "선택한 국가의 접근 여부를 선택해주세요.";

    $lang->antiaccess_header = "차단시 표시할 정보";
    $lang->antiaccess_header_summary = "차단시 표시할 정보를 설정하는 내용 입니다.";
    $lang->antiaccess_code = "header 선택";
    $lang->antiaccess_code_description = "403 : Forbidden , 404 : Not Found";
    $lang->antiaccess_msg = "메시지";
    $lang->antiaccess_msg_description = "출력할 메시지를 적어주세요.(HTML 가능)";
    $lang->antiaccess_forward_url = "URL 이동";
    $lang->antiaccess_forward_url_description = "이동할 URL을 적어주세요.";

    $lang->antiaccess_block = "다중접속 차단";
    $lang->antiaccess_block_summary = "다중 접속을 차단시키는 정보의 등록 내용 입니다.";
    $lang->antiaccess_limit_time = "지정시간(분)";
    $lang->antiaccess_limit_time_description = "지정시간동안에 일어나는 접속 수를 확인합니다.";
    $lang->antiaccess_limit_count = "전체 접속횟수";
    $lang->antiaccess_limit_count_description = "지정시간동안에 연속으로 몇번 접속할경우 차단할지 적어주세요.";
    $lang->antiaccess_limit_display = "display 접속횟수";
    $lang->antiaccess_limit_display_description = "지정시간동안에 기본 XE를 연속으로 몇번 접속할경우 차단할지 적어주세요.";
    $lang->antiaccess_limit_rss = "rss 접속횟수";
    $lang->antiaccess_limit_rss_description = "지정시간동안에 RSS를 연속으로 몇번 접속할경우 차단할지 적어주세요.";
    $lang->antiaccess_limit_atom = "atom 접속횟수";
    $lang->antiaccess_limit_atom_description = "지정시간동안에 ATOM을 연속으로 몇번 접속할경우 차단할지 적어주세요.";
    $lang->antiaccess_limit_trackback = "trackback 접속횟수";
    $lang->antiaccess_limit_trackback_description = "지정시간동안에 trackback을 연속으로 몇번 접속할경우 차단할지 적어주세요.";
    $lang->antiaccess_limit_act = "act접속횟수";
    $lang->antiaccess_limit_act_description = "지정시간동안에 페이지 이동없이 연속으로 몇번 접속할경우 차단할지 적어주세요.";
    $lang->antiaccess_limit_block = "차단시간(분)";
    $lang->antiaccess_limit_block_description = "지정시간에 접속횟수를 만족하는 요청자를 얼마나 차단 지속시킬지 차단시간을 정해주세요.";

    $lang->antiaccess_not_act = "제외 act명";
    $lang->antiaccess_not_act_summary = "제외 시킬 act명을 설정하는 내용 입니다.";
    $lang->antiaccess_not_act_description = "다중접속 차단에서 제외시킬 act명을 ,(쉼표)로 구분하여 나열해주세요.\n설정된 act명으로의 요청은 다중 카운터를 시도하지 않습니다.\n\n(※ dispBoardContent와 같은 기본이 되는 act명은 기본적으로 act값을 공백값으로 인지합니다.\n따라서 직접 url 호출주소에 명시되어있을 경우만 제외합니다.)";

    $lang->antiaccess_banned = "다중접속자 금지";
    $lang->antiaccess_banned_summary = "다중 접속자를 영구금지 시키는 정보의 등록 내용 입니다.";
    $lang->antiaccess_occur_count = "차단발생횟수";
    $lang->antiaccess_occur_count_description = "다중접속 차단설정에 의해 차단된 횟수가 지정횟수를 넘을 경우 그 IP는 자동적으로 금지 IP 리스트에 등록 됩니다.";

    $lang->antiaccess_white = "비금지 대상";
    $lang->antiaccess_white_summary = "비차단 대상자를 설정하는 내용 입니다.";
    $lang->antiaccess_groups = "회원 그룹";
    $lang->antiaccess_groups_description = "선택한 회원 그룹의 회원이 로그인 할 경우 그 회원의 IP는 자동적으로 비금지 IP 리스트에 등록 됩니다.";

    $lang->antiaccess_cache = "캐시 설정";
    $lang->antiaccess_cache_summary = "캐시 기능을 설정하는 내용 입니다.";
    $lang->antiaccess_cache_type = "캐시 기능";
    $lang->antiaccess_cache_select = array(
        "1"=>"차단과 동시에 캐시를 만듭니다.",
        "2"=>"차단 후 접속시도시 캐시를 만듭니다.",
        "3"=>"캐시를 만들지 않습니다.",
    );
    $lang->antiaccess_cache_type_description = "캐시 기능을 이용하면 차단 대상자를 확인하고 차단하는 과정에서 XE의 DB를 로드하고 않고 차단할 수 있습니다.\nXE의 DB를 로드하지 않음으로써 불필요한 자원소모를 막을 수 있습니다.";
    $lang->antiaccess_cache_index = "캐시기능 적용";
    $lang->antiaccess_cache_index_description = "이 옵션을 적용하면 XE를 로드하지 않고 차단 수행을 할 수 있습니다.\n캐시 기능을 제대로 사용하려면 XE의 index.php에서 XE를 호출하기 전에 먼저 호출 되어야 합니다.\n Core 수정을 안전하고 편리하게 하기 위해 anti-accessXE에서는 index.php 파일을 모듈내에 백업하고 캐시 호출 기능이 적용된 index.php로 대체합니다.\n비적용시에는 다시 백업했던 파일을 복원합니다.";
    $lang->antiaccess_cache_backup = "상태확인";
    $lang->antiaccess_cache_backup_description = "캐시 기능이 적용된 index.php를 사용하고 있는지, 백업상태가 정상인지를 확인합니다.";
    $lang->antiaccess_ftp_pass = "FTP 패스워드 입력";
    $lang->antiaccess_ftp_pass_description = "캐시 설정을 위해서는 index.php의 권한을 변경할 필요가 있습니다.\n관리자페이지 Setting에서 설정한 FTP의 패스워드를 입력해주세요.\n올바르게 변경 처리 된 후에는 다시 권한을 원래대로 되돌립니다.(0644)\n(※ 해당 값은 저장하지 않습니다.)";

    $lang->antiaccess_optimize = "DB Table Optimize(최적화)";
    $lang->antiaccess_optimize_summary = "DB Table Optimize(최적화)를 설정하는 내용 입니다.";
    $lang->antiaccess_optimize_date = "기간(일)";
    $lang->antiaccess_optimize_date_description = "DB Table이 로그 형식이거나 자주 수정,삭제가 일어나는 테이블은 단편화가 발생됩니다.\n해당 기능은 정기적으로 단편화가 일어나는 anti-accessXE 테이블을 최적화하여 단편화된 데이터를 정리합니다.\n기간은 7일 정도로 설정해주시면 좋습니다.\n(※ 현재 해당 기능은 Mysql, Mysql_innodb, Mysqli만 사용됩니다.)";

    /* List */
    $lang->antiaccess_source_host = "발생된 HOST";
    $lang->antiaccess_ipaddress = "IP 주소";
    $lang->antiaccess_apply_mode = "적용여부";
    $lang->antiaccess_public_mode = "공개여부";
    $lang->antiaccess_regdate = "등록일시";

    $lang->antiaccess_banip_list = "금지 IP 목록";
    $lang->antiaccess_banip_list_summary = "금지 IP 목록을 나타냅니다.";

    $lang->antiaccess_whiteip_list = "비금지 IP 목록";
    $lang->antiaccess_whiteip_list_summary = "비금지 IP 목록을 나타냅니다.";

    $lang->antiaccess_accessip_list = "접근한 IP 목록";
    $lang->antiaccess_accessip_list_summary = "접근한 IP 목록을 나타냅니다.";

    $lang->antiaccess_banhost_list = "금지 HOST 목록";
    $lang->antiaccess_banhost_list_summary = "금지 HOST 목록을 나타냅니다.";

    $lang->antiaccess_followhost_list = "Follow HOST 목록";
    $lang->antiaccess_followhost_list_summary = "Follow HOST 목록을 나타냅니다.";

    $lang->antiaccess_followhost_state = "상태";
    $lang->antiaccess_followhost_my_level = "Follow Host로부터\n전달받을 IP 종류";
    $lang->antiaccess_followhost_follow_level = "Follow Host가\n설정한 IP 종류";

    $lang->antiaccess_block_mode = "자동차단상태";
    $lang->antiaccess_last_update = "변경일시";
    $lang->antiaccess_ban_mode = "금지상태";

    $lang->antiaccess_ban = "금지";
    $lang->antiaccess_white = "비금지";
    $lang->antiaccess_blocked = "차단";
    $lang->antiaccess_unblock = "해제";

    $lang->antiaccess_host = "HOST";

    $lang->antiaccess_ban_type = "금지 IP 비등록";
    $lang->antiaccess_white_type = "비금지 IP 비등록";

    /* Ban IP Config */
    $lang->antiaccess_banip_config = "금지 IP 설정";
    $lang->antiaccess_banip_config_summary = "금지 IP를 설정하는 내용 입니다.";
    $lang->antiaccess_banip = "금지 IP";
    $lang->antiaccess_banip_description = "금지하려는 IP를 적어주세요.";
    $lang->antiaccess_public_description = "공개 선택을 체크하시면 다른 Follow host에게 정보를 제공합니다.";

    /* White IP Config */
    $lang->antiaccess_whiteip_config = "비금지 IP 설정";
    $lang->antiaccess_whiteip_config_summary = "비금지 IP를 설정하는 내용 입니다.";
    $lang->antiaccess_whiteip = "비금지 IP";
    $lang->antiaccess_whiteip_description = "비금지하려는 IP를 적어주세요.";

    /* Ban Host Config */
    $lang->antiaccess_banhost_config = "금지 HOST 설정";
    $lang->antiaccess_banhost_config_summary = "비금지 HOST를 설정하는 내용 입니다.";
    $lang->antiaccess_banhost = "금지 HOST";
    $lang->antiaccess_banhost_description = "금지하려는 HOST 주소를 적어주세요.";
    $lang->antiaccess_ban_type_description = "전달된 금지 IP가 해당 HOST에서 전달된 정보라면 정보를 등록시킬지 여부.";
    $lang->antiaccess_white_type_description = "전달된 비금지 IP가 해당 HOST에서 전달된 정보라면 정보를 등록시킬지 여부.";
    $lang->antiaccess_unregistered = "비등록";

    /* Follow Host Config */
    $lang->antiaccess_followhost_config = "Follow HOST 설정";
    $lang->antiaccess_followhost_config_summary = "Follow HOST를 설정하는 내용 입니다.";
    $lang->antiaccess_followhost = "Follow HOST";
    $lang->antiaccess_followhost_description = "Follow하려는 HOST 주소를 적어주세요. (※ 실제 동작중인 주소를 적으셔야 합니다. 예: http://도메인.com/xe)";

    $lang->antiaccess_followhost_state = "상태";
    $lang->antiaccess_followhost_state_description = "Follow와의 현재 상태를 나타냅니다.";

    $lang->antiaccess_followhost_my_level_description = "전달 받고싶은 종류를 설정하실 수 있습니다.\n해당 설정은 Follow Host 측에 설정되며 반대로 Follow Host 측에서 설정한 값은 Follow Host의 정보 전달여부에 설정됩니다.";
    $lang->antiaccess_followhost_follow_level_description = "해당 정보는 Follow Host 측에서 설정하게 될 경우 나타납니다.\n해당 값을 기준으로 나에게서 발생된 금지, 비금지 IP 정보를 보낼지 말지를 결정합니다.\n(※ 이 값은 본인이 변경 하실 수 없습니다.)";

    $lang->antiaccess_followhost_level_code = array(
        "101" => "모든 IP를 적용으로 전달 받음",
        "102" => "모든 IP를 비적용으로 전달 받음",
        "103" => "금지 IP만 적용으로 전달 받음",
        "104" => "금지 IP만 비적용으로 전달 받음",
        "105" => "비금지 IP만 적용으로 전달 받음",
        "106" => "비금지 IP만 비적용으로 전달 받음",
        "111" => "Follow가 만든 IP만 적용으로 전달 받음",
        "112" => "Follow가 만든 IP만 비적용으로 전달 받음",
        "113" => "Follow가 만든 금지 IP만 적용으로 전달 받음",
        "114" => "Follow가 만든 금지 IP만 비적용으로 전달 받음",
        "115" => "Follow가 만든 비금지 IP만 적용으로 전달 받음",
        "116" => "Follow가 만든 비금지 IP만 비적용으로 전달 받음",
        "121" => "Follow가 만든 IP이외만 적용으로 전달 받음",
        "122" => "Follow가 만든 IP이외만 비적용으로 전달 받음",
        "123" => "Follow가 만든 금지 IP이외만 적용으로 전달 받음",
        "124" => "Follow가 만든 금지 IP이외만 비적용으로 전달 받음",
        "125" => "Follow가 만든 비금지 IP이외만 적용으로 전달 받음",
        "126" => "Follow가 만든 비금지 IP이외만 비적용으로 전달 받음",
        "100" => "모든 IP를 전달 받지 않음"
    );

    $lang->antiaccess_followhost_state_code = array(
        "100" => "동기화 완료",
        "101" => "Sync 요청",
        "102" => "Sync 응답",
        "103" => "Follow 요청",
        "104" => "Follow 요청받음",
        "105" => "Key 생성",
        "106" => "Key 전달",
        "107" => "동기화 시작",
        "108" => "동기화 중",
        "109" => "동기화 중",
        "110" => "정보 수정",
        "111" => "정보 수정 완료",
        "120" => "정보 삭제",
        "121" => "정보 삭제 완료",
        "122" => "Follow 삭제",
        "503" => "Follow 요청(S)",
        "504" => "Follow 요청받음(S)",
        "505" => "Key 생성(S)",
        "507" => "Key 전달(S)",
        "508" => "동기화 시작(S)",
        "509" => "동기화 중(S)",
        "510" => "동기화 중(S)",
        "201" => "Ban ip 전달",
        "202" => "Ban ip 전달 완료",
        "211" => "White ip 전달",
        "212" => "White ip 전달 완료",
        "301" => "Ban ip 삭제",
        "302" => "Ban ip 삭제 완료",
        "311" => "White ip 삭제",
        "312" => "White ip 삭제 완료",
        "403" => "중복 Follow",
        "404" => "응답없음",
    );

	/* Rank */
	$lang->antiaccess_rank = "anti-accessXE 동작상태";
	$lang->antiaccess_rank_distributor = "현재 동작상태는 배포자(Distributor) 입니다.";
	$lang->antiaccess_rank_subscriber = "현재 동작상태는 구독자(Subscriber) 입니다.";
	$lang->antiaccess_rank_success = "동작상태 확인을 시도했습니다. 5초 후 확인해주세요.";

    /* complete message */
    $lang->success_synchronization = "동기화 진행을 시작합니다.";

    /* check msg */
    $lang->msg_ipaddress_exists = "이미 존재하는 IP 주소 입니다.";
    $lang->msg_host_exists = "이미 존재하는 HOST 주소 입니다.";
    $lang->msg_follow_exists = "상대방과 이미 동기화하고 있는 Follow Host 주소 입니다.";
    $lang->msg_not_rank = "동작상태가 서로 구독자(Subscriber) 일경우 Follow가 불가합니다.";
    $lang->msg_request_uri_exists = "본인의 HOST는 사용하실 수 없습니다.";
    $lang->msg_invalid_ipaddress = "잘못된 IP 주소 형식 입니다.";
    $lang->msg_invalid_host = "잘못된 HOST 형식 입니다.\n입력값이 잘못되었거나 현재 접속하고있는 HOST 주소 형식이 잘못 되었습니다.\n잘못된 예) 127.0.0.1";
    $lang->msg_not_checks = "선택된 대상이 없습니다.";
    $lang->msg_not_response = "대상에게서 응답이 없습니다.";
    $lang->msg_not_keycall = "Key 발급에 실패했습니다.\\n대상자가 거부했거나 문제가 있습니다.";
    $lang->msg_not_my_level = "Follow Host로부터 전달받을 IP 종류를 먼저 설정하셔야 합니다.";
    $lang->msg_synchronization = "동기화 중에는 정보 변경이 불가능 합니다.";
    $lang->msg_fail_to_update = "Follow Host에 업데이트를 실패했습니다.";
    $lang->msg_backup_fail = "백업된 파일이 존재하지 않아 삭제할 수 없습니다.";

    /* new version */
    $lang->msg_antiaccess_new_version = "현재 버전은 최신 버전보다 구버전 입니다.\\n최신버전으로 업그래이드 해주세요.";
?>