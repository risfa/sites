<br/>
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-8 col-md-offset-2 col-lg-8 col-lg-offset-2 well">
		<div class='text-center'><h4 class="text-info"><strong><?php echo $this->lang->line("Duplicate Email Filter"); ?></strong></h4></div>
		<form enctype="multipart/form-data" method="post" class="form-inline text-center" id="new_search_form" style="margin-top:60px margin-left:10px">
			<div class="row">				
				<div class="form-group col-xs-12">
					<textarea id="bulk_email" style="width:100%;padding:10px;" rows="10" placeholder="<?php echo $this->lang->line('put your emails or upload text/csv file - comma/in new line separated'); ?>"></textarea>
					<br/><span style="margin-left:5%"><?php echo $this->lang->line("OR"); ?></span><br/>
				</div> 
			</div>
			
			<div class="row">						
				<div class="form-group col-xs-6">
					<input type="file" name="file_upload" id="file_upload" multiple/>
				</div>

				<div class="form-group col-xs-6 clearfix">
					<button class='btn btn-success'  id = "pull_data"><i class="fa fa-upload"></i> <?php echo $this->lang->line("upload file"); ?></button>     
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
				alert("<?php echo $this->lang->line("please enter your emails"); ?>");
				return false;
			}
			
			$("#modal_unique_email_result").modal();
			
			$("#success_msg").html('<img class="center-block" src="'+base_url+'assets/pre-loader/Fancy pants.gif" alt="Searching..."><br/>');
			$.ajax({
				url:base_url+'tools/email_unique_maker',
				type:'POST',
				data:{emails:emails},
				success:function(response){					
					
					$("#unique_email_download_div").html('<a href="<?php echo base_url()."download/unique_email/unique_email_{$this->user_id}_{$this->download_id}.txt" ?>" target="_blank" class="btn btn-lg btn-warning"><i class="fa fa-cloud-download"></i> <b><?php echo $this->lang->line("download"); ?></b></a>');
					$("#success_msg").html('<center><h3> '+response+' </h3></center>');
					
				}
				
			});
			
			
		});
		
	});
	
</script>


				

<!-- Start modal for response-->
<div id="modal_unique_email_result" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&#215;</span>
				</button>
				<h4 id="new_search_details_title" class="modal-title"><?php echo $this->lang->line("Duplicate Email Filter"); ?></h4>
			</div><br/>


			<div id="new_search_view_body" class="modal-body">				
			
				<div class="row"> 				
					<div class="col-xs-12" class="text-center" id="success_msg"></div>     
				</div> 
				<div class="row">					
					<!-- <div class="col-xs-9 col-xs-offset-2 col-sm-9 col-sm-offset-2 col-md-9 col-md-offset-3 col-lg-9 col-lg-offset-3 wow fadeInRight">		  
						<div class="loginmodal-container"> -->
							
							<div id="unique_email_download_div" class="text-center">
				
							</div>
						<!-- 	                 
						</div>
					</div>	 -->		
				</div>

				
				
				
			</div> <!-- End of body div-->

			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line("close"); ?></button>
			</div>
		</div>
	</div>
</div>
<!-- End modal for new search. -->

