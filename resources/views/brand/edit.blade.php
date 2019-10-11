<body>
  <div class="content">
      <h3>商品库存管理修改</h3>
     <!--  @if ($errors->any())
      <div class="alert alert-danger">
      <ul>
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
      </ul>
      </div>
      @endif -->
      <form action="/brand/update" method="post" enctype="multipart/form-data">
      <input type="hidden" name="brand_id" value="{{$data->brand_id}}">
          @csrf
          <div>
            货物名称：<input type="text" name="brand_name" value="{{$data->brand_name}}">
          </div>
          <div>
            货物图片：<input type="file" name="brand_logo" value="{{$data->brand_logo}}">
          </div>
          <div>
            库存：<input type="text" name="brand_pid" value="{{$data->brand_pid}}">
          </div>
          <p><button>修改</button></p>
      </form>
  </div>
</body>