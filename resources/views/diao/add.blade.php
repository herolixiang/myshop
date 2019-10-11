<html>
<body>
  <div class="content">
      <form action="/diao/add_do" method="post" enctype="multipart/form-data">
          @csrf
          <div>
            调研项目:<input type="text" name="diao_name">
          </div>
          <p><button>添加调研</button></p>
      </form>
  </div>
</body>
</html>