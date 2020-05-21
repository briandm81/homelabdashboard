<?php
require_once('environment.php');
$sitesettings = spawnSettings();
?>

<form>
	<div class="form-row">
		<div class="form-group col-md-4">
		  <label for="inputSiteTitle">Site Title</label>
		  <input type="text" class="form-control" id="inputSiteTitle" placeholder="Site Title" value="<?php echo $sitesettings[0]->siteTitle; ?>" required>
		</div>
		<div class="form-group col-md-4">
		  <label for="inputSiteImage">Site Image</label>
		  <input type="text" class="form-control" id="inputSiteImage" placeholder="Site Image" value="<?php echo $sitesettings[0]->siteImage; ?>" required>
		</div>
		<div class="form-group col-md-4">
		  <label for="inputSiteIcon">Site Icon</label>
		  <input type="text" class="form-control" id="inputSiteIcon" placeholder="Site Icon" value="<?php echo $sitesettings[0]->siteIcon; ?>" required>
		</div>
	</div>
	<div class="form-row">
		<div class="form-group col-md-4">
		  <label for="inputWeatherEnabled">Weather Enabled</label>
		  <select id="inputWeatherEnabled" class="form-control">
			<option<?php if( $sitesettings[0]->weatherEnabled == "Enabled") { echo " selected"; } ?>>Enabled</option>
			<option<?php if( $sitesettings[0]->weatherEnabled == "Disabled") { echo " selected"; } ?>>Disabled</option>
		  </select>
		</div>
		<div class="form-group col-md-4">
		  <label for="inputZipcode">Weather Location</label>
		  <input type="text" class="form-control" id="inputZipcode" placeholder="Location" value="<?php echo $sitesettings[0]->zipCode; ?>" required>
		</div>
		<div class="form-group col-md-4">
		  <label for="inputDaysForecast">Days Forecast</label>
		  <select id="inputDaysForecast" class="form-control">
			<option<?php if( $sitesettings[0]->daysForecast == "3-Day") { echo " selected"; } ?>>3-Day</option>
			<option<?php if( $sitesettings[0]->daysForecast == "4-Day") { echo " selected"; } ?>>4-Day</option>
			<option<?php if( $sitesettings[0]->daysForecast == "5-Day") { echo " selected"; } ?>>5-Day</option>
			<option<?php if( $sitesettings[0]->daysForecast == "6-Day") { echo " selected"; } ?>>6-Day</option>
			<option<?php if( $sitesettings[0]->daysForecast == "7-Day") { echo " selected"; } ?>>7-Day</option>
			<option<?php if( $sitesettings[0]->daysForecast == "8-Day") { echo " selected"; } ?>>8-Day</option>
			<option<?php if( $sitesettings[0]->daysForecast == "9-Day") { echo " selected"; } ?>>9-Day</option>
		  </select>
		</div>
	</div>
	<div class="form-row">
		<div class="form-group col-md-12">
		  <label for="inputTimeFormat">Time Format</label>
		  <select id="inputTimeFormat" class="form-control">
			<option<?php if( $sitesettings[0]->timeFormat == "12 Hour") { echo " selected"; } ?>>12 Hour</option>
			<option<?php if( $sitesettings[0]->timeFormat == "24 Hour") { echo " selected"; } ?>>24 Hour</option>
		  </select>
		</div>
	</div>
	<div class="form-row">
		<div class="form-group col-md-12">
		  <label for="inputIFrameURL">iFrame URL</label>
		  <input type="text" class="form-control" id="inputIFrameURL" placeholder="iFrame URL" value="<?php echo $sitesettings[0]->iframeURL; ?>" required>
		</div>
	</div>
	<div style="display:none;" id="successSettingsGeneralAlert">
		<div class="alert alert-success alert-dismissible fade show" role="alert" id="successSettingsGeneralAlert2"><strong>Settings Saved!</strong> Please refresh the page to see changes.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>
	</div>
	
	<div style="display:none;" id="dangerSettingsGeneralAlert">
		<div class="alert alert-danger alert-dismissible fade show" role="alert" id="dangerSettingsGeneralAlert2"><strong>Settings failed to save!</strong> Check the permissions on the settingsgeneral.dat file (chmod 777).<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>
	</div>

	<div class="table-controls">
		<button type="button" class="btn btn-primary my-2 my-sm-0" id="savegeneralsettings" onclick="savesettings()">Save Settings</button>
	</div>
</form>

<script>

function savesettings()
{
	var text =  "[SETTINGS]\n" +
				"siteTitle=" + $("#inputSiteTitle").val() + "\n" +
				"siteImage=" + $("#inputSiteImage").val() + "\n" +
				"siteIcon=" + $("#inputSiteIcon").val() + "\n" +
				"zipCode=" + $("#inputZipcode").val() + "\n" +
				"daysForecast=" + $("#inputDaysForecast").val() + "\n" +
				"weatherEnabled=" + $("#inputWeatherEnabled").val() + "\n" +
				"timeFormat=" + $("#inputTimeFormat").val() + "\n" +
				"iframeURL=" + $("#inputIFrameURL").val() + "\n\n";
				
	$("#successSettingsGeneralAlert").css("display", "none");
	$.ajax({
		type: "POST",
		url: "savesettings.php",
		data: {settingsgeneral:text},
		success: function(response) {
			if (response=="true") {
				if($("#successSettingsGeneralAlert").find("div#successSettingsGeneralAlert2").length==0){
					$("#successSettingsGeneralAlert").append("<div class='alert alert-success alert-dismissible fade show' role='alert' id='successSettingsGeneralAlert2'><strong>Settings Saved!</strong> Please refresh the page to see changes.<button type='button'class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
				}
				$("#successSettingsGeneralAlert").css("display", "");
			}
			else {
				if($("#dangerSettingsGeneralAlert").find("div#dangerSettingsGeneralAlert2").length==0){
					$("#dangerSettingsGeneralAlert").append("<div class='alert alert-success alert-dismissible fade show' role='alert' id='dangerSettingsGeneralAlert2'><strong>Settings failed to save!</strong> Check the permissions on the settingsgeneral.dat file (chmod 777).<button type='button'class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
				}
				$("#dangerSettingsGeneralAlert").css("display", "");
			}
		}
	});
	
}

</script>

