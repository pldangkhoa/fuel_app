<?php if (!empty($success)) : ?>
    <p class="text-center"><strong>Your email has been updated successfully !!!</strong></p>
<?php else : ?>
    <div class="row">
        <div class="col-xs-12">
            <form class="form-horizontal" role="form" action="<?php echo Uri::create('user/email_edit', array(), array()); ?>" method="post">
                <div class="form-group">
                    <label for="inputNewEmail" class="col-xs-4 control-label">new email: </label>
                    <div class="col-xs-7">
                        <input type="email" name="new_email" class="form-control" id="inputNewEmail" placeholder="new email">
                        <span class="error"><?php echo!empty($error['new_email']) ? $error['new_email'] : ''; ?></span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputConfirmNewEmail" class="col-xs-4 control-label">confirm new email: </label>
                    <div class="col-xs-7">
                        <input type="email" name="confirm_new_email" class="form-control" id="inputConfirmNewEmail" placeholder="confirm new email">
                        <span class="error"><?php echo!empty($error['confirm_new_email']) ? $error['confirm_new_email'] : ''; ?></span>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-4 col-xs-7">
                        <input type="hidden" name="check_password" value="<?php echo!empty($check_password) ? 1 : 0; ?>">
                        <button type="submit" class="btn btn-primary col-xs-12">send</button>
                    </div>
                </div>
            </form>
        </div>
        <div id="confirm-box" style="display: none;">
            <p class="message">confirm password</p>
            <form id="confirm-password-form" class="form-horizontal" role="form" action="<?php echo Uri::create('user/check_password', array(), array()); ?>" method="post">
                <div class="form-group">
                    <div class="col-xs-12">
                        <input type="password" name="password" class="form-control" id="inputPassword" placeholder="enter password">
                        <span class="error error_password"></span>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12">
                        <button type="submit" class="btn btn-primary col-xs-12">send</button>
                    </div>
                </div>
            </form>
        </div>
        <script type="text/javascript">
            check_password = $("input[name=check_password]").val();

    <?php if (empty($check_password)) : ?>
                $("#confirm-box").dialog({
                    resizable: false,
                    height: 270,
                    modal: true
                });

                $("#confirm-password-form").submit(function(event) {
                    event.preventDefault();
                    var $form = $(this),
                            password = $form.find("input[name='password']").val(),
                            url = $form.attr("action");
                    var posting = $.post(url, {password: password});

                    posting.done(function(data) {
                        data = jQuery.parseJSON(data);
                        if (data.success) {
                            $("#confirm-box").dialog("close");
                            $("input[name=check_password]").val(1);
                        } else {
                            $(".error_password").empty().html(data.error["password"]);
                        }
                    });
                });
    <?php endif; ?>
        </script>
    </div>
<?php endif; ?>