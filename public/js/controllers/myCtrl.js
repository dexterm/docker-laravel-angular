angular.module('myCtrl', [])
app.controller('mainController', function($scope, $http, Comment) {   // Using Inline Array Annotation for DI
   // Modify the variable, onclick
   $scope.click = function() {
    // alert("click");
      $scope.name = "Peter";

      $http.get('/api/comments').then(function(response) {
              $scope.comments = response.data;
              $scope.loading = false;
          });

   }

   // loading variable to show the spinning loading icon
   $scope.loading = true;

   // get all the comments first and bind it to the $scope.comments object
   // use the function we created in our service
   // GET ALL COMMENTS ==============

   Comment.get()
       .then(function(response) {
           $scope.comments = response.data;
           $scope.loading = false;
       });

   get = function() {
       return $http.get('/api/comments');
   }
});
