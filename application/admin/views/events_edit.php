		  <script type="text/javascript">
		 function del_confirm(title, msg, link) {
	var args1 = arguments;
	bootbox.dialog({
		message : msg,
		title : title,
		buttons : {
			main : {
				label : "Confirm",
				className : "btn-default",
				callback : function () {

					$.get(link, {
						/*csrf_test_name:$.cookie(CSRF_COOKIE_NAME)*/
					}, function (data) {
						var dialog = top.dialog.get(window);
						dialog.remove();
					});
				}
			},
			success : {
				label : "Cancel",
				className : "btn-primary",
				callback : function () {
					// nothing to do
				}
			}
		}
	});
} 
		  </script>
		  <link rel="stylesheet" href="<?php echo base_url();?>resource/adminlte/plugins/datepicker/datepicker3.css">
		  <?php 
		  if(isset($info) && count($info)>0){
			$action = 'edit';
			$header = 'Edit Event';
			$title = $info->title;
              $start = date('Y-m-d',strtotime($info->start));
              $start_h = date('H',strtotime($info->start));
              $start_m = date('m',strtotime($info->start));
              $end = date('Y-m-d',strtotime($info->end));
              $end_h = date('H',strtotime($info->end));
              $end_m = date('m',strtotime($info->end));
            $description = $info->description;
			$backgroundColor = $info->backgroundColor;
			$borderColor = $info->borderColor;
            $allDay = $info->allDay;
            $hasEnd = $info->hasEnd;
			$id = $info->id;
              if($allDay){
                  $allday_display = "style='display:none'";
                  $allday_chk = "checked";
              }else{
                  $allday_display = "style=''";
                  $allday_chk = '';
              }

              if($hasEnd){
                  $end_display = 'style=""';
                  $end_chk = 'checked';
              }else{
                  $end_display = 'style="display:none"';
                  $end = $start;
                  $end_chk = '';
              }

          }else{
			$action = 'add';
			$header = 'Add Event';
			$title = '';
			$start = date('Y-m-d',strtotime($start));
              $start_h = '00';
              $start_m = '00';
              $end = date('Y-m-d',strtotime($end));
              $end_h = '00';
              $end_m = '00';
            $description = '';
			$backgroundColor = '#3c8dbc';
			$borderColor = '#3c8dbc';
            $allday_chk = 'checked';
            $allday_display = "style='display:none'";
            $end_chk = 'checked';
            $end_display = "style=''";
			$id = '';
		  }
		  ?>
			 
			<?php 
		  echo form_open('c=calendar&m=save', 'class="bs-docs-example" id="event-edit-form"');
		  echo form_hidden('id', $id);
		  ?>


            <div class="form-group">
              <label class="control-label">Title</label>
              <input type="text" name="title" id="title" value="<?php echo $title;?>" class="form-control" />
            </div>

		    <div class="form-group">
			    <label class="control-label">Description</label>
			    <input type="text" name="description" id="description" value="<?php echo $description;?>" class="form-control" />
		    </div>

            <div class="form-group">
                <label class="control-label">Start</label>

                <p>
                    <input type="text" name="start" id="start" value="<?php echo $start;?>" class="form-control" readonly>
                    <span id="sel_start" <?php echo $allday_display;?>>
                        <select name="s_hour">
                            <option value="<?php echo $start_h;?>" selected><?php echo $start_h;?></option>
                            <option value="00">00</option>
                            <option value="01">01</option>
                            <option value="02">02</option>
                            <option value="03">03</option>
                            <option value="04">04</option>
                            <option value="05">05</option>
                            <option value="06">06</option>
                            <option value="07">07</option>
                            <option value="08">08</option>
                            <option value="09">09</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                            <option value="13">13</option>
                            <option value="14">14</option>
                            <option value="15">15</option>
                            <option value="16">16</option>
                            <option value="17">17</option>
                            <option value="18">18</option>
                            <option value="19">19</option>
                            <option value="20">20</option>
                            <option value="21">21</option>
                            <option value="22">22</option>
                            <option value="23">23</option>
                        </select>:<select name="s_minute">
                            <option value="<?php echo $start_m;?>" selected><?php echo $start_m;?></option>
                            <option value="00">00</option>
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="30">30</option>
                            <option value="40">40</option>
                            <option value="50">50</option></select>
                    </span>
                </p>
            </div>

			<div id="p_endtime" class="form-group" <?php echo $end_display;?>>
                <label class="control-label">End</label>

                <p >
                    <input type="text" name="end" id="end" value="<?php echo $end;?>" class="form-control" readonly>
                    <span id="sel_end" <?php echo $allday_display;?>>
                        <select name="e_hour">
                            <option value="<?php echo $end_h;?>" selected><?php echo $end_h;?></option>
                            <option value="00">00</option>
                            <option value="01">01</option>
                            <option value="02">02</option>
                            <option value="03">03</option>
                            <option value="04">04</option>
                            <option value="05">05</option>
                            <option value="06">06</option>
                            <option value="07">07</option>
                            <option value="08">08</option>
                            <option value="09">09</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                            <option value="13">13</option>
                            <option value="14">14</option>
                            <option value="15">15</option>
                            <option value="16">16</option>
                            <option value="17">17</option>
                            <option value="18">18</option>
                            <option value="19">19</option>
                            <option value="20">20</option>
                            <option value="21">21</option>
                            <option value="22">22</option>
                            <option value="23">23</option>
                        </select>:<select name="e_minute">
                            <option value="<?php echo $end_m;?>" selected><?php echo $end_m;?></option>
                            <option value="00">00</option>
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="30">30</option>
                            <option value="40">40</option>
                            <option value="50">50</option></select>
                    </span>
                </p>
            </div>

            <div class="form-group">
              <label>Option</label>

              <div>
                <label><input type="checkbox" value="1" id="isallday" name="isallday" <?php echo $allday_chk;?>> All Day</label>
                <label><input type="checkbox" value="1" id="isend" name="isend" <?php echo $end_chk;?>> Has End Time</label>
              </div>

            </div>

            <div class="form-group">
				<label>Background Color</label>
				<div class="row">
                    <input type="hidden" id="backgroundColor" name="backgroundColor" value="<?php echo $backgroundColor;?>" />

                    <div class="col-lg-12">
						<ul class="fc-color-picker" id="color-chooser">
						  <li><a class="text-aqua" href="#"><i class="fa fa-square"></i></a></li>
						  <li><a class="text-blue" href="#"><i class="fa fa-square"></i></a></li>
						  <li><a class="text-light-blue" href="#"><i class="fa fa-square"></i></a></li>
						  <li><a class="text-teal" href="#"><i class="fa fa-square"></i></a></li>
						  <li><a class="text-yellow" href="#"><i class="fa fa-square"></i></a></li>
						  <li><a class="text-orange" href="#"><i class="fa fa-square"></i></a></li>
						  <li><a class="text-green" href="#"><i class="fa fa-square"></i></a></li>
						  <li><a class="text-lime" href="#"><i class="fa fa-square"></i></a></li>
						  <li><a class="text-red" href="#"><i class="fa fa-square"></i></a></li>
						  <li><a class="text-purple" href="#"><i class="fa fa-square"></i></a></li>
						  <li><a class="text-fuchsia" href="#"><i class="fa fa-square"></i></a></li>
						  <li><a class="text-muted" href="#"><i class="fa fa-square"></i></a></li>
						  <li><a class="text-navy" href="#"><i class="fa fa-square"></i></a></li>
						</ul>
					</div>
				</div>
			</div>
			
            		
            <div class="form-group">
              <div class="controls">
                <button id="add-new-event" type="submit" class="btn btn-primary" style="border-color: <?php echo $backgroundColor;?>; background-color: <?php echo $backgroundColor;?>;">Save</button>
				<button type="button" class="btn btn-default cancel-form">cancel</button>
				<?php 
				if($id != ''){
					?>
					<button type="button" class="btn btn-danger" onclick="del_confirm('Notice', 'Are you sure？', '<?php echo site_url('c=calendar&m=delete&id=' . $id);?>')">delete</button>
					<?php 
				}
				?>
              </div>
            </div>
          <?php echo form_close();?>		
				</div>
			</div>	
        </div>
      </div>

      

      
    </section>
    <!-- /.content -->
