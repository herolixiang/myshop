<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
<table>
    <caption><h3>后台控制比赛结果</h3></caption>
    <tr>
        <td><h5>{{$data->qiudui1}}</h5></td>
        <td><h4>VS</h4></td>
        <td><h5>{{$data->qiudui2}}</h5></td>
    </tr>
    <tr>
        <td><input class="inp" type="radio" qid="{{$data->id}}"  value="1" name="jingcai">胜</td>
        <td><input class="inp" type="radio" qid="{{$data->id}}"  value="2" name="jingcai">平</td>
        <td><input class="inp" type="radio" qid="{{$data->id}}" value="3" name="jingcai">负</td>
    </tr>
</table>
</body>
</html>

  <script src=" {{ asset('/js/jquery.min.js') }} "></script>
<script>
    $(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('.inp').click(function(){
            var v = $(this).val();
            var qid = $(this).attr('qid');
            $.ajax({
                url:"{{url('kongzhido')}}",
                data:{id:v,qid:qid},
                type:'post',
                dataType:'json',
                success:function(msg){
                    // console.log(msg.code);
                    if(msg.code == 1){
                        alert('结果已选定');
                        location.href="{{url('jingcailist')}}";
                        return false;
                    }else{}
                    alert('精彩失败，请重试');
                }
            })
        })
    })
</script>
<?php
