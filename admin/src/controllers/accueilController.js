/**
 * Created by DEV-PC on 29/12/2015.
 */
'use strict';
app
    .controller('sidebar_menu', ['$scope', '$rootScope', 'menuProvider', '$location',
        function ($scope, $rootScope, menuProvider, $location) {
            $scope.sidebar_menu = [{
                icon: 'mdi-image-filter-drama',
                title: 'banque',
                content: 'Lorem ipsum dolor sit amet.'
            }, {
                icon: 'mdi-maps-place',
                title: 'devise',
                content: 'Lorem ipsum dolor sit amet.'
            }, {
                icon: 'mdi-social-whatshot',
                title: 'membre',
                content: 'Lorem ipsum dolor sit amet.'
            }
            ];
        }
    ]);