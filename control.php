<?php

if ( is_admin() ){
	add_action('admin_menu', 'Larrabee_admin_menu');
	function Larrabee_admin_menu() {
		add_options_page('Nio', 'Nio', 'administrator','Nio', 'setup_config_page');
	}
}

function filterData($item, $key, $para){
	if (isset($_POST["Nio_".$para."_".$key])) {
		$value = $_POST["Nio_".$para."_".$key];
		update_option( "Nio_".$para."_".$key, $value );
	}
}

function setup_config_page() {
global $attr;

array_walk_recursive($attr['GENERAL'],'filterData','GENERAL');
array_walk_recursive($attr['CAPTOIN'],'filterData','CAPTOIN');
array_walk_recursive($attr['STYLE'],'filterData','STYLE');
array_walk_recursive($attr['THUMB'],'filterData','THUMB');

?>
<div class="wrap">
	<h2>Nio</h2>
	<span class="description">Display your photoshelter gallery in any page and post.</span>
	<form name="from1" method="post">
		<h3>General Options</h3>
		<table class="form-table">
			<tr>
				<th><label for="RSS">Default Gallery RSS</label></th>
				<td><input type="text" name="Nio_GENERAL_RSS" size="40" value="<?php echo get_option("Nio_GENERAL_RSS") ?>"><span class="description">The default gallery to display. Specify gallery in shortcode otherwise.</span></td>
			</tr>
			<tr>
				<th><label for="description">Gallery's Header</label></th>
				<td><input type="text" name="Nio_GENERAL_Header" size="40" value="<?php echo get_option("Nio_GENERAL_Header") ?>"><span class="description">The header/title for the gallery. The header will be surpressed if nothing ('') is specified.</span></td>
			</tr>
			<tr>
				<th><label for="description">Gallery Second Title</label></th>
				<td><input type="text" name="Nio_GENERAL_SubTitle" size="40" value="<?php echo get_option("Nio_GENERAL_SubTitle") ?>"><span class="description">Text between header and image. The text area will be surpressed, if nothing ('') is specified.</span></td>
			</tr>
			<tr>
				<th><label for="description">Gallery Bottom Text</label></th>
				<td><input type="text" name="Nio_GENERAL_Bottom" size="40" value="<?php echo get_option("Nio_GENERAL_Bottom") ?>"><span class="description">Bottom text. The text area will be surpressed, if nothing ('') is specified.</span></td>
			</tr>
			<tr>
				<th></th>
				<td><input style="float: right;" type="submit" class="button-primary" value="Update" name="submit" /></td>
			</tr>
		</table>
		<h3>Gallery Options</h3>
		<table class="form-table">
			<tr>
				<th><label for="NoThum">Number of thumbnails</label></th>
				<td><input type="text" name="Nio_GENERAL_NoThum" size="40" value="<?php echo get_option("Nio_GENERAL_NoThum") ?>"><span class="description">The number of thumbnails to display in the page.</span></td>
			</tr>
			<tr>
				<th><label for="NoThum">Gallery Background</label></th>
				<td><input type="text" name="Nio_STYLE_GalBackground" size="40" value="<?php echo get_option("Nio_STYLE_GalBackground") ?>"><span class="description">Sets the background color of the gallery, specify a color number including the hash sign.</span></td>
			</tr>
			<tr>
				<th><label for="NoThum">Gallery Padding</label></th>
				<td><input type="text" name="Nio_STYLE_GalPadding" size="40" value="<?php echo get_option("Nio_STYLE_GalPadding") ?>"><span class="description">Sets the padding of the gallery (in number of pixels).</span></td>
			</tr>
			<tr>
				<th><label for="NoThum">Gallery Width</label></th>
				<td><input type="text" name="Nio_STYLE_GalWidth" size="40" value="<?php echo get_option("Nio_STYLE_GalWidth") ?>"><span class="description">Sets the width of the gallery (in number of pixels).</span></td>
			</tr>
			<tr>
				<th><label for="NoThum">Gallery Border Size</label></th>
				<td><input type="text" name="Nio_STYLE_GalBorderSize" size="40" value="<?php echo get_option("Nio_STYLE_GalBorderSize") ?>"><span class="description">Fixes the size of border of the gallery. A value of '0' surpresses the border.</span></td>
			</tr>
			<tr>
				<th><label for="NoThum">Gallery Border Color</label></th>
				<td><input type="text" name="Nio_STYLE_GalBorderColor" size="40" value="<?php echo get_option("Nio_STYLE_GalBorderColor") ?>"><span class="description">Sets the border color of the gallery (please specify a color number including the hash sign).</span></td>
			</tr>
			<tr>
				<th><label for="NoThum">Gallery Font Color</label></th>
				<td><input type="text" name="Nio_STYLE_GalFontColor" size="40" value="<?php echo get_option("Nio_STYLE_GalFontColor") ?>"><span class="description">Sets the font color. Specify the color number including the hash sign.</span></td>
			</tr>
			<tr>
				<th></th>
				<td><input style="float: right;" type="submit" class="button-primary" value="Update" name="submit" /></td>
			</tr>
		</table>
		<h3>Thumbnail Options</h3>
		<table class="form-table">
			<tr>
				<th><label for="description">Thumbnail Size</label></th>
				<td><input type="text" name="Nio_THUMB_Size" size="40" value="<?php echo get_option("Nio_THUMB_Size") ?>"><span class="description">Fixes the size of the of thumbnails (in number of pixels).</span></td>
			</tr>
			<tr>
				<th><label for="description">Layout Style</label></th>
				<td>
					<select name="Nio_THUMB_Style">
						<option value="N" <?php if( get_option("Nio_THUMB_Style")=="N"){ ?> selected="selected" <?php } ?>>Normal</option>
						<option value="M" <?php if( get_option("Nio_THUMB_Style")=="M"){ ?> selected="selected" <?php } ?>>Maximized Height</option>
						<option value="S" <?php if( get_option("Nio_THUMB_Style")=="S"){ ?> selected="selected" <?php } ?>>Square</option>
					</select>
					<span class="description">Opt for a square thumbnail, normal thumbnails or thumbnails with a maximized height</span>
				</td>
			</tr>
			<tr>
				<th><label for="description">Water Mark</label></th>
				<td>
					<select name="Nio_THUMB_WaterMark">
						<option value="Y" <?php if( get_option("Nio_THUMB_WaterMark")=="Y"){ ?> selected="selected" <?php } ?>>Yes</option>
						<option value="N" <?php if( get_option("Nio_THUMB_WaterMark")=="N"){ ?> selected="selected" <?php } ?>>No</option>
					</select>
					<span class="description">Opt for a higher quality thumbnail with watermark ('Y' or 'N').</span>
				</td>
			</tr>
			<tr>
				<th><label for="description">Margin</label></th>
				<td><input type="text" name="Nio_THUMB_Margin" size="40" value="<?php echo get_option("Nio_THUMB_Margin") ?>"><span class="description">Sets the margin between thumbs (in number of pixels).</span></td>
			</tr>
			<tr>
				<th><label for="description">Top/Bottom Padding</label></th>
				<td><input type="text" name="Nio_THUMB_TopBottomPadding" size="40" value="<?php echo get_option("Nio_THUMB_TopBottomPadding") ?>"><span class="description">Sets the top and bottom padding of a thumb (in number of pixels).</span></td>
			</tr>
			<tr>
				<th><label for="description">Left/Right Padding</label></th>
				<td><input type="text" name="Nio_THUMB_LeftRightPadding" size="40" value="<?php echo get_option("Nio_THUMB_LeftRightPadding") ?>"><span class="description">Sets the left and right padding of a thumb (in number of pixels).</span></td>
			</tr>
				<th><label for="description">Thumbnail Background</label></th>
				<td><input type="text" name="Nio_THUMB_ThumbBackground" size="40" value="<?php echo get_option("Nio_THUMB_ThumbBackground") ?>"><span class="description">Color of the background of the thumb (use a color number including the hash sign).</span></td>
			</tr>
			<tr>
				<th><label for="description">Border Size</label></th>
				<td><input type="text" name="Nio_THUMB_ThumbBorderSize" size="40" value="<?php echo get_option("Nio_THUMB_ThumbBorderSize") ?>"><span class="description">The size of border of the thumb (number of pixels). Value of 0 surpresses the border.</span></td>
			</tr>
			<tr>
				<th><label for="description">Border Color</label></th>
				<td><input type="text" name="Nio_THUMB_ThumbBorderColor" size="40" value="<?php echo get_option("Nio_THUMB_ThumbBorderColor") ?>"><span class="description">Sets the border color (color number with the hash).</span></td>
			</tr>
			<tr>
				<th><label for="description">Border Hover Color</label></th>
				<td><input type="text" name="Nio_THUMB_ThumbBorderHover" size="40" value="<?php echo get_option("Nio_THUMB_ThumbBorderHover") ?>"><span class="description">Sets the border hover color (color number with the hash).</span></td>
			</tr>
			<tr>
				<th><label for="description">Hover Text</label></th>
				<td><input type="text" name="Nio_THUMB_ThumbHoverText" size="40" value="<?php echo get_option("Nio_THUMB_ThumbHoverText") ?>"><span class="description">Text that is shown on hovering. If emptied, the IPTC caption and IPTC owner will be shown.</span></td>
			</tr>
			<tr>
				<th><label for="description">Link</label></th>
				<td>
					<select name="Nio_THUMB_ThumbTarget">
						<option value="S" <?php if( get_option("Nio_THUMB_ThumbTarget")=="S"){ ?> selected="selected" <?php } ?>>Same Window</option>
						<option value="N" <?php if( get_option("Nio_THUMB_ThumbTarget")=="N"){ ?> selected="selected" <?php } ?>>New Window</option>
					</select>
					<span class="description">Determines whether PhotoShelter pages open in the same window (S) or a new window (N).</span>
				</td>
			</tr>
			<tr>
				<th></th>
				<td><input style="float: right;" type="submit" class="button-primary" value="Update" name="submit" /></td>
			</tr>
		</table>
		<h3>Caption Options</h3>
		<table class="form-table">
			<tr>
				<th><label for="description">Caption Size</label></th>
				<td><input type="text" name="Nio_CAPTOIN_Size" size="40" value="<?php echo get_option("Nio_CAPTOIN_Size") ?>"><span class="description">Fixes the size of the thumbnail caption. A value of '0' surpresses the caption.</span></td>
			</tr>
			<tr>
				<th><label for="description">IPTC</label></th>
				<td>
					<select name="Nio_CAPTOIN_HorC">
						<option value="H" <?php if( get_option("Nio_CAPTOIN_HorC")=="H"){ ?> selected="selected" <?php } ?>>IPTC Headline</option>
						<option value="C" <?php if( get_option("Nio_CAPTOIN_HorC")=="C"){ ?> selected="selected" <?php } ?>>IPTC Caption</option>
					</select>
					<span class="description">IPTC headline or IPTC caption is used for the text underneath the thumbnail.</span>
				</td>
			</tr>
			<tr>
				<th><label for="description">Caption Height</label></th>
				<td><input type="text" name="Nio_CAPTOIN_Height" size="40" value="<?php echo get_option("Nio_CAPTOIN_Height") ?>"><span class="description">Sets the height of the caption in pixels. This will not apply if no caption is used.</span></td>
			</tr>
			<tr>
				<th></th>
				<td><input style="float: right;" type="submit" class="button-primary" value="Update" name="submit" /></td>
			</tr>
		</table>
	</form>
</div>
<?php
}
?>