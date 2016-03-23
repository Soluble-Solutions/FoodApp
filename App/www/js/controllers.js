angular.module('starter.controllers', [])

.controller('AppCtrl', function($scope, $ionicModal, $timeout, $state) {
    $scope.filters = [
      {text:"Arnold", checked:false},
      {text:"Umph", checked:true},
      {text:"Hot", checked:true},
      {text:"Cold", checked:false},
      {text:"Vegetarian", checked:true},
      {text:"Vegan", checked:true},
      {text:"Bakery", checked:false},
      {text:"Grill", checked:true},
      {text:"Pizza", checked:false},
      {text:"Deli", checked:false},
      {text:"Home_zone", checked:false},
      {text:"Mongolian_grill", checked:false},
      {text:"Produce", checked:false},
      {text:"Soup", checked:false},
      {text:"Tex_Mex", checked:false},
      {text:"Healthy_on_the_Hilltop", checked:false},
      {text:"International", checked:false}
    ];

    $scope.newPost = function() {
      console.log("Switching to $state: app.post");
      $state.go('app.post');
    }

})

.controller('PostCtrl', function($scope) {
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

.controller('FeedCtrl', function($scope, $http, $state) {
  $scope.feedData = [];

  $http.get("http://private-5fb8c-foodapp322.apiary-mock.com/index")
  .then(function(response) {
      $scope.feedData = response.data;
      $scope.status = response.status;
      $scope.statusText = response.statusText;

      //DEBUGGING//
      console.log("Status = " + $scope.statusText);
      console.log(response);
      console.log($scope.feedData);
  });

  $scope.openDetails = function() {
    console.log("Switching to $state: app.details")
    $state.go('app.details');
  }

  $scope.upvote = $scope.votes+1;
  $scope.downvote = $scope.votes-1;

  $scope.upVote = function() {
    var data = $.param({
            json: JSON.stringify({
                votes: $scope.upvote
            })
    });
    $http.post("http://private-80215-sample276.apiary-mock.com/index", data).success(function(data,status){
      $scope.votes = data;
    })
    //put request changing ranking in database to one more
  }


  $scope.downVote = function() {
    var data = $.param({
            json: JSON.stringify({
                votes: $scope.downvote
            })
    });
    $http.post("http://private-80215-sample276.apiary-mock.com/index", data).success(function(data,status){
      $scope.votes = data;
    })
    //Put request changing ranking in database to one less
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
