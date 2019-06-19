<br/>
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-8 col-md-offset-2 col-lg-8 col-lg-offset-2 well">
		<div class='text-center'><h4 class="text-info"><strong> <?php echo $this->lang->line("Plagiarism Check"); ?></strong></h4></div>
		<form enctype="multipart/form-data" method="post" class="form-inline text-center" id="new_search_form" style="margin-top:60px margin-left:10px">
			<div class="row">				
				<div class="form-group col-xs-12">
					<textarea id="bulk_email" style="width:100%;padding:10px;" rows="10" placeholder="<?php echo $this->lang->line('put your text or upload text file with contain 500 words(max)'); ?>"></textarea>
					<br/><span style="margin-left:5%"> <?php echo $this->lang->line("OR"); ?></span><br/>
				</div> 
			</div>
			
			<div class="row">						
				<div class="form-group col-xs-6">
					<input type="file" name="file_upload" id="file_upload" multiple/>
				</div>

				<div class="form-group col-xs-6 clearfix">
					<button class='btn btn-success'  id = "pull_data"><i class="fa fa-upload"></i>  <?php echo $this->lang->line("upload file"); ?></button>     
					<button type="button"  id="new_search_button" class="btn btn-info pull-right"><i class="fa fa-search"></i> <?php echo $this->lang->line("start searching"); ?></button>
				</div>
				
			</div>

		</form>
	</div>
</div>


<script>	
$('#pull_data').click(function(e){
	e.preventDefault();
		var site_url="<?php echo site_url();?>";  
		var queryString = new FormData($("#new_search_form")[0]);
		$.ajax({
			url: site_url+'home/read_text_file',
			type: 'POST',
			data: queryString,
			async: false,
			cache: false,
			contentType: false,
			processData: false,
			success:function(response){            	
				if(response!="0")
				$("#bulk_email").val(response);
				else 
				alert("<?php echo $this->lang->line("something went wrong, please try again"); ?>");	
			}
		});
});

$j("document").ready(function(){
		
		var base_url="<?php echo base_url(); ?>";
		
		$("#new_search_button").on('click',function(){
			$("#email_download_div").html('');
			$("#valid_email_download_div").html('');
			var emails=$("#bulk_email").val();
			
			if(emails==''){
				alert("<?php echo $this->lang->line("please enter your text"); ?>");
				return false;
			}
			
			$("#modal_valid_email_result").modal();
			
			$("#success_msg").html('<img class="center-block" src="'+base_url+'assets/pre-loader/Fancy pants.gif" alt="Searching..."><br/>');
			$.ajax({
				url:base_url+'tools/plagarism_check_action',
				type:'POST',
				data:{emails:emails},
				success:function(response){	

					if(response == 2){
						var mseg = '<?php echo $this->lang->line("sorry, your bulk limit is exceeded for this module.")?>'+"<a href='"+"<?php echo site_url('payment/usage_history'); ?>'>"+"<?php echo $this->lang->line('click here to see usage log') ?>"+"</a>";
						$("#success_msg").html(mseg);
					}

					else if(response == 3){
						var mseg = '<?php echo $this->lang->line("sorry, your limit is exceeded for this module.")?>'+"<a href='"+"<?php echo site_url('payment/usage_history'); ?>'>"+"<?php echo $this->lang->line('click here to see usage log') ?>"+"</a>";
						$("#success_msg").html(mseg);
					}

					else {
						
						var res = response.split("_sep_");
						var unique_per=100-res[1];				
							
						/*if(response>0)*/
							$("#success_msg").html('<center><h3 class = "text-info">'+res[0]+'</h3></center>');
							$("#email_download_div").html('<center><h3 class = "text-info">Unique: '+unique_per+'%</h3></center>');

						/*if(response==0)
							$("#success_msg").html('<center><h3 class = "text-danger"> Match Not Found </h3></center>');*/

						if(res[0]=='size_error'){
							$("#success_msg").html('<center><h3 class = "text-danger"> <?php echo $this->lang->line("you have entered too large string"); ?></h3></center>');
							$("#email_download_div").html('');
						}

						if(res[0]=='blank_error'){
							$("#success_msg").html('<center><h3 class = "text-danger">  <?php echo $this->lang->line("you have provided a blank string"); ?></h3></center>');
							$("#email_download_div").html('');
						}
					}

					
				}
				
			});
			
			
		});
		
	});
	
</script>


				

<!-- Start modal for response-->
<div id="modal_valid_email_result" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&#215;</span>
				</button>
				<h4 id="new_search_details_title" class="modal-title"><?php echo $this->lang->line("Plagiarism Check"); ?></h4>
			</div><br/>


			<div id="new_search_view_body" class="modal-body">
				
			
				<div class="row"> 				
					<div class="col-xs-12" class="text-center" id="success_msg"></div>     
				</div> 
				<div class="row">
					<div class="col-xs-9 col-xs-offset-2 col-sm-9 col-sm-offset-2 col-md-9 col-md-offset-2 col-lg-9 col-lg-offset-2 wow fadeInRight">		  
						<div class="loginmodal-container">
				
							<div id="email_download_div" style="display:inline">
				
							</div>
							
							<div id="valid_email_download_div" style="display:inline">
				
							</div>
							                 
						</div>
					</div>						
				</div>

				
				
				
			</div> <!-- End of body div-->

			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line("close"); ?></button>
			</div>
		</div>
	</div>
</div>
<!-- End modal for new search. -->
