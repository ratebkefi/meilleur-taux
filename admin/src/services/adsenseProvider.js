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
app.service('adsenseProvider', ['config','$http','$location',
    function(config,$http,$location,$rootScope) {
        return {
            lister: function() {
                var url = config.apiUrl+'api/adsense/';
                return $http.get(url);
            },
            afficher: function(item) {
                var url =  config.apiUrl+'api/adsense/afficher/'+item['id'];
                return $http.get(url);
            },
            modifierurl: function(item) {
                $location.url('/adsense/modifier');
                return item;
            },
            modifier: function(item) {
                var url = config.apiUrl+'api/adsense/modifier/';
                return $http.put(url,item);
            },
             afficherurl: function(item) {
                $location.url('/adsense/afficher');
                return item;
            },
            chnagerEtat: function(item) {
                var url = config.apiUrl+'api/adsense/changeretat/'+item['id'];
                return $http.get(url);
            },
            testerRoleModif: function() {
                return $http.put(config.apiUrl+'api/adsense/modifier/');
            },
            testerRoleaffich: function() {
                return $http.get(config.apiUrl+'api/adsense/afficher/'+null);
            },
            testerRolechangeetat: function() {
                return $http.get(config.apiUrl+'api/adsense/changeretat/'+null);
            }
        };
    }
]);