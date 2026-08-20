<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workspace Not Found</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css">
    <style>
        .error-container {
            height: 100vh !important;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            font-family: montserrat, sans-serif;
        }

        .big-text {
            font-size: 200px;
            font-weight: 900;
            font-family: sans-serif;
            background-image: linear-gradient(120deg, #012d80 0%, #045bb8 60%, #012d80 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-size: cover;
            background-position: center;
        }

        .small-text {
            font-family: montserrat, sans-serif;
            color: rgb(0, 0, 0);
            font-size: 24px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .description-text {
            color: #555;
            font-size: 16px;
            line-height: 1.6;
        }

        .button {
            color: #fff;
            padding: 12px 36px;
            font-weight: 600;
            border: none;
            position: relative;
            font-family: 'Raleway', sans-serif;
            display: inline-block;
            text-transform: uppercase;
            border-radius: 90px;
            margin: 2px;
            margin-top: 15px;
            background-image: linear-gradient(120deg, #012d80 0%, #045bb8 60%, #012d80 100%);
            background-size: 200% auto;
            text-decoration: none;
        }

        .button:hover,
        .button:focus {
            color: #ffffff;
            background-position: right center;
            box-shadow: 0px 5px 15px 0px rgba(0, 0, 0, 0.1);
            text-decoration: none;
        }

        .icon-wrapper {
            font-size: 80px;
            color: #045bb8;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container error-container">
        <div class="row d-flex align-items-center justify-content-center">
            <div class="col-md-12 text-center">
                <div class="icon-wrapper">
                    <i class="fas fa-building"></i>
                </div>
                <h1 class="big-text" style="font-size: 120px;">Oops!</h1>
                <h2 class="small-text">Workspace Not Found</h2>
            </div>
            <div class="col-md-6 text-center">
                <p class="description-text">
                    The workspace <strong>{{ request()->getHost() }}</strong> does not exist or is not registered.
                    <br>
                    Please check the URL or contact your administrator to set up this workspace.
                </p>

                <a href="{{ url('http://' . config('tenancy.central_domains')[0]) }}" class="button">GOTO HOME PAGE</a>
            </div>
        </div>
    </div>
</body>
</html>
