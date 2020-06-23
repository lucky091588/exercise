<?php
/*
* Processing all imported data and send it to be included in the table
*
*/
function processData($data) {

  // include states with list of population
  include 'state-popu.php';

  // assign $data in $row var
  $row = $data;

  // check each data if set and not null and assign to their variables
  $first = isset($row[0]) ? $row[0] : '';
  $last  = isset($row[1]) ? $row[1] : '';
  $email = isset($row[2]) ? $row[2] : '';
  $state = isset($row[3]) ? $row[3] : '';

  // get the email domain base on the requirements
  $edomain = '';
  if($email) {
    $edomain = substr(strrchr($email, "@"), 1);
  }

  // changed the email for export base on the requirements
  // the given data only has a state and Jacksonville belongs to Florida, I just assumed that if state = Florida I will change the export data base on the requirement
  $exportedEmail = $email;
  if($state === 'Florida') {
     $exportedEmail = '---@-.-';
  }

  // add class to rows that will be excluded base on state population base on requirements
  $check_pop = '';
  if($state_popu_list[$state] > 10000000) {
    $check_pop = 'js-excluded';
  }

  // putting data as arrays for conversion
  $datas = array(
    $first,
    $last,
    $email,
    $state,
    $edomain,
    $exportedEmail,
    $check_pop
  );

  return $datas;
}

if(!empty($_FILES['uploaded_file']['name'])) {

  // adding variable for all imported datas
  $datas = [];

  // open file and stored in a variable
  $file_data = fopen($_FILES['uploaded_file']['tmp_name'], 'r');

  // parse open file
  fgetcsv($file_data);

  // checking file extention since .tsv has other method of processing
  $ext = pathinfo($_FILES['uploaded_file']['name'], PATHINFO_EXTENSION);

  // process file data
  while($row = ($ext === 'tsv' ? fgetcsv($file_data, 1000, "\t") : fgetcsv($file_data))) {
    $datas[] = processData($row);
  }

  // convert data to json encode for js processing
  echo json_encode($datas);
}