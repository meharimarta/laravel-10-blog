<!doctype html>
<html>
    <head>
        <meta name="viewport" content="width=device-width">
        <meta charset="utf-8">
        <style>
            html,body {
/*                height: 100%;*/
            }
            .wrapper {
                text-align: center;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-content: center;
            }
            h3 {
                background-color: #0d89ff;
                color: #fff;
                padding: 5px;
                border-radius: 10px;
                text-align: center;
/*                font-size: 1.3em;*/
            }
            a {                
                background-color: #183550;
                display: block;
                color: #fff;
                border-radius: 10px;
                width: fit-content;
                padding: 10px;
                font-size: 1.3em;
                text-decoration: none;
                align-self: center;
            }
        </style>
    </head>
    <body>
        <div class="wrapper">
            <h3>Protech Member Notice</h3>
            <p>
                {{$messageConent}}
            </p>
            <h3>© 2020 ProtechEth. All rights reserved.</h3>
        </div>
    </body>
</html>

<!doctype html>
<html style="height: 100%">
    <head>
        <meta name="viewport" content="width=device-width">
        <meta charset="utf-8">
    </head>
    <body
          style="
                 overflow: auto;
                text-align: center;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-content: center;
                height: 100%;
                 ">
        <div class="wrapper"
             style="
                align-self: center;
                width: 400px;
                padding: 15px;
                background-color: #eee;
                height: fit-content;
                height: -ms-fit-content;
                height: -moz-fit-content;
            ">
            <h2
                >ProTechEth</h2>
            <h4>Hello!</h4>
            <p>
                {{$messageConent}}
            </p>
            <p>&copy; 2020 ProtechEth. All rights reserved.<p>
        </div>
    </body>
</html>    
