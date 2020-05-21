<?php
if(isset($_GET["location"]))
{
	$location = $_GET["location"];
}
if(isset($_GET["daysForecast"]))
{
	$daysForecast = substr($_GET["daysForecast"],0,1);
}
//echo $daysForecast;

// This oauth is provided by Yahoo on their api page for weather app
function buildBaseString($baseURI, $method, $params) {
	$r = array();
	ksort($params);
	foreach($params as $key => $value) {
		$r[] = "$key=" . rawurlencode($value);
	}
	return $method . "&" . rawurlencode($baseURI) . '&' . rawurlencode(implode('&', $r));
}

function buildAuthorizationHeader($oauth) {
	$r = 'Authorization: OAuth ';
	$values = array();
	foreach($oauth as $key=>$value) {
		$values[] = "$key=\"" . rawurlencode($value) . "\"";
	}
	$r .= implode(', ', $values);
	return $r;
}

$url = 'https://weather-ydn-yql.media.yahoo.com/forecastrss';

// The next three lines of data are generated using the Yahoo Weather api app
// Complete the information on this page: https://developer.yahoo.com/weather/
$app_id = 'FtCpvK34';
$consumer_key = 'dj0yJmk9N2hsOGw4NG0zQmhMJmQ9WVdrOVJuUkRjSFpMTXpRbWNHbzlNQS0tJnM9Y29uc3VtZXJzZWNyZXQmc3Y9MCZ4PWUx';
$consumer_secret = '86eb5ea9f3447e321fbd7bdf20f286d8924705f5';

// Request Parameters
// Parameter Description Example
// location city name location=sunnyvale,ca
// lat latitude number lat=37.372
// lon longitude number lon=-122.038
// format response format format=xml (default) or format=json
// u unit format u=f (default) or u=c
// woeid woeid number woeid=2502265

// Enter the location you wish to get the weather for on the location line below or use the Request Parameters above
// Units for imperial and metric format are shown below.

// Imperial ("u=f") Metric ("u=c")
// Temperature Fahrenheit Celsius
// Distance Mile Kilometer
// Wind Direction Degree Degree
// Wind Speed Mile Per Hour Kilometer Per Hour
// Humidity Percentage Percentage
// Pressure Inch Hg Millibar

$query = array(
	'location' => 'frisco,tx',
	'format' => 'json',
);
$oauth = array(
	'oauth_consumer_key' => $consumer_key,
	'oauth_nonce' => uniqid(mt_rand(1, 1000)),
	'oauth_signature_method' => 'HMAC-SHA1',
	'oauth_timestamp' => time(),
	'oauth_version' => '1.0'
);
$base_info = buildBaseString($url, 'GET', array_merge($query, $oauth));
$composite_key = rawurlencode($consumer_secret) . '&';
$oauth_signature = base64_encode(hash_hmac('sha1', $base_info, $composite_key, true));
$oauth['oauth_signature'] = $oauth_signature;
$header = array(
buildAuthorizationHeader($oauth),
	'Yahoo-App-Id: ' . $app_id
);
$options = array(
	CURLOPT_HTTPHEADER => $header,
	CURLOPT_HEADER => false,
	CURLOPT_URL => $url . '?' . http_build_query($query),
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_SSL_VERIFYPEER => false
);
$ch = curl_init();
curl_setopt_array($ch, $options);
$response = curl_exec($ch);
curl_close($ch);
//print_r($response);

$characters = json_decode($response, true);
//print_r($characters);

//echo "<br><br>";
date_default_timezone_set("America/Chicago");

?>
<div class="row">
<?php
 for ($i = 0; $i < $daysForecast; $i++) {
?>
    <div class="col-sm" style="<?php if ($i<$daysForecast-1) {echo "border-right: 1px solid #f2f2f2;";} ?>text-align: center;">
      <strong><?php echo date("D",$characters ['forecasts'][$i]['date']); ?></strong><br>
	  <small><?php echo date("M d",$characters ['forecasts'][$i]['date']); ?></small><br>
	  <?php echo "<img src=\"https://s.yimg.com/zz/combo?a/i/us/nws/weather/gr/" . $characters ['forecasts'][$i]['code'] . "ds.png\">"; ?><br>
	  <small>high</small><br>
	  <strong><?php echo $characters ['forecasts'][$i]['high']; ?>&#176;</strong><br>
	  <small>low</small><br>
	  <strong><?php echo $characters ['forecasts'][$i]['low']; ?>&#176;</strong><br>
	</div>
<?php
}
?>
</div>