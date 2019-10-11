<body>
  <div class="content">
      <h3>信息修改</h3>
     <!--  @if ($errors->any())
      <div class="alert alert-danger">
      <ul>
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
      </ul>
      </div>
      @endif -->
      <form action="/user/update" method="post" enctype="multipart/form-data">
          <input type="hidden" name="user_id" value="{{$data->user_id}}">
          @csrf
          <div>
            用户名：<input type="text" name="user_name" value="{{$data->user_name}}">
          </div>
          <div>
            电话：<input type="tel" name="user_tel" value="{{$data->user_tel}}">
          </div>
          <div>
            地址：<input type="text" name="user_dizhi" value="{{$data->user_dizhi}}">
          </div>
          <div>
            年龄：<input type="text" name="user_nian" value="{{$data->user_nian}}">
          </div>
          <p>
          <input type="submit" class="btn" value="提交">
          </p>
      </form>
  </div>
</body>