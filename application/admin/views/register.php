<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>CXPCMS | Register</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="<?php echo base_url();?>resource/adminlte/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>resource/adminlte/dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>resource/adminlte/plugins/iCheck/square/blue.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="register-logo">
    <a href="<?php echo site_url('');?>">CXPCMS</a>
  </div>
  <!-- /.signup-logo -->
  <div class="register-box-body">
    <p class="login-box-msg">Sign up</p>
	
	<?php echo form_open('c=register', 'id="registerform"');?>
      <div class="form-group has-feedback">
        <input type="text" class="form-control" required name="username" id="username" placeholder="Username">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
		<span id="usernameerror"></span>
      </div>
      <div class="form-group has-feedback">
          <input type="email" class="form-control" required name="email" id="email" placeholder="Email">
          <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          <span id="emailerror"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" required name="password" id="password" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
		<span id="passworderror"></span>
      </div>
      <div class="form-group has-feedback">
          <input type="password" class="form-control" required name="re_password" id="re_password" placeholder="Retype password">
          <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
          <span id="re_passworderror"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">

        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Sign up</button>
        </div>
        <!-- /.col -->
      </div>
    <?php echo form_close();?>

    <div class="social-auth-links text-center">
      <p>- or -</p>
<!--      <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign up using-->
<!--        Facebook</a>-->
<!--      <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign up using-->
<!--        Google+</a>-->
    </div>
    <!-- /.social-auth-links -->

    <a href="<?php echo site_url('c=login');?>">Already Have an Account?</a>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 2.1.4 -->
<script src="<?php echo base_url();?>resource/adminlte/plugins/jQuery/jQuery-2.1.4.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>resource/adminlte/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>resource/js/jquery.form.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>resource/js/bootbox.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>resource/js/jquery.validate.min.js" type="text/javascript"></script>
<script>
  $(function () {
	$.validator.setDefaults({
		ignore : "",
		errorPlacement : function (error, element) {
			if ($(document).find('#' + element.attr('id') + 'error')) {
				error.appendTo($('#' + element.attr('id') + 'error'));
			}
		},
		highlight : function (element) {
			$(element).closest('.form-group').removeClass('has-success').addClass('has-error');
		},
		unhighlight : function (element) {
			$(element).closest('.form-group').removeClass('has-error');
		}
	});
	$('#registerform').validate({
		rules:{
			username:{
				required:true
			},
			email:{
				required:true
			},
            password:{
                required:true
            },
            re_password:{
                required:true,
                equalTo:"#password"
            }
		},
		messages:{
			username:{
                required:'Please Enter Username'
            },
            email:{
                required:'Please Enter Email'
            },
            password:{
                required:'Please Enter Password'
            },
            re_password:{
                required:'Please Enter Password Again',
                equalTo:'The Two Passwords You Typed Do Not Match'
            }
		}

	});
	$('#registerform').ajaxForm({
		beforeSubmit:function(formData, jqForm, options){
			return $('#registerform').valid();
		},
		success:function(responseText, statusText, xhr, form){
			var json = $.parseJSON(responseText);
			if(json.success){
				window.location.href = '<?php echo base_url() . $this->config->item('index_page');?>';
			}else{
				bootbox.alert(json.msg);
			}
			return false;
		}
	});
  });
</script>
</body>
</html>
