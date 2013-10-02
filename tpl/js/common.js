/**
 * @file   modules/antiaccess/js/common.js
 * @author largeden (cbrghost@gmail.com)
 * @brief  antiaccessXE common javascript
 **/

/* Follow Host Insert */
function completeInsertFollow(ret_obj) {
    var message = ret_obj['message'];
    var error = ret_obj['error'];
    var page = ret_obj['page'];

    var url = current_url.setQuery('act',ret_obj['act']);
    if(page) url = url.setQuery('page',page);

    alert(message);

    location.href=url;
}

/* Follow Host Delete */
function completeDeleteFollow(ret_obj) {
    var message = ret_obj['message'];
    var error = ret_obj['error'];
    var page = ret_obj['page'];

    var url = current_url.setQuery('act',ret_obj['act']).setQuery('follow_srl','');
    if(page) url = url.setQuery('page',page);

    alert(message);

    location.href=url;
}

/* Access ip List Apply */
function complete_reload(ret_obj) {
    var message = ret_obj['message'];

    location.reload();
}

/* Config Insert */
function complete(ret_obj) {
    var message = ret_obj['message'];

    alert(message);

    location.reload();
}