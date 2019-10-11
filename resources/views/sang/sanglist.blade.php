<h3>接口基础-用户展示</h3>
    用户姓名：<input type="text" name="name" id="name" >
    <input type="button" class='search btn btn-info' value='搜索'>
    <table class="table table-bordered table-striped form-horizontal">
        <tr>
            <td>Id</td>
            <td>商品名</td>
            <td>商品价格</td>
            <td>商品图片</td>
        </tr>
        <tbody class="add">
            
        </tbody> 
    </table>

    <nav aria-label="Page navigation">
        <ul class="pagination">
            <!-- <li>
            <a href="#" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
            </a> -->
            <!-- </li> -->
            <li><a href="#">1</a></li>
            <li><a href="#">2</a></li>
            <li><a href="#">3</a></li>
            <li><a href="#">4</a></li>
            <li><a href="#">5</a></li>
            <!-- <li>
            <a href="#" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
            </a>
            </li> -->
        </ul>
    </nav>

     <script src=" {{ asset('/js/jquery.min.js') }} "></script>

    <script>
      var url="http://www.myshop.com/sang/list";
         $.ajax({
            url:url,
            type:"GET",
            dataType:'json',
            success:function(res){
               myshop(res);
            },
        });


        //搜索功能
        //点击搜索按钮
        $(".search").on('click',function(){
            //获取搜索内容
            var name=$("#name").val();
            //发送ajax请求后台接口
            $.ajax({
                url:"http://www.myshop.com/sang/list",
                type:"GET",
                data:{name:name},
                dataType:'json',
                success:function(res){
                   myshop(res);
                },
            });
        });


        //分页功能
        //点击分页按钮
        $(document).on('click',".pagination a",function(){
            //获取分页页码
            var page =$(this).attr('page');
            var name=$("#name").val();
            //发送ajax请求到后台接口
            $.ajax({
                url:"http://www.myshop.com/sang/list",
                type:"GET",
                data:{page:page,name:name},
                dataType:'json',
                success:function(res){
                    myshop(res);
                },
            });
        });


        //点击删除
        $(document).on('click',".del",function(){
            // alert(1);
            var url ="http://www.myshop.com/sang/del";
            var id = $(this).attr('id');
            // console.log(goods_id);
            $.ajax({
                url:url,
                type:"GET",
                data:{id:id},
                dataType:'json',
                success:function(res){
                    alert(res.msg);
                    location.href='http://www.myshop.com/sang/sanglist';
                }
            });
        });
         
    

        function myshop(res)
        {
             $(".add").empty();
                //渲染页面
                $.each(res.data.data,function(i,v){
                    var tr= $("<tr></tr>");  //构建一个空对象
                    tr.append("<td>"+v.id+"</td>");
                    tr.append("<td>"+v.name+"</td>");
                    tr.append("<td>"+v.price+"</td>");
                    tr.append("<td>"+'<img src="/'+v.tu+'" height="100" width="100">'+"</td>");
                    tr.append("<td><a href='javascript:;' id='"+v.id+"' class='btn btn-danger del'>删除  </a><a href='javascript:;' id='"+v.id+"' class='btn btn-success edit'>修改</a></td>");
                    $(".add").append(tr);
                });
                var page="";
                //构建页码
                for(var i=1;i<=res.data.last_page;i++){
                    page+="<li><a page='"+i+"'>第"+i+"页</a></li>";
                }
                $('.pagination').html(page);
        }

    </script>
