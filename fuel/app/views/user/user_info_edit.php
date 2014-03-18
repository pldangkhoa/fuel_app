<div class="row">
	<div class="col-xs-12">
		<form class="form-horizontal" role="form" action="<?php echo Uri::create('user/user_info_edit', array(), array()); ?>" method="post" enctype="multipart/form-data">
			<div class="form-group">
				<label for="inputUserName" class="col-xs-3 control-label">name: </label>
				<div class="col-xs-7">
					<input type="text" name="username" class="form-control" id="inputUserName" placeholder="username" value="<?php echo !empty($user_info['username']) ? $user_info['username'] : ''; ?>">
					<span class="error"><?php echo !empty($error['username']) ? $error['username'] : ''; ?></span>
				</div>
			</div>
			<div class="form-group">
				<label for="inputUserName" class="col-xs-3 control-label">gender: </label>
				<div class="col-xs-3">
					<select class="form-control" name="gender">
					<?php if (!empty($genders)) : ?>
						<?php foreach ($genders as $gender) : ?>
							<option value="<?php echo $gender['id']; ?>" <?php echo $gender['id'] == $user_info['gender'] ? 'selected' : ''; ?>><?php echo strtolower($gender['name']); ?></option>
						<?php endforeach; ?>
					<?php endif; ?>
					</select>
					<span class="error"><?php echo !empty($error['gender']) ? $error['gender'] : ''; ?></span>
				</div>
			</div>
			<div class="form-group">
				<label for="inputCronmail" class="col-xs-3 control-label">icon: </label>
				<div class="col-xs-3">
					<?php if (!empty($user_info['icon'])) : ?>
					<img alt="icon" width="100px" height="100px" src="/files/<?php echo $user_info['icon']; ?>">
					<label>
						<input type="checkbox" name="view_icon" value="1" <?php echo !empty($user_info['view_icon']) ? '' : 'checked'; ?>> not show
					</label>
					<?php else : ?>
					<span>no icon</span>
					<?php endif ?>
				</div>
				<div class="col-xs-3 input-group">
					<span class="btn btn-file">
						file upload change icon <input type="file" name="upload_icon">
					</span>
					<input type="text" disabled  class="form-control input-file">
				</div>
			</div>
			<div class="form-group">
				<label for="inputCronmail" class="col-xs-3 control-label">cronmail: </label>
				<div class="col-xs-9">
					<div class="checkbox-inline">
						<label>
							<input type="radio" name="cronmail" id="cronmail1" value="1" <?php echo !empty($user_info['cronmail']) ? 'checked' : ''; ?>> receive
						</label>
					</div>
					<div class="checkbox-inline">
						<label>
							<input type="radio" name="cronmail" id="cronmail2" value="0" <?php echo empty($user_info['cronmail']) ? 'checked' : ''; ?>> not receive
						</label>
					</div>
					<span class="error"><?php echo !empty($error['cronmail']) ? $error['cronmail'] : ''; ?></span>
				</div>
			</div>
			<div class="form-group">
				<label for="inputHobby" class="col-xs-3 control-label">hobby: </label>
				<div class="col-xs-9">
				<?php if (!empty($hobbies)) : ?>
					<?php foreach ($hobbies as $hobby) : ?>
						<div class="checkbox-inline">
							<label>
								<input type="checkbox" name="hobby[]" id="hobby" value="<?php echo $hobby['id']; ?>" <?php echo in_array($hobby['id'], (array) $user_info['hobbies']) ? 'checked': ''; ?>> <?php echo $hobby['name']; ?>
							</label>
						</div>
					<?php endforeach; ?>
				<?php endif; ?>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-3 col-xs-7">
					<button type="submit" class="btn btn-primary col-xs-12">save</button>
				</div>
			</div>
		</form>
	</div>
	
	<script type="text/javascript">
		$(document).on('change', '.btn-file :file', function() {
			var input = $(this),
				numFiles = input.get(0).files ? input.get(0).files.length : 1,
				label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
				input.trigger('fileselect', [numFiles, label]);
		});
		
		$(document).ready( function() {
			$('.btn-file :file').on('fileselect', function(event, numFiles, label) {
				var input = $(this).parents('.input-group').find(':text'),
				log = numFiles > 1 ? numFiles + ' files selected' : label;
				if( input.length ) {
					input.val(log);
				}
			});
		}); 
	</script>
</div>