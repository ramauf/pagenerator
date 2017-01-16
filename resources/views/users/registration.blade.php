<div class="col-lg-4"></div>
<div class="col-lg-4">
    <form role="form" method = 'post'>
        <input type = 'hidden' name = '_token' value = '{{csrf_token()}}' />
        <input type = 'hidden' name = 'birthdate' id = 'birthdate' value = '1998.1.1'/>
        <div class="form-group @if (isset($messages[0]['email']))has-error @endif">
            <label>Email:</label>
            <input class="form-control" type = 'text' name = 'email' value = '' />
        </div>
        <div class="form-group @if (isset($messages[0]['firstName']))has-error @endif">
            <label>Имя</label>
            <input class="form-control" type = 'text' name = 'firstName' value = '@if (isset($messages[2]['firstName'])){{$messages[2]['firstName']}}@endif' />
        </div>
        <div class="form-group @if (isset($messages[0]['lastName']))has-error @endif">
            <label>Фамилия</label>
            <input class="form-control" type = 'text' name = 'lastName' value = '@if (isset($messages[2]['lastName'])){{$messages[2]['lastName']}}@endif' />
        </div>
        <div class="form-group">
            <label>Дата рождения</label>
            <div class = 'row'>
                <div class="col-lg-3">
                    <select class="form-control" id = 'day' onchange = 'setBirthdate();'><?php for ($i = 1; $i <= date('Y')-31; $i++) echo '<option value = "'.$i.'">'.$i.'</option>'; ?></select>
                </div>
                <div class="col-lg-5">
                    <select class="form-control" id = 'month' onchange = 'setBirthdate();'>
                        @foreach ($months as $ind => $val)
                        <option value = '{{$ind}}'>{{$val}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-4">
                    <select class="form-control" id = 'year' onchange = 'setBirthdate();'><?php for ($i = date('Y')-18; $i >= 1950; $i--) echo '<option value = "'.$i.'">'.$i.'</option>'; ?></select>
                </div>
            </div>
        </div>
        <div class="form-group" style = 'display:none;'>
            <label>Тип</label>
            <select class="form-control" name = 'type'><option value = 'passenger'>Пассажир</option><option value = 'driver'>Водитель</option></select>
        </div>
        <div class="form-group @if (isset($messages[0]['password']))has-error @endif">
            <label>Пароль</label>
            <input class="form-control" type = 'password' name = 'password' />
            <p class="help-block">Пароль должен состоять минимум из 8 символов</p>
        </div>
        <div class="form-group @if (isset($messages[0]['password2']))has-error @endif">
            <label>Подтверждение</label>
            <input class="form-control" type = 'password' name = 'password2' />
            <p class="help-block">Введите пароль снова</p>
        </div>

        <input type="submit" class="btn btn-primary" value = 'Регистрация' />
        <br /><br /><br /><br />
    </form>
    @if (isset($messages))
    @foreach($messages[1] as $message)
                <!--<div class="alert alert-danger">{{$message}}</div>-->
    @endforeach
    @endif
</div>
<div class="col-lg-4"></div>

<style>
    .errorField{
        background-color: #FFAFAF;
    }
</style>
<script type = 'text/javascript'>
    function setBirthdate(){
        var year = document.getElementById('year').value;
        var month = document.getElementById('month').value;
        var day = document.getElementById('day').value;
        document.getElementById('birthdate').value = year+'.'+month+'.'+day;
    }
</script>