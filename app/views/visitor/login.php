<!-- end-header -->

    <div class="container">

<div style="padding: 50px; margin: 0 auto;">
      <h3>LOGIN</h3>
      <section class="container page-content" >
          <form id="loginForm" role="form">
            <div class="form-group">
              <label for="exampleInputEmail1">Email address / Phone</label>
              <input type="text" class="form-control req" name="login" placeholder="Enter email or Phone">
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Password</label>
              <input type="password" class="form-control req" name="password" placeholder="Password">
            </div>
            <button type="submit" class="btn btn-default">Submit</button>
          </form>

      </section>
</div>
      </div>

  <!-- container -->

<script type="text/javascript">
    $(document).ready(function(){
        $("#loginForm").on('submit', function(e){
            e.preventDefault();
            var $this = $(this);
            $this.find(".req").each(function(){
                if( $(this).val().length < 2 ){
                    alert("please enter " + $(this).attr("name"));
                    exit();
                }
            }); // end of loop checking

            $.post( URL + "/service/login", $this.serialize() , function(data){                $
                if(data.status == true){
                    window.location = "http://accounts.smartajo.com.ng";
                }else{
                    alert("wrong username or password");
                }
            });

        });

    });
</script>


