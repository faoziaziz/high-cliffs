<div class="col-sm-12">
    <!-- start: TEXT FIELDS PANEL -->
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="fa fa-external-link-square"></i>
            Text Fields
            <div class="panel-tools">
                <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                </a>
                <a class="btn btn-xs btn-link panel-config" href="#panel-config" data-toggle="modal">
                    <i class="fa fa-wrench"></i>
                </a>
                <a class="btn btn-xs btn-link panel-refresh" href="#">
                    <i class="fa fa-refresh"></i>
                </a>
                <a class="btn btn-xs btn-link panel-expand" href="#">
                    <i class="fa fa-resize-full"></i>
                </a>
                <a class="btn btn-xs btn-link panel-close" href="#">
                    <i class="fa fa-times"></i>
                </a>
            </div>
        </div>
        <div class="panel-body">

            <?php
            echo form_open_multipart('users/add', 'role="form" class="form-horizontal"');
            ?>


               <div class="form-group">
                        <label class="col-sm-2 control-label" for="form-field-1">Username</label>
                        <div class="col-sm-10">
                            <input type="text" id="form-field-1" class="form-control" name="txtusername"/>
                        </div>
                        <span class="help-block"></span>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="form-field-1">Password</label>
                        <div class="col-sm-10">
                            <input type="password" id="form-field-1" class="form-control" name="txtpassword"/>
                        </div>
                        <span class="help-block"></span>
                        
                    </div>
                      
                   
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="form-field-1">Level</label>
                        <div class="col-sm-10">
                        <?php echo cmb_dinamis('txtlevel','User_level','nama_level','id_level_user', null,"id='datawp'") ?>
                        </div>
                        <span class="help-block"></span>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="form-field-1">Email</label>
                        <div class="col-sm-10">
                            <input type="email" id="form-field-1" class="form-control" name="txtemail"/>
                        </div>
                        <span class="help-block"></span>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="form-field-1">Foto</label>
                        <div class="col-sm-10">
                            <input type="file" id="form-field-1" class="form-control" name="userfile"/>
                        </div>
                        <span class="help-block"></span>
                        
                    </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="form-field-1">

                </label>
                <div class="col-sm-1">
                    <button type="submit" name="submit" class="btn btn-danger  btn-sm">SIMPAN</button>
                </div>
                <div class="col-sm-1">
                    <?php echo anchor('users', 'Kembali', array('class' => 'btn btn-info btn-sm')); ?>
                </div>
            </div>
            </form>
        </div>
    </div>
    <!-- end: TEXT FIELDS PANEL -->
</div>