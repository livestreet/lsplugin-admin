var ls = ls || {};

ls.admin_user_ban = (function($) {
    this.selectors = {
        bans_user_sign: '#admin_bans_user_sign',
        bans_answer_id: '#admin_bans_checking_msg',
        bans_secondary_rule_wrapper: '#js_admin_users_bans_secondary_rule_wrapper',
        bans_secondary_rule_field_id: '#admin_bans_secondary_rule'
    };

    return this;
}).call(ls.admin_user_ban || {}, jQuery);

jQuery(document).ready(function($) {
    $ (ls.admin_user_ban.selectors.bans_user_sign).bind('change.admin', function() {
        var sVal = $.trim ($ (this).val()),
            oUserInfo = $(ls.admin_user_ban.selectors.bans_answer_id);

        if (sVal === '') return false;
        $ (this).addClass('loading');
        oUserInfo.show().html('Загрузка...');
        ls.ajax.load(
            aRouter ['admin'] + 'bans/ajax-check-user-sign',
            {
                value: sVal
            },
            function(data) {
                if (data.bStateError) {
                    ls.msg.notice(data.sTitle, data.sMsg);
                    oUserInfo.hide();
                } else {
                    oUserInfo.html('<i class="icon-check"></i>&nbsp;' + data.sResponse);
                    /*
                        разрешено ли добавлять дополнительное правило
                     */
                    if (data.bAllowSecondaryRule) {
                        $ (ls.admin_user_ban.selectors.bans_secondary_rule_wrapper).show(100);
                        $ (ls.admin_user_ban.selectors.bans_secondary_rule_field_id).val(data.sSecondaryRuleFieldData);
                    } else {
                        $ (ls.admin_user_ban.selectors.bans_secondary_rule_wrapper).hide(100);
                    }
                }
                $ (ls.admin_user_ban.selectors.bans_user_sign).removeClass('loading');
            }
        );
    });
});
