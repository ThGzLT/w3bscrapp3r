<?php

$curl = curl_init($_GET['q']);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);

$page = curl_exec($curl);

if (curl_errno($curl)) {
    echo 'Scraper error: ' . curl_error($curl);
    exit;
}

curl_close($curl);

$regex = '/<div id="case_textlist">(.*?)<\/div>/s';
if (preg_match($regex, $page, $list))
    echo $list[0];
else
    print "Not found";


$db = new Mysqli("", "", "", "");
$query = "INSERT INTO test_xml (title, destination) VALUES ('" . $list[0] . "', '" . $title . "')";
$db->query($query);

$sql = "SELECT destination, price, title FROM test_xml";
$result = $db->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "<br> id: " . $row["destination"] . " - Name: " . $row["price"] . " " . $row["title"] . "<br>";
    }

} else {
    echo "0 results";
}

?>
