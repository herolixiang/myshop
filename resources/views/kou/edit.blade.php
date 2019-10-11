<body>
  <div class="content">
      <h3>用户详情页</h3>
      <form action="/kou/update" method="post" enctype="multipart/form-data">
      <input type="hidden" name="id" value="{{$data->id}}">
          @csrf
          <div>
            用户标识:<input type="text" name="openid" value="{{$data->openid}}">
          </div>
          <div>
            用户名称:<input type="text" name="nickname" value="{{$data->nickname}}">
          </div>
          <div>
            用户性别:<input type="text" name="sex" value="{{$data->sex}}">
          </div>
          <div>
            用户城市:<input type="text" name="country" value="{{$data->country}}">
          </div>
          <div>
            用户头像:<img src="{{$data->headimgurl}}" width="100">
          </div>
      </form>
  </div>
</body>