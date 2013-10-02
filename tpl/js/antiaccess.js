/**
 * @file   modules/antiaccess/js/antiaccess.js
 * @author largeden (cbrghost@gmail.com)
 * @brief  antiaccessXE configuration javascript
 **/

var $ = jQuery.noConflict();
var $antiaccess = {
    // 기본 차단 설정
    use : function(element) {
        var params = new Array();
        if(element.checked) params[element.name] = element.value;
        else params[element.name] = 'N';
        
        exec_xml('antiaccess','procAntiaccessAdminInsertUse', params);
    },
    // 금지 IP 적용 설정
    updateBanipApply : function(element) {
        var value = element.value.split("|@|");
        var params = new Array();
        params['apply'] = value[0];
        params['ban_srl'] = value[1];

        exec_xml('antiaccess','procAntiaccessAdminUpdateBanipApply', params);
    },
    // 금지 IP 공개 설정
    updateBanipPublic : function(element) {
        var params = new Array();
        if(element.checked) params['public'] = 'Y';
        else params['public'] = 'N';

        params['ban_srl'] = element.value;

        exec_xml('antiaccess','procAntiaccessAdminUpdateBanipPublic', params, complete_reload);
    },
    // 비금지 IP 적용 설정
    updateWhiteipApply : function(element) {
        var value = element.value.split("|@|");
        var params = new Array();
        params['apply'] = value[0];
        params['white_srl'] = value[1];

        exec_xml('antiaccess','procAntiaccessAdminUpdateWhiteipApply', params);
    },
    // 금지 IP 공개 설정
    updateWhiteipPublic : function(element) {
        var params = new Array();
        if(element.checked) params['public'] = 'Y';
        else params['public'] = 'N';

        params['white_srl'] = element.value;

        exec_xml('antiaccess','procAntiaccessAdminUpdateWhiteipPublic', params, complete_reload);
    },
    // 접근한 IP 금지 여부 설정
    updateAccessipApply : function(element) {
        var params = new Array();
        if(element.checked) params[element.name] = 'Y';
        else params[element.name] = 'N';

        params['ipaddress'] = element.value;

        exec_xml('antiaccess','procAntiaccessAdminUpdateAccessipApply', params, complete_reload);
    },
    // 접근한 IP 자동차단 해제 설정
    updateAccessipUnblock : function(element) {
        var params = new Array();
        params['ipaddress'] = element.title;

        exec_xml('antiaccess','procAntiaccessAdminUpdateAccessipUnblock', params, complete_reload);
    },
    // 동기화 진행
    synchronization : function(element) {
        var params = new Array();
        params['follow_srl'] = element.title;

        exec_xml('antiaccess','procAntiaccessAdminSynchronization', params, complete);
    },
    // 금지 HOST 등록 여부 설정
    updateBanhostType : function(element) {
        var params = new Array();
        if(element.checked) params[element.name] = 'Y';
        else params[element.name] = 'N';

        params['host_srl'] = element.value;

        exec_xml('antiaccess','procAntiaccessAdminUpdateBanhostType', params);
    },
    // 최신 버전 상태 알림
    new_version : function() {
        alert(msg_antiaccess_new_version);

        var url = "http://www.xpressengine.com/?mid=download&package_srl=19323693";
        window.open(url,'_blank');
    },
    // 셀렉트
    selectable : '',
    doselectable_array : new Array(),
    // Severity 설정 대상 추가
    doInsertItem : function() {
      // 실행할 코드
      $('li.ui-selected', '#country_selectable').each(function() {
	      if($antiaccess.doselectable_array[$(this).attr('title')] != true) {
			$('#country_selectable2').append('<li class="ui-widget-content" title="'+$(this).attr('title')+'">'+$(this).html()+'</li>');
			$antiaccess.doselectable_array[$(this).attr('title')] = true;
		  }
      });

      $antiaccess.selectable = '';
      $('li', '#country_selectable2').each(function() {
         var index = $(this).attr('title');
         $antiaccess.selectable = $antiaccess.selectable+index+',';
      });
      
      $('#insertCountry input[name=country_code]').attr('value', $antiaccess.selectable);

	    $('#country_selectable2').selectable({
	        filter: 'li'
	    });

    },
    // Severity 설정 대상 삭제
    doDeleteItem : function() {
      $('li.ui-selected', '#country_selectable2').each(function() {
		      $antiaccess.doselectable_array[$(this).attr('title')] = false;
      		$(this).remove();
      });

      $antiaccess.selectable = '';
      $('li', '#country_selectable2').each(function() {
         var index = $(this).attr('title');
         $antiaccess.selectable = $antiaccess.selectable+index+',';
      });
      
      $('#insertCountry input[name=country_code]').attr('value', $antiaccess.selectable);

    },
    // 스크립트 로드
    antiaccess_ready : function() {
        $('html').ready(function(){
            // 최신 버전 상태 알림
            if(typeof(msg_antiaccess_new_version) != 'undefined') $antiaccess.new_version();

            // 기본 차단 설정
            $('#use_config input:checkbox').click(function() {
                $antiaccess.use(this);
            });

            // 금지 IP 적용 설정
            $('#banip_list input[name^=apply_]').click(function() {
                $antiaccess.updateBanipApply(this);
            });

            // 금지 IP 공개 설정
            $('#banip_list input[name^=public_]').click(function() {
                $antiaccess.updateBanipPublic(this);
            });

            // 비금지 IP 적용 설정
            $('#whiteip_list input[name^=apply_]').click(function() {
                $antiaccess.updateWhiteipApply(this);
            });

            // 금지 IP 공개 설정
            $('#whiteip_list input[name^=public_]').click(function() {
                $antiaccess.updateWhiteipPublic(this);
            });

            // 접근한 IP 금지 여부 설정
            $('#accessip_list input[name^=ban]').click(function() {
                $antiaccess.updateAccessipApply(this);
            });
            $('#accessip_list input[name^=white]').click(function() {
                $antiaccess.updateAccessipApply(this);
            });

            // 접근한 IP 자동차단 해제 설정
            $('#accessip_list a[id^=block_]').click(function() {
                $antiaccess.updateAccessipUnblock(this);
            });

            // 동기화 진행
            $('#follow_host a[id^=sync_]').click(function() {
                $antiaccess.synchronization(this);
            });

            // 금지 HOST 등록 여부 설정
            $('#banhost_list input[name^=ban_type]').click(function() {
                $antiaccess.updateBanhostType(this);
            });
            $('#banhost_list input[name^=white_type]').click(function() {
                $antiaccess.updateBanhostType(this);
            });
            
            // 출력된 테이블에 selectable 적용
            if($('#country_selectable').is('#country_selectable')) {
                $('#country_selectable').selectable({
                    filter: 'li',
                });

			      $antiaccess.selectable = '';
			      $('li', '#country_selectable2').each(function() {
			         var index = $(this).attr('title');
			         $antiaccess.selectable = $antiaccess.selectable+index+',';
					$antiaccess.doselectable_array[index] = true;
			      });
            }
	    $('#country_selectable2').selectable({
	        filter: 'li'
	    });
            
			$('#country_submit').click(function(){
					$('a.modalAnchor').trigger('close.mw');
			});
				 
			jQuery('a.modalAnchor')
			   .bind('after-close.mw', function(){
			       var country_obj = $antiaccess.selectable.split(',');
			      // 실행할 코드
					jQuery('#country_list').append('<ul>');
			      $.each(country_obj, function(key, val) {
					if(val){
						$('#country_list').append('<li>'+val+'</li>');
					}
			      });
					jQuery('#country_list').append('</ul>');
			   });
				 
        });
    }
};

//$.fn.extend(antiaccess);
$antiaccess.antiaccess_ready();