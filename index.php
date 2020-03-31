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
                    <input type="text" name="first_name" id="first_name" class="form-control">
                    <span id="error_first_name" class="text-danger"></span>
                </div>
                <div class="form-group">
                    <label> Enter Last Name </label>
                    <input type="text" name="last_name" id="last_name" class="form-control">
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

        </div>
    </div>
</body>

</html>

<script>
    $(document).ready(function() {
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
        $("#user_dialog").dialog({
            autoOpen: false,
            width: 400
        });


    });
</script>