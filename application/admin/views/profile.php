<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Profile
        <small>Edit your profile here</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo '#/'; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Profile</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <div class="row">
        <div class="col-md-3">

            <!-- Profile Image -->
            <div class="box box-primary">
                <div class="box-body box-profile">
                    <img class="profile-user-img img-responsive img-circle"
                         src="<?php echo base_url(); ?>resource/adminlte/dist/img/user9-894x893.png"
                         alt="User profile picture">

                    <h3 class="profile-username text-center"><?php echo $user->username; ?></h3>

                    <p class="text-muted text-center"><?php echo $user->motto; ?></p>

                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                            <b>Followers</b> <a class="pull-right" id="followerCnt"></a>
                        </li>
                        <li class="list-group-item">
                            <b>Following</b> <a class="pull-right" id="followingCnt"></a>
                        </li>
                        <li class="list-group-item">
                            <b>Location</b> <a class="pull-right"><?php echo $user->location; ?></a>
                        </li>
                        <li class="list-group-item">
                            <b>Email</b> <a class="pull-right"><?php echo $user->email; ?></a>
                        </li>
                        <li class="list-group-item">
                            <b>Join time</b> <a class="pull-right"><?php echo $user->reg_time; ?></a>
                        </li>
                    </ul>

                    <a href="<?php echo site_url('c=logout'); ?>" class="btn btn-danger btn-block"><b>Logout</b></a>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->


        </div>
        <!-- /.col -->
        <div class="col-md-9">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#settings" data-toggle="tab">Settings</a></li>
                    <li><a href="#password1" data-toggle="tab">Change Password</a></li>
                </ul>
                <div class="tab-content">


                    <div class="active tab-pane" id="settings">
                        <?php
                        echo form_open('c=profile&m=edit_settings', 'class="form-horizontal" id="settings-edit-form"');
                        echo form_hidden('user_id', $user->id);
                        ?>

                            <div class="form-group">
                                <label for="inputName" class="col-sm-2 control-label">Username</label>

                                <div class="col-sm-10">
                                    <p class="form-control-static"><?php echo $user->username; ?></p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail" class="col-sm-2 control-label">Email</label>

                                <div class="col-sm-10">
                                    <p class="form-control-static"><?php echo $user->email; ?></p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputMotto" class="col-sm-2 control-label">Motto</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="motto"
                                           id="motto">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputLocation" class="col-sm-2 control-label">Location</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="location"
                                           id="location">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                    <button type="reset" class="btn btn-default">Reset</button>
                                    <button type="button" class="btn btn-default" onclick="history.go(-1);">Cancel
                                    </button>
                                </div>
                            </div>

                        <?php echo form_close(); ?>
                        <script type="text/javascript">
                            $(function () {
                                $('#settings-edit-form').validate({
                                    rules: {
                                        motto: {
                                            required: true,
                                        },
                                        location: {
                                            required: true,
                                        }
                                    },
                                    messages: {
                                        password: {
                                            required: 'Motto is Required',
                                        },
                                        confirm_password: {
                                            required: 'Location is Required',
                                        }
                                    }
                                });
                                $('#settings-edit-form').ajaxForm({
                                    beforeSubmit: function (formData, jqForm, options) {
                                        return $('#settings-edit-form').valid();
                                    },
                                    success: function (responseText, statusText, xhr, form) {
                                        var json = $.parseJSON(responseText);
                                        if (json.success) {
                                            toastr.success(json.msg);
                                        } else {
                                            toastr.error(json.msg);
                                        }
                                        return false;
                                    }
                                });
                            });
                        </script>
                    </div>
                    <!-- /.tab-pane -->

                    <div class="tab-pane" id="password1">
                        <?php
                        echo form_open('c=profile&m=edit_password', 'class="form-horizontal" id="password-edit-form"');
                        ?>

                        <div class="form-group">
                            <label for="password" class="col-sm-2 control-label">New Password</label>

                            <div class="col-sm-10">
                                <input type="password" class="form-control" name="password" id="password">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password" class="col-sm-2 control-label">Confirm Password</label>

                            <div class="col-sm-10">
                                <input type="password" class="form-control" name="confirm_password"
                                       id="confirm_password">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-primary">Save</button>
                                <button type="reset" class="btn btn-default">Reset</button>
                                <button type="button" class="btn btn-default" onclick="history.go(-1);">Cancel</button>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                        <script type="text/javascript">
                            $(function () {
                                $('#password-edit-form').validate({
                                    rules: {
                                        password: {
                                            required: true,
                                            minlength: 6
                                        },
                                        confirm_password: {
                                            required: true,
                                            equalTo: '#password'
                                        }
                                    },
                                    messages: {
                                        password: {
                                            required: 'New Password is Required',
                                            minlength: 'At least 6 chars'
                                        },
                                        confirm_password: {
                                            required: 'Confirm New Password',
                                            equalTo: 'Two Password do not match'
                                        }
                                    }
                                });
                                $('#password-edit-form').ajaxForm({
                                    beforeSubmit: function (formData, jqForm, options) {
                                        return $('#password-edit-form').valid();
                                    },
                                    success: function (responseText, statusText, xhr, form) {
                                        var json = $.parseJSON(responseText);
                                        if (json.success) {
                                            toastr.success(json.msg);
                                        } else {
                                            toastr.error(json.msg);
                                        }
                                        return false;
                                    }
                                });
                            });
                        </script>
                    </div>


                </div>
                <!-- /.tab-content -->
            </div>
            <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

</section>
<!-- /.content -->
<script>
    $(function () {
        updateFollowInfo();
    });

    function updateFollowInfo() {
        $.ajax({
            type: "POST",  //提交方式
            url: "admin.php?c=followAjaxHelper&m=getCurrentUserFollowInfo",//路径
            success: function (result) {//返回数据根据结果进行相应的处理
                var followInfo = JSON.parse(result);
                $("#followerCnt").html(followInfo.followerCnt);
                $("#followingCnt").html(followInfo.followingCnt);
            }
        })
    }
</script>