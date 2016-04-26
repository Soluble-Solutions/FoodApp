angular.module('starter.controllers', ['ngAnimate'])

.factory('User', function(){
  return {id: [], status: []};
})

.factory('FeedData', function(){

  return {data: []};
})

.factory('Filters', function() {
  return {data: []};
})

.controller('LoginCtrl', function($scope, $state, $ionicModal, $http, User) {

  $ionicModal.fromTemplateUrl('signUp-modal.html', {
    scope: $scope,
    animation: 'slide-in-right'
    }).then(function(modal) {
    $scope.modal = modal
    })

    $scope.openModal = function() {
      console.log("openModal called!");
      $scope.modal.show();
    }

    $scope.closeModal = function() {
      console.log("closeModal() called");
      $scope.modal.hide();
    };

    $scope.$on('$destroy', function() {
      $scope.modal.remove();
    });

  $scope.form = {};

  $scope.login = function() {
    $http({
      method: 'PUT',
      url: 'http://52.37.14.110/login',
      contentType: "application/json",
      data: {
        email: $scope.form.email,
        password: $scope.form.password
      }
    })
    .then(function(response) {
      $scope.loginSuccess = response.data.success;

      if($scope.loginSuccess == "true") {
        User.id = response.data.user_id;
        User.status="1";
        $state.go("app.feed");
      } else {
        $scope.messageDB = response.data.messageDB;
        alert("Login Failed: " + $scope.messageDB);
      }
    })
  }

  $scope.signUp = function() {
    $http({
      method: 'POST',
      url: "http://52.37.14.110/registration",
      data: {
        phone: $scope.form.newPhone,
        email: $scope.form.newEmail,
        password: $scope.form.newPassword
      }
    })
    .then(function(response) {
      $scope.loginSuccess = response.data.success;
      if($scope.loginSuccess == "true") {
        User.id = response.data.user_id;
        User.status="1";
        $scope.closeModal();
        $state.go("app.feed");
      } else {
        $scope.messageDB = response.data.messageDB;
        alert("Login Failed: " + $scope.messageDB);
      }
    });
  }
})


.controller('AppCtrl', function($scope, $ionicModal, $timeout, $state, $http, User, Filters) {

  $scope.logout = function() {
    console.log("logout() called");
    console.log("DATA: ");
    console.log("user_id: " + User.id);
    $http({
      method: 'PUT',
      url: 'http://52.37.14.110/logout',
      contentType: "application/json",
      data: {
        user_id: User.id
      }
    })
    .then(function(response) {
      console.log(response.data);
      $scope.loginSuccess = response.data.success;
      console.log("Success: " + $scope.loginSuccess);

      if($scope.loginSuccess == "true") {
        console.log("Logged out");
        User.status="0";
        console.log("User.status: " + User.status);
        User.id="";
        console.log("User.id: " + User.id);
        $state.go("login");
      } else {
        $scope.messageDB = response.data.messageDB;
        alert("Logout Failed: " + $scope.messageDB);
      }
    })
  }

  if(User.status=="0") {
    $state.go("login");
  }

  $ionicModal.fromTemplateUrl('filtersModal.html', {
    scope: $scope,
    animation: 'slide-in-up'
    }).then(function(modal) {
    $scope.modal = modal
    })

    $scope.openModal = function() {
      $scope.modal.show();
    };

    $scope.closeModal = function() {
      $scope.modal.hide();
    };

    $scope.$on('$destroy', function() {
      $scope.modal.remove();
    });

    $scope.filterData = {
      "attribute_id":[],
      "station_id":[],
      "dh_id":[]
    };


    $scope.diningHalls = [
      {text:"Arnold", checked:true, value:1},
      {text:"Umph", checked:true, value:2}
    ];

    $scope.displayHalls = true;
    $scope.toggleHalls = function() {
      $scope.displayHalls = $scope.displayHalls === false ? true: false;
    };

    $scope.stations = [
      {text:"Bakery", checked:true, value:"1"},
      {text:"Grill", checked:true, value:"2"},
      {text:"Pizza", checked:true, value:"3"},
      {text:"Deli", checked:true, value:"4"},
      {text:"Home Zone", checked:true, value:"5"},
      {text:"Mongolian Grill", checked:true, value:"6"},
      {text:"Produce", checked:true, value:"7"},
      {text:"Soup", checked:true, value:"8"},
      {text:"Tex Mex", checked:true, value:"9"},
      {text:"Healthy on the Hilltop", checked:true, value:"10"},
      {text:"International", checked:true, value:"11"},
      {text:"Salad Bar", checked:true, value:"12"}
    ];

    $scope.displayStations = true;
    $scope.toggleStations = function() {
      $scope.displayStations = $scope.displayStations === false ? true: false;
    };

    $scope.filters = [
      {text:"Hot", checked:true, value:1},
      {text:"Cold", checked:true, value:2},
      {text:"Vegetarian", checked:true, value:3},
      {text:"Vegan", checked:true, value:4}
    ];
    $scope.displayTags = true;
    $scope.toggleTags = function() {
      $scope.displayTags = $scope.displayTags === false ? true: false;
    };


    $scope.applyFilters = function(original) {
      Filters.data = {};
      $scope.filterData = {
        "attribute_id":[],
        "station_id":[],
        "dh_id":[],
        "user_id": User.id
      };


      var i;
      for(i=0; i<4; i++){
        if($scope.filters[i].checked==true){
          $scope.filterData.attribute_id.push({"attribute":$scope.filters[i].value});
        }
      }
      for(i=0; i<12; i++){
        if($scope.stations[i].checked==true){
          $scope.filterData.station_id.push({"station":$scope.stations[i].value});
        }
      }
      for(i=0; i<2; i++){
        if($scope.diningHalls[i].checked==true){
          $scope.filterData.dh_id.push({"dh":$scope.diningHalls[i].value});
        }
      }

      $scope.filterData
      Filters.data = $scope.filterData;
      $state.go("app.post");
      $state.go("app.feed");
      if(!original){
        $scope.closeModal();
      }
    }

    $scope.openAccount = function() {
      $state.go("app.account");
    }
})


