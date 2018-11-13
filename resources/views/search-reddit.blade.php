@extends('layouts.app')

@section('content')
<div class="container">
	<h1>Search Reddit Data</h1>
    <form action="/search-reddit" method="GET">
		{{ csrf_field() }}
        <div class="input-group">
            <input type="search" name="search" class="form-control" placeholder="Search">
            <span class="input-group-prepend">
                <button type="summit" class="btn btn-primary">Search</button>
            </span>
        </div>
    </form>
</div>
<br>
<div class="container">
	<table border="1">
		<th>Author</th>
		<th>Title</th>
		<th>Created_at</th>
		@foreach ($datas as $data)
		<tr>
			<td>{{ $data->author }}</td>
			<td>{{ $data->title }}</td>
			<td>{{ $data->created_at }}</td>
		</tr>
		@endforeach
	</table>

	{{ $datas->links() }}
</div>
@endsection
