<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
ini_set('display_errors', 1);
$examPost = $_POST['exam_id'];
$userPost = $_POST['user_id'];
$numPost = $_POST['question_num'];

$post_submitER = "request=answers_instructorreview".
    "&exam_id=".rawurlencode($examPost).
    "&user_id=".rawurlencode($userPost).
    "&question_num=".rawurlencode($numPost);



for($j = 1; $j <= $numPost; $j++){
    ${"qid" . $j} = $_POST['question_' . $j . '_ID'];
    ${"comment" . $j} = $_POST['question_' . $j . '_comment'];
    ${"testNum" . $j} = $_POST['question_' . $j . '_tests_num'];

    for($i = 1; $i <= ${'testNum' . $j}; $i++){
        ${$j . "score" . $i} = $_POST['question_' . $j . '_test_score_' . $i];
    }

    $post_submitER .= "&question_" . $j . "_ID=".rawurlencode(${'qid' . $j}).
    "&question_" . $j . "_comment=".rawurlencode(${'comment' . $j}).
    "&question_" . $j . "_tests_num=".rawurlencode(${'testNum' . $j});

    for($i = 1; $i <= ${'testNum' . $j}; $i++){
        $post_submitER .= '&question_' . $j . '_test_score_' . $i . '=' . rawurlencode(${$j . 'score' . $i});
    }
}


//echo $post_submitER;
//create curl variable
$curl = curl_init();

//set url for curl to look at
curl_setopt($curl, CURLOPT_URL, 'https://afsaccess1.njit.edu/~dk394/download/CS490/BETA/mid.php');
if (!$curl)
  {
     die("<br>Couldn't initialize a cURL handle with MIDDLE<br>");
  }

//set curl to accept something instead of outputting
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

//doing a post request
curl_setopt($curl, CURLOPT_POST, 1);
//adding post variables
curl_setopt($curl, CURLOPT_POSTFIELDS, $post_submitER);

//assign value from curl pull
$filterRaw = curl_exec($curl);
curl_close($curl);
echo $filterRaw;
//$loginInfo = json_decode($logRaw);
//echo $loginInfo;

?>

