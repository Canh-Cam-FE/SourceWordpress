<?php
defined('ABSPATH') or die('No script kiddies please!');
global $canhcam_settings;
?>
<div class="wrap">
	<h1>Cánh Cam | Trial Website</h1>
	<form action="options.php" method="post" novalidate="novalidate">
		<?php
		settings_fields($this->_optionGroup)
		?>
		<table class="form-table">
			<tbody>
				<tr>
					<th scope="row">
						<label for="active_licsence">Vô hiệu hóa licsence</label>
					</th>
					<td>
						<input type="checkbox" name="<?php echo $this->_optionName ?>[active_licsence]" <?php echo ($canhcam_settings['active_licsence'] == 'true' ? 'checked' : '') ?> id="active_licsence" value="true" />
					</td>
				</tr>
			</tbody>
		</table>
		<?php do_settings_sections('canhcam-options-group', 'default'); ?>
		<?php submit_button(); ?>
	</form>
</div>