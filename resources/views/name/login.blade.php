<form action="{{url('/name/login_do')}}" method="post">
	<h3>用户登入</h3>
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