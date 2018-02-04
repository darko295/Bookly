

$(function () {

    $(".rateYo").rateYo({rating: 0, ratedFill: "#000", halfStar: true})
        .on("rateyo.set", function (e, data) {
            document.getElementById("stars-rating").value = data.rating;
        });


});




    $(document).ready(function () {
        $(".remove-row").click(function () {
            var value = ($(this).attr("id")).substring(7);
            var table_row = $(this);
            $.get("delete_review.php", {reviewID: value},
                function (data) {
                    if (data == 1) {
                        $.notify("Review deleted", "success");
                        $(table_row).parent().parent().parent().remove();
                    }
                });
        });
    });




$(document).ready(function () {
    $(".wishlist-add").click(function () {
        var info = ($(this).attr("id")).split('-');
        var action = info[0];
        var book_id = info[3];
        var author_id = info[2];
        var user_id = info[1];
        $.ajax({
            type: "POST",
            url: "ws_calls.php",
            data: {
                author_id: author_id,
                user_id: user_id,
                book_id: book_id,
                action: action
            },
            success: function (data) {
                if (data === "1") {
                    $.notify("Item added", "success");
                } else {
                    alert(data);
                }
            }
        });
    });
});







function refresh() {
    var action = "nesto";
    $.ajax({
        type: "POST",
        url: "wishlist_ajax.php",
        data: {
            action: action
        },
        success: function (data) {
            if (data !== "1") {
                $("#table-div").show();
                $("#table-div").html(data);
            } else {
                $.notify("Error occurred", "warn");
            }
        }
    });

}



    function obrisi(record_id) {
        $.ajax({
            type: "POST",
            url: "ws_delete.php",
            data: {
                record_id: record_id
            },
            success: function (result) {
                if (result === "0") {
                    alert("Greska");
                } else {
                    var row = "#delete-item-" + record_id;
                    $.notify("Deleting successful", "success");
                    $(row).parent().parent().remove();
                    refresh();
                }
            }
        });

    }





    $(document).ready(function () {
        $("#show-wishlist").click(function () {
            var action = "nesto";
            $.ajax({
                type: "POST",
                url: "wishlist_ajax.php",
                data: {
                    action: action
                },
                success: function (data) {
                    if (data !== "0") {
                        $("#table-div").show();
                        $("#table-div").html(data);
                    } else {
                        $.notify("Error occurred", "warn");
                    }
                }
            });
        });
    });






$(document).ready(function () {
    $(".more-info").click(function () {
        var info = ($(this).attr("id")).split('-');
        //     var book_title = info[3];
        var author_surname = info[2];
        var author_name = info[1];
        var author = author_name + '_' + author_surname;
        var url = "http://en.wikipedia.org/w/api.php?action=parse&format=json&prop=text&section=0&redirects&page=" + author + "&callback=?";


        $.ajax({
            type: "GET",
            url: url,
            contentType: "application/json; charset=utf-8",
            async: false,
            cache: false,
            dataType: "json",
            success: function (data) {
                $('#author-name-surname').text('More info about ' + author_name + ' ' + author_surname);

                var raw = data.parse.text["*"];
                var blurb = $('<div></div>').html(raw);
                blurb.find('a').each(function () {
                    $(this).replaceWith($(this).html());
                });
                blurb.find('sup').remove();
                blurb.find('.mw-ext-cite-error').remove();

                if ($(blurb).find('p')) {
                    $('.data').html($(blurb).find('p'));
                    $('.get-pdf-class').show();

                    var pdf = document.getElementById('get-pdf');
                    pdf.value = author;
                } else {
                    $('.get-pdf-class').hide();
                }

            },
            error: function () {
                alert("Error occurred.");
            }
        });
    });
});


function reset() {
    $('.data').empty();
    var initial = $('.data-not-found').html();
    $('.data').html(initial);
    $('.get-pdf-class').hide();
}




function get_pdf(element) {
    var author = $(element).attr('value');
    var url = "https://en.wikipedia.org/api/rest_v1/page/pdf/" + author;
    $.ajax({
        type: "GET",
        url: url,
        xhrFields: {
            responseType: 'blob'
        },
        success: function (blob) {
            console.log(blob.size);
            var link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = author + ".pdf";
            link.click();
        },
        error: function () {
            alert('Error');
        }
    });
}



$(document).ready(function () {
    $(".more-by-this-author").click(function () {
        var info = ($(this).attr("id")).split('-');
        var action = info[0];
        var author_name = info[1];
        var author_surname = info[2];
        $.ajax({
            type: "GET",
            url: "more_books.php",
            data: {
                author_name: author_name,
                author_surname: author_surname,
                action: action
            },
            success: function (data) {
                if (data === "1") {
                    $.notify("Item added", "success");
                } else {
                    $("#show-this").show();
                    $("#more-books").html(data);
                }
            }
        });
    });
});



function view_more(item) {

    var id = $(item).attr('id');

    var string = id.substring(10);
    var parts = string.split(' ');
    var url = "https://www.goodreads.com/book/title?id=";

    for (var i = 0; i < parts.length; i++) {
        if (i === parts.length) {
            url = url + parts[i];
        } else {
            url = url + parts[i];
            url = url + '+';
        }
    }
    window.open(url);


}

