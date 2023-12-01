<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *{
            margin:0;
            padding:0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body{
            display:flex;
            justify-content:center;
            align-items:center;
            min-height:100vh;
            background:url('./images/image.jpg') no-repeat;
            background-size:cover;
            background-position:center;       
        }

        .wrapper{
            width:420px;
            /* background:#90dcf5; */
            background:rgba(245, 245, 245,0.7);
            color:#0a6bab;
            border-radius:10px;
            padding:30px 40px 60px 40px;
            border:2px solid rgba(255,255,255, .2);
            backdrop-filter:blur(20px);
            box-shadow:0 0 10px rgba(0,0,0,.2);
        }
        .wrapper h1{
            font-size: 36px;
            text-align:center;
        }
        .wrapper .input-box{
            position:relative;
            width:100%;
            height:50px;
            margin:30px 0;
        }

        .input-box input{
            width:100%;
            height:100%;
            background:transparent;
            border:none;
            outline:none;
            /* border:2px solid rgba(255,255,255, .2); */
            border:2px solid rgba( 10, 107, 171, .2);
            border-radius:40px;
            font-size:16px;
            /* color: #fff; */
            color:#0a6bab;
            padding: 20px 45px 20px 20px; 
        }

        .input-box input::placeholder{
            color:#0a6bab; 
        }

        .input-box i{
            position:absolute;
            right:20px;
            top:50%;
            transform:translateY(-50%);
            font-size: 20px;
        }
        .wrapper .btn{
            width:100%;
            height:45px;
            background:#fff;
            border:none;
            outline:none;
            border-radius:40px;
            box-shadow:0 0 10px rgba(0,0,0,0.1);
            cursor:pointer;
            font-size:16px;
            color:#333;
            font-weight: 600;
        }


    </style>
</head>
<body>
    <div class="wrapper">
        <form action="login_db.php" method="post">
            <h1>Login</h1>
            <div class="input-box">
                <input type="text" placeholder="Enter UserID" name="empid" autocomplete="off" required>
                <i class="fa-solid fa-user"></i>
            </div>
            <div class="input-box">
                <input type="password" placeholder="Enter Password" name="pwd" required>
                <i class="fa-solid fa-lock"></i>
            </div>
            <button type="submit" class="btn" name="login" >Login</button>
        </form>
    </div>     
</body>
</html>