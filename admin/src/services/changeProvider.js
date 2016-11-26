'use strict';

/**
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            AiselSettings
 * @description     settingsService
 */
app.service('changeProvider', ['config','$http','$location',
    function(config,$http,$location,$rootScope) {
        return {
            total: function(item) {
                var url = config.apiUrl+'api/change/total/';
                return $http.post(url,item);
            },
            lister: function() {
                var url = config.apiUrl+'api/change/';
                return $http.get(url);
            },
            lister_banque: function() {
                var url = config.apiUrl+'api/banque/';
                return $http.get(url);
            },
            lister_devise: function() {
                var url = config.apiUrl+'api/devises/list/';
                return $http.get(url);
            },
            supprimer: function(item) {
                var url =  config.apiUrl+'api/change/supprimer/'+item['id'];
                return $http.delete(url);
            },
            ajouter: function(item) {
                return $http.post(config.apiUrl+'api/change/ajouter',item);
            },
            testerRoleAjout: function() {
                return $http.post(config.apiUrl+'api/change/ajouter');
            },
            testerRoleLister: function() {
                return $http.get(config.apiUrl+'api/change/30/1');
            }
        };
    }
]);