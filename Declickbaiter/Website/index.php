<?php
// get the IP address of the user
$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
// get the ip address of hbidamian.tplinkdns.com
$ip2 = gethostbyname("hbidamian.tplinkdns.com");

// // If the IPs do not match, then die and display an error message
// if ($ip !== $ip2) {
//     echo "You are not on the same network as the server.";
//     die();
// }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Article De-Clickbait-ify</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        body {
            zoom: 1.15;
            background-color: #1d1f27;
            color: #eaeaea;
            font-family: 'Arial', sans-serif;
        }

        .container {
            max-width: 600px;
            background-color: #282c34;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        h1,
        h2 {
            text-align: center;
            color: #00bfa6;
        }

        .form-control {
            background-color: #343a40;
            color: #eaeaea;
            border: 1px solid #00bfa6;
        }

        .form-control:hover {
            background-color: #343a40;
            color: #eaeaea;
            border: 1px solid #00bfa6;
        }

        .form-control:focus {
            background-color: #343a40;
            color: #eaeaea;
            border: 1px solid #00bfa6;
        }

        .form-control::placeholder {
            color: #868e96;
        }


        .form-control::placeholder {
            color: #868e96;
        }

        .btn-primary {
            background-color: #00bfa6;
            border: none;
            margin: 0 auto;
            display: block;

        }

        .btn-primary:hover {
            background-color: #00a890;
        }

        .btn-secondary {
            background-color: #495057;
            border: none;
            margin: 0 auto;
            display: block;
        }

        .btn-secondary:hover {
            background-color: #616a72;
        }

        textarea {
            resize: none;
            font-family: monospace;
            font-size: 1rem;
        }

        textarea:focus {
            background-color: #343a40;
            color: #eaeaea;
        }

        textarea:active {
            background-color: #343a40;
            color: #eaeaea;
        }

        input[type="url"] {
            font-family: monospace;
            font-size: 1rem;
        }

        input[type="url"]:focus {
            background-color: #343a40;
            color: #eaeaea;
        }

        #loading {
            display: none;
            text-align: center;
        }
    </style>
</head>

