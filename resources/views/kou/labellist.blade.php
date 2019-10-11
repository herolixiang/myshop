<html>
	<head>
		<title>标签列表展示</title>
	</head>
	<body>
        <h3><a href="{{url('/kou/labeladd')}}">添加标签</a></h3>
        <h3></h3>
		<table border="=1">
			<tr>
				<td>ID</td>
				<td>标签id</td>
				<td>标签内容</td>
                <td>此标签下粉丝数</td>
				<td>操作</td>
			</tr>
			@if($data)
			@foreach($data as $v)
			<tr>
				<td>{{$v->b_id}}</td>
				<td>{{$v->label_id}}</td>
                <td>{{$v->label_name}}</td>
                <td>5</td>
				<td>
					<a href="{{url('/kou/labeldel')}}?id={{$v->b_id}}">删除</a>||
                    <a href="{{url('/kou/labelfans',['id'=>$v->b_id])}}">为粉丝打标签</a>||
					<a href="{{url('/kou/newsadd')}}">推送</ a>
				</td>
			</tr>
			@endforeach
			@endif
		</table>
	</body>
</html>