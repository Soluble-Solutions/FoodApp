angular.module('starter.controllers', [])

.controller('AppCtrl', function($scope, $ionicModal, $timeout) {

})

.factory('BeerData', function(){                                          // This factory stores information as a singleton so multiple controllers can access it
  return {data: {}};
})

.controller('SearchCtrl', function($scope, $state, $http, BeerData) {     // use dependency injection to get the BeerData factory
  $scope.form = {};
  $scope.loading = false;                                                  // used to store your form data

  $scope.search = function() {
    $scope.loading=true;                                            // called when the search button is clicked
    $http({
      method: 'GET',
      url: 'https://salty-taiga-88147.herokuapp.com/beers',               // the link to my proxy
      params: {                                                           // sets the GET params
        name: $scope.form.name,
        hasLabels: $scope.form.labels,
        isOrganic: $scope.form.organic,
        abv: $scope.form.abv,
        ibu: $scope.form.ibu,
        order: $scope.form.order,
        sort: $scope.form.sort
      }
    })
    .then(function successCallback(response) {
      console.log("SEARCH FUNCTION CALLED");
      console.log("name: " + $scope.form.name);
      console.log("labels: " + $scope.form.labels);
      console.log("organic: " + $scope.form.organic);
      console.log("abv: " + $scope.form.abv);
      console.log("order: " + $scope.form.order);
      console.log("sort: " + $scope.form.sort);
      BeerData.data = response.data;                                      // save the response data in the factory
      $state.go('app.beers');                                             // go to the beer results state
    })
    .finally(function () {
      // Hide loading spinner whether our call succeeded or failed.
      $scope.loading = false;
    });
  }
})

.controller('BeersCtrl', function($scope, BeerData) {
  $scope.beerList = BeerData.data.data;
})


.controller('BeerCtrl', function($scope, $stateParams, BeerData) {        // use dependency injection to get the BeerData factory
  /*console.log(BeerData.data.data);*/
  $scope.beerList = BeerData.data.data;
  $scope.selectedID = $stateParams.id;
                                           // test to make sure the id gets passed through the URL

  // make another http request to get the beer or...
  // loop through BeerData to find the beer with the same id
});
