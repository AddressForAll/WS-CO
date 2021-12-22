
    function getdata(param = null){
        var valor, atributo, url;
        if (param != null){
            valor = param;
            atributo = "donor_id";
        }
        else if ($('input[type=radio][name=tipo_do_filtro]:checked').val() == "estado") {
            valor = $("#estados").children("option:selected").val();
            atributo = "jurisd_state";
        }
        else {
            valor = $("#donors").children("option:selected").val();
            atributo = "donor_id";
        }

        url = "http://api-test.addressforall.org/v1/vw_core/origin/";
        url += valor != "all" ? atributo + ".eq." + valor : "";

        $.getJSON(url, function(data) {
            $('#tabela').show();
            $('#definepaginacao').show();
            $('#tabela').DataTable({
                "bDestroy": true,
                "dom": 'Bfrtip',
                "buttons": ['copy', 'csv', 'excel', 'print'],
                "data" : data,
                "columns" : [
                    {"data" : "id"},  // control widths!???
                    {"data" : null,
                     "render" : data=> `<a title="Mapa" target="_blank" href="http://osm.org/relation/${data.jurisd_osm_id}" target_blank>${data.jurisd_osm_id}</a>`
                    },
                    {
                        "data" : null,
                        "render" : data=> data.fmeta.jurisdiction_label
                    },
                    {
                        "data" : null,
                        "render" : function(data, type, row) {
                                        return '<div align="center">' + data["ctype"] + '&nbsp;' + '<a class="btn" style="text-decoration: none" href="http://preserv.addressforall.org/download/' + data["fhash"] + "." + data["fmeta"].ext + '" target_blank>' + data["fhash"].substring(0, 7) + ' ↓ </a>' + '&nbsp;v' + data["fversion"] + '</div>'
                                    }
                    },
                    {
                        "data" : null,
                        "render" : data=> `${parseFloat((data.fmeta.size / (1024 ** 2))).toFixed(2)} MB`
                    },
                    {
                        "data" : null,
                        "render" : data=> `<div align="center" ><a href="http://api-test.addressforall.org/v1.htm/nav_core/donor/?id=${data.kx.donor.id}" target_blank>${data.kx.donor.id} - ${data.kx.donor.shortname}</a></div>`
                    },
                    {
                        "data" : null,
                        "render" : data=> `<a title="Home institucional" rel="external noopener" target="_blank" href="${data.kx.donor.url}" target_blank>${data.kx.donor.legalname}</a>`
                    },
                    {
                        "data" : null,
                        "render" : data=> data.kx.pack.accepted_date
                    }
                ],
                "paging": $('#paginar').prop('checked'),
                "responsive": true,
                "pageLength" : 10
            });

            /* Changes automatically the GET LINK at Annotation for Developers Section */
            $('#get_url').text(url);
            $('#get_url').attr("href", url);

        }); // \getJSON

    } // \getdata

    $(document).ready(function(){

        // Pega parametro da url ?donor_id=43242 quando o usuário está navegando de api-donor
        let searchParams = new URLSearchParams(window.location.search);
        if (searchParams.has('donor_id')){
            getdata(searchParams.get('donor_id'));
        }

        // Controla o radio que escolhe o tipo da filtragem
        $('input[type=radio][name=tipo_do_filtro]').change(function() {
            if (this.value == 'estado') {
                $('#div_estados').show();
                $('#div_donors').hide();
            }
            else if (this.value == 'donor') {
                $('#div_donors').show();
                $('#div_estados').hide();
            }
        });

        // Carregar option dos doadores
        $.getJSON('http://api-test.addressforall.org/_sql/vw_donors_origin', data=> {
            var options = '' //"<option selected value='all'>Trazer Tudo</option>";
            for (var i=0; i<data.length; i++) {
              let filesFlex = (data[i].n_files==1)? 'file': 'files';
              options += `<option value="${data[i].donor_id}">${data[i].donor_shortname} - ${data[i].donor_legalname} (${data[i].n_files} ${filesFlex})</option>`
            }
            $('#donors').html(options)
        });

        // Carregar option dos estados
        $.getJSON('http://api-test.addressforall.org/_sql/vw_jurisd_origin?jurisd_base_id=eq.76', data=> {
            var options = '' //"<option selected value='all'>Trazer Tudo</option>";
            for (var i=0; i<data.length; i++) {
               let filesFlex = (data[i].n_files==1)? 'file': 'files';
               let scope = (data[i].jurisd_admin_level==8)? data[i].jurisd_state: '(nacional)'
               options += `<option value="${data[i].jurisd_state}">${scope} - (${data[i].n_files} ${filesFlex})</option>`
            }
            $('#estados').html(options)
        });

        // Páginação controlda
        $('#definepaginacao').on('change', function () {
            var qtd = $("#paginacao").children("option:selected").val();
            $('#tabela').DataTable().page.len(qtd).draw();
        });

        // Considera ordenação correta em PT, A, À, Á, B, C ... Z
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
