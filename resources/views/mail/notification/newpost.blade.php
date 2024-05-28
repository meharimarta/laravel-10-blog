<!doctype html>
<html style="height: 100%">
    <head>
        <meta name="viewport" content="width=device-width">
        <meta charset="utf-8">
    </head>
    <body
          style="
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
            <h3
                style="
                background-color: #0d89ff;
                color: #fff;
                padding: 5px;
                border-radius: 10px;
                text-align: center;">Dont mis New post "{{ $post-> title }}"</h3>
            <h4 style="text-align: left">From:- {{$user->name}}</h4>
            <div style="text-align: center;margin-left: 30%;">
            <a href='{{ url("/blog/$post->id?$post->title")}}'
                style="
                background-color: #183550;
                display: block;
                color: #fff;
                border-radius: 10px;
                width: fit-content;
                width: -ms-fit-content;
                width: -moz-fit-content;
                padding: 10px;
                font-size: 1.3em;
                text-decoration: none;
                align-self: center;
                "
               >Read now</a>
            </div>
            <p>
                If you’re having trouble clicking the "Read now" button, copy and paste the URL below
                into your web browser:<br>
                <a href='{{ url("/blog/$post->id?$post->title")}}'>{{ url("/blog/$post->id?$post->title")}}</a>
            </p>
            <p>&copy; 2020 ProtechEth. All rights reserved.<p>
        </div>
    </body>
</html>  