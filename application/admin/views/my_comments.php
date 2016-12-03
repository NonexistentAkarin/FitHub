<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        My Likes
        <small>See what you like</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">My Likes</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <div class="row">

        <div class="col-md-12">
            <form role="form" action="admin.php?c=SocialMediaFormHelper&m=releaseDynamic" method="post">
                <!-- textarea -->
                <div class="form-group">
                    <textarea class="form-control" rows="3" placeholder="Share your moments here" name="dynamic-content"></textarea>
                </div>
                <div class="form-group mar">
                    <div class="col-sm-offset-10 col-sm-2">
                        <button type="submit" class="btn btn-danger pull-right btn-block btn-sm">Add a post</button>
                    </div>
                </div>
            </form>
        </div>

        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>

        <div id="timeline">

        </div>

    </div>
    <!-- /.row -->

</section>
<!-- /.content -->

<template id="dynamicItem">

    <div class="col-md-12">

        <div class="box box-widget">
            <p class="dynamicId" hidden></p>
            <div class="box-header with-border">
                <div class="user-block">
                    <img class="img-circle" src="<?php echo base_url();?>resource/adminlte/dist/img/user9-894x893.png" alt="User Image">
                    <a href="#" class="userInfoPageLink"><span class="username dynamicUserName">Jonathan Burke Jr.</span></a>
                    <span class="description releasedTime">Shared publicly - 7:30 PM Today</span>
                </div>
                <!-- /.user-block -->
                <div class="box-tools">
                    <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Mark as read">
                        <i class="fa fa-circle-o"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
                <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">

                <p class="dynamicContent">I took this photo this morning. What do you guys think?</p>
                <button type="button" class="btn btn-default btn-xs"><i class="fa fa-share"></i> Share</button>
                <button type="button" class="btn btn-default btn-xs btn-like"  onclick="toggleLike(this);"><i class="fa fa-thumbs-o-up"></i> Like</button>
                <span class="pull-right text-muted like-comment">127 likes - 3 comments</span>
            </div>
            <!-- /.box-body -->
            <div class="box-footer box-comments">

            </div>
            <!-- /.box-footer -->
            <div class="box-footer">
                <form class="form-horizontal" method="post">
                    <div class="form-group margin-bottom-none">
                        <div class="col-sm-10">
                            <img class="img-responsive img-circle img-sm" src="<?php echo base_url();?>resource/adminlte/dist/img/user9-894x893.png" alt="Alt Text">
                            <div class="img-push">
                                <input class="form-control input-sm" placeholder="Type to post comment">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <button type="button" class="btn btn-danger pull-right btn-block btn-sm" onclick="releaseComment(this);">Add a commment</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.box-footer -->
        </div>

    </div>

</template>

<template id="commentItem">
    <div class="box-comment">
        <!-- User image -->
        <img class="img-circle img-sm" src="<?php echo base_url();?>resource/adminlte/dist/img/user9-894x893.png" alt="User Image">

        <div class="comment-text">
                      <span class="username comment-userName">
                        <span class="text-muted pull-right comment-time"></span>
                      </span><!-- /.username -->

        </div>
        <!-- /.comment-text -->
    </div>
    <!-- /.box-comment -->
</template>

