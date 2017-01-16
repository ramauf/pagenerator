<div class="col-lg-4"></div>
<div class="col-lg-4">
    <form role="form" method = 'post'>
        <input type = 'hidden' name = '_token' value = '{{csrf_token()}}' />
        <div class="form-group">
            <label>Email:</label>
            <input class="form-control" type = 'text' class = '@if (isset($messages['emailorpass']))errorField @endif' name = 'email' value = '' />
        </div>
        <div class="form-group">
            <label>Пароль:</label>
            <input class="form-control" type = 'password' name = 'password' />
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value = 'Вход' />
        </div>
    </form>
    @if (isset($messages))
        @foreach($messages as $message)
            <div class="alert alert-danger">{{$message}}</div>
        @endforeach
    @endif
</div>
<div class="col-lg-4"></div>