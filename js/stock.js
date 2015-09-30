function detail_stock(which)
{
    if (which > 0)
    {

        $.ajax({
            url: "ajax.php",
            type: "POST",
            async: false,
            data: {
                resource: 'stock',
                action: 'get_stock_info_html',
                id_visit: which
            },
            dataType: "json",
            success: function (data) {
                if (data.success == true)
                {
                    var html = data.html;

                    $('#tbl_stock > tbody').html(html);

                }
                else {
                    $('#tbl_stock > tbody').html("<tr><td colspan='6' align='center'>No existen registros</td></tr>");

                    //show_error(data.error);
                    return false;
                }
            }
        });

    }
}