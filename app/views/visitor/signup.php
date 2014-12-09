
<!-- end-header -->

<div class="container">

  <div style="padding: 50px; margin: 0 auto;">
    <h3>Create an account?</h3>
    <section class="container page-content" >
      <form id="signupForm" role="form">
        <div class="form-group">
          <label for="exampleInputEmail1">Fullname</label>
          <input type="text" name="name" class="form-control req" placeholder="Your user name">
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1">Email address</label>
          <input type="email" name="email" class="form-control req" id="exampleInputEmail1" placeholder="Enter email ">
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1">Phone</label>
          <input type="text" name="phone" class="form-control req" placeholder="Phone">
        </div>

        <div class="form-group">
          <label for="exampleInputPassword1">Password</label>
          <input type="password" name="password" class="form-control req" id="pswd1" placeholder="Password">
        </div>
        <div class="form-group">
          <label for="exampleInputPassword1">Comfirm Password</label>
          <input type="password" name="confirm password" class="form-control req" id="pswd2"  placeholder="Password">
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
      </form>

    </section>
  </div>
</div>


<!-- container -->

<script type="text/javascript">
    $(document).ready(function(){

        $("#signupForm").on('submit', function(e){
            e.preventDefault();
            var $this = $(this);
            $this.find(".req").each(function(){
                if( $(this).val().length < 2 ){
                    alert("please enter " + $(this).attr("name"));
                    exit();
                }
            }); // end of loop checking

            if( $("#pswd1").val() != $("#pswd2").val() ){
                alert("Passwords do not match");
                exit();
            }

            $.post( URL + "/service/signup", $this.serialize() , function(data){
                if(data.status == true){
                    //alert("signup successful");
                    window.location = URL + '/login' ;
                }else{
                    alert(data.result);
                }
            });

        });

    });
</script>





