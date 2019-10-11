<html>
<body>
  <div class="content">
      <h3>用户管理</h3>
      @if ($errors->any())
      <div class="alert alert-danger">
      <ul>
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
      </ul>
      </div>
      @endif
      <form action="/user/add_do" method="post" enctype="multipart/form-data">
          <meta name="csrf-token" content="{{ csrf_token() }}">
          @csrf
          <div>
            用户logo：<input type="file" name="user_logo">
          </div>
          <div>
            用户名：<input type="text" name="user_name">
          </div>
          <div>
            电话：<input type="tel" name="user_tel">
          </div>
         <div>
           地址：
              <div class="lrList">
                <select class="changearea" id="province">
                 <option value="0" selected="selected">--请选择省市--</option>
                 @if($provinceInfo)
                 @foreach($provinceInfo as $v)
                    <option value="{{$v->id}}">{{$v->name}}</option>
                 @endforeach
                 @endif
                </select>
              </div>
            
              <div class="lrList">
                <select class="changearea" id="city">
                 <option value="0" selected="selected">--请选择市--</option>
                </select>
              </div>

              <div class="lrList">
                <select class="changearea" id="area">
                 <option value="0" selected="selected">--请选择县区--</option>
                </select>
              </div>
         </div>

          <div>
            年龄：<input type="text" name="user_nian">
          </div>
          <p><button>提交</button></p>
      </form>
  </div>
</body>
</html>
<script src="/index/js/jquery.min.js"></script>
<script>
  $(function(){
    // alert(123);
    // //内容改变
    $('.changearea').change(function() {
      var _this=$(this);
      // _this.nextAll('select').html("<option value='0'>--请选择--</option>");
      var id=_this.val();
      // console.log(id);
       $.ajaxSetup({
       headers: {
       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       }
      });
      $.post(
        "{{url('/user/getArea')}}",
        {id:id},
        function(res){
          // console.log(res);
          var _option="<option value='0'>--请选择--</option>";
          for (var i = 0;i<res.length; i++) {
            _option+="<option value='"+res[i]['id']+"'>"+res[i]['name']+"</option>"
          }
          // console.log(_option);
          // _this.next('select').html(_option);
          _this.parent("div[class='lrList']").next("div").children('select').html(_option);
        },
        'json'
      );
    })
  });
</script>