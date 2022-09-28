<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title">SMPP User Credential</h4>
        </div>
        <div class="modal-body">
            <strong>
                <style type="text/css">
                    .modal-body p {
                      margin: 0 0 2px;
                    }
                </style>
                <p>White listed IP: - {{ $data->IpAddress }}</p>
                <p>Username: - {{ $data->Username }}</p>
                <p>Password: - {{ $data->Password }}</p>
                <p>Trx: - {{ $data->MaxInstances }} &nbsp;&nbsp; | &nbsp;&nbsp; Tx/Rx: - {{ $data->MaxReceiverInstances }}/{{ $data->MaxTransceiverInstances }}
                </p>
                <p>Host: - 15.206.96.24 </p>
                <p>Port: - 2775</p>                
                <p>Tps: - {{ $data->Throughput }}</p>
            </strong>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn  btn-primary" data-dismiss="modal">Close</button>  
        </div>
    </div>    
</div>