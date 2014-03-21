<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title><?php echo $title; ?></title>
        <?php echo Asset::css(array('bootstrap.css', 'layout.css', 'ui-lightness/jquery-ui-1.10.4.custom.css')); ?>
        <?php echo Asset::js(array('jquery-1.10.2.js', 'jquery-ui-1.10.4.custom.js')); ?>
    </head>
    <body>
        <div class="container">
            <div class="row myapp-top">
                <div class="col-xs-6 title">mypage</div>
                <div class="col-xs-6 text-right">
                    <a href="/"><button type="button" class="btn btn-default">Go Back App</button></a>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-3">
                    <div class="icon">
                        <?php if (!empty($data['user_info']['icon'])) : ?>
                            <img alt="icon" src="/files/<?php echo $data['user_info']['icon']; ?>">
                        <?php endif; ?>
                        <span><?php echo $data['user_info']['username']; ?></span>
                    </div>

                    <div class="menu">
                        <span>menu</span>
                        <ul>
                            <li class="<?php echo $data['action'] == 'mypage' ? 'active' : ''; ?>"><a href="/user/mypage">user_info</a></li>
                            <li class="<?php echo $data['action'] == 'user_info_edit' ? 'active' : ''; ?>"><a href="/user/user_info_edit">user_edit_info</a></li>
                            <li class="<?php echo $data['action'] == 'email_edit' ? 'active' : ''; ?>"><a href="/user/email_edit">email_edit</a></li>
                            <li class="<?php echo $data['action'] == 'password_edit' ? 'active' : ''; ?>"><a href="/user/password_edit">password_edit</a></li>
                            <li class="<?php echo $data['action'] == 'signout' ? 'active' : ''; ?>"><a href="/user/signout">signout</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xs-9">
                    <?php echo $content; ?>
                </div>
            </div>
        </div>
    </body>
</html>
