
<!doctype html>
<html>
<head>
    <script src="js/register.js"></script>

</head>
<link rel="stylesheet" href="/css/styles.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js"></script>
<body>
<form id="register-form" method="post">
    <div>
        <label>Login</label>
        <input type="text" name="login" id="login"/>

        <label>Password</label>
        <input type="password" name="password" id="password"/>

        <label>Confirmation password</label>
        <input type="password" name="confirmation_password" id="confirmation_password"/>

        <label>Email</label>
        <input type="text" name="email" id="email"/>

        <label>Name</label>
        <input type="text" name="name" id="name"/>

        <input class="submit-button" type="submit" name="submit" id="submit"/>

        <p class="output" id="output"></p>

        <label class="route-link">Do you already have an account?</label>
        <a class="route-span" href="/login.php">Log In</a>
    </div>
</form>


<script type="text/javascript">
    $(document).ready(function () {

        $('#register-form').submit(function (e) {
            e.preventDefault();

            $.validator.addMethod("numsAndChars", function (value, element) {
                return this.optional(element) || /(?=.*[0-9])(?=.*[a-z])/.test(element.value)
            });

            $.validator.addMethod("noSpaces", function (value, element) {
                return this.optional(element) || !/([\s!@#$%.^&*()_])/.test(element.value)
            });

            $.validator.addMethod("onlyChars", function (value, element) {
                return this.optional(element) || /(?=.*[a-z])/.test(element.value)
            });

            $("#register-form").validate({
                rules: {
                    login: {
                        required: true,
                        minlength: 6,
                        noSpaces: true
                    },
                    password: {
                        required: true,
                        minlength: 6,
                        numsAndChars: true
                    },
                    confirmation_password: {
                        required: true,
                        minlength: 6,
                        equalTo: '#password'
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    name: {
                        required: true,
                        minlength: 2,
                        onlyChars: true
                    }
                },

                messages: {
                    login: {
                        required: "Login is required!",
                        noSpaces: "Spaces and special symbols (!@#$%.^&*()_) are not allowed"
                    },
                    password: {
                        required: "Password is required!",
                        numsAndChars: "Password must contain numbers and symbols!"
                    },
                    confirmation_password: {
                        required: "Confirmation password is required!",
                        equalTo: "Please enter the same password!"
                    },
                    email: {
                        required: "Email is required!",
                        email: "Please enter valid email!"
                    },
                    name: {
                        required: "Name is required!",
                        onlyChars: "Name must contain only letters!"
                    }
                }
            })


            if ($('#register-form').valid()) {
                $.ajax({
                    url: 'create_user.php',
                    type: "POST",
                    data: $(this).serialize(),
                    success: function (response) {
                        $('#output').trigger('reset');
                        document.getElementById('output').innerText = response;
                        $('#register-form').trigger('reset');
                    }
                });
            }
        })
    })
</script>
</body>
</html>