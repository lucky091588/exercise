<?php

// fetch data base on file url
function fetchDefaultData($file) {

  // include states with list of population
  include 'state-popu.php';

  // adding variable for all imported datas
  $data = [];

  // open file and stored in a variable
  $file_data = fopen($file, 'r');

  // parse open file
  fgetcsv($file_data);

  // checking file extention since .tsv has other method of processing
  $ext = pathinfo($file, PATHINFO_EXTENSION);

  // process file data
  while ($row = ($ext === 'tsv' ? fgetcsv($file_data, 1000, "\t") : fgetcsv($file_data))) {

    // get the email domain base on the requirements
    $edomain = '';
    if(isset($row[2])) {
      $edomain = substr(strrchr($row[2], "@"), 1);
    }

    // changed the email for export base on the requirements
    // the given data only has a state and Jacksonville belongs to Florida, I just assumed that if state = Florida I will change the export data base on the requirement
    $exportedEmail = isset($row[2]) ? $row[2] : '';
    if(isset($row[3]) && $row[3] === 'Florida') {
       $exportedEmail = '---@-.-';
    }

    // add class to rows that will be excluded base on state population base on requirements
    $check_pop = '';
    if(isset($row[3]) && $state_popu_list[$row[3]] > 10000000) {
      $check_pop = 'js-excluded';
    }

    // putting data in td dom to be included in html table
    $data[] = '
      <tr class="'.$check_pop.'">
        <td>'.(isset($row[0]) ? $row[0] : '').'</td>
        <td>'.(isset($row[1]) ? $row[1] : '').'</td>
        <td>'.(isset($row[2]) ? $row[2] : '').'</td>
        <td>'.(isset($row[3]) ? $row[3] : '').'</td>
        <td>'.$edomain.'</td>
        <td>'.$exportedEmail.'</td>
      </tr>
    ';
  }

  // return data with td dom
  return $data;
}