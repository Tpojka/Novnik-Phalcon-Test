<div class="row">
	<h2><?= $h2Title ?></h2>
</div>
<div class="row">
    <form action="ajaxAddUser" method="POST" id="addUser">
    
    	<?= $usersForm ?>
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
	$("#addUser").validate({

        rules: {
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
		
		submitHandler: function(form) {

			var options = {
				url: '/ajaxAddUser',
	    		method: 'POST',
	    		data: {
	    			f_name: 	$('<?= $name_f_name ?>').val(), 
	    			l_name: 	$('<?= $name_l_name ?>').val(),
	    			cc_number: 	$('<?= $name_cc_number ?>').val(),
	    			cc_cvv: 	$('<?= $name_cc_cvv ?>').val()
	    		},
	    		success: function(data, statusText, xhr) {
	    
	    			if (xhr.status == 201) {
	    				$('.response-text').text("You'll be redirected to Clients list page.");
	    			} else {
		    			console.log(data);
	    				$('.response-text').text("Something went wrong. You'll be redirected to Form page again.");
	    			}
	    
	    			$('.response-text').css({
	    				visibility: "visible"
	    			});
	    
	    			window.setTimeout(function(){// redirect user after 3 seconds
	    
	    				if (xhr.status != 201) {
// 	    					alert("Line 67 " + xhr.status); // @todo on response cc_number is null
	    					window.location.href = "/";
	    				} else {
// 	    					alert("Line 70 " + xhr.status);
	    					window.location.href = "/ourClients";
	    				}
	    
	    		    }, 300000);
	    		}
			}
			
			$(form).ajaxSubmit(options);
		}
	});
</script>