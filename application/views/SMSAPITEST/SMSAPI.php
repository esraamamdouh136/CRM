<html>
<head>
    <title>Test SMS</title>
</head>
<body>

<form method="post"  action="<?=$url?>SMS/send">

    <div class="form-group">

        <div class="input-group">
            <div class="input-group-addon">
                <i class="entypo-phone"></i>
            </div>
            <input type="text"  class="form-control" name="Phone" id="Phone" placeholder="Phone" autocomplete="off" />
        </div>

    </div>


    <div class="form-group">

        <div class="input-group">
            <div class="input-group-addon">
                <i class="entypo-phone"></i>
            </div>
            <input type="text"  class="form-control" name="message" id="message" placeholder="Phone" autocomplete="off" />
        </div>

    </div>



    <div class="form-group">
        <button  type="submit" class="btn btn-primary btn-block btn-login" >
            <i class="entypo-login"></i>
            Send SMS
        </button>
    </div>

</form>
</body>
</html>