<!doctype html> <html lang="en"> <head> <meta charset="UTF-8"> <title>Laravel and Angular Comment System</title>

    <!-- CSS -->
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css"> <!-- load bootstrap via cdn -->
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css"> <!-- load fontawesome -->
    <style>
        body        { padding-top:30px; }
        form        { padding-bottom:20px; }
        .comment    { padding-bottom:20px; }
    </style>
</head>
<body ng-app="myApp" ng-controller="mainController">
    <input type="text" ng-model="name" placeholder="Enter your name">
    <p>Hello, @{{ name | uppercase }}</p>
    <button ng-click="click()">Click Me!</button>

        <!-- LOADING ICON =============================================== -->
        <!-- show loading icon if the loading variable is set to true -->
        <p class="text-center" ng-show="loading"><span class="fa fa-meh-o fa-5x fa-spin"></span></p>

        <!-- THE COMMENTS =============================================== -->
        <!-- hide these comments if the loading variable is true -->
        <div class="comment" ng-hide="loading" ng-repeat="comment in comments">
            <h3>Comment #@{{ comment.id }} <small>by @{{ comment.author }}</h3>
            <p>@{{ comment.text }}</p>

            <p><a href="#" ng-click="deleteComment(comment.id)" class="text-muted">Delete</a></p>
        </div>

  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>

  <script src="js/main.js"></script> <!-- load our application -->
  <script src="js/services/commentService.js"></script> <!-- load our service -->
  <script src="js/controllers/myCtrl.js"></script> <!-- load our application -->


</body>
</html>
