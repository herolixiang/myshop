<html>
	<head>
		<title>商品库存管理展示</title>
	</head>
	<link rel="stylesheet" type="text/css" href="{{asset('css/page.css')}}">
	<body>
	    <form>
			<input type="text" name="huo_name" value="{{$query['huo_name']??''}}" placeholder="请输入货物名称关键字">
			<input type="text" name="huo_ku" value="{{$query['huo_ku']??''}}" placeholder="请输入货物库存关键字">
			<button>搜索</button>
		</form>
		<table border="=1">
			<tr>
				<td>ID</td>
				<td>货物名称</td>
				<td>货物图片</td>
				<td>货物库存</td>
				<td>添加时间</td>
				<td>操作</td>
			</tr>
			@if($data)
			@foreach($data as $v)
			<tr>
				<td>{{$v->huo_id}}</td>
				<td>{{$v->huo_name}}</td>
				<td><img src="{{config('app.img_url')}}{{$v->huo_logo}}" width="100"></td>
				<td>{{$v->huo_ku}}</td>
				<td>{{date('Y-m-d H:i:s',$v->huo_time)}}</td>
				<td>
					<a href="{{url('/huo/edit',['id'=>$v->huo_id])}}">修改</a>
					<a href="del/{{$v->huo_id}}">删除</a>
				</td>
			</tr>
			@endforeach
			@endif
		</table>
		{{$data->appends($query)->links()}}
	</body>
</html>