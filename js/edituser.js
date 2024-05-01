const validateEmail = (email) => {
			  return email.match(
			    /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
			  );
			};

			const validate = () => {
				email = $("#email").val();
				result = $(".emailNewAlert");

				if (validateEmail(email)) {
					result.addClass("alert-email");
					result.addClass("alert");
					result.removeClass("alert-danger");
					result.addClass("alert-success");
					result.text(email + " Is valid Email")
					// result.css("background-color","green")
					$('.emailNewAlert').fadeOut(5000)
					return true;

				}else{
					// Invalid Email
					result.addClass("alert-email");
					result.addClass("alert");
					result.addClass("alert-danger");
					result.text("Invalid Email");
					$('.emailNewAlert').fadeIn(1)
					// $("#button").prop("disabled", true)
					
				}

			}


			const firstnameValidate = () => {

				firstname = $("#firstname").val();

				if(firstname.length <= 4){
					$("#firstnameHelpBlock").fadeIn();
					// $("#button").prop("disabled" , true);
					$("#firstnameHelpBlock").text("minimam required 4 latters for firstname");
				}else{
					$("#firstnameHelpBlock").fadeOut();
					return true;
				}

			} 


			const lastnameValidate = () => {
				lastname = $("#last_name").val();

				if(lastname.length <= 2){
					$("#lasnameHelpBlock").fadeIn()
					// $("#button").prop("disabled" , true);
					$("#lasnameHelpBlock").text("last name minimam required 3 latters");

				}else{
					$("#lasnameHelpBlock").fadeOut();
					return true;

				}
			}


		  $("#email").on("input",validate);
		  $("#firstname").on("input", firstnameValidate);
		  $("#last_name").on("input", lastnameValidate);

 			
 		  $("#button").on("click",(e) => {
 		  	if(firstnameValidate() == true && lastnameValidate() == true && validate() == true){
 		  		// e.preventDefault();
 		  		console.log("DFDFDfd")
 		  		alert("form submited");
 		  		"<?php 'Location: users.php' ?>"
 		  	}else{
 		  		e.preventDefault();
 		  		alert("Check Mistake pls!")
 		  		firstnameValidate();
 		  		validateEmail();
 		  		lastnameValidate();
 		  		passwordCheck();
 		  	}
 		  })