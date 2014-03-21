<div class="row myapp-top">
    <div class="col-xs-6 title"><?php echo!empty($error) ? $error : 'Activation is completed!'; ?></div>
</div>
<div class="row">
    <div class="col-sm-offset-2 col-xs-8">
        <?php if (empty($error)) : ?>
            <div class="row">
                <div class="col-sm-offset-1 col-xs-10">
                    <p>You now have a valid membership.</p>
                    <p>You enjoyed this site!</p>
                </div>
            </div>
        <?php endif; ?>
        <div class="row">
            <div class="col-sm-offset-3 col-xs-6">
                <a href="/auth/login"><button class="btn btn-default col-xs-12">Go login form</button></a>
            </div>
        </div>
    </div>
</div>