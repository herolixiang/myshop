<body>
  <div class="content">
      <h3>商品库存管理</h3>
      @if ($errors->any())
      <div class="alert alert-danger">
      <ul>
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
      </ul>
      </div>
      @endif
      <form action="/brand/add_do" method="post" enctype="multipart/form-data">
          @csrf
          <div>
            货物名称：<input type="text" name="brand_name">
          </div>
          <div>
            货物图片：<input type="file" name="brand_logo">
          </div>
          <div>
            库存：<input type="text" name="brand_pid">
          </div>
          <p><button>提交</button></p>
      </form>
  </div>
</body>