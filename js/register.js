$(document).ready(function () {
    $('#register-form').submit(function (e) {
        e.preventDefault();

        $.validator.addMethod("numsAndChars", function (value, element) {
            return this.optional(element) || /(?=.*[0-9])(?=.*[a-z])/.test(element.value)
        });

        $.validator.addMethod("numsAndChars", function (value, element) {
            return this.optional(element) || /(?=.*[0-9])(?=.*[a-z])/.test(element.value)
        });

        $.validator.addMethod("noSpacesAndSpecialSymbols", function (value, element) {
            return this.optional(element) || !/([\s!@#$%.^&*()_])/.test(element.value)
        });

        $.validator.addMethod("validEmail", function (value, element) {
            return this.optional(element) || /^([a-z0-9_-]+\.)*[a-z0-9_-]+@[a-z0-9_-]+(\.[a-z0-9_-]+)*\.[a-z]{2,6}$/.test(element.value)
        });

        $.validator.addMethod("noSpaces", function (value, element) {
            return this.optional(element) || !/([\s])/.test(element.value)
        });

        $.validator.addMethod("onlyChars", function (value, element) {
            return this.optional(element) || /(?=.*[a-z])/.test(element.value)
        });

        $("#register-form").validate({
            rules: {
                login: {
                    required: true,
                    minlength: 6,
                    noSpacesAndSpecialSymbols: true
                },
                password: {
                    required: true,
                    minlength: 6,
                    numsAndChars: true,
                    noSpacesAndSpecialSymbols: true
                },
                confirmation_password: {
                    required: true,
                    minlength: 6,
                    equalTo: '#password'
                },
                email: {
                    required: true,
                    validEmail: true
                },
                name: {
                    required: true,
                    minlength: 2,
                    onlyChars: true,
                    noSpacesAndSpecialSymbols: true
                }
            },

            messages: {
                login: {
                    required: "Login is required!",
                    noSpacesAndSpecialSymbols: "Spaces and special symbols (!@#$%.^&*()_) are not allowed"
                },
                password: {
                    required: "Password is required!",
                    numsAndChars: "Password must contain numbers and symbols!",
                    noSpacesAndSpecialSymbols: "Password must not contain spaces and special symbols"
                },
                confirmation_password: {
                    required: "Confirmation password is required!",
                    equalTo: "Please enter the same password!"
                },
                email: {
                    required: "Email is required!",
                    validEmail: "Please enter valid email!"
                },
                name: {
                    required: "Name is required!",
                    onlyChars: "Name must contain only letters!",
                    noSpacesAndSpecialSymbols: "Spaces and special symbols (!@#$%.^&*()_) are not allowed."
                }
            }
        })


        if ($('#register-form').valid()) {
            $.ajax({
                url: 'crud_user.php',
                type: "POST",
                data: $(this).serialize(),
                dataType: 'json',
                success: function (response) {
                    document.getElementById('output').innerText = response['message'];
                    $('#register-form').trigger('reset');

                    console.log(response)
                }
            });
        }
    })
})