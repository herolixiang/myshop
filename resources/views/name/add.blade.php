<body>
  <div class="content">
      <h3>用户管理</h3>
      <form action="/name/add_do" method="post" enctype="multipart/form-data">
          @csrf
          <div>
            用户名称：<input type="text" name="name">
          </div>
          <div>
             用户年龄：<input type="text" name="nian">
          </div>
          <div>
             用户地址：<input type="text" name="content">
          </div>
          <p><button>提交</button></p>
      </form>
  </div>
</body>