<?php $this->load->view("header");
/**
 * Created by PhpStorm.
 * User: abdob
 * Date: 10/10/2018
 * Time: 9:35 PM
 */

?>
<script src="assets/UploadFiles/jquery-2.2.0.min.js"></script>
<script src="assets/UploadFiles/jquery.form.min.js"></script>

<style>

    .formarea{
        width:60%;
        margin:0 auto;
        background-color:#fff;
        text-align:center;
        padding:4%;
        border-radius:5px;
    }

    #bararea{
        width:100%;
        height:27px;
        border:2px solid #000;
    }

    #bar{
        width:0%;
        margin:1px;
        height:20px;
        background-color: #18ff10;
    }

    #status{
        color:#000;
    }
</style>


<div class="formarea">

    <form method="post" action="<?=$url?>Upload_Data/save" enctype="multipart/form-data">
        <input type="file" name="file" id="file" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"/>
        <button id="btnUpload">تحميل ملف</button>
    </form>

<div id="barContenar" style="display: none">
    <div id="bararea">
        <div id="bar"></div>
    </div>

    <div id="percent"></div>
    <div id="status"></div>
</div>


</div>

<script>
    var cont = document.getElementById('barContenar');
    var file = document.getElementById('file');
    document.getElementById('btnUpload').onclick=function () {
        if (file.value !=""){
            cont.style.display ="block";
        }
    };
    $(function() {
        $(document).ready(function(){
            var bar = $('#bar')
            var percent = $('#percent');
            var status = $('#status');

            $('form').ajaxForm({
                beforeSend: function() {
                    status.empty();
                    var percentVal = '0%';
                    bar.width(percentVal);
                    percent.html(percentVal);
                },
                uploadProgress: function(event, position, total, percentComplete) {
                    var percentVal = percentComplete + '%';
                    percent.html(percentVal);
                    bar.width(percentVal);
                },
                complete: function(xhr) {
                    status.html(xhr.responseText);
                }
            });
        });
    });
</script>