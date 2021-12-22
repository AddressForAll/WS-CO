

function getdata(param = null){

    url = 'http://api-test.addressforall.org/v1/vw_core/donor/';
    if (param != null) {
        url += param;
    }

    $.getJSON(url, function( data ) {
        $('#tabela').show();
        $('#definepaginacao').show();
        $('#tabela').DataTable({
            "bDestroy": true,
            "dom": 'Bfrtip',
            "buttons": ['copy', 'csv', 'excel', 'print'],
            "data" : data,
            "columns" : [
                {"data" : "id"},
                {"data" : "scope"},
                {"data" : "vat_id"},
                {"data" : "shortname"},
                {
                    "data" : null,
                    "render" : function(data, type, row){
                        return '<a target="_blank" rel="external noopener" href="'+data["url"]+'" target_blank>' + data["legalname"] + '</a>' 
                    }
                },
                {
                    "data" : null,
                    "render": function(data, type, row) {
                        return (data["wikidata_id"]) ? '<a target="_blank" rel="external noopener" href="http://wikidata.org/entity/Q'+data["wikidata_id"]+'" target_blank>' + data["wikidata_id"] + '</a>' : ''
                    }
                },
                {
                    "data" : null,
                    "render" : function(data, type, row) {
                        let qtd = 0;
                        try {
                            qtd = data["kx"].n_files;
                          }
                        finally {
                            let href = (qtd) ? 'href ="http://api-test.addressforall.org/v1.htm/nav_core/origin?donor_id=' + data["id"] + '"' : '';
                            let sclass = (href == '') ? "btn-disabled" : "btn";
                            return '<div align="center"><a style="text-decoration: none" class="'+sclass+'" '+href+' target_blank>'+'&nbsp;'+qtd+'&nbsp;'+'</a></div>' 
                        }
                    }
                }
            ], /* endcolumns */
            "paging": $('#paginar').prop('checked'),
            "responsive": true,
            "pageLength" : 10
        });

    });

    /* Changes automatically the GET LINK at Annotation for Developers Section */
    $('#get_url').text(url);
    $('#get_url').attr("href", url);
}

$(document).ready(function(){

    /* Pega parametro da url ?id=43242 quando o usuário está navegando de api-origin */
    let searchParams = new URLSearchParams(window.location.search);
    if (searchParams.has('id')){
        getdata(searchParams.get('id'));
    } 


    /* Páginação controlda */
    $('#definepaginacao').on('change', function (){
        var qtd = $("#paginacao").children("option:selected").val();
        $('#tabela').DataTable().page.len(qtd).draw();
    });    


    /* Considera ordenação correta em PT, A, À, Á, B, C ... Z */
    $.fn.dataTable.ext.order.intl = function ( locales, options ) {
    if ( window.Intl ) {
        var collator = new window.Intl.Collator( locales, options );
        var types = $.fn.dataTable.ext.type;

        delete types.order['string-pre'];
        types.order['string-asc'] = collator.compare;
        types.order['string-desc'] = function ( a, b ) {
            return collator.compare( a, b ) * -1;
            };
        }
    };
    $.fn.dataTable.ext.order.intl( 'pt' ); 
});
