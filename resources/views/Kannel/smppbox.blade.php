<div class="content-wrapper">
    <section class="content-header">
        <h1>Smppbox  (Users's)</h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div id="smppbox"></div>
                </div>
            </div>
        </div>
    </section>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        getResultSmppBox();
        setInterval("getResultSmppBox()",2000);
    }); 
    function getResultSmppBox(){   
        jQuery.get("/ajaxsmppbox" ,function( data ) {
            jQuery("#smppbox").html(data);
        });
    }
</script>
