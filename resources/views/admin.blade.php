<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Admin Food Tester</title>
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
                width:335px;
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

            .usr{
                width:330px;
                margin: 0 auto 0 auto;
                text-align: left;
            }

            .boxTrans{
                width:316px;
                margin: 0 auto 0 auto;
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
        </style>
    </head>
    <body>
        <div class="box">
                <h1 id="names"></h1>
        </div>
    </body>
</html>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js" type="text/javascript"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
const api = "{{env('API_URL')}}"
$(document).ready(function(){
    var token = localStorage.getItem("_token");
    var user = localStorage.getItem("user");
    if (!token) {
        window.location.href = '/login'
        return;
    }
    var jsonUser = JSON.parse(user)
    if (jsonUser.role_id != 2){
        window.location.href = '/'
        return;
    }
    $('#names').html("Hello "+jsonUser.username)
    $.ajax({
        headers: {
            'Content-Type': 'application/json',
            'Authorization' : 'Bearer '+token
        },
        method : 'GET',
        url: api+'/admin',
        success : function(data){
            // looping waiting list table with action
            var body = $('body')
            body.append('<h1 style="color:red;">Waiting</h1>')
            for(var i = 0;i<data.data.waiting.length;i++){
                body.append('<div class="usr user_'+i+'">')
                $('.user_'+i).append('<h3 style="color:black;" class="userName">'+data.data.waiting[i].User.username+'</h3><button onclick="approve('+data.data.waiting[i].id+')">Accept</button><button onclick="reject('+data.data.waiting[i].id+')">Reject</button>')

                body.append('<div class="box box_'+i+'">');
                $('.box_'+i).append('<table id="example_'+i+'" class="display">');

                $('#example_'+i).append('<thead>'+
                    '<tr>'+
                        '<th>Date</th>'+
                        '<th>Quantity</th>'+
                        '<th>Food</th>'+
                    '</tr>'+
                '</thead>');
                $('#example_'+i).append('<tbody id="bodyTableWaiting_'+i+'">')
                for(var z = 0;z<data.data.waiting[i].OrderDetail.length;z++){
                    $('#bodyTableWaiting_'+i).append('<tr id="waiting_'+i+z+'">')
                    $('#waiting_'+i+z).append('<td>'+data.data.waiting[i].OrderDetail[z].created_at+'</td>')
                    $('#waiting_'+i+z).append('<td>'+data.data.waiting[i].OrderDetail[z].quantity+'</td>')
                    $('#waiting_'+i+z).append('<td>'+data.data.waiting[i].OrderDetail[z].food_name+'</td>')
                }
            }
            //looping accepted list table
            body.append('<h1 style="color:green;">Accepted</h1>')
            for(var i = 0;i<data.data.accepted.length;i++){
                body.append('<div class="usr user_accepted_'+i+'">')
                $('.user_accepted_'+i).append('<h3 style="color:black;" class="userName">'+data.data.accepted[i].User.username+'</h3>')

                body.append('<div class="box box_accepted_'+i+'">');
                $('.box_accepted_'+i).append('<table id="example_accepted_'+i+'" class="display">');

                $('#example_accepted_'+i).append('<thead>'+
                    '<tr>'+
                        '<th>Date</th>'+
                        '<th>Quantity</th>'+
                        '<th>Food</th>'+
                    '</tr>'+
                '</thead>');
                $('#example_accepted_'+i).append('<tbody id="bodyTableAccepted'+i+'">')
                for(var z = 0;z<data.data.accepted[i].OrderDetail.length;z++){
                    $('#bodyTableAccepted'+i).append('<tr id="Accepted'+i+z+'">')
                    $('#Accepted'+i+z).append('<td>'+data.data.accepted[i].OrderDetail[z].created_at+'</td>')
                    $('#Accepted'+i+z).append('<td>'+data.data.accepted[i].OrderDetail[z].quantity+'</td>')
                    $('#Accepted'+i+z).append('<td>'+data.data.accepted[i].OrderDetail[z].food_name+'</td>')
                }
            }
            //looping rejected list table
            body.append('<h1 style="color:red;">Rejected</h1>')
            for(var i = 0;i<data.data.rejected.length;i++){
                body.append('<div class="usr user_rejected_'+i+'">')
                $('.user_rejected_'+i).append('<h3 style="color:black;" class="userName">'+data.data.rejected[i].User.username+'</h3>')

                body.append('<div class="box box_rejected_'+i+'">');
                $('.box_rejected_'+i).append('<table id="example_rejected_'+i+'" class="display">');

                $('#example_rejected_'+i).append('<thead>'+
                    '<tr>'+
                        '<th>Date</th>'+
                        '<th>Quantity</th>'+
                        '<th>Food</th>'+
                    '</tr>'+
                '</thead>');
                $('#example_rejected_'+i).append('<tbody id="bodyTableRejected'+i+'">')
                for(var z = 0;z<data.data.rejected[i].OrderDetail.length;z++){
                    $('#bodyTableRejected'+i).append('<tr id="Rejected'+i+z+'">')
                    $('#Rejected'+i+z).append('<td>'+data.data.rejected[i].OrderDetail[z].created_at+'</td>')
                    $('#Rejected'+i+z).append('<td>'+data.data.rejected[i].OrderDetail[z].quantity+'</td>')
                    $('#Rejected'+i+z).append('<td>'+data.data.rejected[i].OrderDetail[z].food_name+'</td>')
                }
            }
            body.append('<div class="boxTrans">'+
            '<a href="#"><div class="btn3" onclick="logout()">Logout</div></a>'+
            '</div>')
        }
    });
});

function approve(orderID){
    var token = localStorage.getItem("_token");
    $.ajax({
        headers: {
            'Content-Type': 'application/json',
            'Authorization' : 'Bearer '+token
        },
        method :'POST',
        data : JSON.stringify({order_id:orderID}),
        url:api+'/approve',
        success : function (data) {
            if (data.code != 200) {
                alert(data.status)
            } else {
                alert('Approval Success')
                location.reload();
            }
        }
    });
}

function reject(orderID){
    var token = localStorage.getItem("_token");
    $.ajax({
        headers: {
            'Content-Type': 'application/json',
            'Authorization' : 'Bearer '+token
        },
        method :'POST',
        data : JSON.stringify({order_id:orderID}),
        url:api+'/reject',
        success : function (data) {
            if (data.code != 200) {
                alert(data.status)
            } else {
                alert('Reject Success')
                location.reload();
            }
        }
    });
}

function logout(){
    localStorage.clear();
    window.location.href = '/login'
}
</script>
