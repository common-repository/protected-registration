
/*===========================================================
 *Custom Functions
 *=========================================================== */
jQuery(document).ready(function($){ 

	if ($('#pr-baw-invitation').is(":checked") == false ){
		$(".pr_customs").show();
	}
	
		$(document).on('change','#pr-baw-invitation',function() {

			if($(this).is(":checked")){
				$(".pr_customs").hide();
			}else{
				$(".pr_customs").show();
			}

		}); 

});
