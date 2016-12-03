<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Profile
        <small>See who you like</small>
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

                    <h3 class="profile-username text-center" id="username"></h3>

                    <p class="text-muted text-center" id="motto"></p>

                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                            <b >Followers</b> <a class="pull-right" id="followerCnt"><</a>
                        </li>
                        <li class="list-group-item">
                            <b>Following</b> <a class="pull-right" id="followingCnt"></a>
                        </li>
                        <li class="list-group-item">
                            <b>Location</b> <a class="pull-right" id="location"></a>
                        </li>
                        <li class="list-group-item">
                            <b>Email</b> <a class="pull-right" id="email"></a>
                        </li>
                        <li class="list-group-item">
                            <b>Joined on</b> <a class="pull-right" id="regTime"></a>
                        </li>
                    </ul>

                    <button class="btn btn-danger btn-block" id="follow-btn" onclick="toggleFollowing()"><b>Follow</b></button>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->


        </div>
        <!-- /.col -->
        <div class="col-md-9">

        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

</section>
<!-- /.content -->


<script>
    $(function () {
        checkIfFollowing();
        updateFollowInfo();
    });

    function toggleFollowing() {
        if ($("#follow-btn").hasClass("btn-danger")) {
            $("#follow-btn").removeClass("btn-danger").addClass("btn-primary").html("Followed");
        } else {
            $("#follow-btn").removeClass("btn-primary").addClass("btn-danger").html("Follow");
        }
        $.ajax({
            type: "POST",  //提交方式
            url: "admin.php?c=followAjaxHelper&m=toggleFollowing",//路径
            data: "userId=<?php echo $pid; ?>",
            success: function (result) {//返回数据根据结果进行相应的处理
            }
        })
    }

    function checkIfFollowing() {
        $.ajax({
            type: "POST",  //提交方式
            url: "admin.php?c=followAjaxHelper&m=checkIfFollowing",//路径
            data: "userId=<?php echo $pid; ?>",
            success: function (result) {//返回数据根据结果进行相应的处理
                if (result) {
                    console.log(result);
                    $("#follow-btn").removeClass("btn-danger").addClass("btn-primary").html("Followed");
                }

            }
        })
    }

    function updateFollowInfo() {
        $.ajax({
            type: "POST",  //提交方式
            url: "admin.php?c=followAjaxHelper&m=getUserFollowInfo",//路径
            data: "userId=<?php echo $pid; ?>",
            success: function (result) {//返回数据根据结果进行相应的处理
                var followInfo = JSON.parse(result);
                $("#username").html(followInfo.username);
                $("#motto").html(followInfo.motto);
                $("#followerCnt").html(followInfo.followerCnt);
                $("#followingCnt").html(followInfo.followingCnt);
                $("#location").html(followInfo.location);
                $("#email").html(followInfo.email);
                $("#regTime").html(followInfo.reg_time);
            }
        })
    }
</script>