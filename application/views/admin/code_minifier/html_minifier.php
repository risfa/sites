<?php $this->load->view("include/upload_js"); ?>

<section class="content-header">
   <section class="content">
     <div class="box box-info custom_box">
       <div class="box-header">
         <h3 class="box-title"><i class="fa fa-html5"></i> <?php echo $this->lang->line('HTML code minifier');?> </h3>
       </div><!-- /.box-header -->
	   
	   
       <!-- form start -->
	   
	   
       <form class="form-horizontal" method="POST">
	   
         <div class="box-body">	  

         	<div class="form-group">
	             <label class="col-sm-2 control-label" for=""></label>
	             <div class="col-sm-8 col-md-8 col-lg-8">
	             	<textarea style="width:100% !important;" class="form-control" rows="10" name="html_code" id="html_code" placeholder="<?php echo $this->lang->line('Write your html code here...');?>"></textarea><br/>
	             	<div style="display:none;" id="div_for_output">
	             		<div class="label label-success" style="font-size:16px;"><?php echo $this->lang->line('Minified output of the above code');?></div><br/>
		             	<textarea style="width:100% !important;" id="output_html_code" class="form-control" rows="10"></textarea><br/>
	             	</div>
	             	<button type="button" class="btn btn-info" id="minify_html"><?php echo $this->lang->line('minify the above code');?></button><br/>
	             </div>
            </div>
		   
			
            <div class="form-group">
            	<label class="col-sm-2 control-label" for="message"></label>
            	<div class="col-sm-8 col-md-8 col-lg-8">
            		<br/><br/>
            		<div class="alert alert-warning" style="font-size:16px;margin-bottom:10px;"><?php echo $this->lang->line('To minify your single or multiple html files, please select your files by clicking the upload button bellow.');?></div><br/>
            	</div>
            </div>

            <div class="form-group">
            	<label class="col-sm-2 control-label" for="message"></label>
            	<div class="col-sm-5 col-md-5 col-lg-5">
            		<div id="fileuploader"><?php echo $this->lang->line('Upload');?></div>
            	</div>
            </div>
		   
            
           </div> <!-- /.box-body --> 
		   
		   
                   
         </div><!-- /.box-info -->      
		  
       </form>     
     </div>
   </section>
</section>

<script>
$j("document").ready(function(){

	var base_url = "<?php echo base_url(); ?>";

	$(document.body).on('click','#minify_html',function(){
		var html_code = $("#html_code").val().trim();

		if(html_code==''){
			alert("<?php echo $this->lang->line('Please write your html code first');?>");
			return false;
		}

		$.ajax({
			type: "POST",
			url: base_url+"code_minifier/html_minifier_textarea",
			data:{code:html_code},
			async: false,
			success: function(data) {
				$("#output_html_code").text(data);
				$("#div_for_output").show();
			}
		});

	});
	

	$("#fileuploader").uploadFile({
		url:base_url+"code_minifier/html_minifier_action",
		fileName:"myfile",
		returnType: "json",
		dragDrop: true,
		showDelete: true,
		showDownload:true,
		multiple:true,
		sequential:true,
		sequentialCount:1,
		acceptFiles:".html",
		deleteCallback: function (data, pd) {
			var delete_url="<?php echo site_url('code_minifier/delete_html');?>";
		    for (var i = 0; i < data.length; i++) {
		        $.post(delete_url, {op: "delete",name: data[i]},
		            function (resp,textStatus, jqXHR) {		                		                
		            });
		    }
		},
		downloadCallback:function(filename,pd)
		{
			var download_url="<?php echo site_url('code_minifier/download_html');?>";
			location.href = download_url+"/"+encodeURI(filename);
		}

	});


});
</script>