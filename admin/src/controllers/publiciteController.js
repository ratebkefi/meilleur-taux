'use strict';
app
    .controller('publicite_list', ['config', '$scope', '$filter', '$rootScope', 'publiciteProvider', 'ngTableParams', '$state',
        function (config, $scope, $filter, $rootScope, publiciteProvider, ngTableParams, $state) {
            $scope.nameapp = config.appName;
            $scope.suppression = false;
            publiciteProvider.testSupprimer().success(
                function (data, status) {
                    if (data == 403) {
                        $scope.suppression = false;
                    }
                    else if (data == 401) {
                        $scope.suppression = false;
                    }
                    else
                        $scope.suppression = true;
                }
            );
            console.log($scope.suppression);
            publiciteProvider.lister().success(
                function (data, status) {
                    if (data == 403) {
                        $state.go('erreur403');
                        $scope.suppression = false;
                    }
                    if (data == 401) {
                        $state.go('erreur401');
                        $scope.suppression = false;
                    } else {
                        $scope.suppression = true;
                        $scope.publicites = data;
                        for (var i = 0; i < $scope.publicites.length; i++) {
                            if ($scope.publicites[i].etat == true)
                                $scope.publicites[i].etat = "Activé";
                            else
                                $scope.publicites[i].etat = "Désactivé";
                        }
                        $scope.publicitesTable = new ngTableParams({
                            page: 1,
                            count: 10,
                        }, {
                            counts: [], // hides page sizes
                            total: $scope.publicites.length,  // value less than count hide pagination
                            getData: function ($defer, params) {
                                $scope.data = params.sorting() ? $filter('orderBy')($scope.publicites, params.orderBy()) : $scope.publicites;
                                $scope.data = params.filter() ? $filter('filter')($scope.data, params.filter()) : $scope.data;
                                $scope.data = $scope.data.slice((params.page() - 1) * params.count(), params.page() * params.count());
                                $defer.resolve($scope.data);
                            }
                        });
                    }
                }
            );
            $scope.supprimer_publicite = function (item) {
                publiciteProvider.supprimer(item).success(
                    function (data, status) {
                        $scope.publicites.splice($scope.publicites.indexOf(item), 1);
                        $scope.publicitesTable = new ngTableParams({
                            page: 1,
                            count: 5
                        }, {
                            total: $scope.publicites.length,
                            getData: function ($defer, params) {

                                $scope.data = params.sorting() ? $filter('orderBy')($scope.publicites, params.orderBy()) : $scope.publicites;
                                $scope.data = params.filter() ? $filter('filter')($scope.data, params.filter()) : $scope.data;
                                $scope.data = $scope.data.slice((params.page() - 1) * params.count(), params.page() * params.count());
                                $defer.resolve($scope.data);
                            }
                        });
                    }
                );
            };
            $scope.modifier = function (item) {
                $state.go('dashboard.pubmodifier');
                $rootScope.item = item;
            };
            $scope.afficher = function (item) {

                $state.go('dashboard.pubafficher');
                $rootScope.item = item;
            };
        }
    ])
    .controller('publicite_ajouter', ['$scope', 'FileUploader', 'Flash', '$rootScope', 'publiciteProvider', '$location', 'config', '$state',
        function ($scope, FileUploader, Flash, $rootScope, publiciteProvider, $location, config, $state) {
            publiciteProvider.testerRoleAjout().success(
                function (data, status) {
                    if (data == 403) {
                        $state.go('erreur403');
                    }
                    if (data == 401) {
                        $state.go('erreur401');
                    }
                }
            );
            $scope.types = [{
                type: 'Popup (336X280)',
                value: 1
            }, {
                type: 'header (728 X 90)',
                value: 2
            }, {
                type: 'header mobile (320 X 100)',
                value: 3
            }, {
                type: 'footer (728 X 90)',
                value: 4
            }, {
                type: 'footer mobile (320 X 100)',
                value: 5
            }
            ];
            var uploader = $scope.uploader = new FileUploader({
                url: config.mediaUrl
            });

            function randomPassword(length) {
                var chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOP1234567890";
                var pass = "";
                for (var x = 0; x < length; x++) {
                    var i = Math.floor(Math.random() * chars.length);
                    pass += chars.charAt(i);
                }
                return pass;
            }

            $scope.generate = function () {
                return randomPassword(20);
            }
            // FILTERS
            uploader.filters.push({
                name: 'imageFilter',
                fn: function (item /*{File|FileLikeObject}*/, options) {
                    var type = '|' + item.type.slice(item.type.lastIndexOf('/') + 1) + '|';
                    return '|jpg|png|jpeg|bmp|gif|'.indexOf(type) !== -1;
                }
            });
            $scope.ajouter_publicite = function (item) {

                publiciteProvider.ajouter(item).success(
                    function (data, status) {

                        $state.go('dashboard.publicite');
                    }
                );
            };
        }
    ])
    .controller('publicite_modifier', ['$scope', 'FileUploader', '$rootScope', 'publiciteProvider', '$location', 'config', '$state',
        function ($scope, FileUploader, $rootScope, publiciteProvider, $location, config, $state) {
            publiciteProvider.testerRoleModif().success(
                function (data, status) {
                    if (data == 403) {
                        $state.go('erreur403');
                    }
                    if (data == 401) {
                        $state.go('erreur401');
                    }
                }
            );
            $scope.data = {
                availableOptions: [
                    {type: '1', value: 'Popup (336X280)'},
                    {type: '2', value: 'header (728 X 90)'},
                    {type: '3', value: 'header mobile (320 X 100)'},
                    {type: '4', value: 'footer (728 X 90)'},
                    {type: '5', value: 'footer mobile (320 X 100))'}
                ],
                selectedOption: {type: '4'} //This sets the default value of the select in the ui
            };
            var uploader = $scope.uploader = new FileUploader({
                url: config.mediaUrl
            });

            function randomPassword(length) {
                var chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOP1234567890";
                var pass = "";
                for (var x = 0; x < length; x++) {
                    var i = Math.floor(Math.random() * chars.length);
                    pass += chars.charAt(i);
                }
                return pass;
            }

            $scope.generate = function () {
                return randomPassword(20);
            }
            // FILTERS
            uploader.filters.push({
                name: 'imageFilter',
                fn: function (item /*{File|FileLikeObject}*/, options) {
                    var type = '|' + item.type.slice(item.type.lastIndexOf('/') + 1) + '|';
                    return '|jpg|png|jpeg|bmp|gif|'.indexOf(type) !== -1;
                }
            });
            $scope.modifier_publicite = function (item) {
                publiciteProvider.modifier(item).success(
                    function (data, status) {

                        $state.go('dashboard.publicite');
                    }
                );
            };
        }
    ])
    .controller('publicite_afficher', ['$scope', '$rootScope', 'publiciteProvider', '$location', 'config',
        function ($scope, $rootScope, publiciteProvider, $location, config) {
            publiciteProvider.testerRoleAffich().success(
                function (data, status) {
                    if (data == 403) {
                        $state.go('erreur403');
                    }
                    if (data == 401) {
                        $state.go('erreur401');
                    }
                }
            );
            $scope.photourl = config.photoUrl;
        }
    ]);