.controller('PostCtrl', function($scope, $http, User, $cordovaCamera, $cordovaFileTransfer, $state) {

  $scope.takeImage = function () {
    var options = {
      quality: 90,
      destinationType: Camera.DestinationType.DATA_URL,
      sourceType: Camera.PictureSourceType.CAMERA,
      allowEdit: true,
      encodingType: Camera.EncodingType.JPEG,
      targetWidth: 300,
      targetHeight: 325,
      popoverOptions: CameraPopoverOptions,
      saveToPhotoAlbum: false
    };

    $cordovaCamera.getPicture(options).then(function (imageData) {
        $scope.imgURI = "data:image/jpeg;base64," + imageData;
    }, function (err) {
        // An error occured. Show a message to the user
    });
  }

  $scope.diningHalls = [
    {text:"Arnold", checked:false, value:1},
    {text:"Umph", checked:false, value:2}
  ];

  $scope.stations = [
    {text:"Bakery", checked:false, value:1},
    {text:"Grill", checked:false, value:2},
    {text:"Pizza", checked:false, value:3},
    {text:"Deli", checked:false, value:4},
    {text:"Home Zone", checked:false, value:5},
    {text:"Mongolian Grill", checked:false, value:6},
    {text:"Produce", checked:false, value:7},
    {text:"Soup", checked:false, value:8},
    {text:"Tex Mex", checked:false, value:9},
    {text:"Healthy on the Hilltop", checked:false, value:10},
    {text:"International", checked:false, value:11},
    {text:"Salad Bar", checked:false, value:12}
  ];

  $scope.temps = [
    {text:"Hot", checked:false, value:1},
    {text:"Cold", checked:false, value:2}
  ];

  $scope.tags = [
    {text:"Vegetarian", checked:false, value:3},
    {text:"Vegan", checked:false, value:4}
  ];

  $scope.displayTags = false;

  $scope.showTags = function() {
    console.log("toggleTags() called");
    $scope.displayTags = $scope.displayTags === false ? true: false;
  };

  $scope.newPostForm = {};

  $scope.submitData = function() {
    console.log("submitData() called...");
    console.log("user_id: " + User.id);
    console.log("-- DATA --");
    console.log("title: " + $scope.newPostForm.title);
    console.log("newComment: " + $scope.newPostForm.comment);
    console.log("selectedDiningHall: " + $scope.newPostForm.selectedDiningHall);
    console.log("selectedStation: " + $scope.newPostForm.selectedStation);
    console.log("selectedTemp: " + $scope.newPostForm.selectedTemp);
    $scope.selectedTags = [];
    $scope.selectedTags.push({"attribute":$scope.newPostForm.selectedTemp})
    var i;
    for (i=0; i<2; i++) {
      if($scope.tags[i].checked==true){
        $scope.selectedTags.push({"attribute":$scope.tags[i].value})
      }
    }
    console.log("selectedTags: " + $scope.selectedTags);

    /* Post information to API */
    $http({
      method: 'POST',
      url: "http://52.37.14.110/entry",
      data: {
        title: $scope.newPostForm.title,
        comment: $scope.newPostForm.comment,
        dh_id: $scope.newPostForm.selectedDiningHall,
        station_id: $scope.newPostForm.selectedStation,
        attribute_id: $scope.selectedTags,
        image: $scope.image,
        user_id: User.id
      }
    }).then(function(response){
      console.log("<--Response from New Post call -->");
      console.log(response);
      $state.go("app.feed");
      alert("Your post was created! Scroll down to view");
    });
  } /* end submitData() function */

})


