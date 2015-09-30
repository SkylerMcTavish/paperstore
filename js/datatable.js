/**
 * Funciones para Listados
 *   
 * */


/**
 * reload_table
 * Sets column and order values and calls reload_table()
 * @param String table The table ID
 */
function reload_table(table) {

    if (table != '') {

        show_loader(table);
        
        var sord = $('#inp_' + table + '_sord').val();
        var sidx = $('#inp_' + table + '_sidx').val();
        var page = parseInt($('#inp_' + table + '_page').val());
        var rows = $('#inp_' + table + '_rows').val();
        var list = $('#inp_' + table + '_list').val();
        var fidx = $('#inp_' + table + '_fidx').val();
        var fval = $('#inp_' + table + '_fval').val();
        var exfidx = $('#inp_' + table + '_exfidx').val();
        var exfval = $('#inp_' + table + '_exfval').val();
        var srch_string = $('#inp_' + table + '_srch_string').val();
        var srch_idx = $('#inp_' + table + '_srch_idx').val();
        var tpages = parseInt($('#inp_' + table + '_tpages').val());
        if (page < 1) {
            page = 1;
            $('#inp_' + table + '_page').val(1);
        } else if (page > tpages) {
            page = tpages;
            $('#inp_' + table + '_page').val(tpages);
        }

        $.ajax({
            url: "ajax.php",
            type: "POST",
            async: false,
            data: {
                resource: 'lists',
                action: list,
                table_id: table,
                page: page,
                rows: rows,
                sord: sord,
                sidx: sidx,
                searchField: srch_idx,
                searchString: srch_string,
                filterIdx: fidx,
                filterVal: fval,
                extraFilterIdx: exfidx,
                extraFilterVal: exfval
            },
            dataType: "json",
            success: function (data) {
                if (data.success == true) {
                    $('#' + table + '_tbody').html(data.html);
                    $('#' + table + '_lbl_foot').html(data.lbl_foot);
                    $('#' + table + '_lbl_tpages').html(data.tpages);

                    $('#inp_' + table + '_rows').val(data.rows);
                    $('#inp_' + table + '_page').val(data.page);
                    
                    //$('#' + table + '_tfoot').html(data.fcn_foot);

                    set_header(table);
                }
                else {
                    show_error(data.error);
                    return false;
                }
            }
        });


    } else {
        show_error('DataTableLib (js): Invalid table to reload.');
    }

}

/**
 *  move_page(table, direction)
 */
function  move_page(table, direction) {
    var ipage = parseInt($('#inp_' + table + '_page').val());
    var tpages = $('#inp_' + table + '_tpages').val();
    var page = 0;
    switch (direction) {
        case 'n':
            page = ipage + 1;
            break;
        case 'l':
            page = tpages;
            break;
        case 'p':
            page = ipage - 1;
            break;
        case 'f':
            page = 1;
            break;
    }
    $('#inp_' + table + '_page').val(page);
    reload_table(table);
}

function set_header(table) {
    var sidx = $('#inp_' + table + '_sidx').val();
    var str_sidx = table + '_hd_' + sidx;
    $('.' + table + '_head.sortable ').each(function (index) {
        var col = this.id;
        if (col == str_sidx) {
            var sord = $('#inp_' + table + '_sord').val();
            $('#' + this.id).attr('class', table + '_head sortable sorting_' + ((sord == 'DESC') ? 'asc' : 'desc'));
        } else
            $('#' + this.id).attr('class', table + '_head sortable sorting');

    });
}

function show_loader(table) {
    var test = $('#' + table + ' thead tr');

    var html = "<tr> <td colspan = " + $('#inp_' + table + '_cols').val() + "' class='text-center' />";
    html += "<img src='img/loader.gif' /> </td></tr>";
    var loader = "";
    $('#' + table + ' tbody').html(html);
}

/**
 * sort_table
 * Sets column and order values and calls reload_table()
 * @param String table
 * @param String col
 * @param String ord 'ASC' or 'DESC'
 */
function sort_table(table, col, ord) {
    if (table != '' && col != '') {
        var sord = 'ASC';
        if ($('#inp_' + table + '_sidx').val() == col) {
            if ($('#inp_' + table + '_sord').val() == 'ASC') {
                sord = 'DESC';
            }
        } else {
            $('#inp_' + table + '_sidx').val(col);
        }
        $('#inp_' + table + '_sord').val(sord);
        reload_table(table);

    } else {
        show_error('DataTableLib (js): Invalid table to sort');
    }
}


function export_table_xls(table)
{
    if (table != '')
    {

        //show_loader( table );


        var sord = $('#inp_' + table + '_sord').val();
        var sidx = $('#inp_' + table + '_sidx').val();
        var page = $('#inp_' + table + '_page').val();
        var rows = $('#inp_' + table + '_rows').val();
        var list = $('#inp_' + table + '_list').val();
        var fidx = $('#inp_' + table + '_fidx').val();
        var fval = $('#inp_' + table + '_fval').val();
        var srch_string = $('#inp_' + table + '_srch_string').val();
        var srch_idx = $('#inp_' + table + '_srch_idx').val();
        var tpages = $('#inp_' + table + '_tpages').val();

        var url = 'export.php?action=' + list + "&table_id=" + table + "&sord=" + sord + "&sidx=" + sidx + "&searchField=" + srch_idx;
        url += "&searchString=" + srch_string + "&filterIdx=" + fidx + "&filterVal=" + fval;
        url += "&page=" + page + "&rows=" + rows;

        this.location = url;
    }
    else
    {
        show_error('DataTableLib (js): Invalid table to reload.');
    }
}



function export_prospect(table)
{
    if (table != '')
    {
        var ids = '';
        
        $("input[name='prospectos[]']").each(function () {
            
            if (this.checked)
            {
                ids += this.value + ',';
            }
        });

        var url = 'export.php?action=' + table+"&ids="+ids;

        this.location = url;
        
    }
    else
    {
        show_error('DataTableLib (js): Invalid table to reload.');
    }
}
