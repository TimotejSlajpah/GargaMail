<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
    <div class="stran">
        <div class="l">LOGIN</div>
        <form action="login_back.php" method="post">
            <div class="group">
                <br><svg viewBox="0 0 344 384" height="26.72093023255814" width="24" class="icon">
                    <path
                    d="M170.5 192q-35.5 0-60.5-25t-25-60.5T110 46t60.5-25T231 46t25 60.5t-25 60.5t-60.5 25zm0 43q31.5 0 69.5 9t69.5 29.5T341 320v43H0v-43q0-26 31.5-46.5T101 244t69.5-9z"
                    fill="#000000"
                    ></path>
                </svg>
                <input class="input" type="email" placeholder="e-mail" name="email" id="email"><br>
            </div>
            <div class="group">
                <br><svg stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="icon">
                <path d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" stroke-linejoin="round" stroke-linecap="round"></path>
                </svg>
                <input class="input" type="password" placeholder="password" name="geslo" id="geslo"><br>
            </div>
                <div class="group">
                <input type="submit" class="sub">
            </div>
        </form>
    </div>
</body>
</html>