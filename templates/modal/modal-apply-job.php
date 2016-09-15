<div class="modal fade" id="apply_modal" tabindex="-1" role="dialog" aria-labelledby="This is lable">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
  			<div class="modal-header">
    			<button type="button" class="close btn btn-primary pull-right" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    			<h4 class="modal-title" id="myModalLabel">Modal title</h4>
  			</div>
  			<div class="modal-body" id="apply_upload_container">
    			<h3>Tong Quang Dat</h3>
    			<p>datpro.net@gmail.com</p>
    			<div class="row">
    				<div class="col-md-6" id="aplly_drop_element">
    					<a href="javascript:;" data-upload="apply" class="btn btn-primary upload-container" id="apply_btn_uploader" data-nonce="<?php echo wp_create_nonce("apply_opal_uploader"); ?>"><i class="fa fa-plus"></i> Click here or drag file to upload</a>
    					<div class="display_none btn btn-default " id="apply_append"></div>
    				</div>
    				<div class="col-md-6">
    					<select>
    						<option>none</option>
    					</select>
    				</div>
    				<div class="alert alert-warning display_none apply_uploader_alert"></div>
    			</div>
  			</div>
  			<div class="modal-footer">
    			<button type="submit" class="btn btn-primary">Aplly</button>
  			</div>
		</div>
		</div>
</div>