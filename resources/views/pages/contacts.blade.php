<div class="col-lg-12">
    <div class = 'row'>
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-body">
                    <?php if (isset($_POST['subject'])){ ?>
                    <br /><div class="alert alert-success">Спасибо, ваше сообщение отправлено и будет рассмотрено в ближайшее время.</div>
                    <?php }else{ ?>
                    <div class="row">
                        <div class="col-lg-12">
                            <form role="form" method = 'post'>
                                <input type = 'hidden' name = '_token' value = '{{csrf_token()}}' />
                                Если у вас возникли вопросы или предложения - вы можете отправить их через форму обратной связи<br />
                                <div class="form-group">
                                    <label>Тема</label>
                                    <input class="form-control" name = 'subject'>
                                </div>
                                <div class="form-group">
                                    <label>Сообщение</label>
                                    <input class="form-control" name = 'message'>
                                </div>
                                <input type="button" class="btn btn-primary" onclick = 'this.form.submit();' value = 'Отправить сообщение' />
                            </form>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d603.6739013563442!2d55.791180629259486!3d52.75572659874123!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x417d11ccc07fcac3%3A0x593a5a9274006e6a!2zMi3QuSDQodC-0LLQtdGC0YHQutC40Lkg0L_QtdGALiwgMywg0JrRg9C80LXRgNGC0LDRgywg0KDQtdGB0L8uINCR0LDRiNC60L7RgNGC0L7RgdGC0LDQvSwgNDUzMzAw!5e0!3m2!1sru!2sru!4v1482303846349" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
            <br />
            Наш офис находится по адресу <b>2-й Советский пер., 3, Кумертау, Респ. Башкортостан, 453300</b><br />
        </div>
    </div>
</div>

