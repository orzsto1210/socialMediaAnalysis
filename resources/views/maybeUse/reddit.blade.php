<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Social Media Analysis - Dashboard</title>

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

      <!-- Sidebar -->
      <ul class="sidebar navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="{{ url('/') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
          </a>
        </li>
        <li class="nav-item active">
          <a class="nav-link" href="{{ url('/reddit') }}">
            <i class="fas fa-fw fa-table"></i>
            <span>Reddit</span></a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-fw fa-filter"></i>
            <span>Time Filter</span>
          </a>
          <div class="dropdown-menu" aria-labelledby="pagesDropdown">
            <form>
              <input type="radio" name="timefilter" value="a_week" checked="true"> A week<br>
              <input type="radio" name="timefilter" value="two_weeks"> Two weeks<br>
              <input type="radio" name="timefilter" value="a_month"> A month<br>
            </form>
          </div>
        </li>
        
      </ul>

      <div id="content-wrapper">

        <div class="container-fluid">

          <!-- Bar Chart Example-->
          <div class="card mb-3">
            <div class="card-header">
              <i class="fas fa-chart-area"></i>
              Hot Keyword - Reddit
            </div>
            <!-- <div class="card-body"> -->
              <div id="viz-reddit" style="width:auto;height:400px;"></div>
            <!-- </div> -->
          </div>
          <div id="tree_map" style="width:auto;height:400px;"></div>

        </div>

      </div>
      <!-- /.content-wrapper -->

    </div>
    <!-- /#wrapper -->

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

    <!-- Demo scripts for this page-->
    <script src="js/sb-admin/demo/chart-area-demo.js"></script>
    <script src="js/sb-admin/demo/chart-bar-demo.js"></script>
    <script src="js/sb-admin/demo/chart-pie-demo.js"></script>

    <script src="https://d3plus.org/js/d3.js"></script>
    <script src="https://d3plus.org/js/d3plus.js"></script>
    <!-- Reddit Bar Chart -->
    <script>
        var data = {!!$reddit_keywords!!}
        var visualization = d3plus.viz()
            .container("#viz-reddit")
            .data(data)
            .type("bar")
            .id("keyword")
            .x("time")
            .y("count")
            .draw()

    </script>

    <script>
      var data = [
      {id: "ai", x: "2018-09-01", y:  80},
      {id: "iot", x: "2018-09-01", y: 50},
      {id: "block chain", x: "2018-09-01", y: 13},
      {id: "amp",  x: "2018-09-01", y: 17},
      {id: "ai", x: "2018-09-02", y:  60},
      {id: "iot", x: "2018-09-02", y: 80},
      {id: "block chain", x: "2018-09-02", y: 25},
      {id: "amp",  x: "2018-09-02", y: 34},
      {id: "ai", x: "2018-09-03", y:  57},
      {id: "iot", x: "2018-09-03", y: 33},
      {id: "block chain", x: "2018-09-03", y: 46},
      {id: "amp",  x: "2018-09-03", y: 22},
      {id: "ai", x: "2018-09-04", y:  88},
      {id: "iot", x: "2018-09-04", y: 77},
      {id: "block chain", x: "2018-09-04", y: 66},
      {id: "amp",  x: "2018-09-04", y: 55}
      ]
        
      var visualization = d3plus.viz()
          .container("#tree_map")
          .data(data)
          .type("tree_map")
          .id("id")
          .size("y")
          .time({
            "value": "x",
            "solo": "2018-09-01"
          })
          .mouse({                
          "move": true,                  // key will also take custom function
          "click": function(d){location.href= '/keyword_show?keyword_or_author=' + d.id }   
          })        
          .draw()
    </script>



  </body>

</html>
