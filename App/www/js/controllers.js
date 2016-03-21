angular.module('starter.controllers', [])

.controller('AppCtrl', function($scope, $ionicModal, $timeout, $state) {
    $scope.filters = [
      {id: 1, text: "Umph", checked: true},
      {id: 2, text: "Arnold", checked: true},
      {id: 3, text: "Mac's Place", checked: true}
    ];

    $scope.newPost = function() {
      console.log("newPost() called.");
      console.log("Switching 'state' to 'app.post'.");
      $state.go('app.post');
    }

    $scope.takeImage = function() {
      console.log("takeImage() called...");
      var options = {
          quality: 80,
          destinationType: Camera.DestinationType.DATA_URL,
          sourceType: Camera.PictureSourceType.CAMERA,
          allowEdit: true,
          encodingType: Camera.EncodingType.JPEG,
          targetWidth: 250,
          targetHeight: 250,
          popoverOptions: CameraPopoverOptions,
          saveToPhotoAlbum: false
      };

      $cordovaCamera.getPicture(options).then(function(imageData) {
          $scope.srcImage = "data:image/jpeg;base64," + imageData;
      }, function(err) {
          // error
      });
    }
})

.controller('PostCtrl', function() {

})

.controller('FeedCtrl', function($scope, $http, $state) {
  $scope.feedData = {};

  $http.get("http://private-1091a1-sample276.apiary-mock.com/index")
  .then(function(response) {
      $scope.feedData = response.data[0];
      $scope.status = response.status;
      $scope.statusText = response.statusText;
      $scope.number = $scope.feedData.number;

      //DEBUGGING//
      console.log("scope.statusText = " + $scope.statusText);
      console.log("scope.status = " + $scope.status);
      console.log("$scope.feedData = " + $scope.feedData);
      console.log("$scope.number = " + $scope.number);
  });

  $scope.openComments = function() {
    $state.go('app.details');
  }


})

.controller('DetailsCtrl', function($scope) {

  //TEST INFORMATION//
  $scope.comments = [
    {id: 1, text: "This sucked!"},
    {id: 2, text: "Idk what you're talking about^ I thought this was great"},
    {id: 3, text: "I don't know how people eat here..."}
  ];

});
