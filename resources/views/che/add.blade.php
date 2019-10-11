<html>
<body>
  <div class="content">
      <h3>车票管理</h3>
      <!-- @if ($errors->any())
      <div class="alert alert-danger">
      <ul>
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
      </ul>
      </div>
      @endif -->
      <form action="/che/add_do" method="post" enctype="multipart/form-data">
          @csrf
          <div>
            车次：<input type="text" name="che_chi">
          </div>
          <div>
           出发地：<select name="che_di">
                      <option value="北京">北京</option>
                      <option value="上海">上海</option>
                      <option value="广州">广州</option>
                      <option value="深圳">深圳</option>
                      <option value="杭州">杭州</option>
                      </select>
         </div>
         <div>
           到达地：<select name="che_dao">
                      <option value="北京">北京</option>
                      <option value="上海">上海</option>
                      <option value="广州">广州</option>
                      <option value="深圳">深圳</option>
                      <option value="杭州">杭州</option>
                      </select>
         </div>
         <div>
           价钱：<input type="text" name="che_jia">
         </div>
         <div>
           张数：<input type="text" name="che_zhang">
         </div>
         <div>
           出发时间：<input type="text" name="che_chu">
         </div>
         <div>
           到达时间：<input type="text" name="che_jian">
         </div>
          <p><button>提交</button></p>
      </form>
  </div>
</body>
</html>