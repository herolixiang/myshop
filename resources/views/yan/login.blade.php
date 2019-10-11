<form action="{{url('/yan/login_do')}}" method="post">
	<h3>欢迎使用hAdmin</h3>
	<table border="1" width="500">
<!-- 		<caption>管理员登录页面</caption> -->
        @csrf
		<p>
			用户名
			<input type="text" name="yan_name">
		</p>
		<p>
			密码
			<input type="password" name="yan_pwd">
		</p>
		<button>登录</button>
		
	</table>
</form>