'use strict';
app
    .controller('banque_list', ['config', '$scope', '$filter', '$rootScope', 'banqueProvider', 'ngTableParams', '$state',
        function (config, $scope, $filter, $rootScope, banqueProvider, ngTableParams, $state) {
            $scope.nameapp = config.appName;
            $scope.photoUrl = config.photoUrl;
            $scope.suppression = false;
            banqueProvider.testSupprimer().success(
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
            banqueProvider.lister().success(
                function (data, status) {
                    if (data == 403) {
                        $state.go('erreur403');
                    }
                    if (data == 401) {
                        $state.go('erreur401');
                    } else {
                        $scope.banques = data;
                        $scope.banquesTable = new ngTableParams({
                            page: 1,
                            count: 100 // Nbr de ligne par page
                        }, {
                            counts: [], // hides page sizes
                            total: $scope.banques.length,
                            getData: function ($defer, params) {
                                $scope.data = params.sorting() ? $filter('orderBy')($scope.banques, params.orderBy()) : $scope.banques;
                                $scope.data = params.filter() ? $filter('filter')($scope.data, params.filter()) : $scope.data;
                                $scope.data = $scope.data.slice((params.page() - 1) * params.count(), params.page() * params.count());
                                $defer.resolve($scope.data);
                            }
                        });
                    }
                }
            );
            $scope.supprimer_banque = function (item) {
                banqueProvider.supprimer(item).success(
                    function (data, status) {
                        $scope.banques.splice($scope.banques.indexOf(item), 1);
                        $scope.banquesTable = new ngTableParams({
                            page: 1,
                            count: 100 // Nbr de ligne par page
                        }, {
                            counts: [], // hides page sizes
                            total: $scope.banques.length,
                            getData: function ($defer, params) {
                                $scope.data = params.sorting() ? $filter('orderBy')($scope.banques, params.orderBy()) : $scope.banques;
                                $scope.data = params.filter() ? $filter('filter')($scope.data, params.filter()) : $scope.data;
                                $scope.data = $scope.data.slice((params.page() - 1) * params.count(), params.page() * params.count());
                                $defer.resolve($scope.data);
                            }
                        });
                    }
                );
            };
            $scope.modifier = function (item) {
                $state.go('dashboard.banquemodifier');
                $rootScope.banque = item;
            };
            $scope.afficher = function (item) {
                $state.go('dashboard.banqueafficher');
                $rootScope.banque = item;
            };
        }
    ])
    .controller('banque_ajouter', ['$scope', 'FileUploader', 'Flash', '$rootScope', 'banqueProvider', '$location', 'config', '$state',
        function ($scope, FileUploader, Flash, $rootScope, banqueProvider, $location, config, $state) {
            banqueProvider.testerRoleAjout().success(
                function (data, status) {
                    if (data == 403) {
                        $state.go('erreur403');
                    }
                    if (data == 401) {
                        $state.go('erreur401');
                    }
                }
            );
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
                fn: function (banque /*{File|FileLikeObject}*/, options) {
                    var type = '|' + banque.type.slice(banque.type.lastIndexOf('/') + 1) + '|';
                    return '|jpg|png|jpeg|bmp|gif|'.indexOf(type) !== -1;
                }
            });
            $scope.ajouter_banques = function (item) {
                console.log(item);
                banqueProvider.ajouter(item).success(
                    function (data, status) {

                        var message = '<strong>Banque créée avec succès!</strong>';
                        Flash.create('success', message);
                        $state.go('dashboard.banque');
                    }
                );
            };
        }
    ])
    .controller('banque_modifier', ['$scope', '$rootScope', 'banqueProvider', '$location', 'FileUploader', 'config', '$state',
        function ($scope, $rootScope, banqueProvider, $location, FileUploader, config, $state) {
            banqueProvider.testerRoleModif().success(
                function (data, status) {
                    if (data == 403) {
                        $state.go('erreur403');
                    }
                    if (data == 401) {
                        $state.go('erreur401');
                    }
                }
            );
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
                fn: function (banque /*{File|FileLikeObject}*/, options) {
                    var type = '|' + banque.type.slice(banque.type.lastIndexOf('/') + 1) + '|';
                    return '|jpg|png|jpeg|bmp|gif|'.indexOf(type) !== -1;
                }
            });
            $scope.modifier_banque = function (item) {
                banqueProvider.modifier(item).success(
                    function (data, status) {

                        $state.go('dashboard.banque');
                    }
                );
            };
        }
    ])
    .directive('stringToNumber', function () {
        return {
            require: 'ngModel',
            link: function (scope, element, attrs, ngModel) {
                ngModel.$parsers.push(function (value) {
                    return '' + value;
                });
                ngModel.$formatters.push(function (value) {
                    return parseFloat(value, 10);
                });
            }
        };
    })
    .controller('banque_afficher', ['$scope', '$rootScope', 'publiciteProvider', '$location', 'config',
        function ($scope, $rootScope, banqueProvider, $location, config) {
            banqueProvider.testerRoleAffich().success(
                function (data, status) {
                    if (data == 403) {
                        $state.go('erreur403');
                    }
                    if (data == 401) {
                        $state.go('erreur401');
                    }
                }
            );
            $scope.photoUrl = config.photoUrl;
        }
    ]);