<body>
  <div class="content">
      <h3>用户管理</h3>
      <form action="/name/update" method="post" enctype="multipart/form-data">
      <input type="hidden" name="id" value="{{$data->id}}">
          @csrf
          <div>
            用户名称：<input type="text" name="name" value="{{$data->name}}">
          </div>
          <div>
             用户年龄：<input type="text" name="nian" value="{{$data->nian}}">
          </div>
          <div>
             用户地址：<input type="text" name="content" value="{{$data->content}}">
          </div>
          <p><button>修改</button></p>
      </form>
  </div>
</body>