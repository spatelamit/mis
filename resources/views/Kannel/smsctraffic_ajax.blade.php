<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Messages Summary's Only Date <?php echo date('Y-m-d'); ?></h3>
                </div>
                <div class="box-body">
                    <table id="example1" class="table table-bordered table-striped responsive"  style="text-transform: capitalize;" data-page-length='25'>
                        <thead>
                            <tr>
                                <th>Sno.</th>
                                <th>SMSC's Name</th>
                                <th>Submit</th>
                                <th>Delivered</th>
                                <th>Failed</th>
                                <!-- <th>Sent</th> -->
                            </tr>
                        </thead>
                        <tbody>

                        <?php
                            // I AM FOR ORIGNIAL SMSC's
                            $i = 1;
                            $Delivered = 0;
                            $Failed=0;
                            $Reject=0;
                            $Sent=0;
                            $Submit=0;

                            //$HoldSmsc='';
                            if (isset($SmscsTraffic)) {
                                foreach ($SmscsTraffic as $key => $value) {
                                    $Delivered=(isset($value['1']) && $value['1'])?$value['1']:'0';
                                    $Failed=(isset($value['2']) && $value['2'])?$value['2']:'0';
                                    $Reject=(isset($value['16']) && $value['16'])?$value['16']:'0';
                                    $Failed = $Failed+$Reject;
                                    $Total = abs($Delivered+$Failed);
                        ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $value['name']; ?></td>
                                <td><?php echo $Total; ?> </td>
                                <td><?php echo $Delivered; ?> </td>
                                <td><?php echo $Failed; ?> </td>

                            </tr>        
                        <?php   
                            $i++;
                            }
                        }
                        ?>

                        <?php
                            //  i AM FOR FAKE SMSC
                            
                            $i = 1;
                            $Delivered = 0;
                            $Failed=0;
                            $Reject=0;
                            $Sent=0;
                            $Submit=0;
                            if (isset($fakeTraffic)) {
                                foreach ($fakeTraffic as $key => $value) {
                                    $Delivered=(isset($value['1']) && $value['1'])?$value['1']:'0';
                                    $Failed=(isset($value['2']) && $value['2'])?$value['2']:'0';
                                    $Total = abs($Delivered+$Failed);
                                
                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $value['name']; ?></td>
                            <td><?php echo $Total; ?> </td>
                            <td><?php echo $Delivered; ?> </td>
                            <td><?php echo $Failed; ?> </td>
                        </tr>
                                    
                        <?php
                                $i++;
                            }
                        }
                        ?>
                 </tbody>
                        <tfoot>
                             <tr>
                                <th>Sno.</th>
                                <th>SMSC's Name</th>
                                <th>Submit</th>
                                <th>Delivered</th>
                                <th>Failed</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>