<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Login</title>
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:700,600' rel='stylesheet' type='text/css'>
        <style>
            body{
                font-family: 'Open Sans', sans-serif;
                background:#3498db;
                margin: 0 auto 0 auto;  
                width:100%; 
                text-align:center;
                margin: 20px 0px 20px 0px;   
            }

            p{
                font-size:12px;
                text-decoration: none;
                color:#ffffff;
            }

            h1{
                font-size:1.5em;
                color:#525252;
            }

            .box{
                background:white;
                width:300px;
                border-radius:6px;
                margin: 0 auto 0 auto;
                padding:0px 0px 70px 0px;
                border: #2980b9 4px solid; 
            }

            .email{
                background:#ecf0f1;
                border: #ccc 1px solid;
                border-bottom: #ccc 2px solid;
                padding: 8px;
                width:250px;
                color:#AAAAAA;
                margin-top:10px;
                font-size:1em;
                border-radius:4px;
            }

            .password{
                border-radius:4px;
                background:#ecf0f1;
                border: #ccc 1px solid;
                padding: 8px;
                width:250px;
                font-size:1em;
            }

            .btn{
                background:#2ecc71;
                width:125px;
                padding-top:5px;
                padding-bottom:5px;
                color:white;
                border-radius:4px;
                border: #27ae60 1px solid;
                
                margin-top:20px;
                margin-bottom:20px;
                float:left;
                margin-left:16px;
                font-weight:800;
                font-size:0.8em;
            }

            .btn:hover{
                background:#2CC06B; 
            }

            #btn2{
                float:left;
                background:#3498db;
                width:125px;  padding-top:5px;
                padding-bottom:5px;
                color:white;
                border-radius:4px;
                border: #2980b9 1px solid;
                
                margin-top:20px;
                margin-bottom:20px;
                margin-left:10px;
                font-weight:800;
                font-size:0.8em;
            }

            #btn2:hover{ 
                background:#3594D2; 
            }
        </style>
    </head>
    <body>
        <form>
            <div class="box">
                <h1>Dashboard</h1>
                    <input type="text" name="username" placeholder="username" class="email" />
                    <input type="password" name="password" placeholder="password" class="email" />
                <a href="#"><div class="btn">Sign In</div></a>
                <a href="#"><div id="btn2">Sign Up</div></a> 
            </div> 
        </form>
    </body>
</html>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js" type="text/javascript"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
$('.btn').click(function(){
    var username = $('[name=username]').val()
    var password = $('[name=password]').val()
    var api = "{{env('API_URL')}}"
    if (username == '' || password == '') {
        alert('username and password required')
        return;
    }
    $.ajax({
        headers: {
            'Content-Type': 'application/json'
        },
        data :JSON.stringify({
            username:username,
            password:password
        }),
        url: api+'/login',
        method : 'POST',
        success : function(data){
            if (data.code != 200) {
                alert(data.status)
            } else {
                localStorage.setItem("_token", data.access_token.token);
                localStorage.setItem("user", JSON.stringify(data.user));
                if (data.user.role_id == 1) {
                    window.location.href = '/'
                } else {
                    window.location.href = '/admin'
                }
            }
        },
        error : function(error){
            alert('Error')
        }
    });
});

$('#btn2').click(function(){
    window.location.href = '/register'
});
</script>
