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
app.service('groupeProvider', ['config','$http','$location',
    function(config,$http,$location,$rootScope) {
        return {
            lister: function() {
                var url = config.apiUrl+'api/groupe/';
                return $http.get(url);
            },
            lister_role: function() {
                var url = config.apiUrl+'api/groupe/listRole';
                return $http.get(url);
            },
            afficher: function(item) {
                var url =  config.apiUrl+'api/groupe/afficher/'+item['id'];
                return $http.get(url);
            },
            supprimer: function(item) {
                var url =  config.apiUrl+'api/groupe/supprimer/'+item['id'];
                return $http.delete(url);
            },
            testSupprimer: function() {
                var url =  config.apiUrl+'api/groupe/supprimer/'+null;
                return $http.delete(url);
            },
            ajouter: function(item) {
                return $http.post(config.apiUrl+'api/groupe/ajouter',item);
            },
            modifierurl: function(item) {
                $location.url('/groupe/modifier');
                return item;
            },
            modifier: function(item) {
                var url = config.apiUrl+'api/groupe/modifier/';
                return $http.put(url,item);
            },
             afficherurl: function(item) {
                $location.url('/groupe/afficher');
                return item;
            },
            testerRoleAjout: function() {
                return $http.post(config.apiUrl+'api/groupe/ajouter');
            },
             testerRoleModif: function() {
                return $http.put(config.apiUrl+'api/groupe/modifier/');
            },
            testerRoleAffich: function() {
                return $http.get(config.apiUrl+'api/groupe/afficher/'+null);
            }
        };
    }
]);