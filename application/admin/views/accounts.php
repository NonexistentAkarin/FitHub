<link rel="stylesheet"
      href="<?php echo base_url(); ?>resource/bootstrap-switch/css/bootstrap3/bootstrap-switch.min.css"/>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Users
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo '#/'; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Users</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab">Followers</a></li>

                    <li><a href="#tab_2" data-toggle="tab">Followings</a></li>

                    <li><a href="#tab_3" data-toggle="tab">Users</a></li>
                </ul>
                <div class="tab-content table-responsive">
                    <div class="tab-pane active" id="tab_1">
                        <br/>

                        <div class="col-xs-12" id="follower_list">

                        </div>
                    </div>

                    <div class="tab-pane" id="tab_2">
                        <br/>

                        <div class="col-xs-12" id="following_list">

                        </div>
                    </div>

                    <div class="tab-pane" id="tab_3">
                        <div class="col-xs-12">
                            <table class="table table-striped table-bordered table-hover" id="users-datatable"
                                   width="100%">
                                <thead>
                                <tr>
                                    <th nowrap>#</th>
                                    <th nowrap>Username</th>
                                    <th nowrap>Email</th>
                                    <th nowrap>Join Time</th>
                                    <th nowrap>Operation</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>

</section>
<!-- /.content -->

<template id="user_item">
    <!-- Post -->
    <div class="post">
        <div class="user-block">
            <img class="img-circle img-bordered-sm" src="<?php echo base_url(); ?>resource/adminlte/dist/img/user9-894x893.png"
                 alt="user image">
            <span class="username">
                <a href="#" class="userherf">Jonathan Burke Jr.</a>
            </span>
            <span class="description">Shared publicly - 7:30 PM today</span>
        </div>
        <!-- /.user-block -->
        <p class="motto">
            Lorem ipsum represents a long-held tradition for designers,
            typographers and the like. Some people hate it and argue for
            its demise, but others ignore the hate as they create awesome
            tools to help create filler text for everyone from bacon lovers
            to Charlie Sheen fans.
        </p>
    </div>
    <!-- /.post -->
</template>

<script src="<?php echo base_url(); ?>resource/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<script type="text/javascript">
    $(function () {
        var table = $('#users-datatable').DataTable({
            deferRender: true,
            select: {
                style: 'single',
                blurable: true
            },
            ajax: {
                url: '<?php echo site_url('c=accounts&m=data');?>',
                type: 'post',
                data: function (d) {
                    //d.csrf_test_name = $.cookie(CSRF_COOKIE_NAME);
                }
            },
            columns: [
                {
                    data: 'no',
                    className: 'select-checkbox',
                    render: function (data, type, row) {
                        return data;
                    }
                },
                {data: 'username'},
                {data: 'email'},
                {data: 'reg_time'},
                {
                    data: 'id',
                    sortable: false,
                    render: function (data, type, row) {
                        var html = '';
                        html += '<div class="btn-group">';
                        html += '<a href="<?php echo '#/users?m=edit&id=';?>' + data + '" title="edit" class="btn btn-default btn-xs"><i class="fa fa-pencil icon-pencil"></i></a>';
                        html += '<a href="<?php echo '#/users?m=edit_password&user_id=';?>' + data + '" title="change password" class="btn btn-default btn-xs"><i class="fa fa-lock icon-pencil"></i></a>';
                        html += '<a href="<?php echo '#/users?m=edit_password&user_id=';?>' + data + '" title="change password" class="btn btn-default btn-xs"><i class="fa fa-lock icon-pencil"></i></a>';
                        html += '</div>';
                        return html;
                    }
                }
            ],
            fnDrawCallback: function (oSettings) {
                $(".switchchk").bootstrapSwitch({
                    onSwitchChange: function (e, state) {
                        var fieldval = state;
                        var $element = $(e.currentTarget);
                        var tablename = $element.attr('data-table');
                        var fieldname = $element.attr('data-field');
                        var rowid = $element.attr('data-pk');
                        if (fieldval) {
                            fieldval = 1;
                        } else {
                            fieldval = 0;
                        }
                        $.post(
                            "<?php echo site_url('c=ajax&m=setboolattribute');?>",
                            {
                                act: 'upsort',
                                tbname: tablename,
                                tbfield: fieldname,
                                tbfieldvalue: fieldval,
                                id: rowid//,
                                // csrf_test_name:$.cookie(CSRF_COOKIE_NAME)

                            },
                            function (data) {
                                //alert(data);
                                if (data == 'success') {
                                    toastr.success('change success');

                                } else {
                                    toastr.error('change error');
                                }
                            }
                        );
                    }
                });
            }
        });
    });
</script>
<script>
    $(function () {
        updateUser('admin.php?c=socialMediaAjaxHelper&m=getCurrentUserFollower','#follower_list');
        updateUser('admin.php?c=socialMediaAjaxHelper&m=getCurrentUserFollowing','#following_list');
    });

    function updateUser(url,id) {
        $.ajax({
            type: "POST",  //提交方式
            url: url,//路径
            success: function (result) {//返回数据根据结果进行相应的处理
                updateUserList(result,id);
            }
        })
    }
    function updateUserList(followArray,id) {
        var itemTemplate = document.querySelector('#user_item');
        var content = itemTemplate.content;
        var userList = document.querySelector(id);

        $.each(JSON.parse(followArray), function (idx, follow) {
            content.querySelector(".userherf").textContent = follow.username;

            followTime = 'Followed on ' + new Date(parseInt(follow.createdAt) * 1000).toUTCString();
            content.querySelector(".description").textContent = followTime;
            content.querySelector(".motto").textContent = follow.motto;
            content.querySelector(".userherf").href = "admin.php?" + follow.followerId;
            userList.appendChild(itemTemplate.content.cloneNode(true));
        });

    }


</script>

