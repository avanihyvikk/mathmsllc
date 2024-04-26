$.validator.setDefaults({
    submitHandler: function() {
        alert("submitted!");
    }
});

$(document).ready(function() {

    $("#employeeForm").validate({
        rules: {
            firstName: "required",
            lastName: "required",
            phoneNumber: "required",
            email: {
                required: true,
                email: true
            },
            username: {
                required: true,
                minlength: 2
            },
            password: {
                required: true,
                minlength: 5
            },
            confirm_password: {
                required: true,
                minlength: 5,
                equalTo: "#password"
            },
            location: "required",
            role: "required",
            manager: "required",
            startDate: "required"
        },
        messages: {
            firstName: "Please enter your first name",
            lastName: "Please enter your last name",
            phoneNumber: "Please enter your phone number",
            email: "Please enter a valid email address",
            username: {
                required: "Please enter a username",
                minlength: "Your username must consist of at least 2 characters"
            },
            password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 5 characters long"
            },
            confirm_password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 5 characters long",
                equalTo: "Please enter the same password as above"
            },
            location: "Please select a location",
            role: "Please select a role",
            manager: "Please select a manager",
            startDate: "Please select a start date"
        },
    });

});
