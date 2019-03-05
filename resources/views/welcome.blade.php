<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Home</title>
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
            width:316px;
            border-radius:6px;
            margin: 0 auto 0 auto;
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
            margin-left:93px;
            font-weight:800;
            font-size:0.8em;
        }

        .btn3{
            background:red;
            width:125px;
            padding-top:5px;
            padding-bottom:5px;
            color:white;
            border-radius:4px;
            border: #27ae60 1px solid;
            
            margin-top:20px;
            margin-bottom:20px;
            margin-left:93px;
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
        .boxTrans{
            width:316px;
            margin: 0 auto 0 auto;
        }

        #btn2:hover{ 
            background:#3594D2; 
        }
        </style>
    </head>
    <body>
        <div class="box">
                <h1 id="names"></h1>
                <a href="#"><div class="btn btnOrder">Order Here ...</div></a>
        </div>
        <h1 style="color:yellow;">Waiting</h1>
        <div class="box">
            <table id="example" class="display">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Quantity</th>
                        <th>Food</th>
                    </tr>
                </thead>
                <tbody id="bodyTableWaiting">
                </tbody>
            </table>
        </div>
        <h1 style="color:green;">Accepted</h1>
        <div class="box">
            <table id="example" class="display">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Quantity</th>
                        <th>Food</th>
                    </tr>
                </thead>
                <tbody id="bodyTableAccepted">
                </tbody>
            </table>
        </div>
        <h1 style="color:red;">Rejected</h1>
        <div class="box">
            <table id="example" class="display">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Quantity</th>
                        <th>Food</th>
                    </tr>
                </thead>
                <tbody id="bodyTableRejected">
                </tbody>
            </table>
        </div>
        <div class="boxTrans">
            <a href="#"><div class="btn3 btnLogout">Logout</div></a>
        </div>
    </body>
</html>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js" type="text/javascript"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
    var token = localStorage.getItem("_token");
    var user = localStorage.getItem("user");
    if (!token) {
        window.location.href = '/login'
        return;
    }
    var jsonUser = JSON.parse(user)
    if (jsonUser.role_id != 1){
        window.location.href = '/admin'
        return;
    }
    $('#names').html("Hello "+jsonUser.username)
    var api = "{{env('API_URL')}}"
    $.ajax({
        headers: {
            'Content-Type': 'application/json',
            'Authorization' : 'Bearer '+token
        },
        method : 'GET',
        url: api,
        success : function(data){
            // looping waiting table
            var bodyWaiting = $('#bodyTableWaiting')
            for(var i = 0;i<data.data.waiting.length;i++){
                for(var z = 0;z<data.data.waiting[i].OrderDetail.length;z++){
                    bodyWaiting.append('<tr id="waiting_'+i+z+'">')
                    $('#waiting_'+i+z).append('<td>'+data.data.waiting[i].OrderDetail[z].created_at+'</td>')
                    $('#waiting_'+i+z).append('<td>'+data.data.waiting[i].OrderDetail[z].quantity+'</td>')
                    $('#waiting_'+i+z).append('<td>'+data.data.waiting[i].OrderDetail[z].food_name+'</td>')
                }
            }
            //looping table accepted
            var bodyAccepted = $('#bodyTableAccepted')
            for(var i = 0;i<data.data.accepted.length;i++){
                for(var z = 0;z<data.data.accepted[i].OrderDetail.length;z++){
                    bodyAccepted.append('<tr id="accepted_'+i+z+'">')
                    $('#accepted_'+i+z).append('<td>'+data.data.accepted[i].OrderDetail[z].created_at+'</td>')
                    $('#accepted_'+i+z).append('<td>'+data.data.accepted[i].OrderDetail[z].quantity+'</td>')
                    $('#accepted_'+i+z).append('<td>'+data.data.accepted[i].OrderDetail[z].food_name+'</td>')
                }
            }
            //looping table rejected
            var bodyRejected = $('#bodyTableRejected')
            for(var i = 0;i<data.data.rejected.length;i++){
                for(var z = 0;z<data.data.rejected[i].OrderDetail.length;z++){
                    bodyRejected.append('<tr id="rejected_'+i+z+'">')
                    $('#rejected_'+i+z).append('<td>'+data.data.rejected[i].OrderDetail[z].created_at+'</td>')
                    $('#rejected_'+i+z).append('<td>'+data.data.rejected[i].OrderDetail[z].quantity+'</td>')
                    $('#rejected_'+i+z).append('<td>'+data.data.rejected[i].OrderDetail[z].food_name+'</td>')
                }
            }
        }
    });
});

$('.btnOrder').click(function(){
    window.location.href = '/order'
});

$('.btnLogout').click(function(){
    localStorage.clear();
    window.location.href = '/login'
});
</script>
