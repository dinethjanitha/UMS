const passwordCheck = () => {

		  		password = $("#password").val();

			  	if(password.length > 7 && /[!@#$%^&*()_+{}[\]:;<>,.?~]/.test(password)){

			  		console.log("Password strength");
			  		// $("button").prop("disabled", false);
			  		$("#passwordHelpBlock").text("password Very good");
			  		$("#passwordHelpBlock").fadeOut(6000);
			  		$("#passwordHelpBlock").css("color","green");
			  		$("#passwordHelpBlock").removeClass("firstnameHelpBlock");
			  		return true;

			  	}else{
			  		$("#passwordHelpBlock").fadeIn(1);
			  		// $("#button").prop("disabled", true)
				  	$("#passwordHelpBlock").text("password week")
				  	$("#passwordHelpBlock").css("color","red");
				  	$("#passwordHelpBlock").addClass("firstnameHelpBlock")
				  	return false;
			  	}

}

const passwordconfire = () => {
			firstpassword = $("#password").val();
			secondpassword = $("#confirmpassword").val();

			if(firstpassword == secondpassword){
				$("#confirmpasswordHelpBlock").text("Password Match!");
				return true;
			}else{
				$("#confirmpasswordHelpBlock").text("Password Not Match!");
			}
		}
		$("#password").on("input", passwordCheck )

		$("#confirmpassword").on("input", passwordconfire );

		$("#button").click((e)=>{
			if(passwordconfire() == true && passwordCheck() == true){
				alert("form submited");
			}else{
				e.preventDefault();
				passwordCheck();
				passwordconfire();
				

			}
		})

