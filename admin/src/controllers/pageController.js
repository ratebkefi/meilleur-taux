'use strict';
app
    .controller('page_list', ['config', '$scope', '$filter', '$rootScope', 'pageProvider', 'ngTableParams', '$state',
        function (config, $scope, $filter, $rootScope, pageProvider, ngTableParams, $state) {
            $scope.nameapp = config.appName;
            $scope.suppression = false;
            pageProvider.testSupprimer().success(
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
            pageProvider.lister().success(
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
                        $scope.users = data;
                        $scope.usersTable = new ngTableParams({
                            page: 1,
                            count: 5
                        }, {
                            total: $scope.users.length,
                            getData: function ($defer, params) {
                                $scope.data = params.sorting() ? $filter('orderBy')($scope.users, params.orderBy()) : $scope.users;
                                $scope.data = params.filter() ? $filter('filter')($scope.data, params.filter()) : $scope.data;
                                $scope.data = $scope.data.slice((params.page() - 1) * params.count(), params.page() * params.count());
                                $defer.resolve($scope.data);
                            }
                        });
                    }
                }
            );
            $scope.supprimer_page = function (item) {
                pageProvider.supprimer(item).success(
                    function (data, status) {
                        $scope.users.splice($scope.users.indexOf(item), 1);
                        $scope.usersTable = new ngTableParams({
                            page: 1,
                            count: 5
                        }, {
                            total: $scope.users.length,
                            getData: function ($defer, params) {

                                $scope.data = params.sorting() ? $filter('orderBy')($scope.users, params.orderBy()) : $scope.users;
                                $scope.data = params.filter() ? $filter('filter')($scope.data, params.filter()) : $scope.data;
                                $scope.data = $scope.data.slice((params.page() - 1) * params.count(), params.page() * params.count());
                                $defer.resolve($scope.data);
                            }
                        });
                    }
                );
            };
            $scope.modifier_page = function (item) {
                $state.go('dashboard.pagemodifier');
                $rootScope.item = item;
            };
            $scope.afficher_page = function (item) {
                $state.go('dashboard.pageafficher');
                $rootScope.item = item;
            };
        }
    ])
    .controller('page_ajouter', ['$scope', '$rootScope', 'pageProvider', '$location', '$state',
        function ($scope, $rootScope, pageProvider, $location, $state) {
            pageProvider.testerRoleAjout().success(
                function (data, status) {
                    if (data == 403) {
                        $state.go('erreur403');
                    }
                    if (data == 401) {
                        $state.go('erreur401');
                    }
                }
            );
            $scope.tinymceOptions = {
                onChange: function (e) {
                    // put logic here for keypress and cut/paste changes
                },
                inline: false,
                // plugins: 'advlist autolink link image lists charmap print ',
                skin: 'lightgray',
                theme: 'modern',
                preview_styles: false,
                resize: true,
                language: "fr_FR",
                plugins: [
                    "advlist autolink link image lists charmap print preview hr anchor pagebreak",
                    "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
                    "table contextmenu directionality emoticons paste textcolor responsivefilemanager code"
                ],
                toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
                toolbar2: "| responsivefilemanager | link unlink anchor | image media | forecolor backcolor  | print preview code ",
                image_advtab: true,
                external_filemanager_path: "/meilleur-taux.tn/admin/filemanager/",
                filemanager_title: "Responsive Filemanager",
                external_plugins: {"filemanager": "/meilleur-taux.tn/admin/filemanager/plugin.min.js"}
            };
            $scope.ajouter_page = function (item) {
                pageProvider.ajouter(item).success(
                    function (data, status) {
                        $scope.success = function () {
                        };
                        $state.go('dashboard.page');
                    }
                );
            };
        }
    ])
    .controller('page_modifier', ['$scope', '$rootScope', 'pageProvider', '$location', '$state',
        function ($scope, $rootScope, pageProvider, $location, $state) {
            pageProvider.testerRoleModif().success(
                function (data, status) {
                    if (data == 403) {
                        $state.go('erreur403');
                    }
                    if (data == 401) {
                        $state.go('erreur401');
                    }
                }
            );
            $scope.tinymceOptions = {
                onChange: function (e) {
                    // put logic here for keypress and cut/paste changes
                },
                inline: false,
                // plugins: 'advlist autolink link image lists charmap print ',
                skin: 'lightgray',
                theme: 'modern',
                preview_styles: false,
                resize: true,
                language: "fr_FR",
                plugins: [
                    "advlist autolink link image lists charmap print preview hr anchor pagebreak",
                    "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
                    "table contextmenu directionality emoticons paste textcolor responsivefilemanager code"
                ],
                toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
                toolbar2: "| responsivefilemanager | link unlink anchor | image media | forecolor backcolor  | print preview code ",
                image_advtab: true,
                external_filemanager_path: "/meilleur-taux.tn/admin/filemanager/",
                filemanager_title: "Responsive Filemanager",
                external_plugins: {"filemanager": "/meilleur-taux.tn/admin/filemanager/plugin.min.js"}
            };
            $scope.modifier_page = function (item) {
                pageProvider.modifier(item).success(
                    function (data, status) {
                        $state.go('dashboard.page');
                    }
                );
            };
        }
    ])
    .controller('page_afficher', ['$scope', '$rootScope', 'pageProvider', '$location', '$state',
        function ($scope, $rootScope, pageProvider, $location, $state) {
            $scope.afficher_page = function (item) {
                pageProvider.afficher(item).success(
                    function (data, status) {
                        $state.go('dashboard.page');
                    }
                );
            };
        }
    ]);