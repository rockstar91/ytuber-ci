
<div class="row">
    <!-- /.col-lg-4 -->
    <div class="col-lg-4">
        <div class="panel panel-primary">
            <div class="panel-body">
                <?=form_open('dashboard'); ?>


                    <div class="form-group col-sm-6">
                        <select class="form-control" name="type_id" id="type_id">
                            <option value="0">- Выберите -</option>
                            <option value="1">Физическое лицо</option>
                            <option value="2">Юридическое лицо</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input class="form-control" name="email" id="email" placeholder="Email">
                    </div>
                        <p id="iserror">is error</p>
                    <div class="form-group">
                        <input class="form-control" name="subject" placeholder="">
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" name="text" placeholder="" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-default">Отправить</button>
                    <button type="reset" class="btn btn-default"><?=$this->lang->line('tpl_support_reset');?></button>
                </form>
            </div>
        </div>
    </div>
    <!-- /.col-lg-4 -->
</div>
    <script src="/static/bower/jquery/dist/jquery.min.js"></script>


<script type="text/javascript">
    $("#email").change(function(){
        if($(this).val().length == 0) {
            $(this).addClass('error');
        }
        else {
            $(this).removeClass('error');
        }
    });

    $("iserror").click(function(event) {

        if($("#email").hasClass('error')) 
        {
            alert('has error');
        }
        else 
        {
            alert('no have');
        }
    });
</script>