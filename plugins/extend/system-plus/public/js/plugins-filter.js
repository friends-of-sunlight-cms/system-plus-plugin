$(document).ready(function () {
    $("div.module-plugins > p").after(
        '<div class="hr"><hr></div>'
        + '<div id="systemplusFilterOptions"></div>'
        + '<div class="hr"><hr></div>'
    );

    const systemplusFilterOptions = $('#systemplusFilterOptions');
    // append input
    systemplusFilterOptions.append(
        '<div class="right">'
        + '<strong>' + SunlightVars.tabFilter['filter'] + ':</strong> '
        + '<input class="inputsmall" id="plugin-filter" type="search" autofocus>'
        + '</div>'
    );
    // apply filter (the 'search' event allows to reset the results after clicking on 'X')
    $("#plugin-filter").on("keyup search", function () {
        var value = $(this).val().toLowerCase();
        $("table.plugin-list tbody tr").filter(function () {
            $(this).toggle($(this).find("td:first-child h3").text().toLowerCase().indexOf(value) > -1)
        });
    });
});
