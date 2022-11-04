
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/css/styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js"></script>
    <title>Log in form</title>
</head>
<body>
<form class="" id="login-form" enctype="multipart/form-data" autocomplete="off">
    <h2>Login form</h2>

    <label>Login</label>
    <input type="text" name="login" id="login">

    <label>Password</label>
    <input type="password" name="password" id="password">

    <input class="submit-button" type="submit" name="submit"/>

    <label class="route-link" for="">Do not have an account?</label>

    <a class="route-span" href="/index.php">Register</a>

    <p class="output" id="login-output"></p>

</form>

<script type="text/javascript">
    $(document).ready(function () {

        $('#login-form').submit(function (e) {
            e.preventDefault();

            $("#login-form").validate({
                rules: {
                    login: {
                        required: true,
                    },
                    password: {
                        required: true,
                    }
                },

                messages: {
                    login: {
                        required: "Login is required!"
                    },
                    password: {
                        required: "Password is required!"
                    }
                }
            })


            if ($('#login-form').valid()) {
                $.ajax({
                    url: 'login_user.php',
                    type: "POST",
                    data: $(this).serialize(),
                    success: function (response) {
                        if ((response.indexOf("Invalid login or password!") > -1)) {
                            document.getElementById('login-output').innerText = response;
                            $('#login-form').trigger('reset');
                        } else {
                            window.location = 'account.php';
                        }
                    }
                });
            }
        })
    })
</script>
</body>
</html>

