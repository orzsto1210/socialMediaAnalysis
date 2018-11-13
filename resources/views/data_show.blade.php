<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Social Media Analysis</title>

    <!-- Bootstrap core CSS-->
    <link href="vendor/sb-admin/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template-->
    <link href="vendor/sb-admin/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    
    <!-- Page level plugin CSS-->
    <link href="vendor/sb-admin/datatables/dataTables.bootstrap4.css" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin/sb-admin.css" rel="stylesheet">

  </head>

  <body id="page-top">

    <nav class="navbar navbar-expand navbar-dark bg-dark static-top">

      <a class="navbar-brand mr-1" href="{{ url('/') }}">Social Media Analysis</a>

      <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
        <i class="fas fa-bars"></i>
      </button>

    </nav>

    <div id="wrapper">
      <div id="content-wrapper">
        <div class="container-fluid">
        <div class="card mb-3">
                <div class="card-header">
                  <h2>Data Table</h2>
                </div>
                <div class="card-body">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                     <thead>
                      <tr>
                        <th>Author</th>
                        <th>Title</th>
                        <th>Text</th>
                        <th>Created_at</th>
                      </tr>
                     </thead>
                     <tbody>
                       @foreach ($datas as $data)
                        <tr>
                            <td>{{ $data->author }}</td>
                            <td>{{ $data->title }}</td>
                            <td>{{ $data->text }}</td>
                            <td>{{ $data->created_at }}</td>
                        </tr>
                        @endforeach
                     </tbody>
                        
                    </table>
                </div>
            </div>
        </div>
      </div>
      <!-- /.content-wrapper -->
    </div>
    <!-- /#wrapper -->



    <!-- <div id="container">
        <div class="container-fluid">
            <div class="card mb-3">
                <div class="card-header">
                  <i class="fas fa-table"></i>
                  Data Table
                </div>
                <div class="card-body">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                     <thead>
                      <tr>
                        <th>Author</th>
                        <th>Text</th>
                        <th>Created_at</th>
                      </tr>
                     </thead>
                     <tbody>
                       @foreach ($datas as $data)
                        <tr>
                            <td>{{ $data->author }}</td>
                            <td>{{ $data->text }}</td>
                            <td>{{ $data->created_at }}</td>
                        </tr>
                        @endforeach
                     </tbody>
                        
                    </table>


                </div>

            </div>
        </div>
    </div> -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/sb-admin/jquery/jquery.min.js"></script>
    <script src="vendor/sb-admin/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/sb-admin/jquery-easing/jquery.easing.min.js"></script>

    <!-- Page level plugin JavaScript-->
    <script src="vendor/sb-admin/chart.js/Chart.min.js"></script>
    <script src="vendor/sb-admin/datatables/jquery.dataTables.js"></script>
    <script src="vendor/sb-admin/datatables/dataTables.bootstrap4.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin/sb-admin.min.js"></script>

  </body>

</html>
