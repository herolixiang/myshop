<form action="{{url('/ku/login_do')}}" method="post">
	<table border="1" width="500">
<!-- 		<caption>管理员登录页面</caption> -->
        @csrf
		<p>
			用户名
			<input type="text" name="ku_name">
		</p>
		<p>
			密码
			<input type="password" name="ku_pwd">
		</p>
		<button>登录</button>
		
	</table>
</form>