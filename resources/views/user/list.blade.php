<html>
	<head>
		<title>用户信息展示</title>
	</head>
	<link rel="stylesheet" type="text/css" href="{{asset('css/page.css')}}">
	<body>
		<form>
			<input type="text" name="user_name" value="{{$query['user_name']??''}}" placeholder="请输入名称关键字">
			<input type="text" name="user_nian" value="{{$query['user_nian']??''}}" placeholder="请输入年龄关键字">
			<button>搜索</button>
		</form>
		<table border="=1">
			<tr>
				<td>ID</td>
				<td>用户名称</td>
				<td>电话</td>
				<td>地址</td>
				<td>年龄</td>
				<td>操作</td>
			</tr>
			@if($data)
			@foreach($data as $v)
			<tr>
				<td>{{$v->user_id}}</td>
				<td><img src="{{config('app.img_url')}}{{$v->user_logo}}" width="100"></td>
				<td>{{$v->user_name}}</td>
				<td>{{$v->user_tel}}</td>
				<td>{{$v->user_dizhi}}</td>
				<td>{{$v->user_nian}}</td>
				<td>
					<a href="{{url('/user/edit',['id'=>$v->user_id])}}">修改</a>
					<a href="del/{{$v->user_id}}">删除</a>
				</td>
			</tr>
			@endforeach
			@endif
		</table>
		{{$data->appends($query)->links()}}
	</body>
</html>