/**
 * Управление правами
 *
 * @module ls/plugin/admin/rbac
 *
 * @license   GNU General Public License, version 2
 * @copyright 2013 OOO "ЛС-СОФТ" {@link http://livestreetcms.com}
 */

var ls = ls || {};

ls.admin_rbac = ( function($) {


    this.addPermissionToRole = function(role,permission) {
        ls.ajax.load(aRouter.admin + 'ajax/rbac/role-permission-add/', { role: role, permission: permission }, function(result) {
            $('.js-rbac-role-permissions-area').prepend(result.sText);
        });
    };

    this.removePermissionFromRole = function(role,permission) {
        ls.ajax.load(aRouter.admin + 'ajax/rbac/role-permission-remove/', { role: role, permission: permission }, function(result) {
            var item=$('.js-rbac-role-permission-item[data-id='+permission+']');
            if (item.length) {
                item.fadeOut(600,function(){
                    item.remove();
                });
            }
        });
    };

    this.addUserToRole = function(role,login) {
        ls.ajax.load(aRouter.admin + 'ajax/rbac/role-user-add/', { role: role, login: login }, function(result) {
            $('.js-rbac-role-user-area').prepend(result.sText);
        });
    };

    this.removeUserFromRole = function(role,user) {
        ls.ajax.load(aRouter.admin + 'ajax/rbac/role-user-remove/', { role: role, user: user }, function(result) {
            var item=$('.js-rbac-role-user-item[data-id='+user+']');
            if (item.length) {
                item.fadeOut(600,function(){
                    item.remove();
                });
            }
        });
    };

    $(function(){
        $('.js-rbac-role-permission-add').click(function(){
            var sel=$('#rbac-role-permissions-select');
            ls.admin_rbac.addPermissionToRole(sel.data('roleId'),sel.val());
        });
        $(document).on('click','.js-rbac-role-permission-remove', function (e) {
            ls.admin_rbac.removePermissionFromRole($(this).data('role'),$(this).data('permission'));
            e.preventDefault();
        });
        $('.js-rbac-role-user-add').click(function(){
            var sel=$('#rbac-role-users-input');
            ls.admin_rbac.addUserToRole(sel.data('roleId'),sel.val());
        });
        $(document).on('click','.js-rbac-role-user-remove', function (e) {
            ls.admin_rbac.removeUserFromRole($(this).data('role'),$(this).data('user'));
            e.preventDefault();
        });
    });

    return this;

}).call(ls.admin_rbac || {}, jQuery);
