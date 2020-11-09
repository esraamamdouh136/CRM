<?php  $this->load->view("header");?>
<link href="vendors/jquery-paginate-master/src/jquery.paginate.css" rel="stylesheet">

<div class="m-grid__item m-grid__item--fluid m-wrapper" style="margin-right:10%; margin-left:3%; margin-top:1%;">

<div class="row action-row mb-3">
           
            <div class="col-md-12 col-md-offset-2" >
                <div class="mail-sidebar-row">
                <a id="opener2" class="btn btn-info btn-icon btn-block float-right px-5" data-toggle="modal" data-target="#exampleModal">
                        رد
                        <i class="entypo-mail" ></i>
                    </a>
</div>
</div>
</div>
    <div class="m-content">

        <div class="m-portlet">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            تفاصيل الشكوى
                        </h3>
                    </div>
                </div>
            </div>
            <div class="m-portlet__body">
<div class="contains">
    <div class="col-sm-12 CommentContainer" style="float : none;">
<ul id="paginate">
        <?php
        if ($MessageDetails != null){
            foreach ($MessageDetails as $Message){?>
            <li>
                <div class="col-lg-8">
                <section class="comment-list">
                    <article class="row">
                        <div class="col-md-2 col-sm-2 hidden-xs">
                            <figure class="thumbnail">
                                <img class="img-responsive" src="assets/images/user-avatar-placeholder.png" />
                                <figcaption class="text-center">
                                    <?php echo get_Emp_name($Message->Owner_ID)?>
                                </figcaption>
                            </figure>
                        </div>
                        <div class="col-md-10 col-sm-10  border py-1">
                            <div class="panel panel-default arrow right">
                                <div class="panel-body">
                                    <header class="text-left">
                                        التاريخ
                                        <time class="comment-date" datetime="<?php echo $Message->Send_Date ?>"><i
                                                class="fa fa-clock-o"></i>
                                            <?php echo ' '.$Message->Send_Date ?></time>
                                    </header>
                                    <div class="comment-post text-break">

                                            <?php echo $Message->complaints_details ?>

                                    </div>

                                </div>
                            </div>
                        </div>

                    </article>
                </section>
            </div>
            </li>
            <?php }
        }
        ?>
        </ul>
    </div>

       

                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"> ارسال رساله</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
         
        </button>
      </div>
      <div class="modal-body">
      <form method="post" action="<?php echo $url.'CRM_Complain/Replay'?>">
                                    <input type="hidden" name="msgID"  value="<?= $MessageDetails[0]->complaints_ID?>">
                                    <div class="form-group">
                                        <label for="subject">المحتوى:</label>
                                        <textarea type="text" required name="content" class="form-control etextar2" id="subject" rows="7" cols="50"
                                               tabindex="1" /> </textarea>
                                    </div>   
                             
      </div>
      <div class="modal-footer">
          
      <button type="submit" class="btn btn-info" value="ارسال"> ارسال  </button>
      </form>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">غلق</button>
      </div>
    </div>
  </div>





                 

                </div>


            </div>
        </div>



    </div>
</div>
    </div>
    </div>
    </div>
    </div>


<script>

// $('#paginate').paginate({
//     "perPage": 2
// });
</script>

</body>
</html>