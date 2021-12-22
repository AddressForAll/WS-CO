/**
 * NAV_ECLUSA, reactive form interface, multiple APIs.
 */

/* Formatting function for row details - modify as you need */
function format ( d ) {
    // `d` is the original data object for the row
    return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
        '<tr>'+
            '<td>donor_id:</td>'+
            '<td>'+d.packinfo.donor_id+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td>user_respr:</td>'+
            '<td>'+d.packinfo.user_resp+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td>accepted_date:</td>'+
            '<td>'+d.packinfo.accepted_date+'</td>'+
        '</tr>'+
    '</table>';
}


var who_show = '';

function getdata(param = null){
    let step = $('input[type=radio][name=tipo_do_filtro]:checked').val();
    let user_type = $('input[type=radio][name=tipo_de_usuario]:checked').val();
    let user = $('#usuario').val();

    if (user != "") {
        let fn = 'checkuserfiles_'+ step;
        if (step == 'step0') {
            fn = 'checkuserdir';
            user_type = '';
        }
        url = 'http://api-test.addressforall.org/v1/eclusa/'+ fn +'/'+ user +'/' + user_type
        if (step =='step0'){
            columns = [
                {
                    "className":      'details-control',
                    "orderable":      false,
                    "data":           null,
                    "defaultContent": ''
                },
                {"data" : "username"},
                {
                    "data" : null,
                    "render" : data=> `<a href="http://api-test.addressforall.org/v1.htm/vw_core/jurisdiction/${data.jurisdiction_label}" target_blank>${data.jurisdiction_label}</a>`
                },
                {
                    "data" : null,
                    "render" : data=> `<a title="Mapa" rel="external noopener" target="_blank" href="http://osm.org/relation/${data.jurisdiction_osmid}" target_blank>${data.jurisdiction_osmid}</a>`
                },
                {
                    "data" : null,
                    "render" : data=> `<a href="http://api-test.addressforall.org/v1.htm/vw_core/donatedpack/${data.pack_id}" target_blank>${data.pack_id}</a>`
                },
                {
                  "data" : null,
                  "render" : data=> data.pack_path.replace(/^\/home\/[a-z][^\/]+\/(?:_eclusa\/)?/,'')
                },
                {"data" : "packinfo.user_resp"},
                {"data" : "packinfo.accepted_date"}
            ]
            $('#tabela').hide();
            $('#tabela_step_0').show();
        } else {
            columns = [
                {
                    "data" : null,
                    "render" : data=> `<a href="http://api-test.addressforall.org/v1.htm/vw_core/jurisdiction/${data.fmeta.jurisdiction_label}" target_blank>${data.fmeta.jurisdiction_label}</a>`
                },
                {"data" : "fid"},
                {"data" : "fname"},
                {"data" : "is_valid"},
                {"data" : "ctype"},
                {
                    "data" : null,
                    "render" : data=> `<a href="http://api-test.addressforall.org/v1.htm/vw_core/donatedpack/${data.pack_id}" target_blank>${data.pack_id}</a>`
                }
            ];
            $('#tabela').show();
            $('#tabela_step_0').hide();
        } // \if step

        // Calling DataTable constructor
        [who_show, who_destroy] = $('#tabela').is(":visible")
          ? ['#tabela', '#tabela_step_0']
          : ['#tabela_step_0', '#tabela']
        ; // Luiz see https://javascript.info/destructuring-assignment
        $.getJSON(url, function( data ) {
            $(who_show).show();
            $('#definepaginacao').show();

            // Changes automatically html pagination options from select based on data length
            $('#paginacao option').show();
            $('#paginacao option').filter(function(){ return parseInt(this.value) > data.length}).hide();

            var table = $(who_show).DataTable({
                "bDestroy": true,
                "dom": 'Bfrtip',
                "buttons": ['copy', 'csv', 'excel', 'print'],
                "data" : data,
                "columns" : columns,
                "paging": true,
                "responsive": true,
                "pageLength" : 10,
                stateSave: true
            });

            // Add title at first column (+)(-)
            $(".details-control").attr("title","Pack Info");

            if (step = 'step0') 
                $('#tabela_step_0 tbody').on('click', 'td.details-control', function () {
                    var tr = $(this).closest('tr');
                    var row = table.row( tr );
                    if ( row.child.isShown() ) {
                        // This row is already open - close it
                        row.child.hide();
                        tr.removeClass('shown');
                    }
                    else {
                        // Open this row
                        row.child( format(row.data()) ).show();
                        tr.addClass('shown');
                    }
                });
        });

        // Destroy unchecked table to remove duplicated export buttons
        $(who_destroy).DataTable().destroy();

        // Changes automatically the GET LINK at Annotation for Developers Section
        $('#get_url').text(url);
        $('#get_url').attr("href", url);

    }
    else {
        alert('Inserir usuário para completar.')
    }

}


$(document).ready(function(){ // ONLOAD

    // Se radio = step 0 então radio de tipo de usuário não filtra
    $('input[type=radio][name=tipo_do_filtro]').change( ()=> {
        checked = $('input[type=radio][name=tipo_do_filtro]:checked').val();
        if (checked == 'step0')
            $('#tipo_de_usuario_div').hide();
        else
            $('#tipo_de_usuario_div').show();
    });
    var qtd = 10; //$("#paginacao").children("option:selected").val();

    // Páginação controlda
    $('#paginacao').on('change', ()=> {
        qtd = $("#paginacao").children("option:selected").val()
        $(who_show).DataTable().page.len(qtd).draw()
    });

    $('#paginar').on('change', ()=> {
        if (!$('#paginar').prop('checked'))
            $(who_show).DataTable().page.len(-1).draw()
        else if (qtd)
            $(who_show).DataTable().page.len(qtd).draw()
        else
            $(who_show).DataTable().page.len(10).draw()
    });

    // Considera ordenação correta em PT, A, À, Á, B, C ... Z
    $.fn.dataTable.ext.order.intl = function (locales, options) {
      if ( window.Intl ) {
        var collator = new window.Intl.Collator(locales,options);
        var types = $.fn.dataTable.ext.type;
        delete types.order['string-pre'];
        types.order['string-asc'] = collator.compare;
        types.order['string-desc'] = (a,b)=> collator.compare(a,b) * -1;
      }
    };
    $.fn.dataTable.ext.order.intl( 'pt' )

}); // \ONLOAD
