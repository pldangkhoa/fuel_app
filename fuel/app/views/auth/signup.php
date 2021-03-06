<div class="row myapp-top">
    <div class="col-xs-6 title"><?php echo $app_name; ?></div>
    <div class="col-xs-6 text-right">
        <a href="/auth/login"><button type="button" class="btn btn-default">Go login form</button></a>
    </div>
</div>
<div class="row">
    <fieldset class="col-sm-offset-2 col-xs-8 box">
        <legend>sign up</legend>
        <div class="row fb-box">
            <div class="col-sm-offset-1 col-xs-10">
                <a href="<?php echo !empty($loginUrl) ? $loginUrl : ''; ?>">
                    <button class="btn btn-primary col-xs-12"><?php ?>Facebook on Signup</button>
                </a>
            </div>
        </div>
        <div class="row login-box">
            <div class="col-xs-12">
                <form class="form-horizontal" role="form" action="<?php echo Uri::create('auth/signup', array(), array()); ?>" method="post">
                    <?php if (!empty($error['signup_fail'])) : ?>
                        <div class="form-group">
                            <span class="error col-sm-offset-4"><?php echo $error['signup_fail']; ?></span>
                        </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <label for="inputUsername" class="col-xs-4 control-label">username: </label>
                        <div class="col-xs-7">
                            <input type="text" name="username" class="form-control" id="inputUsername" placeholder="username" value="<?php echo !empty($user['username']) ? $user['username'] : ''; ?>">
                            <span class="error"><?php echo !empty($error['username']) ? $error['username'] : ''; ?></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail" class="col-xs-4 control-label">Email: </label>
                        <div class="col-xs-7">
                            <input type="email" name="email" class="form-control" id="inputEmail" placeholder="your email" value="<?php echo !empty($user['email']) ? $user['email'] : ''; ?>">
                            <span class="error"><?php echo !empty($error['email']) ? $error['email'] : ''; ?></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword" class="col-xs-4 control-label">password: </label>
                        <div class="col-xs-7">
                            <input type="password" name="password" class="form-control" id="inputPassword" placeholder="password">
                            <span class="error"><?php echo !empty($error['password']) ? $error['password'] : ''; ?></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputConfirmPassword" class="col-xs-4 control-label">confirm password: </label>
                        <div class="col-xs-7">
                            <input type="password" name="confirm_password" class="form-control" id="inputConfirmPassword" placeholder="confirm password">
                            <span class="error"><?php echo !empty($error['confirm_password']) ? $error['confirm_password'] : ''; ?></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputGender" class="col-xs-4 control-label">gender: </label>
                        <div class="col-xs-8">
                            <?php if (!empty($genders)) : ?>
                                <?php foreach ($genders as $gender) : ?>
                                    <div class="checkbox-inline">
                                        <label>
                                            <input type="radio" name="gender" id="gender<?php echo $gender['id']; ?>" value="<?php echo $gender['id']; ?>" <?php echo (!empty($user['gender']) && $user['gender'] == $gender['id']) ? 'checked' : ''; ?>> <?php echo strtolower($gender['name']); ?>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-4 col-xs-7">
                            <button type="submit" class="btn btn-default col-xs-12">Signup!!</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </fieldset>

    <script type="text/javascript">
<?php if (empty($user['gender'])) : ?>
            $("#gender1").prop("checked", true);
<?php endif; ?>
    </script>
</div>