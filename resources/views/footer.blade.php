    
        </section>
        <script src="{{asset('/assets/js/bootstrap.js')}}"></script>
        <script src="{{asset('/assets/js/jquery.dcjqaccordion.2.7.js')}}"></script>
        <script src="{{asset('/assets/js/scripts.js')}}"></script>

        <script src="{{asset('/assets/js/jquery.nicescroll.js')}}"></script>
        <script  src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
        <script  src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
        <script src="{{asset('/assets/js/ajax.js')}}"></script>

        <script  src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
        <script  src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    
        <script  src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script  src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script  src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script  src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
        <script  src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        
       
       
       
       
       
        <script>
            $(document).ready(function() {
                $('#example').DataTable({
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ]
                });
                
                  $('.code-select2').select2({
                        placeholder: 'Select Custome Code',
                    allowClear: true,
                 });
               
            });
        </script>
	</body>
</html>