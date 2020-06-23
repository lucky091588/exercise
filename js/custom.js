$(document).ready(function(){

  // setting variables for the data processing
  var $tableMain = $('#js-table'),
      $fileUpload = $('#js-upload-file'),
      $fileUploadInput = $('#js-uploaded-file'),
      $runningTable;

  // set datatable
  $runningTable = $tableMain.DataTable({
    "searching": false, // turn off search functionality
    dom: 'lBfrtip', // export button position
    buttons: [
      {
        text: 'Export Data as TSV', 
        extend: 'csvHtml5',
        fieldSeparator: '\t',
        extension: '.tsv', // export data as a .tsv file
        exportOptions: {
          columns: [0, 1, 5, 3], // export column data that will be included
          rows: ':not(.js-excluded)', // export row data that will not included
        },
      },
      {
        text: 'Export Data as CSV',
        extend: 'csvHtml5', // export data as a .csv file
        exportOptions: {
          columns: [0, 1, 5, 3], // export column data that will be included
          rows: ':not(.js-excluded)', // export row data that will not included
        },
      }
    ],
    order: [[4, "asc"], [1, "asc"]], // order base on requirement (4 for email domain and 1 for last name)
    "columnDefs": [
      {
        "targets": [4, 5], // hide column 4 and 5 (4 is the email domain for sorting and 5 is the email that's change when state is Florida (it was Jacksonville but there is no city capitol in the provided data))
        "visible": false
      },
      { targets: 'js-no-sort', orderable: false } // remove sort functionality base on class (Last column is the only one sortable)
    ]
  });

  // run when importing data
  $fileUpload.on('submit', function(event){
    event.preventDefault();
    $.ajax({
      url:"http://ldinawanao.com/exercise/inc/import.php", // url of the import function (change this to your url path)
      method:"POST",
      data:new FormData(this),
      dataType:'json',
      contentType:false,
      cache:false,
      processData:false,
      success:function(jsonData) { // if import is success
        $fileUploadInput.val(''); // remove imported data
        var data = jsonData,
            mainData = '';
        data.forEach(function(value, key) {
            var dataTD = "<tr>";
            value.forEach(function(value, key) {
               if(key === 6) {
                 dataTD = dataTD.replace('<tr>', '<tr class="' + value + '">'); // adding exclude class when exporting
               } else {
                 dataTD = dataTD + "<td>" + value + "</td>";
               }
            });
            dataTD = dataTD + "</tr>";
            mainData = mainData + dataTD;
        });

        $runningTable.rows.add($(mainData)).draw(); // put imported data in the datatables
      },
      error:function(data){ // if import has error
        console.log(data.responseText);
      }
    });
  });
});