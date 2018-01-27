
$(document).ready(function(){
    $.ajax({
        url: "json/views_by_day.json",
        method: "GET",
        success: function(data) {
            console.log(data);
            var date = [];
            var viewsBookly = [];
            var viewsIndex = [];
            var brojac = 0;
            for(var i in data) {

                if(!date.includes("On " + data[i].views_date)){
                    date.push("On " + data[i].views_date);
                }
                if(data[i].page === "bookly.php"){
                    viewsBookly.push(data[i].views);
                }else if(data[i].page === "index.php"){
                    viewsIndex.push(data[i].views);
                }
                brojac++;
                if(viewsIndex.length === 7 && viewsBookly.length === 7 ){
                    break;

                }
            }
            date.reverse();
            viewsBookly.reverse();
            viewsIndex.reverse();
            var chartdata = {
                labels: date,
                datasets : [
                    {
                        label: 'Hits on index.php',
                        borderColor: 'rgba(250, 100, 100, 0.75)',
                        hoverBorderColor: 'rgba(200, 200, 200, 1)',
                        data: viewsIndex
                    },
                    {
                        label: 'Hits on bookly.php',
                        borderColor: 'rgba(200, 200, 200, 0.75)',
                        hoverBorderColor: 'rgba(200, 200, 200, 1)',
                        data: viewsBookly
                    }
                ]
            };

            var ctx = $("#mycanvas");

            var lineGraph = new Chart(ctx, {
                type: 'line',
                data: chartdata
            });
        },
        error: function(data) {
            console.log(data);
        }
    });
});





$(document).ready(function(){
    $.ajax({
        url: "json/total_views.json",
        method: "GET",
        success: function(data) {
            console.log(data);
            var totalBookly = 0;
            var totalIndex = 0;
            for(var i in data) {


                if(data[i].page_total === "bookly.php"){
                    totalBookly = data[i].views_total;
                }else if(data[i].page_total === "index.php"){
                    totalIndex = data[i].views_total;
                }

            }

            var chartdata = {
                labels: ["index.php", "bookly.php"],
                datasets : [
                    {
                        label: "Total visits",
                        data: [totalIndex,totalBookly],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255,99,132,1)',
                            'rgba(54, 162, 235, 1)'
                        ],
                        borderWidth: 1

                    }
                ]
            };

            var ctx = $("#mycanvas1");

            var barGraph = new Chart(ctx, {
                type: 'bar',
                data: chartdata,
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero:true
                            }
                        }]
                    }
                }
            });
        },
        error: function(data) {
            console.log(data);
        }
    });
});
