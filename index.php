<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP AJAX jQuery CRUD</title>
    <link rel="stylesheet" href="assets/jquery-ui.css">
    <link rel="stylesheet" href="assets/bootstrap.min.css">
    <script src="assets/jquery.min.js"></script>
    <script src="assets/jquery-ui.js"></script>
</head>

<body>
    <div class="container">
        <br>
        <h3 align="center">PHP AJAX CRUD Using jQuery UI Dialog</h3>
        <br>
        <br>
        <div align="right" style="margin-bottom: 5px;">
            <button type="button" name="add" id="add" class="btn btn-success">Add</button>
        </div>
        <div class="table-responsive" id="user_data">

        </div>
        <br>
        <div id="user_dialog" title="Add Data">
            <form id="user_form" method="post">
                <div class="form-group">
                    <label> Enter First Name </label>
                    <input type="text" name="first_name" id="first_name" class="form-control" required>
                    <span id="error_first_name" class="text-danger"></span>
                </div>
                <div class="form-group">
                    <label> Enter Last Name </label>
                    <input type="text" name="last_name" id="last_name" class="form-control" required>
                    <span id="error_last_name" class="text-danger"></span>
                </div>
                <div class="form-group">
                    <input type="hidden" name="action" id="action" value="insert">
                    <input type="hidden" name="hidden_id" id="hidden_id">
                    <input type="submit" name="form_action" id="form_action" class="btn btn-info" value="Insert">
                </div>
            </form>
            <div id="action_alert" title="Action">

            </div>
            <div id="delete_confirmation" title="Confirmation">
                <p>Are You Sure, Want Delete the Data?</p>
            </div>

        </div>
    </div>
</body>

</html>

<script>
    $(document).ready(function() {
        // Memanggil fungsi untuk menampilkan data 
        load_data();

        // fungsi untuk me load data dari database 
        function load_data() {
            $.ajax({
                url: "fetch.php",
                method: "POST",
                success: function(data) {
                    $('#user_data').html(data);
                }
            });
        }

        // function user dialog untuk menampilkan form inputan
        $("#user_dialog").dialog({
            autoOpen: false,
            width: 400
        });

        // function on click modal dialog jquery 
        $('#add').click(function() {
            $('#user_dialog').attr('title', 'Add Data');
            $('#action').val('insert');
            $('#form_action').val('Insert');
            $('#user_form')[0].reset();
            $('#form_action').attr('disabled', false);
            $("#user_dialog").dialog('open');
        });

        // function insert on dialog form
        $('#user_form').on('submit', function(event) {
            event.preventDefault();
            /**
            fungsi eevnt.preventDefault adalah sebuah method yang mencegah event bawaan dari sebuah DOM, misalkan tag "a href" jika kita klik akan melakukan reload dan memathakn fungsi jQuery yang berjalan */
            var error_first_name = '';
            var error_last_name = '';

            // membuat sebuah fungsi validasi untuk form inptan 
            if ($('#first_name').val() == '') {
                $('#error_first_name').text('First Name is Required');
                $('#first_name').css('border-color', 'red');
            } else {
                $('#error_first_name').text('');
                $('#first_name').css('border-color', 'blue');
            }
            if ($('#last_name').val() == '') {
                $('#error_last_name').text('Last Name is Required');
                $('#last_name').css('border-color', 'red');
            } else {
                $('error_last_name').text('');
                $('#last_name').css('border-color', '');
            }

            // setelah di validasi lanjut untuk proses inputan menggunakn ajax 
            if (error_first_name != '' || error_last_name != '') {
                return false;
            } else {
                $('#form_action').attr('disabled', 'disabled');
                var form_data = $(this).serialize();
                /**
                Fungsi serialize adalah fungsi untuk merubah value pada form inptan menjadi type data array untuk di kirimkan ke database
                 */
                $.ajax({
                    url: 'action.php',
                    method: 'POST',
                    data: form_data,
                    success: function(data) {
                        $('#user_dialog').dialog('close');
                        $('#action_alert').html(data);
                        $('#action_alert').dialog('open');
                        load_data();
                        $('#form_action').attr('disabled', false);
                    }
                });
            }
        });
        $('#action_alert').dialog({
            autoOpen: false
        });

        $(document).on('click', '.edit', function() {
            var id = $(this).attr('id');
            var action = 'fetch_single';
            $.ajax({
                url: 'action.php',
                method: 'POST',
                data: {
                    id: id,
                    action: action
                },
                dataType: "json",
                success: function(data) {
                    $('#first_name').val(data.first_name);
                    $('#last_name').val(data.last_name);
                    $('#user_dialog').attr('title', 'Edit Data');
                    $('#action').val('update');
                    $('#hidden_id').val(id);
                    $('#form_action').val('Update');
                    $('#user_dialog').dialog('open');
                }
            })
        })

        $('#delete_confirmation').dialog({
            autoOpen: false,
            modal: true,
            buttons: {
                Ok: function() {
                    var id = $(this).data('id');
                    var action = 'delete';
                    $.ajax({
                        url: 'action.php',
                        method: 'POST',
                        data: {
                            id: id,
                            action: action
                        },
                        success: function(data) {
                            $('#delete_confirmation').dialog('close');
                            $('#action_alert').html(data);
                            $('#action_alert').dialog('open');
                            load_data();
                        }

                    });
                },
                Cancel: function() {
                    $(this).dialog('close');
                }
            }
        });
        $(document).on('click', '.delete', function() {
            var id = $(this).attr("id");
            $('#delete_confirmation').data('id', id).dialog('open');
        });

    });
</script>