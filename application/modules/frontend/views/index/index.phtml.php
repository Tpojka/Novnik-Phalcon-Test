<div class="row">
	<h2><?= $this->escaper->escapeHtml($this->escaper->escapeHtml($h2Title)) ?></h2>
</div>
<div class="row">
    <form action="ajaxAddUser" method="POST" id="addUser">
    
    	<?= $usersForm ?>
    	<input type="text" name="<?= $this->escaper->escapeHtml($name_f_name) ?>" placeholder="<?= $this->escaper->escapeHtml($ph_f_name) ?>">
        <input type="text" name="<?= $this->escaper->escapeHtml($name_l_name) ?>" placeholder="<?= $this->escaper->escapeHtml($ph_l_name) ?>">
        <input type="text" name="<?= $this->escaper->escapeHtml($name_cc_number) ?>" placeholder="<?= $this->escaper->escapeHtml($ph_cc_number) ?>">
        <input type="text" name="<?= $this->escaper->escapeHtml($name_cc_cvv) ?>" placeholder="<?= $this->escaper->escapeHtml($ph_cc_cvv) ?>">
        <input type="submit" placeholder="GO">
    
    </form>
</div>
<div class="row">
	<p class="response-text" style="visibility: hidden"></p>
</div>

<script>
	$("#addUser").validate({

        rules: {
            <?= $this->escaper->escapeHtml($name_f_name) ?>: "required",
            
            <?= $this->escaper->escapeHtml($name_l_name) ?>: "required",
            
            <?= $this->escaper->escapeHtml($name_cc_number) ?>: {
              required: true,
              creditcard: true
            },
            
            <?= $this->escaper->escapeHtml($name_cc_cvv) ?>: {
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
	    			f_name: 	$('<?= $this->escaper->escapeHtml($name_f_name) ?>').val(), 
	    			l_name: 	$('<?= $this->escaper->escapeHtml($name_l_name) ?>').val(),
	    			cc_number: 	$('<?= $this->escaper->escapeHtml($name_cc_number) ?>').val(),
	    			cc_cvv: 	$('<?= $this->escaper->escapeHtml($name_cc_cvv) ?>').val()
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
	    					alert(data);
	    					window.location.href = "/";
	    				} else {
// 	    					alert(data);
	    					window.location.href = "/ourClients";
	    				}
	    
	    		    }, 3000);
	    		},
	    		error: function(data, statusText, xhr) { 
		    		alert(data.responseText); 
	    		}
			}
			
			$(form).ajaxSubmit(options);
		}
	});
</script>