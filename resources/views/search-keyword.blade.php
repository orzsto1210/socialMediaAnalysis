@extends('layouts.app')

@section('content')

<div class="container">
    <h1>Search Keyword</h1>
    <form action="/search-keyword" method="GET">
		{{ csrf_field() }}
        <div class="input-group">
            <input type="search" name="search" class="form-control" placeholder="Default Search: ai">
            <span class="input-group-prepend">
                <button type="summit" class="btn btn-primary">Search</button>
            </span>
        </div>
    </form>
</div>
<br>
<div class="container">
	<table >
        @foreach($keywords as $keyword)
        <tr>
            <td>{{ $keyword['keyword'] }}</td>
        </tr>
        @endforeach
	</table>

</div>

@endsection
