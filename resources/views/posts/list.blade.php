<div class="col-lg-12">
    <?php
    if ($postPages > 1){
        echo 'Страницы: ';
        for ($a = 1; $a <= $postPages; $a++) echo $a==$_GET['page']?'[ '.$a.' ] ':'<a href = "?page='.$a.'">[ '.$a.' ]</a> ';
    }
    ?>
    <div class="panel panel-default">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Направление</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($posts as $post)
                    <tr>
                        <td><a href = '/poputchik/{{strtolower($post->pointFrom['transname'])}}/{{strtolower($post->pointTo['transname'])}}'>Из "<b>{{$post->pointFrom['name']}}</b>" в "<b>{{$post->pointTo['name']}}</b>"</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <?php
    if ($postPages > 1){
        echo 'Страницы: ';
        for ($a = 1; $a <= $postPages; $a++) echo $a==$_GET['page']?'[ '.$a.' ] ':'<a href = "?page='.$a.'">[ '.$a.' ]</a> ';
    }
    ?>
    <br /><br />
</div>