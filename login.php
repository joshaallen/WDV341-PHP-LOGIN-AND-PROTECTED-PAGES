<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="This webpage will implement PHP to build a login page that will grant admin priviliges upon validation">
  <meta name="keywords" content="PHP Admin Login SQL">
  <meta name="author" content="Joshua Allen">
  <title>Login Page</title>
  <style>
    *, ::after, ::before{
      margin:0;
      padding:0;
      box-sizing: border-box;
    }
    html {
      font-size: 62.5%;
    }
    body {
      font: 1.8rem Tahoma, Geneva,  sans-serif;
    }
    main{
      border: 5px dashed rgba(255,0,255,1);
     
      margin: 0 auto;
      
    }
    form {
      border: 3px solid rgba(255,0,0,0);
      background: rgba(255,0,0,0.3);
    }
    input, label {
      width: 150px;
      padding: 1.2rem;
    }
    input[type="text"] {
      background: none;
      font: inherit;
      border: none;
      border-bottom: 3px solid #FFFFFF;
    }
    input[type="text"], button {
      font: inherit;
   }
   button {
     margin-left: 1.2rem;
   }
   section {
     border: 3px solid #000000;
     border-radius: 12px;
   }
   section:nth-of-type(1) {
     align-self: end;
   }
   section:nth-last-of-type(1) {
     justify-self: end;
   }
  </style>
</head>
<body>
  <div class="container">
    <header>WDV341</header>
    <main>
      <div><h1>Login and Protected Page</h1></div>
      <section>
        <h3>Admin Console</h3>
        <div><a href="#">Add</a></div>
        <div><a href="#">List</a></div>
        <div><a href="#">Logout</a></div>
      </section>
    
      <form action="login.php" method="post">
        <div>
        <label for="userName">Username:</label>
        <input type="text" name="userName" id="userName" autofocus placeholder="John Smith">
        </div>
        <div>
        <label for="password">Password:</label>
        <input type="text" name="password" id="password">
        </div>
        <div>
          <button type="submit">Logon</button>
        </div>
      </form>
    </main>
    <footer>WDV341</footer>
  </div>  
</body>
</html>