.controller('FeedCtrl', function($scope, $http, $state, FeedData, $stateParams, $window, $location, User, $rootScope, Filters) {
  $scope.applyFilters(1);

  // $rootScope.$on('$viewContentLoading', function(event, viewConfig){
  //   // Access to all the view config properties.
  //   // and one special property 'targetView'
  //   // viewConfig.targetView
  //   $http({
  //     method: 'POST',
  //     url: "http://52.37.14.110/filters",
  //     data: Filters.data
  //   })
  //   .then(function(response) {
  //         console.log(response);
  //         $scope.responseData=response.data;
  //         angular.forEach($scope.responseData,function(value,index){
  //                   value.votes = parseInt(value.votes);
  //               })
  //         FeedData.data = $scope.responseData;

  //         //DEBUGGING//
  //         console.log("Status = " + response.statusText);
  //         console.log($scope.feedData);
  //     });
  // });

  $scope.newPost = function() {
    $state.go('app.post');
  }

  $http({
    method: 'POST',
    url: "http://52.37.14.110/filters",
    data: Filters.data
  })
  .then(function(response) {
      $scope.responseData=response.data;
      angular.forEach($scope.responseData,function(value,index){
                value.votes = parseInt(value.votes);
            })
      FeedData.data = $scope.responseData;
      $scope.feedData = FeedData.data;
      for(var i = 0; i < FeedData.data.length; i++){
        $scope.feedData[i].upFlag = false;
        $scope.feedData[i].downFlag = false;
      }
      //DEBUGGING//
  });

  $scope.upVote = function(entryID, invotes) {
    $scope.upvote = parseInt(invotes-0+1);

    $http({
      method: 'PUT',
      url: "http://52.37.14.110/index",
      data: {
        votes: $scope.upvote,
        entry_id: entryID,
        user_id: User.id
      }
    })
    .then(function(response) {
      for(var x=0; x < $scope.feedData.length; x++)
      {

        if($scope.feedData[x].entry_id == entryID){
           if($scope.feedData[x].upFlag == true){
              $scope.feedData[x].upFlag = false;
            }
           else{
             $scope.feedData[x].upFlag = true;
           }
           $scope.feedData[x].downFlag = false;
        }
      }
      // if(response.data.success=="false"){
      //   alert("Sorry, you already voted up on this!");
      // }
      $http({
        method: 'POST',
        url: "http://52.37.14.110/filters",
        data: Filters.data
      })
      .then(function(response) {
          $scope.responseData=response.data;
          angular.forEach($scope.responseData,function(value,index){
                    value.votes = parseInt(value.votes);
                })
          FeedData.data = $scope.responseData;
          $scope.feedData = FeedData.data;
          for(x=0; x < $scope.feedData.length; x++)
          {
            if($scope.feedData[x].entry_id == entryID){
              if($scope.feedData[x].upFlag == true){
                $scope.feedData[x].upFlag = false;
              }
              else{
                $scope.feedData[x].upFlag = true;
              }
              $scope.feedData[x].downFlag = false;
            }
          }
          //DEBUGGING//
      });
    });
  }

  $scope.downVote = function(entryID, invotes) {
    $scope.downvote = parseFloat(invotes-1);
    $http({
      method: 'PUT',
      url: "http://52.37.14.110/index",
      data: {
        votes: $scope.downvote,
        entry_id: entryID,
        user_id: User.id
      }
    })
    .then(function(response) {
      for(var x=0; x < $scope.feedData.length; x++)
      {
        if($scope.feedData[x].entry_id == entryID){
          if($scope.feedData[x].downFlag == true){
            $scope.feedData[x].downFlag = false;
          }
          else{
            $scope.feedData[x].downFlag = true;
          }
          $scope.feedData[x].upFlag = false;
        }
      }

      $http({
        method: 'POST',
        url: "http://52.37.14.110/filters",
        data: Filters.data
      })
      .then(function(response) {
          $scope.responseData=response.data;
          angular.forEach($scope.responseData,function(value,index){
                    value.votes = parseInt(value.votes);
                })
          FeedData.data = $scope.responseData;
          $scope.feedData = FeedData.data;
          for(var x=0; x < $scope.feedData.length; x++)
          {
            if($scope.feedData[x].entry_id == entryID){
              if($scope.feedData[x].downFlag == true){
                $scope.feedData[x].downFlag = false;
              }
              else{
                $scope.feedData[x].downFlag = true;
              }
              $scope.feedData[x].upFlag = false;
            }
          }
          //DEBUGGING//
      });
    });
  }
})


