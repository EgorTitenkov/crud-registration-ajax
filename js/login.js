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
                        document.getElementById('login-output').innerText = "Invalid login or password!";
                        $('#login-form').trigger('reset');
                    } else {
                        window.location = 'account.php';
                    }
                }
            });
        }
    })
})