<script type="text/javascript" src="<?php echo base_url();?>resource/adminlte/plugins/datepicker/bootstrap-datepicker.js"></script>
<script type="text/javascript">
$(function(){
	
    $('#start').datepicker({
        format: 'yyyy-mm-dd'
    });

    $('#end').datepicker({
        format: 'yyyy-mm-dd'
    });

    $("#isallday").click(function(){
        if($("#sel_start").css("display")=="none"){
            $("#sel_start,#sel_end").show();
        }else{
            $("#sel_start,#sel_end").hide();
        }
        reset_dialog();
    });

    $("#isend").click(function(){
        if($("#p_endtime").css("display")=="none"){
            $("#p_endtime").show();
        }else{
            $("#p_endtime").hide();
        }
        reset_dialog();
    });

    /* ADDING EVENTS */
  	var currColor = "#3c8dbc"; //Red by default
  	//Color chooser button
  	var colorChooser = $("#color-chooser-btn");
  	$("#color-chooser > li > a").click(function (e) {
  		e.preventDefault();
  		//Save color
  		currColor = $(this).css("color");
  		//Add color effect to button
  		$('#add-new-event').css({
  			"background-color" : currColor,
  			"border-color" : currColor
  		});
		$('#backgroundColor').val(currColor);
  	});
	
	$('#event-edit-form').validate({
		rules:{
			title:{
				required:true
			}
		},
		messages:{
			title:{
				required:'Title Is Required'
			}
		}
	});	
	$('#event-edit-form').ajaxForm({
		beforeSubmit:function(formData, jqForm, options){
			return $('#event-edit-form').valid();
		},
		success:function(responseText, statusText, xhr, form){
			var json = $.parseJSON(responseText);
			var dialog = top.dialog.get(window);
			dialog.remove();
			// if(json.success){
				// var dialog = top.dialog.get(window);
				// dialog.close();
			// }else{
				// toastr.error(json.msg);
				
			// }
			return false;
		}
	});			
});
</script>		  					  