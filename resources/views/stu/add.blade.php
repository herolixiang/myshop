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
      <form action="/stu/add_do" method="post" enctype="multipart/form-data">
          @csrf
          <div>
            学生姓名：<input type="text" name="stu_name">
          </div>
          <div>
            学生性别：<input type="radio"  name="stu_xing" value="男">男
                      <input type="radio"  name="stu_xing" value="女" checked>女
          </div>
          <div>
            学生年龄：<input type="text" name="stu_nian">
          </div>
         <div>
           学生地址：<select name="stu_di">
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