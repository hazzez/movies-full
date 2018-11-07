<html>
<head>
    <title>CORS</title>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            $.get("http://movies.local/app_dev.php/movies/1", function (data) {
                $('#title').text(data.title);
                $('#year').text(data.year);
                $('#desc').text(data.description);
            });
        });
    </script>
</head>
<body>

<div>
    Title: <span id="title"></span><br/>
    Year: <span id="year"></span><br/>
    Description: <span id="desc"></span>
</div>

</body>
</html>