<script>
    var likeCtn = 0;
    var CommentCtn = 0;

    $(function () {
        updateDynamic();
    });

    function updateDynamic() {
        $.ajax({
            type : "POST",  //提交方式
            url : "admin.php?c=socialMediaAjaxHelper&m=getCurrentUserCommentsDynamic",//路径
            success : function(result) {//返回数据根据结果进行相应的处理
                updateDynamicList(result);
            }
        })
    }

    function updateDynamicList(dynamics) {
        var itemTemplate = document.querySelector('#dynamicItem');
        var content = itemTemplate.content;
        var timeline = document.querySelector('#timeline');
        //timeline.innerHTML="";//删除所有子节点

        $.each(JSON.parse(dynamics), function(idx, dynamic) {
            content.querySelector(".dynamicId").textContent = dynamic.rowid;
            content.querySelector(".dynamicContent").textContent = dynamic.content;
            content.querySelector(".dynamicUserName").textContent = dynamic.userName;
            //设置动态发布时间
            releasedTime = 'Shared publicly - '+new Date(parseInt(dynamic.createdAt) * 1000).toDateString();
            content.querySelector(".releasedTime").textContent = releasedTime;
            //设置赞数

            likeCtn = dynamic.likesCnt;

            if(dynamic.isLike){
                isLiked = '<i class="fa fa-thumbs-o-up"></i>'+" Liked";
            }else{
                isLiked = '<i class="fa fa-thumbs-o-up"></i>'+" Like";

            }
            content.querySelector(".btn-like").innerHTML = isLiked;

            content.querySelector(".like-comment").innerHTML = likeCtn+" likes - "+CommentCtn+" comments";

            var commentBox = content.querySelector(".box-comments");
            commentBox.innerHTML="";
            updateComment(dynamic.rowid,commentBox);

            timeline.appendChild(itemTemplate.content.cloneNode(true));
        });

    }

    function updateComment(dynamicId,commentBox) {
        $.ajax({
            type : "POST",  //提交方式
            url : "admin.php?c=socialMediaAjaxHelper&m=getCommentsByDynamicId",//路径
            async :false,
            data : "dynamicId="+dynamicId,
            success : function(result) {//返回数据根据结果进行相应的处理
                updateCommentsList(result,commentBox);
            }
        })
    }

    function updateCommentsList(comments,commentBox) {
        CommentCtn=0;

        $.each(JSON.parse(comments), function(idx, comment){
            var commentItem = document.querySelector('#commentItem');
            var content = commentItem.content;
            content = content.cloneNode(true);
            content.querySelector(".comment-text").innerHTML = content.querySelector(".comment-text").innerHTML+comment.content;

            content.querySelector(".comment-userName").innerHTML = content.querySelector(".comment-userName").innerHTML+comment.userName;
            releasedTime = new Date(parseInt(comment.createdAt) * 1000).toDateString();
            content.querySelector(".comment-time").textContent = releasedTime;

            CommentCtn += 1;

            console.log(CommentCtn);

            commentBox.appendChild(content);
        });

        document.querySelector('#dynamicItem').content.querySelector(".like-comment").innerHTML = likeCtn+" likes - "+CommentCtn+" comments";
    }



    function toggleLike(buttonLike) {
        length = buttonLike.innerHTML.length;
        if(buttonLike.innerHTML.indexOf('Liked')==-1){
            likeCtn++;
            buttonLike.innerHTML = '<i class="fa fa-thumbs-o-up"></i>'+" Liked";
        }else{
            likeCtn--;
            buttonLike.innerHTML = '<i class="fa fa-thumbs-o-up"></i>'+" Like";
        }

        dynamicId = buttonLike.parentNode.parentNode.getElementsByTagName('p')[0].innerHTML;

        $.ajax({
            type : "POST",  //提交方式
            url : "admin.php?c=socialMediaAjaxHelper&m=toggleLike",//路径
            data :"dynamicId="+dynamicId,
            success : function(result) {//返回数据根据结果进行相应的处理

            }
        })
    }

    function releaseComment(buttonComment) {
        commentContent = buttonComment.parentNode.parentNode.getElementsByTagName('input')[0].value;
        dynamicId = buttonComment.parentNode.parentNode.parentNode.parentNode.parentNode.getElementsByTagName('p')[0].innerHTML;
        $.ajax({
            type : "POST",  //提交方式
            url : "admin.php?c=socialMediaAjaxHelper&m=releaseComment",//路径
            data :"dynamicId="+dynamicId+"&content="+commentContent,
            success : function(result) {//返回数据根据结果进行相应的处理
                result = JSON.parse(result);
                commentBox = buttonComment.parentNode.parentNode.parentNode.parentNode.parentNode.getElementsByClassName('box-comments')[0];
                addComment(result,commentBox);
            }
        });
    }

    function addComment(comment,commentBox) {
        var commentItem = document.querySelector('#commentItem');
        var content = commentItem.content;
        content = content.cloneNode(true);
        content.querySelector(".comment-text").innerHTML = content.querySelector(".comment-text").innerHTML+comment.content;

        content.querySelector(".comment-userName").innerHTML = content.querySelector(".comment-userName").innerHTML+comment.userName;
        releasedTime = new Date(parseInt(comment.createdAt) * 1000).toDateString();
        content.querySelector(".comment-time").textContent = releasedTime;
        commentBox.appendChild(content);
    }



</script>