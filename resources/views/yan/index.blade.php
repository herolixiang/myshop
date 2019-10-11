<body>
  <div class="content">
      <h3>留言板</h3>
      <form action="/yan/add_do" method="post" enctype="multipart/form-data">
          @csrf
          <div>
            留言内容：<input type="text" name="yan1_long">
          </div>
          <p><button>发布</button></p>
      </form>
  </div>
</body>

  <head>
    <title>留言列表</title>
  </head>
  <link rel="stylesheet" type="text/css" href="{{asset('css/page.css')}}">
  <body>
    <form>
      姓名：<input type="text" name="yan1_name" value="{{$query['yan1_name']??''}}" placeholder="请输入姓名关键字">
      <input type="text" name="yan1_long" value="{{$query['yan1_long']??''}}" placeholder="请输入内容关键字">
      <button>搜索</button>
    </form>
    <table border="=1">
      <tr>
        <td>编号</td>
        <td>留言内容</td>
        <td>姓名</td>
        <td>时间</td>
        <td>操作</td>
      </tr>
      @if($data)
      @foreach($data as $v)
      <tr>
        <td>{{$v->yan1_id}}</td>
        <td>{{$v->yan1_long}}</td>
         <td>{{$v->yan1_name}}</td>
        <td>{{date('Y-m-d H:i:s',$v->yan1_time)}}</td>
        <td>
          <a href="del/{{$v->yan1_id}}">删除</a>
        </td>
      </tr>
      @endforeach
      @endif
    </table>
    {{$data->appends($query)->links()}}
  </body>