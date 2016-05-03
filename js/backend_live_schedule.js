var app = angular.module('app_backend_live_schedule', ['ngMaterial', 'ngMessages', 'ui.bootstrap']);

app.controller('cont_backend_live_schedule', function($scope, $http, $filter, $q) {


    $scope.radio1_league = {};
    $scope.radio2_team_home = {};
    $scope.radio3_team_away = {};
    $scope.radio4_channel = {};
    $scope.u = {};
    $scope.insert_team_home = {};
    $scope.insert_team_away = {};
    $scope.result = '';
    $scope.ch_selected = [];
		$scope.selectedhome = null;
		$scope.selectedaway = null;
    //channel check box
    $scope.ch_toggle = function(item, list) {
        var idx = list.indexOf(item);
        if (idx > -1) {
            list.splice(idx, 1);
        } else {
            list.push(item);
            $scope.ch_selected = list;

        }

    };
    $scope.ch_exists = function(item, list) {
        return list.indexOf(item) > -1;
    };

    //datetime picker
    $scope.today = function() {
        $scope.u.dt = new Date();
    };
    $scope.today();

    $scope.clear = function() {
        $scope.u.dt = null;
    };

    $scope.inlineOptions = {
        customClass: getDayClass,
        minDate: new Date(),
        showWeeks: true
    };

    function getDayClass(data) {
        var date = data.date,
            mode = data.mode;
        if (mode === 'day') {
            var dayToCheck = new Date(date).setHours(0, 0, 0, 0);

            for (var i = 0; i < $scope.events.length; i++) {
                var currentDay = new Date($scope.events[i].date).setHours(0, 0, 0, 0);

                if (dayToCheck === currentDay) {
                    return $scope.events[i].status;
                }
            }
        }

        return '';
    }


    ////time
    $scope.u.mytime = new Date();

    $scope.hstep = 1;
    $scope.mstep = 1;
    //onchange league
    $scope.on_radir_list_league = function() {
        for (var i = 0; i < $scope.json_data_league.length; i++) {
            if ($scope.json_data_league[i].league_name == $scope.radio1_league) {
                if (i + 1 <= 6) { //main league
                    $scope.list_teamhw(i + 1);
                } else {
                    $scope.list_teamhw(1);
                }
            }
        }
        $scope.result = '';
    };
    //onchange team home
    $scope.on_radir_team_h = function() {

        $scope.insert_team_home = $scope.radio2_team_home;
				$scope.selectedhome = $scope.insert_team_home;
        $scope.result = '';
    };
    //onchange team away
    $scope.on_radir_team_aw = function() {

        $scope.insert_team_away = $scope.radio3_team_away;
				$scope.selectedaway = $scope.insert_team_away;
        $scope.result = '';
    };
    //query data
    $scope.user_data = {};
    $scope.data_list = function(q_id) {
        $scope.user_data.q_id = q_id;
        $http({
                method: 'POST',
                url: WPURLS.templateurl + "/php/backend_live_sch_list.php",
                data: $scope.user_data,
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }

            })
            .success(function(data_league) {
                $scope.json_data_league = data_league;

                $scope.radio1_league = $scope.json_data_league[0].league_name;
                $scope.list_teamhw(1);
                $scope.list_ch('c');


            });
    };
    //query ch

    $scope.data_list_ch = {};
    $scope.list_ch = function(c_id) {
        $scope.data_list_ch.c_id = c_id;

        $http({
                method: 'POST',
                url: WPURLS.templateurl + "/php/backend_live_sch_list.php",
                data: $scope.data_list_ch,
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }

            })
            .success(function(d_list_ch) {

                //console.log(d_list_ch);
                $scope.json_data_list_ch = d_list_ch;
                //init radio selected
                $scope.radio4_channel = $scope.json_data_list_ch[0].channel_name;

            });
    };


    //query teamhw
    $scope.data_list_teamhw = {};
    $scope.list_teamhw = function(q_id) {
        $scope.data_list_teamhw.q_id = q_id;

        $http({
                method: 'POST',
                url: WPURLS.templateurl + "/php/backend_live_sch_list.php",
                data: $scope.data_list_teamhw,
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }

            })
            .success(function(data_team_hw) {


                $scope.json_data_team_hw = data_team_hw;
                //init radio selected
                $scope.radio2_team_home = $scope.json_data_team_hw[0].team_name;
                $scope.radio3_team_away = $scope.json_data_team_hw[0].team_name;
                $scope.insert_team_home = $scope.json_data_team_hw[0].team_name;
                $scope.insert_team_away = $scope.json_data_team_hw[0].team_name;

								$scope.selectedhome = $scope.insert_team_home;
								$scope.selectedaway = $scope.insert_team_away;
            });
    };

    $scope.data_insert = {};
    $scope.insertdata = function() {

        if ($scope.ch_selected.length == 0) {
            $scope.result = "เลือกอย่างน้อย 1 ช่องสำหรับถ่ายทอดสด";
        } else {

            $scope.data_insert.c_id = "i";
            $scope.data_insert.u_dt = $scope.u.dt;
            $scope.data_insert.mytime = $scope.u.mytime;
            $scope.data_insert.league = $scope.radio1_league;

            $scope.data_insert.team_home = $scope.insert_team_home;
            $scope.data_insert.team_away = $scope.insert_team_away;
            $scope.data_insert.ch_selected = $scope.ch_selected;

						console.log('team_home = ' + $scope.data_insert.team_home);
						console.log('team_away = ' + $scope.data_insert.team_away);

            $http({
                    method: 'POST',
                    url: WPURLS.templateurl + "/php/backend_live_sch_list.php",
                    data: $scope.data_insert,
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    }

                })
                .success(function(data) {
                    $scope.result = data;

                });
            //     console.log($scope.u.dt,$scope.u.mytime,$scope.radio2_team_home,$scope.radio3_team_away,$scope.ch_selected);
					}
    };

		//var self = this;
		var self = this;
    self.simulateQuery = false;
    self.isDisabled    = false;
		$scope.selectedhome = null;
		$scope.selectedaway = null;
    // list of `state` value/display objects
    loadAll();
    self.querySearch   = querySearch;
    self.selectedItemChange = selectedItemChange;
		self.selectedItemChange2 = selectedItemChange2;
    self.searchTextChange   = searchTextChange;
		self.searchTextChange2   = searchTextChange2;
		self.newState = newState;
		self.newState2 = newState2;
    // list of `state` value/display objects
    //$scope.states = {};
		function newState(state) {
    	$scope.insert_team_home = state;
			document.querySelector('md-virtual-repeat-container').classList.add('ng-hide');
    }
		function newState2(state) {
    	$scope.insert_team_away = state;
			document.querySelector('md-virtual-repeat-container').classList.add('ng-hide');
    }

    function querySearch (query) {
			var results = query ? createFilterFor(query) : $scope.states4,deferred;
      return results;
    };

		function searchTextChange(text) {
      document.querySelector('md-virtual-repeat-container').classList.remove('ng-hide');
    }

		function searchTextChange2(text) {
      document.querySelector('md-virtual-repeat-container').classList.remove('ng-hide');
    }
    function selectedItemChange(item) {
      //$log.info('Item changed to ' + JSON.stringify(item))

			if (angular.isDefined(item)) {
  			$scope.insert_team_home = item;
			}
			console.log($scope.insert_team_home);

    }
		function selectedItemChange2(item) {
      //$log.info('Item changed to ' + JSON.stringify(item))
		if (angular.isDefined(item)) {
				$scope.insert_team_away = item;
			}
			console.log($scope.insert_team_away);
    }

		function createFilterFor(query) {
			var filtered = [];
			angular.forEach($scope.states4, function(value, key) {
	    	if( value.team_name.indexOf(query) >= 0 ) filtered.push(value);
			});
			return filtered;
    }

	function loadAll() {

			var get_team_name = $http({
				method: "post",
				url: WPURLS.templateurl + "/php/backend-live-schedule-get-teamname.php",
				data: {},
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded'
				}
			});
			get_team_name.success(function(team_name_list) {

				$scope.states4 = team_name_list;

				//$scope.states3 = Object.keys(team_name_list).map(function (key) {
				//	return team_name_list[key]['team_name'];
				//});

			});
	}

//AIzaSyCCgxI8wEkcLtH_v3YEjql8vQnP45sWT4c

});
