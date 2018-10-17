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
    </nav>

    <div id="wrapper">

      <!-- Sidebar -->
      <!-- <ul class="sidebar navbar-nav toggled">
        <li class="nav-item active">
          <a class="nav-link" href="{{ url('/') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Overview</span>
          </a>
        </li>       
      </ul> -->

      <div id="content-wrapper">
        <div class="container-fluid">
          <!-- Tree map Chart-->
            <div class="card mb-3">
              <div class="card-header">
                <h2>Hot Keyword</h2>
              </div>
              <div id="tree_map" style="width:auto;height:300px;"></div>
            </div>

          <div class="row">
            <div class="col-lg-10">
              <div class="card mb-3">
                <div class="card-header">
                  <h2>Hot Author</h2>
                </div>
                <div id="circle" style="width:auto;height:700px;"></div>
              </div>
            </div>
          </div>
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

    <!-- D3 Plus -->
    <!-- <script src="https://d3plus.org/js/d3.js"></script> -->
    <!-- <script src="https://d3plus.org/js/d3plus.js"></script> -->
    <script src="https://d3plus.org/js/d3plus.v2.0.0-alpha.17.full.min.js"></script>
    <script src="https://d3plus.org/js/d3plus-hierarchy.v0.7.full.min.js"></script>

    <script>
      var data = {!!$keywords!!}
      new d3plus.Treemap()
        .data(data)
        .groupBy("keyword")
        .select("#tree_map")
        .tooltipConfig({
          body: function(d) {
            var table = "<table class='tooltip-table'>";
            table += "<tr><td class='title'>Value:</td><td class='data'>" + d.count + "</td></tr>";
            table += "</table>";
            return table;
          },
          title: function(d) {
            var txt = d.keyword;
            return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();;
          }
        })
        .shapeConfig({
          labelConfig: {
            fontFamily: "serif",
            fontMax: 100
          }
        })
        .on("click", function(d) {
            location.href= '/keyword_show?keyword=' + d.keyword
          })
        .time("created_at")
        .sum("count")
        .render();

    </script>

    <script>
      //  var data = [
      //  {"time":"2018-07-01","id":"Apple","value":1.5,"parent":"twitter"},
      //  {"time":"2018-07-02","id":"Banana","value":1.2,"parent":"twitter"},
      //  {"time":"2018-07-03","id":"Cat","value":1.3,"parent":"twitter"},
      //  {"time":"2018-07-04","id":"Dog","value":1.1,"parent":"twitter"},
      //  {"time":"2018-07-05","id":"Egg","value":1,"parent":"twitter"},
      //  {"time":"2018-07-01","id":"Food","value":6,"parent":"reddit"},
      //  {"time":"2018-07-02","id":"Gerge","value":5,"parent":"reddit"},
      //  {"time":"2018-07-03","id":"Hamburger","value":4,"parent":"reddit"},
      //  {"time":"2018-07-04","id":"Ice","value":3,"parent":"reddit"},
      //  {"time":"2018-07-05","id":"Joyce","value":2,"parent":"reddit"}
      //  ];
      var data = {!!$authors!!}
      new d3plus.Pack()
        .data(data)
        .select("#circle")
        .groupBy(["parent","id"])
        .sum("value")
        .on("click", function(d) {
          if ( d.parent == undefined )
            location.href= '/';
          else
            location.href= '/author_show?tag=' + d.parent + '&author=' + d.id;
        })
        .time("time")
        .render();

    </script>

  </body>

</html>
