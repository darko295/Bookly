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
        "ajax": "http://localhost/domaci_1/DataTables-1.10.4/datatables_obrada_reviews.php",
        "processing": true,
        "serverSide": true
    });

});

$(document).ready(function () {
    var t = $('#tabela').DataTable({
        "columnDefs": [{
            "searchable": false,
            "orderable": false,
            "targets": 0
        }],
        "order": [[1, 'asc']]
    });

    t.on('order.dt search.dt', function () {
        t.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();
});



$(document).ready(function () {
    $(".tabela1").DataTable({
        "columns": [
            {"title": "Question ID"},
            {"title": "Question email"},
            {"title": "Question text"},
            {"title": "Question time"},
            {"title": "Is answered?"},
            {"title": "Is member?"},
            {"title": "User ID"}
        ],
        "ajax": "http://localhost/domaci_1/DataTables-1.10.4/datatables_obrada_questions.php",
        "processing": true,
        "serverSide": true
    });

});

$(document).ready(function () {
    var t = $('#tabela1').DataTable({
        "columnDefs": [{
            "searchable": false,
            "orderable": false,
            "targets": 0
        }],
        "order": [[1, 'asc']]
    });

    t.on('order.dt search.dt', function () {
        t.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();
});

