<html>
<head>
	<title></title>
</head>
<body>
	<center>
        <h3>车位信息</h3>
		<form action="{{url('ku/cheadd_do')}}" method="post">
        @csrf
            车位数：<input type="text" name="ku2_liang">
            <p><input type="submit" value="车位添加"></p>
        </form>
	</center>
</body>
</html>