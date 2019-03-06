var colores = ['#FF6633', '#ffafb8', '#FF33FF', '#FFFF99', '#00B3E6',
    '#E6B333', '#3366E6', '#999966', '#99FF99', '#B34D4D',
    '#80B300', '#809900', '#E6B3B3', '#6680B3', '#66991A',
    '#FF99E6', '#CCFF1A', '#FF1A66', '#E6331A', '#33FFCC',
    '#66994D', '#B366CC', '#4D8000', '#B33300', '#CC80CC',
    '#66664D', '#991AFF', '#E666FF', '#4DB3FF', '#1AB399',
    '#E666B3', '#33991A', '#CC9999', '#B3B31A', '#00E680',
    '#4D8066', '#809980', '#E6FF80', '#1AFF33', '#999933',
    '#FF3380', '#CCCC00', '#66E64D', '#4D80CC', '#9900B3',
    '#E64D66', '#4DB380', '#FF4D4D', '#99E6E6', '#6666FF'];


cargarEstadisticasIncidenciasAbiertas();
cargarEstadisticasIncidenciasCerradas();
cargarEstadisticasIncidenciasCerradasTecnicos();


function cargarEstadisticasIncidenciasAbiertas() {

    $.ajax({
        url:"cargarEstadisticasIncidenciasAbiertas",
        type: "get",
        dataType: "json",
        async: false,
        success: function (return_data) {

            var categoria = [];
            var cantidad = [];

            for (i = 0; i < return_data.length; i++) {
                categoria.push(return_data[i]['categoria']);
                cantidad.push(return_data[i]['cantidad']);
            }

            var ctxP = document.getElementById("abiertas").getContext('2d');
            var myPieChart = new Chart(ctxP, {
                type: 'pie',
                data: {
                    labels: categoria,
                    datasets: [{
                        data: cantidad,
                        backgroundColor: ['#FF6633', '#ffafb8', '#FF33FF', '#FFFF99', '#00B3E6',
                            '#E6B333', '#3366E6', '#999966', '#99FF99', '#B34D4D',
                            '#80B300', '#809900', '#E6B3B3', '#6680B3', '#66991A',
                            '#FF99E6', '#CCFF1A', '#FF1A66', '#E6331A', '#33FFCC',
                            '#66994D', '#B366CC', '#4D8000', '#B33300', '#CC80CC',
                            '#66664D', '#991AFF', '#E666FF', '#4DB3FF', '#1AB399',
                            '#E666B3', '#33991A', '#CC9999', '#B3B31A', '#00E680',
                            '#4D8066', '#809980', '#E6FF80', '#1AFF33', '#999933',
                            '#FF3380', '#CCCC00', '#66E64D', '#4D80CC', '#9900B3',
                            '#E64D66', '#4DB380', '#FF4D4D', '#99E6E6', '#6666FF']
                    }]
                },
                options: {
                    responsive: true
                }
            });

        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(xhr,ajaxOptions,thrownError);
        }
    });

    return false;
}

function cargarEstadisticasIncidenciasCerradas() {

    $.ajax({
        url:"cargarEstadisticasIncidenciasCerradas",
        type: "get",
        dataType: "json",
        async: false,
        success: function (return_data) {

            var categoria = [];
            var cantidad = [];

            for (i = 0; i < return_data.length; i++) {
                categoria.push(return_data[i]['categoria']);
                cantidad.push(return_data[i]['cantidad']);
            }

            var ctxP = document.getElementById("cerradas").getContext('2d');
            var myPieChart = new Chart(ctxP, {
                type: 'pie',
                data: {
                    labels: categoria,
                    datasets: [{
                        data: cantidad,
                        backgroundColor: colores
                    }]
                },
                options: {
                    responsive: true
                }
            });

        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(xhr,ajaxOptions,thrownError);
        }
    });

    return false;
}

function cargarEstadisticasIncidenciasCerradasTecnicos() {

    $.ajax({
        url:"cargarEstadisticasIncidenciasCerradasTecnicos",
        type: "get",
        dataType: "json",
        async: false,
        success: function (return_data) {

            var juan = {
                label: "Juan",
                data: [65, 59, 80, 81, 56, 55, 40],
                backgroundColor: [
                    'rgba(255, 255, 255, .0)',
                ],
                borderColor: [
                    '#4DB380',
                ],
                borderWidth: 2
            };

            //line
            var ctxL = document.getElementById("lineChart").getContext('2d');
            var myLineChart = new Chart(ctxL, {
                type: 'line',
                data: {
                    labels: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio"],
                    datasets: [
                        juan
                    ]
                },
                options: {
                    responsive: true
                }
            });

        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(xhr,ajaxOptions,thrownError);
        }
    });

    return false;
}