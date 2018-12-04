<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Social Media Analysis</title>
    
    <!-- Bootstrap core CSS-->
    <link href="vendor/sb-admin/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template-->
    <link href="vendor/sb-admin/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    
    <!-- Page level plugin CSS-->
    <link href="vendor/sb-admin/datatables/dataTables.bootstrap4.css" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin/sb-admin.css" rel="stylesheet">

    <style>
      
    
    </style>

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
          <div class="card mb-3">
            <div class="card-header">
              <h2>Hot Keyword</h2>
            </div>
            <div id="tree_map" style="width:auto;height:450px;"></div>
          </div>

          <div class="row" >

            <div class="col-lg-6">
              <div class="card mb-3">
                <div class="card-header">
                  <h2>Hot Author</h2>
                </div>
                <div id="pack" style="width:auto;height:400px;"></div>
              </div>
            </div>
    
            <div class="col-lg-6">
              <div class="card mb-3">
                <div class="card-header">
                  <h2>該作者常發關鍵字</h2>
                </div>
                <div id="block" style="width:auto;height:350px;"></div>
              </div>
              <div id="detail" style="display:none">
                <h3><a id="detail_link" href="">more detail...</a></h3>
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
    <script src="https://d3js.org/d3.v5.js"></script>
    <script src="https://d3plus.org/js/d3plus.v2.0.0-alpha.17.full.min.js"></script>
    <script src="https://d3plus.org/js/d3plus-hierarchy.v0.7.full.min.js"></script>

    <script>
      var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
      var data = {!!$keywords!!}
      var pack = new d3plus.Pack().select("#pack");
      // var block = new d3plus.Treemap().select("#block");
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
            // ,
            // text: function(d) {
            //   return d.keyword.toUpperCase() ;
            // }
          }
          
        })
        .on("click", function(d) {
          $.ajax({
            type: "POST",
            url: '/keyword_authors',
            data: {_token: CSRF_TOKEN,  word: d.keyword },
              success: function (data){ 
                document.getElementById("detail").style.display='block';
                document.getElementById("detail_link").href = "/keyword_show?keyword=" + d.keyword;
                keyword_authors(data);
              },
              error: function(xhr, ajaxOptions, thrownError){
                alert(xhr.responseText);
              }
          });
        })
        .time("created_at")
        .sum("count")
        .render();
        

        function keyword_authors(_data){
          pack
            .data(_data)
            .groupBy(["parent","id"])
            .sum("value")
            .on("click", function(d) {
              $.ajax({
                type: "POST",
                url: '/author_keywords',
                data: {_token: CSRF_TOKEN,  word: d.id },
                  success: function (data){ 
                    author_keywords(data);
                  },
                  error: function(xhr, ajaxOptions, thrownError){
                    alert(xhr.responseText);
                  }
              });
            })
            .time("time")
            .render();
        }

        function author_keywords(_data){
          console.log(_data);
          d3.select("#block").selectAll("svg").remove();
          new d3plus.Treemap()
            .select("#block")
            .data(_data)
            .groupBy("keyword")
            .time("time")
            .sum("value")
            .render();
        }

    </script>

    <!-- <script>
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
    </script> -->

  </body>

</html>



















































