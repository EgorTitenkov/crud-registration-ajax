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
                dataType: 'json',
                success: function (response) {

                    if (response['message'] == "Invalid login or password!") {
                        document.getElementById('login-output').innerText = response['message']
                        $('#login-form').trigger('reset');
                    } else {
                        window.location = 'account.php';
                    }

                    console.log(response)

                }
            });
        }
    })
})