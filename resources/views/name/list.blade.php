<html>
	<head>
		<title>用户管理展示</title>
	</head>
	<link rel="stylesheet" type="text/css" href="{{asset('css/page.css')}}">
	<body>
		<form>
			<input type="text" name="name" value="{{$query['name']??''}}" placeholder="请输入用户名称关键字">
			<input type="text" name="nian" value="{{$query['nian']??''}}" placeholder="请输入年龄关键字">
			<button>搜索</button>
		</form>
		<table border="=1">
			<tr>
				<td>ID</td>
				<td>用户名称</td>
				<td>用户年龄</td>
				<td>用户地址</td>
				<td>添加时间</td>
				<td>操作</td>
			</tr>
			@if($data)
			@foreach($data as $v)
			<tr>
				<td>{{$v->id}}</td>
				<td>{{$v->name}}</td>
				<td>{{$v->nian}}</td>
				<td>{{$v->content}}</td>
				<td>{{date('Y-m-d H:i:s',$v->time)}}</td>
				<td>
					<a href="{{url('/name/edit',['id'=>$v->id])}}">修改</a>
					<a href="del/{{$v->id}}">删除</a>
				</td>
			</tr>
			@endforeach
			@endif
		</table>
		{{$data->appends($query)->links()}}
	</body>
</html>