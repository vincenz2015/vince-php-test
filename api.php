<?php
/* Vince test business Minutes - allow option for include/exclude weekends

Example usage
-------------
$startDateTime = new DateTime('2023-06-18 07:00 AM');
$endDateTime = new DateTime('2023-06-19 09:15 AM');
$includeWeekends = true;
$businessMinutes = calculateBusinessMinutes($startDateTime, $endDateTime, $includeWeekends);
*/

/* Config */
$BUSINESS_START_TIME = '9:00 AM';
$BUSINESS_END_TIME = '5:00 PM';

function calculateBusinessMinutes($startDateTime, $endDateTime, $includeWeekends = false) {
    global $BUSINESS_START_TIME;
    global $BUSINESS_END_TIME;
    $businessStartTime = strtotime($BUSINESS_START_TIME);
    $businessEndTime = strtotime($BUSINESS_END_TIME);
    $businessMinutes = 0;
    $currentDateTime = $startDateTime;
    while ($currentDateTime < $endDateTime) {
        $currentDayOfWeek = date('N', $currentDateTime);
        $currentTime = strtotime(date('H:i', $currentDateTime));
        if ($includeWeekends || ($currentDayOfWeek >= 1 && $currentDayOfWeek <= 5)) {
            if ($currentTime >= $businessStartTime && $currentTime <= $businessEndTime) {
                $businessMinutes++;
            }
        }
        $currentDateTime = strtotime('+1 minute', $currentDateTime);
    }
    return $businessMinutes;
}

/* Get the form POST data */
$postData = $_POST;
if($postData) {
$jsonData = json_decode(file_get_contents('php://input'), true);
$data = array_merge($postData, $jsonData);

$startDate = $data['startDateTime'];
$endDate = $data['endDateTime'];
$includeWeekends = $data['includeWeekends'] == '1' ? true : false;

$startDate = (new DateTime($startDate))->getTimestamp();
$endDate = (new DateTime($endDate))->getTimestamp();

/* Get result and return response */
$result = calculateBusinessMinutes($startDate, $endDate, $includeWeekends);
$responseData = [
    'businessMinutes' => $result,
];
header('Content-Type: application/json');
http_response_code(200);
echo json_encode($responseData);
}
?>
