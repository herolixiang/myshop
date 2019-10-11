<div>
        <h3>本场比赛竞猜结果</h3>
    <br><br><br><b>本场比赛：</b>
    <span>
        {{$dd->qiudui1}}
        @if($dd->adjieguo == 1)
            胜
        @elseif($dd->adjieguo == 2)
            平
        @else
            负
        @endif
        {{$dd->qiudui2}}
    </span><br><br><br>
    @if($dd->jieguo != '')
        <b>您的竞猜：</b>
        <span>
        {{$dd->qiudui1}}
            @if($dd->jieguo == 1)
                胜
            @elseif($dd->jieguo == 2)
                平
            @else
                负
            @endif
            {{$dd->qiudui2}}
    </span>
    @else
        <b>您好，该场比赛无人竞猜</b>
    @endif

    <br> <br> <br> <br>
    结果
    @if($dd->adjieguo != $dd->jieguo)
        <b>很抱歉，您没有猜中！！！</b>
    @else
        <b>恭喜您，猜中了</b>
    @endif
</div>