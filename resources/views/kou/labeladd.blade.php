<form action="{{url('kou/labeladd_do')}}" method="post" enctype="multipart/form-data">
@csrf
  <div class="form-group">
  <h3>标签管理-创建标签</h3>
    <label for="exampleInputEmail1">标签名称</label>
    <input type="text" class="form-control" id="label_name" name="label_name" placeholder="请写标签名称">
  </div>
  
  <button type="submit" class="btn btn-default" id="sub">添加</button>
</form>