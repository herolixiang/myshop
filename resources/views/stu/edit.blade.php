<html>
<body>
  <div class="content">
      <h3>学生管理</h3>
      <!-- @if ($errors->any())
      <div class="alert alert-danger">
      <ul>
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
      </ul>
      </div>
      @endif -->
      <form action="/stu/update" method="post" enctype="multipart/form-data">
      <input type="hidden" name="stu_id" value="{{$data->stu_id}}">
          @csrf
          <div>
            学生姓名：<input type="text" name="stu_name" value="{{$data->stu_name}}">
          </div>
          <div>
            学生年龄：<input type="text" name="stu_nian" value="{{$data->stu_nian}}">
          </div>
         <div>
           学生地址：<select name="stu_di" value="{{$data->stu_di}}">
                      <option value="北京">北京</option>
                      <option value="上海">上海</option>
                      <option value="广州">广州</option>
                      <option value="深圳">深圳</option>
                      <option value="杭州">杭州</option>
                      </select>
         </div>
          <p><button>提交</button></p>
      </form>
  </div>
</body>
</html>