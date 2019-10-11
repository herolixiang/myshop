<html>
	<head>
		<title>学生管理展示</title>
	</head>
	<link rel="stylesheet" type="text/css" href="{{asset('css/page.css')}}">
	<body>
	    <form>
			<input type="text" name="stu_name" value="{{$query['stu_name']??''}}" placeholder="请输入学生名称关键字">
			<input type="text" name="stu_nian" value="{{$query['stu_nian']??''}}" placeholder="请输入学生年龄关键字">
			<button>搜索</button>
		</form>
		<table border="=1">
			<tr>
				<td>ID</td>
				<td>学生姓名</td>
				<td>学生性别</td>
				<td>学生年龄</td>
				<td>学生地址</td>
				<td>操作</td>
			</tr>
			@if($data)
			@foreach($data as $v)
			<tr>
				<td>{{$v->stu_id}}</td>
				<td>{{$v->stu_name}}</td>
				<td>{{$v->stu_xing}}</td>
				<td>{{$v->stu_nian}}</td>
				<td>{{$v->stu_di}}</td>
				<td>
					<a href="{{url('/stu/edit',['id'=>$v->stu_id])}}">修改</a>
					<a href="del/{{$v->stu_id}}">删除</a>
				</td>
			</tr>
			@endforeach
			@endif
		</table>
		{{$data->appends($query)->links()}}
	</body>
</html>