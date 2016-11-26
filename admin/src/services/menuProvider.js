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
app.service('menuProvider', ['config','$http','$location',
    function(config,$http,$location,$rootScope) {
        return {
            lister: function() {
                var url = config.apiUrl+'api/menus/';
                return $http.get(url);
            },
            lister_page: function() {
                var url = config.apiUrl+'api/page/';
                return $http.get(url);
            },
            menu_afficher: function(item) {
                var url =  config.apiUrl+'api/menus/afficher/'+item['id'];
                return $http.get(url);
            },
            supprimer: function(item) {
                var url =  config.apiUrl+'api/menus/supprimer/'+item['id'];
                return $http.delete(url);
            },
            testSupprimer: function() {
                var url =  config.apiUrl+'api/menus/supprimer/'+null;
                return $http.delete(url);
            },
            ajouter: function(item) {
                return $http.post(config.apiUrl+'api/menus/ajouter',item);
            },
            modifierurl: function(item) {
                $location.url('/menu/modifier');
                return item;
            },
            modifier: function(item) {
                var url = config.apiUrl+'api/menus/modifier/';
                return $http.put(url,item);
            },
            testerRoleModif: function() {
                return $http.put(config.apiUrl+'api/menus/modifier/');
            },
            testerRoleAjout: function() {
                return $http.get(config.apiUrl+'api/menus/ajouter/');
            },
            testerRoleAffich: function() {
                return $http.get(config.apiUrl+'api/menus/afficher/'+null);
            }
        };
    }
]);