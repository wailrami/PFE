<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Result</title>
</head>
<body>
    <div>Hi , {{$gestionnaire->user->nom.' '.$gestionnaire->user->prenom}} </div>

    <br><br>
    {{-- message for this this manager is added seccessfully and we gave you his new password with a link if he want to change it--}}

    You have been added as a manager to the system.
    <br>
    Please click the following link to reset your account password:
    <a href="{{route('gestionnaire.password', ['id'=> $gestionnaire->id])}}">Set Password</a>

</body>
</html>