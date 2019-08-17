<!-- <div class="modal-dialog">
    <div class="modal-content" style="margin-top:100px;">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" style="text-align:center;">Are you sure to delete this information ?</h4>
      </div>
                
      <div class="modal-footer" style="margin:0px; border-top:0px; text-align:center;">
        <a href="#" class="btn btn-danger" id="delete_link">Delete</a>
        <button type="button" class="btn btn-success" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div> -->
    <div class="table-resposnive">
                        <table class="table table-striped table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>Device id</th>
                                <th>Tanggal</th>
                                <th>Total</th>
                                
                            </tr>
                          
                            </thead>
                         <tbody>
                            <?php

                              foreach($record as $r){
                                echo "

                                <tr>
                                  <td>$r->date</td>
                                  <td>$r->DeviceId</td>
                                  <td>$r->total</td>

                                </tr>
                                ";
                              }
                            ?>
                          
                        </tbody>
                    </table>
                    </div>