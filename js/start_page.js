$(document).ready(function() {

        $("#login_form").yav({
            //errorDiv:"main_error",
            //errorMessage:"Some errors are found, please correct them",
            errorTag:"span", 
        	errorPosition:"parent().before"
        });

        $("#register_check").yav({
            //errorDiv:"main_error",
            //errorMessage:"Some errors are found, please correct them",
            errorTag:"span",
        	errorPosition:"parent().before"
        });

        $("#button").click(function() {
            $("#register_form").toggle("blind");
			return false;
		});

});


