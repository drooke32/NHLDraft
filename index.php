<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>PSI NHL Draft Standings</title>
    <meta name="description" content="Current standings for the PSI NHL Draft 2015">
    <meta name="author" content="D. Rooke">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="//fonts.googleapis.com/css?family=Raleway:400,300,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/skeleton.css">
    <link rel="icon" type="image/png" href="images/favicon.png">
    <script src="//code.jquery.com/jquery-2.1.4.js"></script>
    <script src="js/scripts.js"></script>
    <script>
        $(function(){
            loadNHLStandings();
        });
    </script>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="twelve columns" style="margin-top: 5%">
                <h2>Current Standings</h2>
                <div id="standings"></div>
            </div>
        </div>
    </div>
    <div class="modal"></div>
    <h4 class="loadingText">Loading standings from ESPN.com</h4>
</body>
</html>
