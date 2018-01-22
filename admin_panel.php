<html>

<head>

    <script src="js/jquery-2.1.1.min.js"></script>
    <script src="DataTables-1.10.4/media/js/jquery.js"></script>
    <link rel="stylesheet" type="text/css" href="DataTables-1.10.4/media/css/jquery.dataTables.min.css"/>
    <script src="DataTables-1.10.4/media/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function () {
            $(".tabela").DataTable({
                "columns": [
                    {"title": "Review ID"},
                    {"title": "User ID"},
                    {"title": "Book ID"},
                    {"title": "Author ID"},
                    {"title": "Review Content"},
                    {"title": "Review stars"},
                    {"title": "Review time"}
                ],
                "ajax": "datatables_obrada.php",
                "processing": true,
                "serverSide": true
            });

        });
    </script>


</head>
<body>
<table class="tabela display" width="100%">
</table>

</body>
</html>

