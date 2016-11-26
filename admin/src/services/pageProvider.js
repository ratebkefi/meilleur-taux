'use strict';

/**
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            Taux de change
 * @description     settingsService
 */
app.service('pageProvider', ['config','$http','$location',
    function(config,$http,$location,$rootScope) {
        return {
            lister: function() {
                var url = config.apiUrl+'api/page/';
                return $http.get(url);
            },
            afficher: function(item) {
                var url =  config.apiUrl+'api/page/afficher/'+item['id'];
                return $http.get(url);
            },
            supprimer: function(item) {
                var url =  config.apiUrl+'api/page/supprimer/'+item['id'];
                return $http.delete(url);
            },
            testSupprimer: function() {
                var url =  config.apiUrl+'api/page/supprimer/'+null;
                return $http.delete(url);
            },
            ajouter: function(item) {
                return $http.post(config.apiUrl+'api/page/ajouter',item);
            },
            modifierurl: function(item) {
                $location.url('/page/modifier');
                return item;
            },
            modifierpage: function(item) {
                $location.url('/page/afficher');
                return item;
            },
            modifier: function(item) {
                var url = config.apiUrl+'api/page/modifier/'+item['id'];
                return $http.put(url,item);
            },
            testerRoleModif: function() {
                return $http.put(config.apiUrl+'api/page/modifier/');
            },
            testerRoleAjout: function() {
                return $http.get(config.apiUrl+'api/page/ajouter/');
            },
            testerRoleAffich: function() {
                return $http.get(config.apiUrl+'api/page/afficher/'+null);
            }
        };
    }
]);