.controller('DetailsCtrl', function($http, $scope, FeedData, $stateParams, $state, $location, User, $rootScope) {
  $scope.feedData = FeedData.data;
  $scope.selectedID = $stateParams.entry_id;
  $scope.commentURL = "http://52.37.14.110/comment/" + $scope.selectedID;

  $http({
    method: 'GET',
    url: $scope.commentURL
  }).then(function(response){
    $scope.comments = response.data.comment;
    $scope.entryData = [];
    $scope.entryData = response.data.entry[0];
    $scope.votes = $scope.entryData.votes;
    $scope.upvote = parseFloat($scope.votes) + 1;
    $scope.downvote = $scope.votes - 1;
  });


  $scope.submitComment = function() {
    if($scope.newComment != ''){
      $http({
        method: 'POST',
        url: "http://52.37.14.110/comment",
        data: {
          entry_id: $scope.selectedID,
          comment: $scope.newComment,
          user_id: User.id
        }
      }).then(function(response){
        $http({
          method: 'GET',
          url: $scope.commentURL
        }).then(function(response){
          $scope.$parent.comments = response.data.comment;
          $scope.entryData = [];
          $scope.entryData = response.data.entry[0];
          $scope.votes = $scope.entryData.votes;
          $scope.upvote = parseFloat($scope.votes) + 1;
          $scope.downvote = $scope.votes - 1;
        });
      });
      $scope.newComment = '';
    }
  }


  $scope.upVote = function() {
    $http({
      method: 'PUT',
      url: "http://52.37.14.110/index",
      data: {
        votes: $scope.upvote,
        entry_id: $scope.selectedID,
        user_id: User.id
      }
    })
    .then(function(response) {
      $http({
        method: 'GET',
        url: $scope.commentURL
      }).then(function(response){
        $scope.comments = response.data.comment;
        $scope.entryData = [];
        $scope.entryData = response.data.entry[0];
        $scope.votes = $scope.entryData.votes;
        $scope.upvote = parseFloat($scope.votes) + 1;
        $scope.downvote = $scope.votes - 1;
      });
    });
    $scope.upIsDisabled = true;
    $scope.downIsDisabled = false;
  }


  $scope.downVote = function() {
    $http({
      method: 'PUT',
      url: "http://52.37.14.110/index",
      data: {
        votes: $scope.downvote,
        entry_id: $scope.selectedID,
        user_id: User.id
      }
    })
    .then(function(response) {
      $http({
        method: 'GET',
        url: $scope.commentURL
      }).then(function(response){
        $scope.comments = response.data.comment;
        $scope.entryData = [];
        $scope.entryData = response.data.entry[0];
        $scope.votes = $scope.entryData.votes;
        $scope.upvote = parseFloat($scope.votes) + 1;
        $scope.downvote = $scope.votes - 1;
      });
    });
  }

  // var oldSoftBack = $rootScope.$ionicGoBack;
  //
  //   // override default behaviour
  // $rootScope.$ionicGoBack = function() {
  //   $http.get("http://52.37.14.110/index")
  //   .then(function(response) {
  //       FeedData.data = response.data;
  //       $scope.feedData = FeedData.data;
  //   });
  //   // uncomment below line to call old function when finished
  //   oldSoftBack();
  // };

})


.controller('AccountCtrl', function($http, $scope, User, $state) {
  $scope.userID = User.id;

  $scope.logout = function() {
    $http({
      method: 'PUT',
      url: 'http://52.37.14.110/logout',
      contentType: "application/json",
      data: {
        user_id: User.id
      }
    })
    .then(function(response) {
      $scope.loginSuccess = response.data.success;

      if($scope.loginSuccess == "true") {
        User.status="0";
        User.id="";
        $state.go("login");
      } else {
        $scope.messageDB = response.data.messageDB;
        alert("Logout Failed: " + $scope.messageDB);
      }
    })
  }
})
