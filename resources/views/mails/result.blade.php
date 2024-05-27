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
    @if ($gestionnaire->status == 'accepted')
        <div> Your request has been accepted </div>

        <div> Please click the following link to set your account password: </div>
        <a href="{{route('gestionnaire.password', ['id'=> $gestionnaire->id])}}">Set Password</a>
        
    @else 
    @if ($gestionnaire->status == 'rejected')

            <div> We're sorry, but your request has been rejected. </div>
    @endif
        
    @endif
    
</body>
</html>