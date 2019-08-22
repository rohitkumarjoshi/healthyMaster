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

    $('#password').on('keyup',function()
    {
      var c_pass=$(this).val();
      var old_pass=$('#old_password').val();
      if(c_pass == old_pass)
      {
        alert('Please Enter Different Password');
        $('#password').val('');
      }
     
    }); 

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
             required: true
            
          },
          cpassword:{
            required:true,
            equalTo: "#password"
            
          }
        
      },

    

  });
 });

</script>  
