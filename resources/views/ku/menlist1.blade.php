<!DOCTYPE html>
<html>
<head>
	<title>车库管理系统-车辆入库</title>
</head>
<body>
	<center>
        <h3>车辆入库</h3>
		<form action="{{url('ku/menlist1_do')}}" method="post">
        @csrf
            车牌号：<input type="text" name="ku1_name">
            <p><input type="submit" value="车辆进入"></p>
        </form>
	</center>
</body>
</html>