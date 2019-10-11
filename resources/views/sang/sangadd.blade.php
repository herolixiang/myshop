<form action="" method="post" enctype="multipart/form-data">
  <table class="table table-bordered table-striped form-horizontal">
    <h3>接口基础-商品添加</h3>
      <div class="form-group">
        <label for="exampleInputEmail1">商品名</label>
        <input type="text" class="form-control" name="name" placeholder="用户名">
      </div>
      <div class="form-group">
        <label for="exampleInputEmail1">商品价钱</label>
        <input type="text" class="form-control" name="price" placeholder="价钱">
      </div>
      <div class="form-group">
        <label for="exampleInputEmail1">商品图片</label>
        <input type="file" class="form-control" name="file" id="file" placeholder="图片">
      </div>
      <button type="button" class="btn btn-info sub">添加</button>
  </table> 
</form>

<script src="{{ asset('/js/jquery.min.js') }} "></script>
<script>
    $(".sub").on('click',function(){
        // alert(1);
        //异步上传表单
        var fd = new FormData();

        var name=$("[name='name']").val();
        var price=$("[name='price']").val();
        var file =($("#file")[0].files[0]);

        fd.append('name',name);
        fd.append('price',price);
        fd.append('file',file);
        
        //调用后台接口
        $.ajax({
            url:"http://www.myshop.com/sang/add",
            data:fd,
            dataType:"json",
            type:"POST",
             processData:false,
              contentType:false,
            success:function(res){
                // alert(res.msg);
                alert(res.msg);location.href='http://www.myshop.com/sang/sanglist';
            }
        });
    });
</script>