<body class="dark-mode">


    <header class="header mt-auto py-3 text-center">
        <!-- Remove empty padding/space at bottom -->
        <div class="container text-center text-white py-3 mt-auto mb-0 pb-0">
            <h1 class="text-center">Article De-Clickbait-ify</h1>
            <p class="text-center mb-0">Enter the URL of a clickbait article to get a de-clickbaited version.</p>
    </header>

    <div class="container mt-auto pb-0">
        <form action="send.php" method="post">
            <h2>Enter URL of Clickbaited article</h2>
            <div class="form-group">
                <input type="url" class="form-control" name="url" placeholder="Enter URL" required autocomplete="off">
            </div>
            <input type="submit" class="btn btn-primary mb-0" value="De-Clickbait-ify">
            <button type="button" class="btn btn-secondary" id="loading" style="display: none;" disabled>
                <i class="fa fa-spinner fa-spin"></i> De-Clickbait-ifying...
            </button>
        </form>
        <br>
        <div id="DeClickbaitAssistantResponseConainer" style="display: none;" class="py-3 mt-auto mb-4">
            <h2>De-Clickbait-ified Article</h2>
            <div class="form-group">
                <textarea class="form-control" data-gramm="false" name="DeClickbaitAssistantResponse" rows="10" cols="30"></textarea>
                <!-- Copy button -->
                <br>
                <button type="button" class="btn btn-primary" onclick="copyToClipboard()">Copy Response</button>
            </div>
            <button type="button" class="btn btn-secondary mb onclick=" clearAllCookies()" id="cookies">Clear All Cookies</button>
        </div>
    </div>

    <!-- Add footer -->
    <footer class="footer mt-auto py-3 text-center">
        <div class="container">
            <span class="text-muted">This service is provided in good faith and is not responsible for the content of the articles submitted.<br> It's not meant to replace the original article, but to provide a summary of it.</span>
            <br>
            <span class="text-muted"><small>If sites don't clickbait, there would be no need for this service.</small></span>
        </div>
    </footer>

    <script>
        // if the cookie exists, display the assistant response
        if (document.cookie.indexOf("DeClickbaitAssistantResponse") >= 0) {
            document.getElementById("DeClickbaitAssistantResponseConainer").style.display = "block";
            // get the cookie value
            var DeClickbaitAssistantResponse = document.cookie.replace(/(?:(?:^|.*;\s*)DeClickbaitAssistantResponse\s*\=\s*([^;]*).*$)|^.*$/, "$1");
            // set the textarea[name='DeClickbaitAssistantResponse'] value to the cookie value and decode it
            document.querySelector("textarea[name='DeClickbaitAssistantResponse']").value = decodeURIComponent(DeClickbaitAssistantResponse);
            // delete the cookie
            document.cookie = "DeClickbaitAssistantResponse=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/; secure; samesite=strict;";
        }

        // if the url cookie exists, display the url
        if (document.cookie.indexOf("url") >= 0) {
            // get the cookie value
            var url = document.cookie.replace(/(?:(?:^|.*;\s*)url\s*\=\s*([^;]*).*$)|^.*$/, "$1");
            // set the textarea[name='url'] value to the cookie value and decode it
            document.querySelector("input[name='url']").value = decodeURIComponent(url);
        }

        // Change the textarea[name='DeClickbaitAssistantResponse'] height to fit the content inside on page load
        window.onload = function() {
            var textarea = document.querySelector("textarea[name='DeClickbaitAssistantResponse']");
            textarea.style.height = "1px";
            textarea.style.height = (25 + textarea.scrollHeight) + "px";
        };

        // Change the textarea[name='prompt'] height to fit the content inside on keyup
        document.querySelector("input[name='url']").addEventListener("keyup", function() {
            var textarea = document.querySelector("input[name='url']");
            textarea.style.height = "1px";
            textarea.style.height = (25 + textarea.scrollHeight) + "px";
            // set url value to a cookie that expires in 1 hour
            document.cookie = "url=" + encodeURIComponent(textarea.value) + "; expires=" + new Date(new Date().getTime() + 3600 * 1000).toUTCString() + "; path=/; secure; samesite=strict;";
        });

        // If there is content in the textarea[name='url'] or textarea[name='DeClickbaitAssistantResponse'], change the hight to fit the content inside on page load
        if (document.querySelector("input[name='url']").value !== "") {
            var textarea = document.querySelector("input[name='url']");
            textarea.style.height = "1px";
            textarea.style.height = (25 + textarea.scrollHeight) + "px";
        }
        if (document.querySelector("textarea[name='DeClickbaitAssistantResponse']").value !== "") {
            var textarea = document.querySelector("textarea[name='DeClickbaitAssistantResponse']");
            textarea.style.height = "1px";
            textarea.style.height = (25 + textarea.scrollHeight) + "px";
        }

        // Change submit button text to   <i class="fa fa-spinner fa-spin"></i> 
        document.querySelector("input[type='submit']").addEventListener("click", function() {
            document.querySelector("input[type='submit']").style.display = "none";
            document.getElementById("loading").style.display = "block";
        });

        function clearAllCookies() {
            // hide the button
            document.querySelector('button[type="button"][id="cookies"]').style.display = "none";
            var cookies = document.cookie.split(";");
            for (var i = 0; i < cookies.length; i++) {
                var cookie = cookies[i];
                var eqPos = cookie.indexOf("=");
                var name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
                document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/; secure; samesite=strict;";
            }
            // reload the page
            location.reload();
        }

        // Copy the assistant response to the clipboard
        function copyToClipboard() {
            var copyText = document.querySelector("textarea[name='DeClickbaitAssistantResponse']");
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            document.execCommand("copy");
        }
    </script>
    <!-- Bootstrap JS and Popper.js -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>
