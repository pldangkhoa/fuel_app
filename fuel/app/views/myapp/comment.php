<?php if (!empty($comments)) : ?>
    <?php foreach ($comments as $comment) : ?>
        <div class="row comment">
            <div class="col-xs-2 col-sm-offset-2 icon-medium">
                <?php if (!empty($comment['owner']['icon']) && !empty($comment['owner']['view_icon'])) : ?>
                    <img alt="icon" class="img-circle" src="<?php echo _ICON_PATH_ . $comment['owner']['icon']; ?>">
                <?php endif; ?>
                <span><?php echo $comment['owner']['username']; ?></span>
            </div>
            <div class="col-xs-7 comment-box">
                <span><?php echo $comment['body']; ?></span>
                <span class="time"><?php echo $comment['created_at']; ?></span>
            </div>
        </div>
    <?php endforeach; ?>
    <div id="read-more" class="row">
        <form id="load-comment-form" class="form-horizontal" role="form" action="<?php echo Uri::create('myapp/loadComment', array(), array()); ?>" method="post">
            <div class="form-group">
                <input type="hidden" name="offset" value="<?php echo $offset; ?>">
                <input type="hidden" name="total_record" value="<?php echo $num; ?>">
                <button type="submit" class="col-md-offset-6 col-xs-2 btn btn-default">Read More</button>
            </div>
        </form>
        <div class="row record">
            <div class="col-md-offset-5 col-xs-4"><?php echo $num . ' record / ' . $total . ' record'; ?></div>
        </div>
        <script type="text/javascript">
            $("#load-comment-form").submit(function(event) {
                event.preventDefault();
                var $form = $(this),
                        offset = $form.find("input[name='offset']").val(),
                        total_record = $form.find("input[name='total_record']").val(),
                        url = $form.attr("action");
                var posting = $.post(url, {offset: offset, total_record: total_record});

                posting.done(function(data) {
                    $("#read-more").remove();
                    $(".record").remove();
                    $("#comments").append(data);
                });
            });
        </script>
    </div>
<?php endif; ?>