<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Developer exercise 1</title>
    <script src="js/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/datatables.min.css"/>
    <script type="text/javascript" src="js/datatables.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <script src="js/bootstrap.min.js"></script>
    <script src="js/custom.js"></script>
    <link rel="stylesheet" href="css/style.css" />
  </head>
  <body>
    <div class="body-wrapper">
      <div class="container">
        <div class="upload clearfix">
          <form id="js-upload-file" method="post" enctype="multipart/form-data"> 
            <div class="col-md-3 upload-input">  
               <input type="file" name="uploaded_file" id="js-uploaded-file" accept=".csv,.tsv"/>
            </div>  
            <div class="col-md-3">  
                <input type="submit" name="upload" id="upload" value="Import Data" class="btn btn-info" />
            </div>  
          </form>
        </div>
        <div class="table-responsive">
          <table class="table table-striped table-bordered clearfix" id="js-table">
           <thead>
            <tr>
             <th class="js-no-sort">First</th>
             <th>Last</th>
             <th class="js-no-sort">Email</th>
             <th class="js-no-sort">State</th>
             <th>Email Domain</th>
             <th>Email</th>
            </tr>
           </thead>
           <tbody>
             <?php
              // load default data
              include 'inc/fetch.php';
              $datas = fetchDefaultData('data/testdata.tsv');
              echo implode(" ", $datas);
             ?>
           </tbody>
          </table>
        </div>
      </div>
    </div>
  </body>
</html>