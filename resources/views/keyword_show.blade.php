@extends('layouts.dashboard')

@section('content')


	<div class="card-header">
              <i class="fas fa-chart-area"></i>
              AI</div>
    <div class="card-body">

	<canvas id="myChart" width="100%" height="30">
	

		<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>

		<script>

			var ctx = document.getElementById('myChart').getContext('2d');

			var chart = new Chart(ctx, {
		    	type: 'bar',
		    	data: {
		        	labels: ["2018-05", "2018-06", "2018-07"],
			        datasets: [{
			            label: 'Pos',
			            data: [67.57205773863085, 77.79837000104902, 71.2590571535965],

			            backgroundColor: [
			                'rgba(255, 99, 132, 0.2)',
			                'rgba(255, 99, 132, 0.2)',
			                'rgba(255, 99, 132, 0.2)'
			                
			            ],
			            borderColor: [
			                'rgba(255,99,132,1)',
			                'rgba(255,99,132,1)',
			                'rgba(255,99,132,1)'	 
			                
			            ]

			        },
			        {
			            label: 'Neg',
			            data: [32.427942261369154, 22.201629998950978, 28.7409428464035],


			            backgroundColor: [
			                
			                'rgba(54, 162, 235, 0.2)',
			                'rgba(54, 162, 235, 0.2)',
			                'rgba(54, 162, 235, 0.2)'
			        
			            ],
			            borderColor: [
			                
			                'rgba(54, 162, 235, 1)',
			                'rgba(54, 162, 235, 1)',
			                'rgba(54, 162, 235, 1)'
			                
			            ]

			        }]
			    }
			});

		</script>
	
	</canvas>


@endsection
