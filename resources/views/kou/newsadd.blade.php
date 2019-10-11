<form action="" method="post" enctype="multipart/form-data">
<!-- <meta name="csrf-token" content="{{ csrf_token() }}"> -->
@csrf

<div class="form-group">
<h3>推送</h3>
<label for="exampleInputEmail1">消息内容</label>
<input type="text" class="form-control" id="news_content" name="news_content" placeholder="消息内容">
</div>
<input type="hidden" name="id" value="" class="hidden">

<div class="form-group">
<label for="exampleInputEmail1">消息方式</label>
<select name="news_type" id="news_type" class="form-control">
<option value="">请选择发送的方式</option>
<option value="all">给所有用户发送</option>

</select>
<!-- <p class="help-block">Example block-level help text here.</p > -->
</div>
<table class="table-striped table-bordered table-hover table-responsive portion" width="900" style="display:none">
<tr align='center'>
<td></td>
<td>用户编号</td>
<td>用户openid</td>
<td>用户昵称</td>
<td>用户城市</td>
<td>关注时间</td>
</tr>
@if($userData)
@foreach($userData as $v)
<tr align='center'>
<td>
<input type="checkbox" name="openidlist" value="$v['openid']" class="check">
</td>
<td>{{$v->user_id}}</td>
<td>{{$v->openid}}</td>
<td>{{$v->nickname}}</td>
<td>{{$v->city}}</td>
<td>{{date('Y-m-d H:i:s',$v->subscribe_time)}}</td>
</tr>
@endforeach
@endif

</table>
<div class="form-group labels" style="display:none">
<label for="exampleInputEmail1">选择标签</label>
<select name="b_id" id="b_id" class="form-control">
<!-- <option value="0">一级菜单</option> -->
@foreach($data as $v)
<option value="{{$v['label_id']}}">{{$v['label_name']}}</option>
@endforeach
</select>
</div>
<button type="submit" class="btn btn-default sub">添加</button>
</form>
<script src=" {{ asset('/admin/js/jquery.min.js?v=2.1.4') }} "></script>

<script>
$("#news_type").on('change',function(){
var val = $(this).val();
// alert(val); 
if (val =='labels') {
$(".labels").show();
}else{
$(".labels").hide();
}
if (val =='portion') {
$(".portion").show();

}else{
$(".portion").hide();
}
return false;
})

$('.sub').click(function(){
var arr=[];
$('.check:checked').each(function(){
arr.push($(this).parent().next().next().text());
});
// console.log(arr);
var news_content = $('#news_content').val();
var news_type = $('#news_type').val();
var b_id = $('#b_id').val();
// console.log(news_content);
// console.log(news_type);
// console.log(arr);
$.ajax({
url:"{{url('kou/newsdoadd')}}",
data:{news_content:news_content,news_type:news_type,arr:arr,b_id:b_id},
dataType:"json",

success:function(res){
if (res.code) {
window.location.href='/kou/newsadd';
alert(res.font);
}
}

})
return false;

})

</script>