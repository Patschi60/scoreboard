<html>
    <head>

<script>
var UserAgent = navigator.userAgent.toLowerCase();
if (UserAgent.search(/(iphone|ipod|opera mini|fennec|palm|blackberry|android|symbian|series60)/) > -1)
{window.location = "mobile.php";}
</script>
        <meta charset="utf-8">
        <meta name="google" value="notranslate">
        <link rel="stylesheet" href="resources/ui.css">
        <link rel="icon" type="image/x-icon" href="icon/favicon.ico">
    </head>

    <body>
    <center>
        <h1>Scoreboard</h1>

        <form action="core/logincheck.php" Method="post">
            <p><input class="login" placeholder="Benutzername" name="user" size="20"></p>
            <p><input class="login" placeholder="Passwort" type="password" name="pw" size="20"></p>
            <p><input class="speichern" style="font-size:25px;" type="submit" value="login"></p>
        </form>

    </center>
    </body>
</html>