<?php

function getWeather()
{
    $ack = "";
    $output = "";

    if (!isset($_POST["zip_code"]) || trim($_POST["zip_code"]) === "") {
        return [
            '<p class="text">No zip code provided. Please enter a zip code.</p>',
            ''
        ];
    }

    $zip = trim($_POST["zip_code"]);

    $url = "https://russet-v8.wccnet.edu/~sshaper/assignments/assignment10_rest/get_weather_json.php?zip_code={$zip}";

    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false
    ]);

    $response = curl_exec($ch);

    if ($response === false) {
        curl_close($ch);
        return [
            '<p class="text">There was an error retrieving the records.</p>',
            ''
        ];
    }

    curl_close($ch);

    $data = json_decode($response, true);

    if (!is_array($data) || isset($data["error"])) {
        $err = isset($data["error"]) ? $data["error"] : "There was an error retrieving the records.";
        return [
            '<p class="text">' . htmlspecialchars($err) . '</p>',
            ''
        ];
    }

    if (!isset($data["searched_city"])) {
        return [
            '<p class="text">There was an error retrieving the records.</p>',
            ''
        ];
    }

    $city      = $data["searched_city"];
    $cityName  = $city["name"];
    $temp      = $city["temperature"];   
    $humidity  = $city["humidity"];
    $forecast  = $city["forecast"];


    $html  = '<h2>' . htmlspecialchars($cityName) . '</h2>';
    $html .= '<p><strong>Temperature:</strong> ' . $temp . '</p>';                 
    $html .= '<p><strong>Humidity:</strong> ' . htmlspecialchars($humidity) . '</p>';
    $html .= '<p><strong>3-day forecast</strong></p>';

    $html .= '<ul>';
    foreach ($forecast as $f) {
        $day  = htmlspecialchars($f["day"]);
        $cond = htmlspecialchars($f["condition"]);
        $html .= "<li>{$day}: {$cond}</li>";
    }
    $html .= '</ul>';

    $higher = array_slice($data["higher_temperatures"], 0, 3);

    if (count($higher) === 0) {
        $html .= '<p><strong>There are no cities with temperatures higher than ' . htmlspecialchars($cityName) . '.</strong></p>';
    } else {
        $html .= '<p><strong>Up to three cities where temperatures are higher than ' . htmlspecialchars($cityName) . '</strong></p>';
        $html .= '<table class="table table-striped"><thead><tr><th>City Name</th><th>Temperature</th></tr></thead><tbody>';
        foreach ($higher as $h) {
            $html .= '<tr><td>' . htmlspecialchars($h["name"]) . '</td><td>' . $h["temperature"] . '</td></tr>';
        }
        $html .= '</tbody></table>';
    }

    $lower = array_slice($data["lower_temperatures"], 0, 3);

    if (count($lower) > 0) {
        $html .= '<p><strong>Up to three cities where temperatures are lower than ' . htmlspecialchars($cityName) . '</strong></p>';
        $html .= '<table class="table table-striped"><thead><tr><th>City Name</th><th>Temperature</th></tr></thead><tbody>';
        foreach ($lower as $l) {
            $html .= '<tr><td>' . htmlspecialchars($l["name"]) . '</td><td>' . $l["temperature"] . '</td></tr>';
        }
        $html .= '</tbody></table>';
    } else {
        $html .= '<p><strong>There are no cities with temperatures lower than ' . htmlspecialchars($cityName) . '.</strong></p>';
    }

    return [$ack, $html];
}
