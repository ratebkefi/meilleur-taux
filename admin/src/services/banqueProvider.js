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
app.service('banqueProvider', ['config','$http','$location',
    function(config,$http,$location,$rootScope) {
        return {
            lister: function() {
                var url = config.apiUrl+'api/banque/';
                return $http.get(url);
            },
            testerRoleAjout: function() {
                return $http.post(config.apiUrl+'api/banque/ajouter');
            },
            afficher: function(item) {
                var url =  config.apiUrl+'api/banque/afficher/'+item['id'];
                return $http.get(url);
            },
            supprimer: function(item) {
                var url =  config.apiUrl+'api/banque/supprimer/'+item['id'];
                return $http.delete(url);
            },
            testSupprimer: function() {
                var url =  config.apiUrl+'api/banque/supprimer/'+null;
                return $http.delete(url);
            },
            ajouter: function(item) {
                return $http.post(config.apiUrl+'api/banque/ajouter',item);
            },
            modifierurl: function(item) {
                $location.url('/banque/modifier');
                return item;
            },
            testerRoleModif: function() {
                return $http.put(config.apiUrl+'api/banque/modifier/');
            },
            modifier: function(item) {
                var url = config.apiUrl+'api/banque/modifier/';
                return $http.put(url,item);
            },
             afficherurl: function(item) {
                $location.url('/banque/afficher');
                return item;
            },
            testerRoleAffich: function() {
                return $http.get(config.apiUrl+'api/banque/afficher/'+null);
            },
        };
    }
]);