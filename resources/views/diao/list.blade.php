<center>
   <form action="list_do" method="post">
   @csrf
 <div>
    <div>
      <label>调研问题:</label>
      <input type="text"  name="diao1_name" value="你在公司使用的php框架是什么">
    </div>
  </div>
 <div>
  <div>
        &nbsp;
  </div>
    <div>
      <label>问题选项:</label>
      <input type="radio" name="diao1_sex" value="1" title="单选" checked="">单选
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <input type="radio" name="diao1_sex" value="2" title="复选">复选
    </div>
  </div>
  <div>
        &nbsp;
  </div>
  <div>
    <button>添加问题</button>
  </div>
</form>


 </center>