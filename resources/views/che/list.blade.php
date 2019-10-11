<html>
	<head>
		<title>学生管理展示</title>
	</head>
	<link rel="stylesheet" type="text/css" href="{{asset('css/page.css')}}">
	<body>
	    <form>
			<input type="text" name="che_di" value="{{$query['che_di']??''}}" placeholder="请输入出发地关键字">
			<input type="text" name="che_dao" value="{{$query['che_dao']??''}}" placeholder="请输入到达地关键字">
			<button>搜索</button>
		</form>
		<table border="=1">
			<tr>
				<td>ID</td>
				<td>车次</td>
				<td>出发地</td>
				<td>到达地</td>
				<td>价钱</td>
				<td>张数</td>
				<td>操作</td>
			</tr>
			@if($data)
			@foreach($data as $v)
			<tr>
				<td>{{$v->che_id}}</td>
				<td>{{$v->che_chi}}</td>
				<td>{{$v->che_di}}</td>
				<td>{{$v->che_dao}}</td>
				<td>{{$v->che_jia}}</td>
				<td>
					@if($v->che_zhang == 0)
						无可够
					@elseif($v->che_zhang >= 100)
						有
					@else
						{{$v->che_zhang}}
					@endif
				</td>
				<td>
					@if($v->che_zhang == 0)
			           <a href="" style="color:black;">预约</a>
			        @elseif($v->che_zhang>0)
			           <a href="{{url('/che/edit',['id'=>$v->che_id])}}" style="color:red;">预约</a>
			        @endif
				</td>
			</tr>
			@endforeach
			@endif
		</table>
		{{$data->appends($query)->links()}}
	</body>
</html>