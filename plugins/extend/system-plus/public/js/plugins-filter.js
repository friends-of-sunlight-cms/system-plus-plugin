$(document).ready(function () {
    // append input
    $("div.module-plugins > p").append('<input class="inputsmall right" id="plugin-filter" type="search" placeholder="Filter..." autofocus>')
    // apply filter (the 'search' event allows to reset the results after clicking on 'X')
    $("#plugin-filter").on("keyup search", function () {
        var value = $(this).val().toLowerCase();
        $("table.plugin-list tbody tr").filter(function () {
            $(this).toggle($(this).find("td:first-child h3").text().toLowerCase().indexOf(value) > -1)
        });
    });
});
