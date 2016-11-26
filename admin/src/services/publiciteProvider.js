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
app.service('publiciteProvider', ['config','$http','$location',
    function(config,$http,$location,$rootScope) {
        return {
            lister: function() {
                var url = config.apiUrl+'api/pub/';
                return $http.get(url);
            },
            afficher: function(item) {
                var url =  config.apiUrl+'api/pub/afficher/'+item['id'];
                return $http.get(url);
            },
            supprimer: function(item) {
                var url =  config.apiUrl+'api/pub/supprimer/'+item['id'];
                return $http.delete(url);
            },
            testSupprimer: function() {
                var url =  config.apiUrl+'api/pub/supprimer/'+null;
                return $http.delete(url);
            },
            ajouter: function(item) {
                return $http.post(config.apiUrl+'api/pub/ajouter',item);
            },
            modifierurl: function(item) {
                $location.url('/publicite/modifier');
                return item;
            },
            modifier: function(item) {
                var url = config.apiUrl+'api/pub/modifier/';
                return $http.put(url,item);
            },
             afficherurl: function(item) {
                $location.url('/publicite/afficher');
                return item;
            },
            testerRoleModif: function() {
                return $http.put(config.apiUrl+'api/pub/modifier/');
            },
            testerRoleAjout: function() {
                return $http.get(config.apiUrl+'api/pub/ajouter/');
            },
            testerRoleAffich: function() {
                return $http.get(config.apiUrl+'api/pub/afficher/'+null);
            }
        };
    }
]);