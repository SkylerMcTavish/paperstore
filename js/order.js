function detail_order(which, force)
{
    if (which > 0)
    {
        if (which != $('#inp_detail_id_order').val() || force == true)
        {

            $.ajax({
                url: "ajax.php",
                type: "POST",
                async: false,
                data: {
                    resource: 'order',
                    action: 'get_order_info_html',
                    id_order: which
                },
                dataType: "json",
                success: function (data) {
                    if (data.success == true) {
                        var html = data.html;
                        $('#inp_detail_id_order').val(which);
                        $('#detail_order_content').html(html);

                        $('#mdl_detail_order').modal('show');
                        //load_detail_map();
                    }
                    else {
                        show_error(data.error);
                        return false;
                    }
                }
            });
        }
        else
        {
            $('#mdl_detail_order').modal('show');
        }
    }
}