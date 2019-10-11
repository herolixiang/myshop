<form action="">
<meta name="csrf-token" content="{{ csrf_token() }}"> 
  <div class="form-group">
  <h2><b><center>标签管理--分配用户标签</center></b></h2>
   <h4>当前标签是：{{$res->label_name}}<small class="red">请勾选要打标签的用户</small></h4> 
    <input type="hidden" name="b_id" value="{{$res->b_id}}" id="b_id">
    <table  barter="1">
        <tr align='center'>
             <td></td> 
            <td>用户编号</td>
            <td>用户openid</td>
            <td>用户昵称</td>
            <td>用户城市</td>
            <td>关注时间</td>
        </tr>
         @if($data)
            @foreach($data as $v)
            <tr align='center'>
                <td>
                    <input type="checkbox" name="openidlist" value="$v['openid']" class="check">
                </td> 
                <td>{{$v->id}}</td>
                <td>{{$v->openid}}</td>
                <td>{{$v->nickname}}</td>
                <td>{{$v->city}}</td>
                <td>{{date('Y-m-d H:i:s',$v->time)}}</td>
            </tr>
        @endforeach
        @endif 
    </table>
    <button type="submit" class="btn btn-success" id="sub">添加</button>
</form>
	<script src="https://cdn.jsdelivr.net/npm/jquery@1.12.4/dist/jquery.min.js"></script>
	<script>
    $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#sub').click(function(){
        // alert('asdada');die;
        var arr=[];
        $('.check:checked').each(function(){
            arr.push($(this).parent().next().next().text());
        });
        // console.log(arr);
        var b_id = $('#b_id').val();
		$.ajax({
			url:"{{url('kou/labelfansadd')}}",
            data:{b_id:b_id,arr:arr},
            dataType:"json",
            success:function(res){
                if (res.code) {
                    window.location.href='/kou/labellist';
                	alert(res.font);
                }
            }
		});
    });
</script>

  