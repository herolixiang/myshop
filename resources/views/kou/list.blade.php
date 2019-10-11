<html>
	<head>
		<title>粉丝列表</title>
	</head>
	<link rel="stylesheet" type="text/css" href="{{asset('css/page.css')}}">
	<body>
		<table border="=1">
			<tr>
				<td>ID</td>
				<td>用户标识</td>
				<td>用户名称</td>
				<td>用户性别</td>
				<td>用户城市</td>
				<td>用户头像</td>
				<td>关注时间</td>
				<td>操作</td>
			</tr>
			@if($data)
			@foreach($data as $v)
			<tr>
				<td>{{$v->id}}</td>
				<td>{{$v->openid}}</td>
				<td>{{$v->nickname}}</td>
				<td>
					@if($v->sex=='1')
						男
					@else
						女
					@endif
				</td>
				<td>{{$v->country}}.{{$v->province}}.{{$v->city}}</td>
				<td><img src="{{$v->headimgurl}}" width="100"></td>
				<td>{{date('Y-m-d H:i:s',$v->time)}}</td>
				<td>
					<a href="{{url('/kou/edit',['id'=>$v->id])}}">用户详情页</a>
					<a href="del/{{$v->id}}">删除</a>
				</td>
			</tr>
			@endforeach
			@endif
		</table>
		{{$data->links()}}
	</body>
</html>