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

    <style>
      body {font-family: Arial;}

      /* Style the tab */
      .tab {
          overflow: hidden;
          border: 1px solid #ccc;
          background-color: #f1f1f1;
      }

      /* Style the buttons inside the tab */
      .tab button {
          background-color: inherit;
          float: left;
          border: none;
          outline: none;
          cursor: pointer;
          padding: 10px 9px;
          transition: 0.3s;
          font-size: 15px;
      }

      /* Change background color of buttons on hover */
      .tab button:hover {
          background-color: #ddd;
      }

      /* Create an active/current tablink class */
      .tab button.active {
          background-color: #ccc;
      }

      /* Style the tab content */
      .tabcontent {
          display: none;
          padding: 6px 12px;
          border: 1px solid #ccc;
          border-top: none;
      }
    </style>
    
  </head>

  <body id="page-top">

    <nav class="navbar navbar-expand navbar-dark bg-dark static-top">
      <a class="navbar-brand mr-1" href="{{ url('/') }}">Social Media Analysis</a>
    </nav>

    <div id="wrapper">
      <div id="content-wrapper">        
        <div class="container-fluid">

          <ol class="breadcrumb">
            <li class="breadcrumb-item">{{$keyword}}</li>
            <li class="breadcrumb-item">{{$start_time}}~{{$end_time}}</li>
          </ol>

          <div class="row">
            <div class="col-lg-2">
              <div class="tab">
                <button class="tablinks" onclick="openCity(event, 'Day')" id="defaultOpen">Day</button>
                <button class="tablinks" onclick="openCity(event, 'Week')">Week</button>
                <button class="tablinks" onclick="openCity(event, 'Month')">Month</button>
              </div>

              <div id="Day" class="tabcontent">
                <h4>Day</h4>
                <form>
                  <input type="hidden" name="keyword" value="{{$keyword}}">
                  <input type="hidden" name="filter" value="D">
                  <p>Start:
                    <select name="start_time">
                      @foreach($day_time as $t)
                        <option value="{{$t->time}}">{{$t->time}}</option>
                      @endforeach
                    </select>
                  </p>
                  <p>End:
                      <select name="end_time">
                      @foreach($day_time as $t)
                        <option value="{{$t->time}}">{{$t->time}}</option>
                      @endforeach
                      </select>
                  </p>
                  <input class="btn btn-primary" type="submit" value="OK">
                </form>
              </div>

              <div id="Week" class="tabcontent">
                <h4>Week</h4>
                <form>
                  <input type="hidden" name="keyword" value="{{$keyword}}">
                  <input type="hidden" name="filter" value="W">
                  <p>Start:
                    <select name="start_time">
                      @foreach($week_time as $t)
                        <option value="{{$t->time}}">{{$t->time}}</option>
                      @endforeach
                    </select>
                  </p>
                  <p>End:
                    <select name="end_time">
                      @foreach($week_time as $t)
                        <option value="{{$t->time}}">{{$t->time}}</option>
                      @endforeach
                    </select>
                  </p>
                  <input class="btn btn-primary" type="submit" value="OK">
                </form>
              </div>

              <div id="Month" class="tabcontent">
                <h4>Month</h4>
                <form>
                  <input type="hidden" name="keyword" value="{{$keyword}}">
                  <input type="hidden" name="filter" value="M">
                  <p>Start:
                    <select name="start_time">
                      @foreach($month_time as $t)
                        <option value="{{$t->time}}">{{$t->time}}</option>
                      @endforeach
                    </select>
                  </p>
                  <p>End:
                    <select name="end_time">
                      @foreach($month_time as $t)
                        <option value="{{$t->time}}">{{$t->time}}</option>
                      @endforeach
                    </select>
                  </p>
                  <input class="btn btn-primary" type="submit" value="OK">
                </form>
              </div>
            </div>
            <!-- Senti Chart-->
            <!-- Reddit -->
            <div class="col-lg-5">
              <div class="card mb-3">
                <div class="card-header">
                  <h3>Sentiment - Reddit - {{$keyword}}</h3>
                </div>
                <div id="senti_reddit" style="width:auto;height:400px;"></div>
              </div>
            </div>
            <!-- Twitter -->
            <div class="col-lg-5">
              <div class="card mb-3">
                <div class="card-header">
                  <h3>Sentiment - Twitter - {{$keyword}}</h3>
                </div>
                <div id="senti_twitter" style="width:auto;height:400px;"></div>
              </div>
            </div>
          </div>
          <!-- Google Trend Chart -->
          <div class="card mb-3">
            <div class="card-header">
              <h3>Google Trend - Reddit&Twitter</h3>
            </div>
            <div id="google_trend" style="width:auto;height:500px;"></div>
          </div>
        </div>       
      </div>
    </div>
    <!-- /#wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>

	<!-- script -->
  <script>
    function openCity(evt, cityName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(cityName).style.display = "block";
        evt.currentTarget.className += " active";
    }

    // Get the element with id="defaultOpen" and click on it
    document.getElementById("defaultOpen").click();
  </script>

	<!-- <script src="https://d3plus.org/js/d3.js"></script> -->
  <!-- <script src="https://d3plus.org/js/d3plus.js"></script> -->
  <script src="https://d3plus.org/js/d3plus.v2.0.0-alpha.17.full.min.js"></script>

	<script>
		var data = {!!$senti_reddit_datas!!};
    new d3plus.BarChart()
      .select("#senti_reddit")
      .data(data)
      .groupBy("pos_or_neg")
      .x("time")
      .y("value")
      .stacked(true)
      .tooltipConfig({
          body: function(d) {
            var table = "<table class='tooltip-table'>";
            table += "<tr><td class='data'>" + d.value + "%</td></tr>";
            table += "</table>";
            return table;
          }
      })
      .barPadding(0)
      .render();
	</script>

  <script>
		var data = {!!$senti_twitter_datas!!};
    new d3plus.BarChart()
      .select("#senti_twitter")
      .data(data)
      .groupBy("pos_or_neg")
      .x("time")
      .y("value")
      .stacked(true)
      .tooltipConfig({
          body: function(d) {
            var table = "<table class='tooltip-table'>";
            table += "<tr><td class='data'>" + d.value + "%</td></tr>";
            table += "</table>";
            return table;
          }
      })
      .barPadding(0)
      .render();
	</script>

	<script>
    // const twitterhight = {!!$twitterhight!!}.map( item=> Object.values(item)[0])[0] ;
    // const reddithight = {!!$reddithight!!}.map( item=> Object.values(item)[0])[0] ;
    // console.log({!!$end_time!!})
    const arrayToObject = (array) =>
      array.reduce((obj) => {
      obj[item] = item
      return obj
    }, {})

    // const event_datas = arrayToObject(event_datas)
    // console.log(event_datas)
    // var_dump($event_datas)
    
    var data = {!!$event_datas!!};
    for(var i = 0 ; i < data.length ; i++  ) {
      data[i].Discussion = parseFloat(data[i].Discussion);
    }
    
    new d3plus.LinePlot()
    .select("#google_trend")
    .data(data)
    .groupBy("tag")
    .x("time")
    .y("Discussion")
    .shapeConfig({
      Line: {
        strokeWidth: 4
      }
    })
    .tooltipConfig({
      body: function(d) {
        if ( d.tag == 'twitter' ) {
          var tokens = d.top_event.split(' ');
          delete tokens[tokens.length - 1];
          return "Top_event: " + tokens.join(' ');
        }
        else
          return "Top_event:" + d.top_event;
      }
    })
    .on("click", function(d) {
      if ( d.tag == 'twitter' ) {
        var tokens = d.top_event.split(' ');
        location.href = tokens[tokens.length - 1];
      }
      else
        location.href = '/data_show?event='+ d.top_event;
    })
    .render();

	</script>
  
  
<!-- {!!$event_datas!!} -->


  </body>
  
</html>
