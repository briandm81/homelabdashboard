<?php


// Simple functions to check strings
function startsWith($haystack, $needle) {
    $length = strlen($needle);
    return (substr($haystack, 0, $length) === $needle);
}

function endsWith($haystack, $needle) {
    $length = strlen($needle);
    if ($length == 0) {
        return true;
    }

    return (substr($haystack, -$length) === $needle);
}

if (!file_exists("settingsgeneral.dat")) {
    //file_put_contents("bookmarks.dat", "");
    echo "No settings!";
}

$Settings = array_map('trim', file("settingsgeneral.dat"));
//print_r($Settings);

class Setting {

    var $siteTitle;
    var $siteImage;
    var $siteIcon;
	var $zipCode;
    var $daysForecast;
	var $weatherEnabled;
    var $timeFormat;
	var $iframeURL;

}

// Parse Settings file
function spawnSettings() {
    $Settings_array = [];
    global $Settings;
    for ($i = 0; $i < count($Settings); $i++) {
        $setting = $Settings[$i];
        if (startsWith($setting, "[") && endsWith($setting, "]")) {
            $new = new Setting();
            $name = substr($setting, 1, strlen($setting) - 2);
            //$new->name = trim($name);
            do {
                $i++;
                if ($i >= count($Settings)) {
                    break;
                }
                if (startsWith($Settings[$i], "siteTitle=")) {
                    $new->siteTitle = substr($Settings[$i], 10, strlen($Settings[$i]) - 10);
                }
                if (startsWith($Settings[$i], "siteImage=")) {
                    $new->siteImage = substr($Settings[$i], 10, strlen($Settings[$i]) - 10);
                }
				if (startsWith($Settings[$i], "siteIcon=")) {
                    $new->siteIcon = substr($Settings[$i], 9, strlen($Settings[$i]) - 9);
                }
				if (startsWith($Settings[$i], "zipCode=")) {
                    $new->zipCode = substr($Settings[$i], 8, strlen($Settings[$i]) - 8);
                }
				if (startsWith($Settings[$i], "daysForecast=")) {
                    $new->daysForecast = substr($Settings[$i], 13, strlen($Settings[$i]) - 13);
                }
				if (startsWith($Settings[$i], "weatherEnabled=")) {
                    $new->weatherEnabled = substr($Settings[$i], 15, strlen($Settings[$i]) - 15);
                }
				if (startsWith($Settings[$i], "timeFormat=")) {
                    $new->timeFormat = substr($Settings[$i], 11, strlen($Settings[$i]) - 11);
                }
				if (startsWith($Settings[$i], "iframeURL=")) {
                    $new->iframeURL = substr($Settings[$i], 10, strlen($Settings[$i]) - 10);
                }
            } while (trim($Settings[$i]) !== "");
            array_push($Settings_array, $new);
        }
    }
    return $Settings_array;
}

$bookmarks = array_map('trim', file("settingsbookmarks.dat"));

class Bookmark {

    var $name;
    var $url;
    var $icon;
	var $image;
    var $isIframe;
    var $isDivider;
	var $isHeading;
    var $isCollapsed;
	var $isCollapseHeader;
	var $isCollapseItem;
	var $delete;

}

// Parse bookmarks file
function spawnBookmarks() {
    $bookmark_array = [];
    global $bookmarks;
    for ($i = 0; $i < count($bookmarks); $i++) {
        $bm = $bookmarks[$i];
        if (startsWith($bm, "[") && endsWith($bm, "]")) {
            $new = new Bookmark();
            $name = substr($bm, 1, strlen($bm) - 2);
            $new->name = trim($name);
            do {
                $i++;
                if ($i >= count($bookmarks)) {
                    break;
                }
                if (startsWith($bookmarks[$i], "url=")) {
                    $new->url = substr($bookmarks[$i], 4, strlen($bookmarks[$i]) - 4);
                }
                if (startsWith($bookmarks[$i], "icon=")) {
                    $new->icon = substr($bookmarks[$i], 5, strlen($bookmarks[$i]) - 5);
                }
				if (startsWith($bookmarks[$i], "image=")) {
                    $new->image = substr($bookmarks[$i], 6, strlen($bookmarks[$i]) - 6);
                }

                if (startsWith($bookmarks[$i], "isIframe=")) {
                    $new->isIframe = substr($bookmarks[$i], 9, strlen($bookmarks[$i]) - 9);
                    if ($new->isIframe === "true") {
                        $new->isIframe = true;
                    } else
                        $new->isIframe = false;
                }
				if (startsWith($bookmarks[$i], "isDivider=")) {
                    $new->isDivider = substr($bookmarks[$i], 10, strlen($bookmarks[$i]) - 10);
                    if ($new->isDivider === "true") {
                        $new->isDivider = true;
                    } else
                        $new->isDivider = false;
                }
				if (startsWith($bookmarks[$i], "isHeading=")) {
                    $new->isHeading = substr($bookmarks[$i], 10, strlen($bookmarks[$i]) - 10);
                    if ($new->isHeading === "true") {
                        $new->isHeading = true;
                    } else
                        $new->isHeading = false;
                }
                if (startsWith($bookmarks[$i], "isCollapsed=")) {
                    $new->isCollapsed = substr($bookmarks[$i], 12, strlen($bookmarks[$i]) - 12);
                    if ($new->isCollapsed === "true") {
                        $new->isCollapsed = true;
                    } else
                        $new->isCollapsed = false;
                }
				if (startsWith($bookmarks[$i], "isCollapseHeader=")) {
                    $new->isCollapseHeader = substr($bookmarks[$i], 17, strlen($bookmarks[$i]) - 17);
                    if ($new->isCollapseHeader === "true") {
                        $new->isCollapseHeader = true;
                    } else
                        $new->isCollapseHeader = false;
                }
				if (startsWith($bookmarks[$i], "isCollapseItem=")) {
                    $new->isCollapseItem = substr($bookmarks[$i], 15, strlen($bookmarks[$i]) - 15);
                    if ($new->isCollapseItem === "true") {
                        $new->isCollapseItem = true;
                    } else
                        $new->isCollapseItem = false;
                }
            } while (trim($bookmarks[$i]) !== "");
            array_push($bookmark_array, $new);
        }
    }
    return $bookmark_array;
}

?>