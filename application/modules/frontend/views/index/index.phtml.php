<div class="row">
	<h2><?= $h2Title ?></h2>
</div>
<div class="row">
    <form action="ajaxAddUser" method="POST" id="addUser">
    
    	<input type="text" name="<?= $name_f_name ?>" placeholder="<?= $ph_f_name ?>">
        <input type="text" name="<?= $name_l_name ?>" placeholder="<?= $ph_l_name ?>">
        <input type="text" name="<?= $name_cc_number ?>" placeholder="<?= $ph_cc_number ?>">
        <input type="text" name="<?= $name_cc_cvv ?>" placeholder="<?= $ph_cc_cvv ?>">
        <input type="submit" placeholder="GO">
    
    </form>
</div>
<div class="row">
	<p class="response-text" style="visibility: hidden"></p>
</div>


    <script>
    	$(document).ready(function(){
        	$("#addUser").submit(function(e){

        		var <?= $name_f_name ?> = $('input[name="<?= $name_f_name ?>"]').val();
        			<?= $name_l_name ?> = $('input[name="<?= $name_l_name ?>"]').val(),
        			<?= $name_cc_number ?> = $('input[name="<?= $name_cc_number ?>"]').val(),
        			<?= $name_cc_cvv ?> = $('input[name="<?= $name_cc_cvv ?>"]').val();

        		console.log(<?= $name_f_name ?>);

                $("#addUser").validate({

                	errorElement: "em",

        			rules: {
        			    // simple rule, converted to {required:true}
        				<?= $name_f_name ?>: "required",

        				<?= $name_l_name ?>: "required",

        				<?= $name_cc_number ?>: {
							required: true,
							creditcard: true
        				},

        				<?= $name_cc_cvv ?>: {
							required: true,
							number: true,
							maxlength: 4
        				}
        			  },
                    
                    submitHandler: function() {
                    	$(".response-text").css( "visibility", "visible" );

                    	var responseText;

						$.ajax({
                            method: "POST",
                            url: "/ajaxAddUser",
                            data: $("#addUser").serialize()
						})
						  .done(function(data, textStatus, xhr) {

							  var respondedXhr = xhr;

							  passedText = "You'll be redirected to clients list.";

							  failedText = "Something went wrong with data saving. Please contact administrator. You'll be redirected to form page.";


            				  window.setTimeout(function(respondedXhr){// redirect user after 5 seconds

									if (xhr.status == 200) {
										
										window.location.href = "/ourClients";
										
									} else {
										
										window.location.href = "/";
									}

      						    }, 5000);

							if (respondedXhr.status != 200) {
								$(".response-text").text(failedText);
							} else {
								$(".response-text").text(passedText);
							}
							
        				  })
        				  .always(function(data, textStatus, xhr){
        					  $(".response-text").css("visibility", "visible");
        				  });
                    }
                });

                e.preventDefault();
        	});
    		
    	});
    </script>