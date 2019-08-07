<?php echo $this->Html->script('/assets/plugins/jquery/jquery-2.2.3.min.js'); ?>
<style>
#Content{ width:90% !important; margin-left: 5%;}
input:focus {background-color:#FFF !important;}
input[type="password"]:focus {background-color:#FFF !important;}
div.error { display: block !important; } 
label { font-weight:100 !important;}
fieldset
{
    border-radius: 7px;
    box-shadow: 0 3px 9px rgba(0,0,0,0.25), 0 2px 5px rgba(0,0,0,0.22);
}
</style>

<section class="content">
<div class="col-md-12"></div>
      <div class="row">
        <div class="col-md-12">
         <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Change Password</h3>
            </div>
            
            <?php  echo $this->Form->create("Users", ['id'=>"form_sample_3"]); ?>
            <div class="box-body">
                <div class="col-md-offset-3 col-md-6">
              
                <div class="">
                    <div class="form-group ">
                      <label>Current Password</label>
                      <input type="password" class="form-control" name="old_password" id="old_password" value=""  placeholder="Current Password">
                    </div>
                </div>
                <div class="">
                    <div class="form-group  ">
                      <label>New Password</label>
                      <input type="password" class="form-control" name="password" id="password" value=""  placeholder="New Password" required="required">
                    </div>
                </div>
                <div class="">
                     <div class="form-group  ">
                      <label>Confirm New Password</label>
                      <input type="password" class="form-control" name="cpassword" id="cpassword" value=""  placeholder="Confirm New Password" required="required">
                    </div>              
                </div>
              <div class="col-md-12">
                <hr></hr>
                <center>
                    <button type="submit" class="btn btn-info">Update Password</button>
                </center>   
              </div>                
                        
                </div>              
            </div>
            </form>
          </div>            
        </div>
       </div>
   </section>
<div class="loader-wrapper" style="width: 100%;height: 100%;  display: none;  position: fixed; top: 0px; left: 0px;    background: rgba(0,0,0,0.25); display: none; z-index: 1000;" id="loader-1">
<div id="loader"></div>
</div>
 <?php echo $this->Html->script('/assets/global/plugins/jquery.min.js'); ?>  
<script>
 $(document).ready(function(){
  var form3 = $('#form_sample_3');
  var error3 = $('.alert-danger', form3);
  var success3 = $('.alert-success', form3);
  form3.validate({
    
    errorElement: 'span', //default input error message container
    errorClass: 'help-block help-block-error', // default input error message class
    focusInvalid: true, // do not focus the last invalid input
    rules: {
        
        old_password:{
            required:true
            
          },
          password:{
            required:true
            
          },
          cpassword:{
            required:true,
            equalTo: "#password"
            
          }
        
      },

    errorPlacement: function (error, element) { // render error placement for each input type
      if (element.parent(".input-group").size() > 0) {
        error.insertAfter(element.parent(".input-group"));
      } else if (element.attr("data-error-container")) { 
        error.appendTo(element.attr("data-error-container"));
      } else if (element.parents('.radio-list').size() > 0) { 
        error.appendTo(element.parents('.radio-list').attr("data-error-container"));
      } else if (element.parents('.radio-inline').size() > 0) { 
        error.appendTo(element.parents('.radio-inline').attr("data-error-container"));
      } else if (element.parents('.checkbox-list').size() > 0) {
        error.appendTo(element.parents('.checkbox-list').attr("data-error-container"));
      } else if (element.parents('.checkbox-inline').size() > 0) { 
        error.appendTo(element.parents('.checkbox-inline').attr("data-error-container"));
      } else {
        error.insertAfter(element); // for other inputs, just perform default behavior
      }
    },

    invalidHandler: function (event, validator) { //display error alert on form submit   
      success3.hide();
      error3.show();
    },

    highlight: function (element) { // hightlight error inputs
       $(element)
        .closest('.form-group').addClass('has-error'); // set error class to the control group
    },

    unhighlight: function (element) { // revert the change done by hightlight
      $(element)
        .closest('.form-group').removeClass('has-error'); // set error class to the control group
    },

    success: function (label) {
      label
        .closest('.form-group').removeClass('has-error'); // set success class to the control group
    },

    submitHandler: function (form) {
      success3.show();
      error3.hide();
      form[0].submit(); // submit the form
    }

  });
 });

</script>  
