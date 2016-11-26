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
app.service('deviseProvider', ['config','$http','$location',
    function(config,$http,$location,$rootScope) {
        return {
            total: function() {
                var url = config.apiUrl+'api/devises/total/';
                return $http.get(url);
            },
            lister: function() {
                var url = config.apiUrl+'api/devises/';
                return true;
            },
            devise_afficher: function(item) {
                var url =  config.apiUrl+'api/devises/afficher/'+item['id'];
                return $http.get(url);
            },
            supprimer: function(item) {
                var url =  config.apiUrl+'api/devises/supprimer/'+item['id'];
                return $http.delete(url);
            },
            ajouter: function(item) {
                return $http.post(config.apiUrl+'api/devises/ajouter',item);
            },
            modifierurl: function(item) {
                $location.url('/devise/modifier');
                return item;
            },
            modifier: function(item) {
                var url = config.apiUrl+'api/devises/modifier/';
                return $http.put(url,item);
            },
            testerRoleAjout: function() {
                return $http.post(config.apiUrl+'api/devises/ajouter');
            },
             testerRoleModif: function() {
                return $http.put(config.apiUrl+'api/devises/modifier/');
            },
            testerRoleAffich: function() {
                return $http.get(config.apiUrl+'api/devises/afficher/'+null);
            },
            testerRoleLister: function() {
                return $http.get(config.apiUrl+'api/devises/list/');
            }
        };
    }
]);