<html>
	<head>
		<title>学生管理展示</title>
	</head>
	<link rel="stylesheet" type="text/css" href="{{asset('css/page.css')}}">
	<body>
		<table border="=1">
			<tr>
				<td>ID</td>
				<td>调研项目</td>
				<td>操作</td>
			</tr>
			@if($data)
			@foreach($data as $v)
			<tr>
				<td>{{$v->diao_id}}</td>
				<td>{{$v->diao_name}}</td>
				<td>
					<a href="#">启用</a>
					<a href="del/{{$v->diao_id}}">删除</a>
				</td>
			</tr>
			@endforeach
			@endif
		</table>
		{{$data->links()}}
	</body>
</html>